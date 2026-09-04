<?php
/**
 * Template Name: Page — page-danila-contacts
 * Template Post Type: page
 */
get_header();
$data = vlata_brand_data( 'danila' );
$danila_url = vlata_page_url( 'danila' );
?>
<section class="page-hero">
	<div class="container">
		<div class="breadcrumb"><a href="<?php echo esc_url( $danila_url ); ?>">Данила Мастер</a> / Контакты</div>
		<p class="brand-label">Данила Мастер · производство памятников</p>
		<h1>Контакты</h1>
		<p class="lead">Расчёт стоимости памятника, гравировки и установки — по телефону.</p>
	</div>
</section>
<main class="page-content">
	<div class="container">
		<div class="contacts-grid">
			<div class="contact-card">
				<h3>Данила Мастер</h3>
				<ul>
					<li><i class="fas fa-phone"></i><div><strong>Телефон</strong><br><a href="tel:<?php echo esc_attr( $data['phone_main_raw'] ); ?>"><?php echo esc_html( $data['phone_main'] ); ?></a><br><a href="tel:<?php echo esc_attr( $data['phone_second_raw'] ); ?>"><?php echo esc_html( $data['phone_second'] ); ?></a></div></li>
					<li><i class="fas fa-envelope"></i><div><strong>Email</strong><br><a href="mailto:<?php echo esc_attr( $data['email'] ); ?>"><?php echo esc_html( $data['email'] ); ?></a></div></li>
					<li><i class="fas fa-clock"></i><div><strong>Режим работы</strong><br><?php echo esc_html( $data['hours'] ); ?></div></li>
					<li><i class="fas fa-map-marker-alt"></i><div><strong>Адрес</strong><br><?php echo esc_html( $data['address'] ); ?><br><a href="<?php echo esc_url( $data['map_link'] ); ?>" target="_blank" rel="noopener" style="font-size:.9em;opacity:.85">Смотреть на Яндекс.Картах →</a></div></li>
				</ul>
				<button class="btn-order"><i class="fas fa-phone"></i> Позвонить</button>
			</div>
			<div class="contact-card">
				<h3>Нужна организация похорон?</h3>
				<p>Ритуальные услуги оказывает отдельная организация — центр «Влата» (круглосуточно).</p>
				<a href="<?php echo esc_url( vlata_page_url( 'contacts' ) ); ?>" class="btn-order">Контакты «Влата»</a>
			</div>
		</div>
		<div class="contact-map">
			<h3 class="contact-map-title"><i class="fas fa-map-marker-alt"></i> Мы на карте — <?php echo esc_html( $data['address_short'] ); ?></h3>
			<div class="contact-map-frame">
				<iframe src="<?php echo esc_url( $data['map_embed'] ); ?>" width="100%" height="100%" frameborder="0" allowfullscreen="true" title="Данила Мастер на карте — <?php echo esc_attr( $data['address_short'] ); ?>" loading="lazy"></iframe>
			</div>
		</div>
	</div>
</main>
<?php
get_footer();
