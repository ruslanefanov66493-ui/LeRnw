<?php
get_header();
$term  = get_queried_object();
$brand = vlata_current_brand();

$card_texts = array(
	'coffins'      => 'Эконом, комбинированные и элитные гробы, обитые тканью.',
	'church'       => 'Кресты, свечи, иконы, ритуальный текстиль и одежда для усопших.',
	'hall'         => 'Прощальный зал и содержание тел в холодильнике-хранилище.',
	'crosses'      => 'Деревянные и металлические кресты, мусульманские доски, католические кресты.',
	'transport'    => 'Специализированный автотранспорт по РФ, катафалк с подиумом и кондиционером.',
	'wreaths'      => 'Венки, корзины, букеты и цветы на любой выбор и бюджет.',
	'granite'      => 'Стелы с подставкой и цветником, размеры от 800×400×80.',
	'metal'        => 'Ограды (более 40 видов), кресты, столы и лавочки. Покрытие полимерное и порошковое.',
	'engraving'    => 'Портреты, ФИО, эпитафии и рисунки на камне.',
	'installation' => '10 вариантов монтажа памятников.',
);

$children = get_terms( array(
	'taxonomy'   => 'product_cat',
	'parent'     => $term->term_id,
	'hide_empty' => false,
	'orderby'    => 'name',
	'order'      => 'ASC',
) );

$brand_labels = array(
	'funerals'  => 'Влата · ритуальные услуги',
	'monuments' => 'Данила Мастер · производство памятников',
);
$is_danila = 'danila' === $brand;
$home_link = $is_danila ? vlata_page_url( 'danila' ) : home_url( '/' );
$home_text = $is_danila ? 'Данила Мастер' : 'Главная';

$catalog_lead = get_term_meta( $term->term_id, 'vlata_lead', true );
if ( ! $catalog_lead ) {
	$catalog_lead = 'funerals' === $term->slug
		? 'Полный комплекс ритуальных товаров и услуг. Цены прозрачны. Возможна отсрочка платежа. Уточнение и заказ — по телефону.'
		: 'Продукция и услуги производства «Данила Мастер». Организация похорон — у партнёра «Влата».';
}
?>
<section class="page-hero">
	<div class="container">
		<div class="breadcrumb"><a href="<?php echo esc_url( $home_link ); ?>"><?php echo esc_html( $home_text ); ?></a> / <?php echo esc_html( $term->name ); ?></div>
		<p class="brand-label"><?php echo esc_html( $brand_labels[ $term->slug ] ?? '' ); ?></p>
		<h1><?php echo esc_html( $term->name ); ?></h1>
		<p class="lead"><?php echo esc_html( $catalog_lead ); ?></p>
	</div>
</section>
<main class="page-content">
	<div class="container">
		<?php if ( ! empty( $children ) && ! is_wp_error( $children ) ) : ?>
			<div class="catalog-grid">
				<?php foreach ( $children as $child ) : ?>
					<?php
					$card_text = $card_texts[ $child->slug ] ?? wp_trim_words( wp_strip_all_tags( $child->description ), 20, '…' );
					?>
					<a class="catalog-card" href="<?php echo esc_url( get_term_link( $child ) ); ?>">
						<div class="card-top"><?php echo esc_html( $child->name ); ?></div>
						<div class="card-body">
							<p><?php echo esc_html( $card_text ); ?></p>
							<span class="card-link">Смотреть →</span>
						</div>
					</a>
				<?php endforeach; ?>
			</div>
			<?php if ( 'funerals' === $term->slug ) : ?>
				<div class="content-block" style="margin-top:36px">
					<h2>Пакеты организации похорон</h2>
					<p>Готовые комплексы услуг — см. также на <a href="<?php echo esc_url( home_url( '/' ) ); ?>#services">главной странице</a>.</p>
					<ul>
						<?php foreach ( vlata_get_packages() as $package ) : ?>
							<li><strong><?php echo esc_html( $package['name'] ); ?></strong> — от <?php echo esc_html( vlata_format_price( $package['price'] ) ); ?> руб</li>
						<?php endforeach; ?>
					</ul>
					<p class="price-note">Наши цены максимально прозрачны. С нами вы экономите своё время. Возможна отсрочка платежа.</p>
					<button class="btn-order"><i class="fas fa-phone"></i> Уточнить по телефону</button>
				</div>
			<?php endif; ?>
		<?php else : ?>
			<?php
			$description_blocks = get_term_meta( $term->term_id, 'vlata_blocks', true );
			if ( ! is_array( $description_blocks ) || empty( $description_blocks ) ) {
				$description_blocks = array_filter( array_map( 'trim', explode( "\n", (string) $term->description ) ) );
			}
			foreach ( $description_blocks as $block ) :
				if ( '' === trim( (string) $block ) ) {
					continue;
				}
				?>
				<div class="content-block"><?php echo wp_kses_post( $block ); ?></div>
			<?php endforeach; ?>

			<?php
			$image_ids = array();
			if ( vlata_woocommerce_active() ) {
				foreach ( vlata_category_product_ids( $term->term_id ) as $product_id ) {
					$image_ids = array_merge( $image_ids, vlata_get_product_image_ids( $product_id ) );
				}
			}
			if ( $image_ids ) :
				?>
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
		<?php endif; ?>
	</div>
</main>
<?php
get_footer();
