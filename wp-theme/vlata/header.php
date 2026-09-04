<?php
$brand      = vlata_current_brand();
$data       = vlata_brand_data( $brand );
$page       = vlata_active_page();
$is_danila  = ( 'danila' === $brand );
$home_url   = home_url( '/' );
$danila_url = vlata_page_url( 'danila' );
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?> <?php vlata_body_open(); ?>>
<?php wp_body_open(); ?>
<div class="brand-bar">
	<div class="header-inner brand-bar-inner">
		<div class="brand-switch" role="navigation" aria-label="Выбор организации">
			<a href="<?php echo esc_url( $home_url ); ?>" class="brand-switch-item <?php echo $is_danila ? '' : 'is-active'; ?>" title="Центр ритуальных услуг Влата">Влата</a>
			<span class="brand-switch-sep" aria-hidden="true">|</span>
			<a href="<?php echo esc_url( $danila_url ); ?>" class="brand-switch-item <?php echo $is_danila ? 'is-active' : ''; ?>" title="Производство памятников Данила Мастер">Данила Мастер</a>
		</div>
		<span class="brand-bar-note"><?php echo esc_html( $data['note'] ); ?></span>
	</div>
</div>
<header class="header header-solid">
	<div class="header-inner">
		<?php if ( $is_danila ) : ?>
			<a href="<?php echo esc_url( $danila_url ); ?>" class="logo logo-danila">
				<span class="logo-name">Данила Мастер</span>
				<span class="logo-tag">производство памятников</span>
			</a>
			<nav class="navbar" aria-label="Навигация Данила Мастер">
				<ul class="nav-menu">
					<li class="nav-item"><a href="<?php echo esc_url( $danila_url ); ?>" class="nav-link <?php echo 'danila-home' === $page ? 'active' : ''; ?>">Главная</a></li>
					<li class="nav-item"><a href="<?php echo esc_url( vlata_page_url( 'danila-about' ) ); ?>" class="nav-link <?php echo 'danila-about' === $page ? 'active' : ''; ?>">О компании</a></li>
					<li class="nav-item dropdown">
						<a href="<?php echo esc_url( vlata_category_url( 'monuments' ) ); ?>" class="nav-link <?php echo in_array( $page, array( 'granite', 'metal', 'engraving', 'installation', 'monuments' ), true ) ? 'active' : ''; ?>">Каталог <i class="fas fa-chevron-down"></i></a>
						<ul class="dropdown-menu">
							<li><a href="<?php echo esc_url( vlata_category_url( 'granite' ) ); ?>">Гранит и мрамор</a></li>
							<li><a href="<?php echo esc_url( vlata_category_url( 'metal' ) ); ?>">Металлические изделия</a></li>
							<li><a href="<?php echo esc_url( vlata_category_url( 'engraving' ) ); ?>">Гравировка</a></li>
							<li><a href="<?php echo esc_url( vlata_category_url( 'installation' ) ); ?>">Варианты установок</a></li>
						</ul>
					</li>
					<li class="nav-item"><a href="<?php echo esc_url( vlata_page_url( 'danila-works' ) ); ?>" class="nav-link <?php echo 'danila-works' === $page ? 'active' : ''; ?>">Наши работы</a></li>
					<li class="nav-item"><a href="<?php echo esc_url( vlata_page_url( 'danila-contacts' ) ); ?>" class="nav-link <?php echo 'danila-contacts' === $page ? 'active' : ''; ?>">Контакты</a></li>
				</ul>
			</nav>
			<a href="tel:<?php echo esc_attr( $data['phone_main_raw'] ); ?>" class="header-phone"><i class="fas fa-phone"></i><span><?php echo esc_html( $data['header_phone_label'] ); ?></span></a>
		<?php else : ?>
			<a href="<?php echo esc_url( $home_url ); ?>" class="logo logo-vlata">
				<span class="logo-name">Влата</span>
				<span class="logo-tag">ритуальная служба</span>
			</a>
			<nav class="navbar" aria-label="Навигация Влата">
				<ul class="nav-menu">
					<li class="nav-item"><a href="<?php echo esc_url( $home_url ); ?>" class="nav-link <?php echo 'home' === $page ? 'active' : ''; ?>">Главная</a></li>
					<li class="nav-item"><a href="<?php echo esc_url( vlata_page_url( 'about' ) ); ?>" class="nav-link <?php echo 'about' === $page ? 'active' : ''; ?>">О компании</a></li>
					<li class="nav-item dropdown">
						<a href="<?php echo esc_url( vlata_category_url( 'funerals' ) ); ?>" class="nav-link <?php echo in_array( $page, array( 'funerals', 'coffins', 'church', 'hall', 'crosses', 'transport', 'wreaths' ), true ) ? 'active' : ''; ?>">Похоронные услуги <i class="fas fa-chevron-down"></i></a>
						<ul class="dropdown-menu">
							<li><a href="<?php echo esc_url( vlata_category_url( 'coffins' ) ); ?>">Гробы</a></li>
							<li><a href="<?php echo esc_url( vlata_category_url( 'church' ) ); ?>">Церковные принадлежности</a></li>
							<li><a href="<?php echo esc_url( vlata_category_url( 'hall' ) ); ?>">Прощальный зал</a></li>
							<li><a href="<?php echo esc_url( vlata_category_url( 'crosses' ) ); ?>">Кресты</a></li>
							<li><a href="<?php echo esc_url( vlata_category_url( 'transport' ) ); ?>">Перевозка тел</a></li>
							<li><a href="<?php echo esc_url( vlata_category_url( 'wreaths' ) ); ?>">Венки и корзины</a></li>
						</ul>
					</li>
					<li class="nav-item"><a href="<?php echo esc_url( vlata_page_url( 'works' ) ); ?>" class="nav-link <?php echo 'works' === $page ? 'active' : ''; ?>">Наши работы</a></li>
					<li class="nav-item"><a href="<?php echo esc_url( vlata_page_url( 'contacts' ) ); ?>" class="nav-link <?php echo 'contacts' === $page ? 'active' : ''; ?>">Контакты</a></li>
				</ul>
			</nav>
			<a href="tel:<?php echo esc_attr( $data['phone_second_raw'] ); ?>" class="header-phone"><i class="fas fa-phone"></i><span><?php echo esc_html( $data['header_phone_label'] ); ?></span></a>
		<?php endif; ?>
		<button class="nav-toggle" type="button" aria-label="Открыть меню" aria-controls="site-nav" aria-expanded="false">
			<span class="nav-toggle-bar"></span>
			<span class="nav-toggle-bar"></span>
			<span class="nav-toggle-bar"></span>
		</button>
	</div>
</header>
