<?php
/**
 * Данные организаций. Значения по умолчанию можно изменить
 * в админке: Внешний вид → Настроить → Контакты организаций.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function vlata_brand_defaults() {
	return array(
		'vlata'  => array(
			'name'          => 'Влата',
			'full_name'     => 'Центр ритуальных услуг «Влата»',
			'tagline'       => 'ритуальная служба',
			'note'          => 'Ритуальные услуги · г. Ершов',
			'schema_type'   => 'FuneralHome',
			'schema_desc'   => 'Ритуальные услуги в г. Ершове и Ершовском районе: организация похорон, гробы, венки, кресты, перевозка, прощальный зал. Круглосуточно.',
			'phone_main'    => '+7 (960) 343-18-91',
			'phone_main_raw'=> '+789603431891',
			'phone_second'  => '+7 (927) 154-09-50',
			'phone_second_raw' => '+789271540950',
			'phone_confirm' => '+7 (927) 154-09-50',
			'header_phone_label' => 'Круглосуточно',
			'email'         => 'iva0281@yandex.ru',
			'hours'         => 'Круглосуточно, без выходных',
			'address'       => 'ул. Фрунзе, 18, г. Ершов, Саратовская область',
			'address_short' => 'ул. Фрунзе, 18, г. Ершов',
			'map_link'      => 'https://yandex.ru/maps/org/vlata/176311151621/',
			'map_embed'     => 'https://yandex.ru/map-widget/v1/?ll=48.270298%2C51.352332&z=17&pt=48.270298,51.352332,pm2rdm',
			'geo_lat'       => '51.352332',
			'geo_lon'       => '48.270298',
			'footer_text'   => 'Центр ритуальных услуг «Влата» — организация похорон в г. Ершове и Ершовском районе более 27 лет. Работаем круглосуточно.',
		),
		'danila' => array(
			'name'          => 'Данила Мастер',
			'full_name'     => '«Данила Мастер»',
			'tagline'       => 'производство памятников',
			'note'          => 'Производство памятников · г. Ершов',
			'schema_type'   => 'LocalBusiness',
			'schema_desc'   => 'Производство и установка памятников из гранита и мрамора',
			'phone_main'    => '+7 (909) 331-68-77',
			'phone_main_raw'=> '+789093316877',
			'phone_second'  => '+7 (937) 970-27-55',
			'phone_second_raw' => '+789379702755',
			'phone_confirm' => '+7 (909) 331-68-77',
			'header_phone_label' => 'Заказать расчёт',
			'email'         => 'iva0281@yandex.ru',
			'hours'         => 'Ежедневно с 8:00 до 17:00',
			'address'       => 'ул. Кутузова, 38, г. Ершов, Саратовская область',
			'address_short' => 'ул. Кутузова, 38, г. Ершов',
			'map_link'      => 'https://yandex.ru/maps/org/danila_master/125287762138/',
			'map_embed'     => 'https://yandex.ru/map-widget/v1/?ll=48.268223%2C51.361894&z=17&pt=48.268223,51.361894,pm2rdm',
			'geo_lat'       => '51.361894',
			'geo_lon'       => '48.268223',
			'footer_text'   => 'Изготовление и установка памятников из гранита и мрамора. Более 25 лет. Собственное производство, цены от производителя.',
		),
	);
}

function vlata_phone_raw( $phone ) {
	$raw = preg_replace( '/[^0-9]/', '', $phone );
	if ( 11 === strlen( $raw ) && '8' === $raw[0] ) {
		$raw = '7' . substr( $raw, 1 );
	}
	return '+' . $raw;
}

function vlata_brand_data( $brand = null ) {
	$brand    = $brand ? $brand : vlata_current_brand();
	$defaults = vlata_brand_defaults();
	$data     = isset( $defaults[ $brand ] ) ? $defaults[ $brand ] : $defaults['vlata'];

	$keys = array( 'phone_main', 'phone_second', 'email', 'hours', 'address' );
	foreach ( $keys as $key ) {
		$value = get_theme_mod( "vlata_{$brand}_{$key}" );
		if ( is_string( $value ) && '' !== $value ) {
			$data[ $key ] = $value;
		}
	}
	$data['phone_main_raw']   = vlata_phone_raw( $data['phone_main'] );
	$data['phone_second_raw'] = vlata_phone_raw( $data['phone_second'] );
	$data['phone_confirm']    = ( 'vlata' === $brand ) ? $data['phone_second'] : $data['phone_main'];
	return $data;
}

function vlata_register_customizer( $wp_customize ) {
	$defaults = vlata_brand_defaults();
	$labels   = array( 'vlata' => 'Влата', 'danila' => 'Данила Мастер' );
	$fields   = array(
		'phone_main'   => 'Телефон основной',
		'phone_second' => 'Телефон дополнительный',
		'email'        => 'Email',
		'hours'        => 'Режим работы',
		'address'      => 'Адрес',
	);

	foreach ( $labels as $brand => $label ) {
		$wp_customize->add_section( "vlata_contacts_{$brand}", array(
			'title'       => 'Контакты — ' . $label,
			'priority'    => 35,
		) );

		foreach ( $fields as $key => $field_label ) {
			$wp_customize->add_setting( "vlata_{$brand}_{$key}", array(
				'default'           => $defaults[ $brand ][ $key ],
				'sanitize_callback' => 'sanitize_text_field',
			) );
			$wp_customize->add_control( "vlata_{$brand}_{$key}", array(
				'label'   => $field_label,
				'section' => "vlata_contacts_{$brand}",
				'type'    => 'text',
			) );
		}
	}
}
add_action( 'customize_register', 'vlata_register_customizer' );
