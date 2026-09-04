<?php
get_header();
$cards = array(
	'funerals'  => array(
		'name' => 'Похоронные услуги',
		'desc' => 'Полный комплекс ритуальных товаров и услуг: гробы, венки, кресты, перевозка, прощальный зал.',
	),
	'monuments' => array(
		'name' => 'Памятники — Данила Мастер',
		'desc' => 'Гранит и мрамор, металлические изделия, гравировка, варианты установок.',
	),
);
?>
<section class="page-hero">
	<div class="container">
		<div class="breadcrumb"><a href="<?php echo esc_url( home_url( '/' ) ); ?>">Главная</a> / Каталог</div>
		<h1>Каталог</h1>
		<p class="lead">Две организации: ритуальные услуги «Влата» и производство памятников «Данила Мастер».</p>
	</div>
</section>
<main class="page-content">
	<div class="container">
		<div class="catalog-grid">
			<?php foreach ( $cards as $slug => $card ) : ?>
				<a class="catalog-card" href="<?php echo esc_url( vlata_category_url( $slug ) ); ?>">
					<div class="card-top"><?php echo esc_html( $card['name'] ); ?></div>
					<div class="card-body">
						<p><?php echo esc_html( $card['desc'] ); ?></p>
						<span class="card-link">Смотреть →</span>
					</div>
				</a>
			<?php endforeach; ?>
		</div>
	</div>
</main>
<?php
get_footer();
