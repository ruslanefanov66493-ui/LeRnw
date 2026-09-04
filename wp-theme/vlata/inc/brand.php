<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function vlata_danila_templates() {
	return array( 'page-danila-home.php', 'page-danila-about.php', 'page-danila-contacts.php', 'page-danila-works.php' );
}

function vlata_is_danila_page() {
	if ( is_page() ) {
		$templates = vlata_danila_templates();
		if ( in_array( get_page_template_slug( get_the_ID() ), $templates, true ) ) {
			return true;
		}
		$slug = get_post_field( 'post_name' );
		if ( 0 === strpos( $slug, 'danila' ) ) {
			return true;
		}
	}
	return false;
}

function vlata_term_belongs_to_monuments( $term_id ) {
	$monuments = get_term_by( 'slug', 'monuments', 'product_cat' );
	if ( ! $monuments ) {
		return false;
	}
	if ( (int) $term_id === (int) $monuments->term_id ) {
		return true;
	}
	$ancestors = get_ancestors( $term_id, 'product_cat' );
	return in_array( (int) $monuments->term_id, array_map( 'intval', $ancestors ), true );
}

function vlata_current_brand() {
	if ( vlata_is_danila_page() ) {
		return 'danila';
	}
	if ( function_exists( 'is_product_taxonomy' ) && is_product_taxonomy() ) {
		$term = get_queried_object();
		if ( $term && isset( $term->term_id ) && vlata_term_belongs_to_monuments( $term->term_id ) ) {
			return 'danila';
		}
		return 'vlata';
	}
	if ( function_exists( 'is_product' ) && is_product() ) {
		$terms = get_the_terms( get_the_ID(), 'product_cat' );
		if ( $terms && ! is_wp_error( $terms ) ) {
			foreach ( $terms as $term ) {
				if ( vlata_term_belongs_to_monuments( $term->term_id ) ) {
					return 'danila';
				}
			}
		}
	}
	return 'vlata';
}

function vlata_page_url( $slug ) {
	$page = get_page_by_path( $slug );
	if ( $page ) {
		return get_permalink( $page->ID );
	}
	return home_url( '/' . $slug . '/' );
}

function vlata_category_url( $slug ) {
	$term = get_term_by( 'slug', $slug, 'product_cat' );
	if ( $term && ! is_wp_error( $term ) ) {
		return get_term_link( $term );
	}
	return '#';
}

function vlata_active_page() {
	$slug = is_page() ? get_post_field( 'post_name' ) : '';
	$map  = array(
		'home'            => is_front_page(),
		'about'           => 'about' === $slug,
		'works'           => 'works' === $slug,
		'contacts'        => 'contacts' === $slug,
		'danila-home'     => 'danila' === $slug,
		'danila-about'    => 'danila-about' === $slug,
		'danila-works'    => 'danila-works' === $slug,
		'danila-contacts' => 'danila-contacts' === $slug,
	);
	foreach ( $map as $key => $active ) {
		if ( $active ) {
			return $key;
		}
	}
	if ( function_exists( 'is_product_taxonomy' ) && is_product_taxonomy() ) {
		$term = get_queried_object();
		if ( $term && isset( $term->slug ) ) {
			return $term->slug;
		}
	}
	if ( function_exists( 'is_product' ) && is_product() ) {
		$terms = get_the_terms( get_the_ID(), 'product_cat' );
		if ( $terms && ! is_wp_error( $terms ) ) {
			return $terms[0]->slug;
		}
	}
	return '';
}

function vlata_schema_json_ld() {
	$brand = vlata_brand_data();
	$schema = array(
		'@context'    => 'https://schema.org',
		'@type'       => $brand['schema_type'],
		'name'        => $brand['full_name'],
		'description' => $brand['schema_desc'],
		'url'         => home_url( '/' ),
		'areaServed'  => 'Ершов, Саратовская область',
		'telephone'   => $brand['phone_main_raw'],
		'priceRange'  => '₽₽',
		'address'     => array(
			'@type'           => 'PostalAddress',
			'streetAddress'   => $brand['address_short'],
			'addressLocality' => 'Ершов',
			'addressRegion'   => 'Саратовская область',
			'addressCountry'  => 'RU',
		),
		'geo'         => array(
			'@type'     => 'GeoCoordinates',
			'latitude'  => $brand['geo_lat'],
			'longitude' => $brand['geo_lon'],
		),
	);

	if ( 'danila' === vlata_current_brand() ) {
		$schema['openingHoursSpecification'] = array(
			'@type'     => 'OpeningHoursSpecification',
			'dayOfWeek' => array( 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday' ),
			'opens'     => '08:00',
			'closes'    => '17:00',
		);
	} else {
		$schema['openingHours'] = 'Mo-Su 00:00-24:00';
	}

	return $schema;
}
