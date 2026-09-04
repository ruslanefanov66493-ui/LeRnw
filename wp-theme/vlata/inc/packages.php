<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function vlata_register_packages() {
	register_post_type( 'service_package', array(
		'labels'        => array(
			'name'          => 'Пакеты услуг',
			'singular_name' => 'Пакет услуг',
			'add_new_item'  => 'Добавить пакет',
			'edit_item'     => 'Редактировать пакет',
			'menu_name'     => 'Пакеты услуг',
		),
		'public'        => false,
		'show_ui'       => true,
		'menu_icon'     => 'dashicons-list-view',
		'menu_position' => 26,
		'supports'      => array( 'title', 'page-attributes' ),
		'hierarchical'  => false,
	) );
}
add_action( 'init', 'vlata_register_packages' );

function vlata_package_metabox() {
	add_meta_box( 'vlata_package_meta', 'Параметры пакета', 'vlata_package_metabox_html', 'service_package', 'normal', 'high' );
}
add_action( 'add_meta_boxes', 'vlata_package_metabox' );

function vlata_package_metabox_html( $post ) {
	wp_nonce_field( 'vlata_package_save', 'vlata_package_nonce' );
	$price = get_post_meta( $post->ID, 'price_from', true );
	$items = get_post_meta( $post->ID, 'items', true );
	?>
	<p><label><strong>Цена «от», руб</strong><br>
		<input type="number" min="0" step="100" name="vlata_price_from" value="<?php echo esc_attr( $price ); ?>" style="width:200px"></label></p>
	<p><label><strong>Состав пакета</strong> — одна позиция на строку. Формат: <code>Название позиции</code> или <code>**Заголовок**: деталь</code><br>
		<textarea name="vlata_items" rows="10" style="width:100%;max-width:600px"><?php echo esc_textarea( $items ); ?></textarea></label></p>
	<p>Порядок пакетов на главной: задаётся полем «Порядок» (меньше — выше).</p>
	<?php
}

function vlata_package_save( $post_id ) {
	if ( ! isset( $_POST['vlata_package_nonce'] ) || ! wp_verify_nonce( $_POST['vlata_package_nonce'], 'vlata_package_save' ) ) {
		return;
	}
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}
	update_post_meta( $post_id, 'price_from', absint( $_POST['vlata_price_from'] ?? 0 ) );
	update_post_meta( $post_id, 'items', sanitize_textarea_field( wp_unslash( $_POST['vlata_items'] ?? '' ) ) );
}
add_action( 'save_post_service_package', 'vlata_package_save' );

function vlata_get_packages() {
	$query = new WP_Query( array(
		'post_type'      => 'service_package',
		'posts_per_page' => 6,
		'orderby'        => 'menu_order title',
		'order'          => 'ASC',
	) );

	if ( $query->have_posts() ) {
		$packages = array();
		foreach ( $query->posts as $post ) {
			$packages[] = array(
				'name'  => $post->post_title,
				'price' => (int) get_post_meta( $post->ID, 'price_from', true ),
				'items' => vlata_parse_package_items( get_post_meta( $post->ID, 'items', true ) ),
			);
		}
		return $packages;
	}

	return vlata_default_packages();
}

function vlata_parse_package_items( $raw ) {
	$items = array();
	foreach ( preg_split( '/\r\n|\r|\n/', (string) $raw ) as $line ) {
		$line = trim( $line );
		if ( '' === $line ) {
			continue;
		}
		$items[] = $line;
	}
	return $items;
}

function vlata_default_packages() {
	$packages = array();
	$catalog  = wp_json_file_decode( get_theme_file_path( 'data/catalog.json' ), array( 'associative' => true ) );
	if ( empty( $catalog['packages'] ) ) {
		return array();
	}
	foreach ( $catalog['packages'] as $package ) {
		$packages[] = array(
			'name'  => $package['name'],
			'price' => $package['priceFrom'],
			'items' => $package['items'],
		);
	}
	return $packages;
}

function vlata_format_price( $price ) {
	return number_format( (float) $price, 0, ',', ' ' );
}
