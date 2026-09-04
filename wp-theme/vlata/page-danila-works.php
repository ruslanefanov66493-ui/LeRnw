<?php
/**
 * Template Name: Page — page-danila-works
 * Template Post Type: page
 */
get_header();
$danila_url = vlata_page_url( 'danila' );
$sections = array(
	'granite'      => 'Памятники',
	'metal'        => 'Металлические изделия',
	'installation' => 'Установки',
);
?>
<section class="page-hero">
	<div class="container">
		<div class="breadcrumb"><a href="<?php echo esc_url( $danila_url ); ?>">Данила Мастер</a> / Наши работы</div>
		<p class="brand-label">Данила Мастер · производство</p>
		<h1>Наши работы</h1>
		<p class="lead">Памятники, металл и выполненные установки. Ритуальные товары «Влата» — в отдельном разделе.</p>
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
				<?php if ( 'installation' === $slug ) : ?>
					<a href="<?php echo esc_url( vlata_category_url( 'installation' ) ); ?>" class="btn-order" style="margin-top:16px">Варианты установок</a>
				<?php endif; ?>
			</div>
		<?php endforeach; ?>
		<?php if ( ! vlata_woocommerce_active() ) : ?>
			<div class="content-block"><p>Для отображения галереи активируйте плагин WooCommerce и запустите импорт каталога (Инструменты → Импорт каталога Влата).</p></div>
		<?php endif; ?>
		<div class="content-block partner-note"><p>Ритуальные фото (гробы, катафалк, венки): <a href="<?php echo esc_url( vlata_page_url( 'works' ) ); ?>">работы «Влата»</a>.</p></div>
	</div>
</main>
<?php
get_footer();
