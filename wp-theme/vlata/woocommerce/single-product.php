<?php
get_header();
$product      = wc_get_product( get_the_ID() );
$brand        = vlata_current_brand();
$is_danila    = 'danila' === $brand;
$home_link    = $is_danila ? vlata_page_url( 'danila' ) : home_url( '/' );
$home_text    = $is_danila ? 'Данила Мастер' : 'Главная';
$parent_terms = get_the_terms( get_the_ID(), 'product_cat' );
$parent_term  = $parent_terms && ! is_wp_error( $parent_terms ) ? $parent_terms[0] : null;
$image_ids    = vlata_get_product_image_ids( get_the_ID() );
$price        = $product ? $product->get_price() : '';
?>
<section class="page-hero">
	<div class="container">
		<div class="breadcrumb">
			<a href="<?php echo esc_url( $home_link ); ?>"><?php echo esc_html( $home_text ); ?></a>
			<?php if ( $parent_term ) : ?>
				/ <a href="<?php echo esc_url( get_term_link( $parent_term ) ); ?>"><?php echo esc_html( $parent_term->name ); ?></a>
			<?php endif; ?>
			/ <?php echo esc_html( get_the_title() ); ?>
		</div>
		<p class="brand-label"><?php echo esc_html( $is_danila ? 'Данила Мастер · производство памятников' : 'Влата · ритуальные услуги' ); ?></p>
		<h1><?php echo esc_html( get_the_title() ); ?></h1>
		<?php if ( $price ) : ?>
			<p class="lead">Цена от <?php echo esc_html( vlata_format_price( $price ) ); ?> руб</p>
		<?php endif; ?>
	</div>
</section>
<main class="page-content">
	<div class="container">
		<?php if ( get_the_content() ) : ?>
			<div class="content-block"><?php the_content(); ?></div>
		<?php endif; ?>

		<?php if ( $image_ids ) : ?>
			<div class="content-block">
				<h2>Фото</h2>
				<?php echo vlata_gallery_html( $image_ids ); ?>
			</div>
		<?php endif; ?>

		<div class="content-block">
			<p>Уточнение и заказ — по телефону.</p>
			<button class="btn-order"><i class="fas fa-phone"></i> <?php echo $is_danila ? 'Заказать расчёт' : 'Уточнить по телефону'; ?></button>
			<?php if ( $is_danila ) : ?>
				<p style="margin-top:18px">Организация похорон — <a href="<?php echo esc_url( vlata_page_url( 'about' ) ); ?>">центр ритуальных услуг «Влата»</a> (отдельная организация).</p>
			<?php endif; ?>
		</div>
	</div>
</main>
<?php
get_footer();
