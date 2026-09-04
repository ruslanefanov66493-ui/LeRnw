<?php
get_header();
$slug = get_post_field( 'post_name' );
$titles = array(
	'about'           => array( 'label' => 'Центр ритуальных услуг «Влата»', 'lead' => 'Оказываем ритуальные услуги по подготовке и проведению похорон и траурных процессий в городе Ершове и Ершовском районе уже более 27 лет.', 'h1' => 'О компании' ),
	'contacts'        => array( 'label' => '', 'lead' => 'Бесплатная консультация по телефону круглосуточно. Выезд специалиста на место в любое время суток.', 'h1' => 'Контакты' ),
	'works'           => array( 'label' => 'Влата · ритуальные услуги', 'lead' => 'Фотографии ритуальных товаров и транспорта службы «Влата». Памятники и установки — у партнёра «Данила Мастер».', 'h1' => 'Наши работы' ),
	'danila'          => array( 'label' => 'Производство памятников · отдельная организация', 'lead' => 'Производство красивых долговечных надгробий — наша основная специализация. Гранит и мрамор, монтаж любой сложности, цены от производителя.', 'h1' => 'Данила Мастер' ),
	'danila-about'    => array( 'label' => 'Данила Мастер', 'lead' => 'Гарантия самой выгодной цены на памятники. Производство красивых долговечных надгробий — наша основная специализация.', 'h1' => 'О компании' ),
	'danila-contacts' => array( 'label' => 'Данила Мастер · производство памятников', 'lead' => 'Расчёт стоимости памятника, гравировки и установки — по телефону.', 'h1' => 'Контакты' ),
	'danila-works'    => array( 'label' => 'Данила Мастер · производство', 'lead' => 'Памятники, металл и выполненные установки. Ритуальные товары «Влата» — в отдельном разделе.', 'h1' => 'Наши работы' ),
);
$config = $titles[ $slug ] ?? array( 'label' => '', 'lead' => get_the_excerpt(), 'h1' => get_the_title() );
$is_danila = 0 === strpos( $slug, 'danila' );
$home_link = $is_danila ? vlata_page_url( 'danila' ) : home_url( '/' );
$home_text = $is_danila ? 'Данила Мастер' : 'Главная';
?>
<section class="page-hero">
	<div class="container">
		<div class="breadcrumb"><a href="<?php echo esc_url( $home_link ); ?>"><?php echo esc_html( $home_text ); ?></a> / <?php echo esc_html( $config['h1'] ); ?></div>
		<?php if ( $config['label'] ) : ?>
			<p class="brand-label"><?php echo esc_html( $config['label'] ); ?></p>
		<?php endif; ?>
		<h1><?php echo esc_html( $config['h1'] ); ?></h1>
		<p class="lead"><?php echo esc_html( $config['lead'] ); ?></p>
		<?php if ( 'danila' === $slug ) : ?>
			<div class="hero-actions">
				<a href="#catalog" class="btn-order">Каталог</a>
				<a href="<?php echo esc_url( vlata_page_url( 'danila-contacts' ) ); ?>" class="btn-order btn-order-outline">Связаться</a>
			</div>
		<?php endif; ?>
	</div>
</section>
<main class="page-content">
	<div class="container">
		<?php
		while ( have_posts() ) :
			the_post();
			the_content();
		endwhile;
		?>
	</div>
</main>
<?php
get_footer();
