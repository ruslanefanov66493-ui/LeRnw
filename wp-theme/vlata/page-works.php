<?php
/**
 * Template Name: Page — page-works
 * Template Post Type: page
 */
get_header();
$sections = array(
	'coffins'   => 'Гробы',
	'transport' => 'Катафалк и перевозка',
	'wreaths'   => 'Венки и корзины',
	'church'    => 'Церковные принадлежности',
	'hall'      => 'Прощальный зал',
);
?>
<section class="page-hero">
	<div class="container">
		<div class="breadcrumb"><a href="<?php echo esc_url( home_url( '/' ) ); ?>">Главная</a> / Наши работы</div>
		<p class="brand-label">Влата · ритуальные услуги</p>
		<h1>Наши работы</h1>
		<p class="lead">Фотографии ритуальных товаров и транспорта службы «Влата». Памятники и установки — у партнёра «Данила Мастер».</p>
	</div>
</section>
<main class="page-content">
	<div class="container">
		<?php foreach ( $sections as $slug => $title ) : ?>
			<?php
			$term = get_term_by( 'slug', $slug, 'product_cat' );
			if ( ! $term || ! vlata_woocommerce_active() ) {
				continue;
			}
			$image_ids = array();
			foreach ( vlata_category_product_ids( $term->term_id ) as $product_id ) {
				$image_ids = array_merge( $image_ids, vlata_get_product_image_ids( $product_id ) );
			}
			if ( empty( $image_ids ) ) {
				continue;
			}
			?>
			<div class="content-block">
				<h2><?php echo esc_html( $title ); ?></h2>
				<?php echo vlata_gallery_html( $image_ids ); ?>
			</div>
		<?php endforeach; ?>
		<?php if ( ! vlata_woocommerce_active() ) : ?>
			<div class="content-block"><p>Для отображения галереи активируйте плагин WooCommerce и запустите импорт каталога (Инструменты → Импорт каталога Влата).</p></div>
		<?php endif; ?>
		<div class="content-block partner-note">
			<p>Галерея памятников и установок: <a href="<?php echo esc_url( vlata_page_url( 'danila-works' ) ); ?>">работы «Данила Мастер»</a>.</p>
		</div>
	</div>
</main>
<?php
get_footer();
