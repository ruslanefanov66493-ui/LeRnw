<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'VLATA_VERSION', '1.0.0' );

require get_theme_file_path( 'inc/config.php' );
require get_theme_file_path( 'inc/brand.php' );
require get_theme_file_path( 'inc/packages.php' );
require get_theme_file_path( 'inc/importer.php' );

function vlata_setup() {
	load_theme_textdomain( 'vlata', get_theme_file_path( 'languages' ) );
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'html5', array( 'search-form', 'gallery', 'caption', 'style', 'script' ) );
	add_theme_support( 'responsive-embeds' );
	add_theme_support( 'custom-logo' );

	if ( class_exists( 'WooCommerce' ) ) {
		add_theme_support( 'woocommerce', array(
			'product_grid' => array( 'default_columns' => 3 ),
		) );
		remove_theme_support( 'wc-product-gallery-zoom' );
		remove_theme_support( 'wc-product-gallery-lightbox' );
		remove_theme_support( 'wc-product-gallery-slider' );
	}
}
add_action( 'after_setup_theme', 'vlata_setup' );

function vlata_assets() {
	wp_enqueue_style( 'vlata-main', get_theme_file_uri( 'style.css' ), array(), VLATA_VERSION );
	wp_enqueue_style( 'vlata-pages', get_theme_file_uri( 'assets/css/pages-style.css' ), array( 'vlata-main' ), VLATA_VERSION );
	wp_enqueue_style( 'font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css', array(), '6.0.0' );
	wp_enqueue_script( 'vlata-theme', get_theme_file_uri( 'assets/js/theme.js' ), array(), VLATA_VERSION, true );
}
add_action( 'wp_enqueue_scripts', 'vlata_assets' );

function vlata_body_classes( $classes ) {
	$classes[] = 'brand-' . vlata_current_brand();
	return $classes;
}
add_filter( 'body_class', 'vlata_body_classes' );

function vlata_body_open() {
	$brand = vlata_current_brand();
	$data  = vlata_brand_data( $brand );
	echo 'data-brand="' . esc_attr( $brand ) . '" data-phone="' . esc_attr( $data['phone_confirm'] ) . '" data-phone-raw="' . esc_attr( vlata_phone_raw( $data['phone_confirm'] ) ) . '"';
}

function vlata_head_meta() {
	$data = vlata_brand_data();
	echo '<meta name="theme-color" content="#121212">' . "\n";
	echo '<meta name="geo.region" content="RU-SAR">' . "\n";
	echo '<meta name="geo.placename" content="Ершов">' . "\n";
	echo '<meta name="geo.position" content="' . esc_attr( $data['geo_lat'] . ';' . $data['geo_lon'] ) . '">' . "\n";
	echo '<meta name="ICBM" content="' . esc_attr( $data['geo_lat'] . ', ' . $data['geo_lon'] ) . '">' . "\n";
}
add_action( 'wp_head', 'vlata_head_meta', 1 );

function vlata_schema_ld() {
	echo '<script type="application/ld+json">' . wp_json_encode( vlata_schema_json_ld(), JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES ) . '</script>' . "\n";
}
add_action( 'wp_footer', 'vlata_schema_ld' );

function vlata_template_include( $template ) {
	if ( is_page() && ! is_page_template() ) {
		$slug      = get_post_field( 'post_name' );
		$candidate = locate_template( 'page-' . $slug . '.php' );
		if ( $candidate ) {
			return $candidate;
		}
	}
	return $template;
}
add_filter( 'template_include', 'vlata_template_include' );

function vlata_woocommerce_active() {
	return class_exists( 'WooCommerce' );
}

if ( vlata_woocommerce_active() ) {
	add_filter( 'woocommerce_enqueue_styles', '__return_empty_array' );

	remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20 );
	remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar', 10 );

	remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5 );
	remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );
	remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40 );
	remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_sharing', 50 );

	add_filter( 'woocommerce_is_purchasable', '__return_false' );
	add_filter( 'woocommerce_product_add_to_cart_text', function () {
		return 'Уточнить по телефону';
	} );

	function vlata_redirect_cart_checkout() {
		if ( is_cart() || is_checkout() ) {
			wp_safe_redirect( home_url( '/' ) );
			exit;
		}
	}
	add_action( 'template_redirect', 'vlata_redirect_cart_checkout' );

	add_filter( 'woocommerce_get_availability', function ( $availability ) {
		$availability['availability'] = '';
		return $availability;
	} );
}

function vlata_old_url_map() {
	return array(
		'index.html'          => array( 'type' => 'home' ),
		'about.html'          => array( 'type' => 'page', 'slug' => 'about' ),
		'contacts.html'       => array( 'type' => 'page', 'slug' => 'contacts' ),
		'works.html'          => array( 'type' => 'page', 'slug' => 'works' ),
		'funerals.html'       => array( 'type' => 'term', 'slug' => 'funerals' ),
		'monuments.html'      => array( 'type' => 'page', 'slug' => 'danila' ),
		'coffins.html'        => array( 'type' => 'term', 'slug' => 'coffins' ),
		'church.html'         => array( 'type' => 'term', 'slug' => 'church' ),
		'hall.html'           => array( 'type' => 'term', 'slug' => 'hall' ),
		'crosses.html'        => array( 'type' => 'term', 'slug' => 'crosses' ),
		'transport.html'      => array( 'type' => 'term', 'slug' => 'transport' ),
		'wreaths.html'        => array( 'type' => 'term', 'slug' => 'wreaths' ),
		'granite.html'        => array( 'type' => 'term', 'slug' => 'granite' ),
		'metal.html'          => array( 'type' => 'term', 'slug' => 'metal' ),
		'engraving.html'      => array( 'type' => 'term', 'slug' => 'engraving' ),
		'installation.html'   => array( 'type' => 'term', 'slug' => 'installation' ),
	);
}

function vlata_old_url_redirect() {
	if ( ! is_404() ) {
		return;
	}
	$request = trim( wp_parse_url( $_SERVER['REQUEST_URI'] ?? '', PHP_URL_PATH ), '/' );
	$file    = basename( $request );
	$map     = vlata_old_url_map();

	if ( ! isset( $map[ $file ] ) ) {
		return;
	}
	$target = $map[ $file ];
	if ( 'home' === $target['type'] ) {
		wp_safe_redirect( home_url( '/' ), 301 );
		exit;
	}
	if ( 'page' === $target['type'] ) {
		wp_safe_redirect( vlata_page_url( $target['slug'] ), 301 );
		exit;
	}
	$url = vlata_category_url( $target['slug'] );
	if ( '#' !== $url ) {
		wp_safe_redirect( $url, 301 );
		exit;
	}
}
add_action( 'template_redirect', 'vlata_old_url_redirect' );

function vlata_get_product_image_ids( $product_id ) {
	$ids = array();
	$thumb = get_post_thumbnail_id( $product_id );
	if ( $thumb ) {
		$ids[] = (int) $thumb;
	}
	$gallery = get_post_meta( $product_id, '_product_image_gallery', true );
	if ( $gallery ) {
		foreach ( explode( ',', $gallery ) as $id ) {
			$id = (int) trim( $id );
			if ( $id && ! in_array( $id, $ids, true ) ) {
				$ids[] = $id;
			}
		}
	}
	return $ids;
}

function vlata_category_product_ids( $term_id ) {
	$products = get_posts( array(
		'post_type'      => 'product',
		'posts_per_page' => 100,
		'orderby'        => 'menu_order date',
		'order'          => 'ASC',
		'tax_query'      => array(
			array(
				'taxonomy' => 'product_cat',
				'field'    => 'term_id',
				'terms'    => $term_id,
			),
		),
	) );
	return wp_list_pluck( $products, 'ID' );
}

function vlata_gallery_html( $image_ids, $link_to = '' ) {
	if ( empty( $image_ids ) ) {
		return '';
	}
	$out = '<div class="gallery-grid">';
	foreach ( $image_ids as $id ) {
		$img = wp_get_attachment_image( $id, 'large', false, array( 'loading' => 'lazy' ) );
		if ( $link_to ) {
			$out .= '<a href="' . esc_url( $link_to ) . '">' . $img . '</a>';
		} else {
			$out .= $img;
		}
	}
	$out .= '</div>';
	return $out;
}
