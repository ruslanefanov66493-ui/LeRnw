<?php
get_header();
$packages = vlata_get_packages();
?>
<section class="hero" id="top">
	<div class="hero-content">
		<div class="hero-inner">
			<h1 class="hero-title">Ритуальные услуги</h1>
			<ul class="hero-list">
				<li class="hero-item"><i class="fas fa-check-circle"></i><span>Организация похорон под ваш бюджет</span></li>
				<li class="hero-item"><i class="fas fa-check-circle"></i><span>Полный комплекс услуг</span></li>
				<li class="hero-item"><i class="fas fa-check-circle"></i><span>Оформление всех документов</span></li>
				<li class="hero-item"><i class="fas fa-check-circle"></i><span>Работаем круглосуточно</span></li>
			</ul>
			<button class="cta-button">
				<i class="fas fa-phone"></i>
				Заказать
			</button>
		</div>
	</div>
	<div class="slider-indicators">
		<span class="indicator active"></span>
		<span class="indicator"></span>
		<span class="indicator"></span>
	</div>
</section>

<section class="about-brief home-about">
	<div class="container">
		<div class="section-heading">
			<h2>Центр ритуальных услуг «Влата»</h2>
			<p>Специализированная служба по похоронному делу в г. Ершове и Ершовском районе уже более 27 лет. Мы те, на кого можно положиться в трудную минуту.</p>
		</div>
		<div class="features-row">
			<div class="feature-box">
				<h3>Более 27 лет</h3>
				<p>Квалифицированные специалисты, контроль на всех этапах похорон</p>
			</div>
			<div class="feature-box">
				<h3>Собственный автопарк</h3>
				<p>Катафалки 2–6 мест, перевозка на любые расстояния</p>
			</div>
			<div class="feature-box">
				<h3>Круглосуточно</h3>
				<p>Бесплатная консультация и выезд агента в любое время суток</p>
			</div>
		</div>
		<p style="text-align:center;margin-top:8px"><a href="<?php echo esc_url( vlata_page_url( 'about' ) ); ?>" class="btn-order">Подробнее о компании</a></p>
	</div>
</section>

<section class="services" id="services">
	<div class="container">
		<div class="section-heading">
			<h2>Пакеты услуг</h2>
			<p>Подберём оптимальный вариант под ваш бюджет. Цены прозрачны, возможна отсрочка платежа.</p>
		</div>
		<div class="services-grid">
			<?php foreach ( $packages as $package ) : ?>
				<div class="service-card">
					<div class="card-header"><h3><?php echo esc_html( $package['name'] ); ?></h3></div>
					<div class="card-content">
						<ul class="service-list">
							<?php foreach ( $package['items'] as $item ) : ?>
								<?php if ( 0 === strpos( $item, '—' ) ) : ?>
									<li class="service-subitem"><span><?php echo esc_html( ltrim( $item, '—' ) ); ?></span></li>
								<?php elseif ( preg_match( '/^\*\*(.+?)\*\*(.*)$/', $item, $m ) ) : ?>
									<li class="service-item"><i class="fas fa-check"></i><span><strong><?php echo esc_html( $m[1] ); ?></strong><?php echo esc_html( $m[2] ); ?></span></li>
								<?php else : ?>
									<li class="service-item"><i class="fas fa-check"></i><span><?php echo esc_html( $item ); ?></span></li>
								<?php endif; ?>
							<?php endforeach; ?>
						</ul>
						<div class="price">
							<span class="price-text">от</span>
							<span class="price-amount"><?php echo esc_html( vlata_format_price( $package['price'] ) ); ?></span>
							<span class="price-currency">руб</span>
						</div>
						<button class="service-button">Уточнить</button>
					</div>
				</div>
			<?php endforeach; ?>
		</div>
		<p style="text-align:center;margin-top:36px">
			<a href="<?php echo esc_url( vlata_category_url( 'funerals' ) ); ?>" class="btn-order">Каталог похоронных услуг</a>
		</p>
	</div>
</section>

<section class="page-content" style="padding-top:0;background:#1a1a1a">
	<div class="container">
		<div class="vlata-partner-card">
			<h2>Памятники — «Данила Мастер»</h2>
			<p>Изготовление и установка памятников из гранита и мрамора — отдельная организация «Данила Мастер». При полном комплексе ритуальных услуг у «Влата» выдаётся скидочный купон 5% на изделия партнёра.</p>
			<a href="<?php echo esc_url( vlata_page_url( 'danila' ) ); ?>" class="btn-order">Перейти в раздел «Данила Мастер»</a>
		</div>
	</div>
</section>
<?php
get_footer();
