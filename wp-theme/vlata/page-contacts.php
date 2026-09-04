<?php
/**
 * Template Name: Page — page-contacts
 * Template Post Type: page
 */
get_header();
$data = vlata_brand_data( 'vlata' );
?>
<section class="page-hero">
	<div class="container">
		<div class="breadcrumb"><a href="<?php echo esc_url( home_url( '/' ) ); ?>">Главная</a> / Контакты</div>
		<h1>Контакты</h1>
		<p class="lead">Бесплатная консультация по телефону круглосуточно. Выезд специалиста на место в любое время суток.</p>
	</div>
</section>
<main class="page-content">
	<div class="container">
		<div class="contacts-grid">
			<div class="contact-card">
				<h3>Связь с нами</h3>
				<ul>
					<li><i class="fas fa-phone"></i><div><strong>Телефон</strong><br><a href="tel:<?php echo esc_attr( $data['phone_main_raw'] ); ?>"><?php echo esc_html( $data['phone_main'] ); ?></a><br><a href="tel:<?php echo esc_attr( $data['phone_second_raw'] ); ?>"><?php echo esc_html( $data['phone_second'] ); ?></a> <span style="font-size:.85em;opacity:.8">(круглосуточно)</span></div></li>
					<li><i class="fas fa-envelope"></i><div><strong>Email</strong><br><a href="mailto:<?php echo esc_attr( $data['email'] ); ?>"><?php echo esc_html( $data['email'] ); ?></a></div></li>
					<li><i class="fas fa-clock"></i><div><strong>Режим работы</strong><br><?php echo esc_html( $data['hours'] ); ?></div></li>
					<li><i class="fas fa-map-marker-alt"></i><div><strong>Адрес</strong><br><?php echo esc_html( $data['address'] ); ?><br><a href="<?php echo esc_url( $data['map_link'] ); ?>" target="_blank" rel="noopener" style="font-size:.9em;opacity:.85">Смотреть на Яндекс.Картах →</a></div></li>
				</ul>
				<button class="btn-order"><i class="fas fa-phone"></i> Позвонить</button>
			</div>
			<div class="contact-card">
				<h3>Как мы работаем</h3>
				<p>По вашему звонку организуем выезд ритуального агента. Индивидуальный подход к каждому клиенту.</p>
				<p>Центр ритуальных услуг «Влата» предоставляет гарантии по достойному отношению к умершим в соответствии с Федеральным законом «О погребении и похоронном деле» и ГОСТ Р 54611-2011.</p>
				<p>При желании предоставляем прощальный зал.</p>
				<ul>
					<li><i class="fas fa-check"></i><span>Гарантия неизменности цен в договоре</span></li>
					<li><i class="fas fa-check"></i><span>Бесплатная круглосуточная консультация</span></li>
					<li><i class="fas fa-check"></i><span>Собственное производство и автопарк</span></li>
				</ul>
			</div>
		</div>
		<div class="contact-map">
			<h3 class="contact-map-title"><i class="fas fa-map-marker-alt"></i> Мы на карте — <?php echo esc_html( $data['address_short'] ); ?></h3>
			<div class="contact-map-frame">
				<iframe src="<?php echo esc_url( $data['map_embed'] ); ?>" width="100%" height="100%" frameborder="0" allowfullscreen="true" title="Центр ритуальных услуг «Влата» на карте — <?php echo esc_attr( $data['address_short'] ); ?>" loading="lazy"></iframe>
			</div>
		</div>
	</div>
</main>
<?php
get_footer();
