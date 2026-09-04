<?php
$brand     = vlata_current_brand();
$data      = vlata_brand_data( $brand );
$is_danila = ( 'danila' === $brand );
$home_url  = home_url( '/' );
$danila_url = vlata_page_url( 'danila' );
$year      = gmdate( 'Y' );
?>
<footer class="footer" id="contacts-footer">
	<div class="container">
		<div class="footer-grid">
			<div class="footer-brand">
				<?php if ( $is_danila ) : ?>
					<a href="<?php echo esc_url( $danila_url ); ?>" class="logo logo-footer logo-danila">
						<span class="logo-name">Данила Мастер</span>
						<span class="logo-tag">производство памятников</span>
					</a>
					<p class="footer-text"><?php echo esc_html( $data['footer_text'] ); ?></p>
					<p class="footer-partner">Партнёр по ритуальным услугам: <a href="<?php echo esc_url( $home_url ); ?>">центр «Влата»</a></p>
				<?php else : ?>
					<a href="<?php echo esc_url( $home_url ); ?>" class="logo logo-footer logo-vlata">
						<span class="logo-name">Влата</span>
						<span class="logo-tag">ритуальная служба</span>
					</a>
					<p class="footer-text"><?php echo esc_html( $data['footer_text'] ); ?></p>
					<p class="footer-partner">Памятники изготавливает партнёр: <a href="<?php echo esc_url( $danila_url ); ?>">«Данила Мастер»</a></p>
				<?php endif; ?>
			</div>
			<div class="footer-nav">
				<h4>Навигация</h4>
				<ul>
					<?php if ( $is_danila ) : ?>
						<li><a href="<?php echo esc_url( $danila_url ); ?>">Главная</a></li>
						<li><a href="<?php echo esc_url( vlata_page_url( 'danila-about' ) ); ?>">О компании</a></li>
						<li><a href="<?php echo esc_url( vlata_page_url( 'danila-works' ) ); ?>">Наши работы</a></li>
						<li><a href="<?php echo esc_url( vlata_page_url( 'danila-contacts' ) ); ?>">Контакты</a></li>
						<li><a href="<?php echo esc_url( $home_url ); ?>">← Ритуальная служба «Влата»</a></li>
					<?php else : ?>
						<li><a href="<?php echo esc_url( $home_url ); ?>">Главная</a></li>
						<li><a href="<?php echo esc_url( vlata_page_url( 'about' ) ); ?>">О компании</a></li>
						<li><a href="<?php echo esc_url( vlata_category_url( 'funerals' ) ); ?>">Похоронные услуги</a></li>
						<li><a href="<?php echo esc_url( vlata_page_url( 'works' ) ); ?>">Наши работы</a></li>
						<li><a href="<?php echo esc_url( vlata_page_url( 'contacts' ) ); ?>">Контакты</a></li>
						<li><a href="<?php echo esc_url( $danila_url ); ?>">Памятники «Данила Мастер» →</a></li>
					<?php endif; ?>
				</ul>
			</div>
			<div class="footer-nav">
				<?php if ( $is_danila ) : ?>
					<h4>Продукция</h4>
					<ul>
						<li><a href="<?php echo esc_url( vlata_category_url( 'granite' ) ); ?>">Гранит и мрамор</a></li>
						<li><a href="<?php echo esc_url( vlata_category_url( 'metal' ) ); ?>">Металл</a></li>
						<li><a href="<?php echo esc_url( vlata_category_url( 'engraving' ) ); ?>">Гравировка</a></li>
						<li><a href="<?php echo esc_url( vlata_category_url( 'installation' ) ); ?>">Установки</a></li>
					</ul>
				<?php else : ?>
					<h4>Услуги</h4>
					<ul>
						<li><a href="<?php echo esc_url( vlata_category_url( 'coffins' ) ); ?>">Гробы</a></li>
						<li><a href="<?php echo esc_url( vlata_category_url( 'wreaths' ) ); ?>">Венки и кресты</a></li>
						<li><a href="<?php echo esc_url( vlata_category_url( 'transport' ) ); ?>">Перевозка</a></li>
						<li><a href="<?php echo esc_url( vlata_category_url( 'hall' ) ); ?>">Прощальный зал</a></li>
						<li><a href="<?php echo esc_url( vlata_category_url( 'funerals' ) ); ?>">Все услуги</a></li>
					</ul>
				<?php endif; ?>
			</div>
			<div class="footer-contacts">
				<h4>Контакты</h4>
				<ul>
					<li><i class="fas fa-phone"></i><a href="tel:<?php echo esc_attr( $data['phone_main_raw'] ); ?>"><?php echo esc_html( $data['phone_main'] ); ?></a></li>
					<li><i class="fas fa-clock"></i><span><?php echo esc_html( $data['hours'] ); ?></span></li>
					<li><i class="fas fa-envelope"></i><a href="mailto:<?php echo esc_attr( $data['email'] ); ?>"><?php echo esc_html( $data['email'] ); ?></a></li>
					<li><i class="fas fa-map-marker-alt"></i><span><?php echo esc_html( $data['address_short'] ); ?></span></li>
				</ul>
			</div>
		</div>
		<div class="footer-bottom">
			<p>&copy; <?php echo esc_html( $year ); ?> <?php echo esc_html( $is_danila ? 'Данила Мастер' : 'Центр ритуальных услуг «Влата»' ); ?>. Все права защищены.</p>
			<nav class="footer-bottom-nav" aria-label="Организации">
				<a href="<?php echo esc_url( $home_url ); ?>">Влата</a>
				<a href="<?php echo esc_url( $danila_url ); ?>">Данила Мастер</a>
			</nav>
		</div>
	</div>
</footer>
<?php wp_footer(); ?>
</body>
</html>
