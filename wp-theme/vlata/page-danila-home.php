<?php
/**
 * Template Name: Page — page-danila-home
 * Template Post Type: page
 */
get_header();
$danila_url = vlata_page_url( 'danila' );
$catalog_sections = array(
	'granite'      => array( 'name' => 'Гранит и мрамор', 'desc' => 'Стелы с подставкой и цветником, размеры от 800×400×80.' ),
	'metal'        => array( 'name' => 'Металлические изделия', 'desc' => 'Ограды (более 40 видов), кресты, столы и лавочки. Покрытие полимерное и порошковое.' ),
	'engraving'    => array( 'name' => 'Гравировка', 'desc' => 'Портреты, ФИО, эпитафии и рисунки на камне.' ),
	'installation' => array( 'name' => 'Варианты установок', 'desc' => '10 вариантов монтажа памятников.' ),
);
?>
<section class="page-hero">
	<div class="container">
		<p class="brand-label">Производство памятников · отдельная организация</p>
		<h1>Данила Мастер</h1>
		<p class="lead">Производство красивых долговечных надгробий — наша основная специализация. Гранит и мрамор, монтаж любой сложности, цены от производителя.</p>
		<div class="hero-actions">
			<a href="#catalog" class="btn-order">Каталог</a>
			<a href="<?php echo esc_url( vlata_page_url( 'danila-contacts' ) ); ?>" class="btn-order btn-order-outline">Связаться</a>
		</div>
	</div>
</section>
<main class="page-content">
	<div class="container">
		<div class="features-row">
			<div class="feature-box"><h3>Более 25 лет</h3><p>Изготовление памятников из натурального камня</p></div>
			<div class="feature-box"><h3>Своё производство</h3><p>Прямые поставки из российских месторождений</p></div>
			<div class="feature-box"><h3>Гарантия цены</h3><p>Цены от производителя и 12 месяцев на установку</p></div>
		</div>
		<div class="content-block" id="catalog">
			<h2>Каталог</h2>
			<p>Продукция и услуги только «Данила Мастер». Организация похорон — у «Влата».</p>
		</div>
		<div class="catalog-grid">
			<?php foreach ( $catalog_sections as $slug => $section ) : ?>
				<a class="catalog-card" href="<?php echo esc_url( vlata_category_url( $slug ) ); ?>"><div class="card-top"><?php echo esc_html( $section['name'] ); ?></div><div class="card-body"><p><?php echo esc_html( $section['desc'] ); ?></p><span class="card-link">Смотреть →</span></div></a>
			<?php endforeach; ?>
		</div>
		<?php
		if ( vlata_woocommerce_active() ) :
			$granite = get_term_by( 'slug', 'granite', 'product_cat' );
			if ( $granite ) :
				$image_ids = array();
				foreach ( vlata_category_product_ids( $granite->term_id ) as $product_id ) {
					$image_ids = array_merge( $image_ids, vlata_get_product_image_ids( $product_id ) );
				}
				$image_ids = array_slice( $image_ids, 0, 6 );
				if ( $image_ids ) :
					?>
					<div class="content-block" style="margin-top:28px">
						<h2>Примеры работ</h2>
						<?php echo vlata_gallery_html( $image_ids ); ?>
						<a href="<?php echo esc_url( vlata_page_url( 'danila-works' ) ); ?>" class="btn-order" style="margin-top:16px">Все работы</a>
					</div>
					<?php
				endif;
			endif;
		endif;
		?>
		<div class="content-block partner-banner">
			<h2>Партнёр — ритуальная служба «Влата»</h2>
			<p>Две разные организации. При полном комплексе услуг у «Влата» — купон 5% на изделия из гранита/мрамора у «Данила Мастер».</p>
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="btn-order">Перейти на «Влата»</a>
		</div>
	</div>
</main>
<?php
get_footer();
