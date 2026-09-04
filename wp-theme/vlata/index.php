<?php
get_header();
?>
<section class="page-hero">
	<div class="container">
		<div class="breadcrumb"><a href="<?php echo esc_url( home_url( '/' ) ); ?>">Главная</a></div>
		<h1><?php echo esc_html( is_404() ? 'Страница не найдена' : ( is_search() ? 'Поиск' : get_the_title() ) ); ?></h1>
		<p class="lead"><?php echo esc_html( is_404() ? 'Такой страницы нет. Воспользуйтесь меню сайта.' : 'Результаты поиска и архивные записи.' ); ?></p>
	</div>
</section>
<main class="page-content">
	<div class="container">
		<?php if ( have_posts() ) : ?>
			<?php while ( have_posts() ) : the_post(); ?>
				<div class="content-block">
					<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
					<?php the_excerpt(); ?>
				</div>
			<?php endwhile; ?>
		<?php else : ?>
			<div class="content-block">
				<p><?php echo is_404() ? 'Вернитесь на <a href="' . esc_url( home_url( '/' ) ) . '">главную</a> или выберите раздел в меню.' : 'Ничего не найдено.'; ?></p>
			</div>
		<?php endif; ?>
	</div>
</main>
<?php
get_footer();
