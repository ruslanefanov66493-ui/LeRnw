<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function vlata_importer_menu() {
	add_management_page( 'Импорт каталога Влата', 'Импорт каталога Влата', 'manage_options', 'vlata-importer', 'vlata_importer_page' );
}
add_action( 'admin_menu', 'vlata_importer_menu' );

function vlata_importer_page() {
	if ( ! current_user_can( 'manage_options' ) ) {
		wp_die( 'Недостаточно прав.' );
	}

	$catalog = wp_json_file_decode( get_theme_file_path( 'data/catalog.json' ), array( 'associative' => true ) );
	$log     = array();
	$done    = false;

	if ( isset( $_POST['vlata_import'] ) && check_admin_referer( 'vlata_import_run' ) ) {
		$base_url = untrailingslashit( esc_url_raw( wp_unslash( $_POST['vlata_base_url'] ?? '' ) ) );
		$with_images = ! empty( $_POST['vlata_import_images'] );
		$result = vlata_run_import( $catalog, $base_url, $with_images );
		$log   = $result['log'];
		$done  = true;
	}

	$images_count = 0;
	foreach ( (array) ( $catalog['categories'] ?? array() ) as $category ) {
		$images_count += count( $category['images'] ?? array() );
	}
	?>
	<div class="wrap">
		<h1>Импорт каталога Влата</h1>
		<?php if ( $done ) : ?>
			<div class="notice notice-success"><p>Импорт завершён. Отчёт ниже.</p></div>
		<?php endif; ?>
		<p>Импортирует из файла темы <code>data/catalog.json</code>:</p>
		<ul style="list-style:disc;padding-left:20px">
			<li>страницы сайта (О компании, Контакты, Наши работы, Данила Мастер) с шаблонами;</li>
			<li>категории WooCommerce: «Похоронные услуги» (6 подкатегорий) и «Памятники» (4 подкатегории);</li>
			<li>товар-фотогалерею в каждой категории (<?php echo (int) $images_count; ?> фото);</li>
			<li>пакеты услуг для главной (Эконом, Эконом +, Стандарт).</li>
		</ul>
		<form method="post">
			<?php wp_nonce_field( 'vlata_import_run' ); ?>
			<table class="form-table">
				<tr>
					<th scope="row">Адрес старого сайта</th>
					<td>
						<input type="url" name="vlata_base_url" class="regular-text" placeholder="https://ваш-сайт.vercel.app" required>
						<p class="description">Фотографии скачиваются со старого статического сайта (деплой Vercel). Например: https://lernw.vercel.app — без слэша в конце.</p>
					</td>
				</tr>
				<tr>
					<th scope="row">Фото</th>
					<td><label><input type="checkbox" name="vlata_import_images" value="1" checked> Скачать и привязать фотографии</label></td>
				</tr>
			</table>
			<?php submit_button( 'Запустить импорт', 'primary', 'vlata_import' ); ?>
		</form>

		<?php if ( $log ) : ?>
			<h2>Отчёт</h2>
			<div style="background:#fff;padding:12px 16px;border:1px solid #ccd0d4;max-height:480px;overflow:auto">
			<?php foreach ( $log as $line ) : ?>
				<div><?php echo esc_html( $line ); ?></div>
			<?php endforeach; ?>
			</div>
		<?php endif; ?>
	</div>
	<?php
}

function vlata_import_log( &$log, $message ) {
	$log[] = $message;
}

function vlata_sideload_image( $url, $parent_id, $alt ) {
	require_once ABSPATH . 'wp-admin/includes/media.php';
	require_once ABSPATH . 'wp-admin/includes/file.php';
	require_once ABSPATH . 'wp-admin/includes/image.php';

	// Разрешить скачивание со старого сайта, если он на локальном/приватном адресе
	// (по умолчанию WP блокирует запросы к приватным IP и нестандартным портам — защита от SSRF).
	add_filter( 'http_request_host_is_external', '__return_true' );
	$port = (int) parse_url( $url, PHP_URL_PORT );
	if ( $port ) {
		add_filter( 'http_allowed_safe_ports', function ( $ports ) use ( $port ) {
			return array_merge( (array) $ports, array( $port ) );
		} );
	}

	$tmp = download_url( $url );
	if ( is_wp_error( $tmp ) ) {
		return $tmp;
	}

	$file_array = array(
		'name'     => basename( parse_url( $url, PHP_URL_PATH ) ),
		'tmp_name' => $tmp,
	);

	$attachment_id = media_handle_sideload( $file_array, $parent_id, $alt, array( 'test_form' => false ) );
	if ( is_wp_error( $attachment_id ) ) {
		@unlink( $tmp );
		return $attachment_id;
	}
	update_post_meta( $attachment_id, '_wp_attachment_image_alt', $alt );
	return $attachment_id;
}

function vlata_sync_category_content( $term_id, $category, $blocks, $plain ) {
	if ( ! empty( $category['lead'] ) ) {
		update_term_meta( $term_id, 'vlata_lead', $category['lead'] );
	}
	update_term_meta( $term_id, 'vlata_blocks', array_values( (array) $blocks ) );
	wp_update_term( $term_id, 'product_cat', array( 'description' => $plain ) );
}

function vlata_run_import( $catalog, $base_url, $with_images ) {
	$log = array();

	if ( empty( $catalog ) ) {
		vlata_import_log( $log, 'ОШИБКА: не удалось прочитать data/catalog.json' );
		return array( 'log' => $log );
	}

	$imported_pages = array();
	foreach ( (array) ( $catalog['pages'] ?? array() ) as $page ) {
		$existing = get_page_by_path( $page['slug'] );
		if ( $existing ) {
			$imported_pages[ $page['slug'] ] = $existing->ID;
			vlata_import_log( $log, "Страница «{$page['title']}» уже существует — пропущена" );
			continue;
		}
		$post_id = wp_insert_post( array(
			'post_type'   => 'page',
			'post_status' => 'publish',
			'post_title'  => $page['title'],
			'post_name'   => $page['slug'],
		) );
		if ( $post_id && ! empty( $page['template'] ) && locate_template( $page['template'] . '.php' ) ) {
			update_post_meta( $post_id, '_wp_page_template', $page['template'] . '.php' );
		}
		$imported_pages[ $page['slug'] ] = $post_id;
		vlata_import_log( $log, "Создана страница «{$page['title']}» (/{$page['slug']}/)" );
	}

	$term_ids = array();
	foreach ( (array) ( $catalog['categories'] ?? array() ) as $category ) {
		$parent_id = 0;
		if ( ! empty( $category['parent'] ) ) {
			$parent_id = isset( $term_ids[ $category['parent'] ] ) ? $term_ids[ $category['parent'] ] : 0;
		}
		$existing = get_term_by( 'slug', $category['slug'], 'product_cat' );
		$blocks   = (array) ( $category['blocks'] ?? array() );
		$plain    = wp_strip_all_tags( implode( "\n", $blocks ) );

		if ( $existing ) {
			$term_ids[ $category['slug'] ] = $existing->term_id;
			vlata_sync_category_content( $existing->term_id, $category, $blocks, $plain );
			vlata_import_log( $log, "Категория «{$category['name']}» уже существует — контент обновлён" );
			continue;
		}
		$result = wp_insert_term( $category['name'], 'product_cat', array(
			'slug'        => $category['slug'],
			'parent'      => $parent_id,
			'description' => $plain,
		) );
		if ( is_wp_error( $result ) ) {
			vlata_import_log( $log, "ОШИБКА категории «{$category['name']}»: " . $result->get_error_message() );
			continue;
		}
		$term_ids[ $category['slug'] ] = $result['term_id'];
		vlata_sync_category_content( $result['term_id'], $category, $blocks, $plain );
		vlata_import_log( $log, "Создана категория «{$category['name']}»" );
	}

	foreach ( (array) ( $catalog['categories'] ?? array() ) as $category ) {
		$term_id = $term_ids[ $category['slug'] ] ?? 0;
		if ( ! $term_id || empty( $category['images'] ) || ! $with_images ) {
			continue;
		}

		$product_title = 'Каталог: ' . $category['name'];
		$existing_product = get_page_by_path( sanitize_title( $product_title ), OBJECT, 'product' );
		if ( $existing_product ) {
			vlata_import_log( $log, "Товар «{$product_title}» уже существует — пропущен" );
			continue;
		}

		$product_id = wp_insert_post( array(
			'post_type'    => 'product',
			'post_status'  => 'publish',
			'post_title'   => $product_title,
			'post_content' => $category['lead'] ?? '',
		) );
		if ( ! $product_id || is_wp_error( $product_id ) ) {
			vlata_import_log( $log, "ОШИБКА товара «{$product_title}»" );
			continue;
		}
		wp_set_object_terms( $product_id, array( (int) $term_id ), 'product_cat' );
		update_post_meta( $product_id, '_visibility', 'visible' );

		$gallery_ids = array();
		$first       = true;
		foreach ( $category['images'] as $image ) {
			$url  = $base_url . '/' . ltrim( $image['src'], '/' );
			$att  = vlata_sideload_image( $url, $product_id, $image['alt'] );
			if ( is_wp_error( $att ) ) {
				vlata_import_log( $log, "  фото не скачано: {$image['src']} (" . $att->get_error_message() . ')' );
				continue;
			}
			if ( $first ) {
				set_post_thumbnail( $product_id, $att );
				$first = false;
			} else {
				$gallery_ids[] = $att;
			}
		}
		if ( $gallery_ids ) {
			update_post_meta( $product_id, '_product_image_gallery', implode( ',', $gallery_ids ) );
		}
		vlata_import_log( $log, "Создан товар «{$product_title}»: " . ( count( $gallery_ids ) + ( $first ? 0 : 1 ) ) . ' фото' );

		if ( class_exists( 'WC_Product_Simple' ) ) {
			$product = new WC_Product_Simple( $product_id );
			$product->set_catalog_visibility( 'visible' );
			$product->save();
		}
	}

	foreach ( (array) ( $catalog['packages'] ?? array() ) as $package ) {
		$existing = get_page_by_path( $package['slug'], OBJECT, 'service_package' );
		if ( $existing ) {
			vlata_import_log( $log, "Пакет «{$package['name']}» уже существует — пропущен" );
			continue;
		}
		$post_id = wp_insert_post( array(
			'post_type'   => 'service_package',
			'post_status' => 'publish',
			'post_title'  => $package['name'],
			'post_name'   => $package['slug'],
			'menu_order'  => count( (array) get_posts( array( 'post_type' => 'service_package', 'fields' => 'ids' ) ) ),
		) );
		if ( $post_id ) {
			update_post_meta( $post_id, 'price_from', $package['priceFrom'] );
			update_post_meta( $post_id, 'items', implode( "\n", $package['items'] ) );
			vlata_import_log( $log, "Создан пакет «{$package['name']}» — от " . vlata_format_price( $package['priceFrom'] ) . ' руб' );
		}
	}

	$pages_content = $catalog['pagesContent'] ?? array();
	foreach ( array( 'about', 'danila-about' ) as $slug ) {
		if ( empty( $pages_content[ $slug ] ) || empty( $imported_pages[ $slug ] ) ) {
			continue;
		}
		$config = $pages_content[ $slug ];
		if ( ! empty( $config['gallery']['images'] ) && $with_images ) {
			$gallery_ids = array();
			foreach ( $config['gallery']['images'] as $image ) {
				$url = $base_url . '/' . ltrim( $image['src'], '/' );
				$att = vlata_sideload_image( $url, $imported_pages[ $slug ], $image['alt'] );
				if ( is_wp_error( $att ) ) {
					vlata_import_log( $log, "  фото не скачано: {$image['src']}" );
					continue;
				}
				$gallery_ids[] = $att;
			}
			if ( $gallery_ids ) {
				$gallery_html = '[gallery ids="' . implode( ',', $gallery_ids ) . '" columns="4" link="file"]';
				$pos          = (int) ( $config['gallery']['position'] ?? 1 );
				if ( isset( $config['blocks'][ $pos ] ) ) {
					$config['blocks'][ $pos ] .= "\n\n" . $gallery_html;
				} else {
					$config['blocks'][] = $gallery_html;
				}
			}
		}
		$existing_post = get_post( $imported_pages[ $slug ] );
		if ( trim( (string) $existing_post->post_content ) !== '' ) {
			vlata_import_log( $log, "Контент страницы /{$slug}/ уже заполнен — не перезаписан" );
			continue;
		}
		$html = '';
		foreach ( $config['blocks'] as $block ) {
			if ( 0 === strpos( trim( $block ), '<div class="features-row"' ) ) {
				$html .= $block . "\n\n";
			} else {
				$html .= '<div class="content-block">' . $block . '</div>' . "\n\n";
			}
		}
		wp_update_post( array(
			'ID'           => $imported_pages[ $slug ],
			'post_content' => trim( $html ),
		) );
		vlata_import_log( $log, "Наполнена страница /{$slug}/" );
	}

	vlata_import_log( $log, '—' );
	vlata_import_log( $log, 'Готово. Проверьте: Страницы, Товары → Категории, Товары, Пакеты услуг.' );
	return array( 'log' => $log );
}
