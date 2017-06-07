<?php

	register_field_group(array (
		'id' => 'acf_abonament',
		'title' => 'Abonament',
		'fields' => array (
			array (
				'key' => 'field_55808722b922a',
				'label' => 'Czas trwania (dni)',
				'name' => 'days_durations',
				'type' => 'number',
				'required' => 1,
				'default_value' => 0,
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'min' => 0,
				'max' => '',
				'step' => '',
			),
			array (
				'key' => 'field_5580879bd9f08',
				'label' => 'Ilość darmowych zasobów',
				'name' => 'free_resources',
				'type' => 'number',
				'required' => 1,
				'default_value' => 0,
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'min' => 0,
				'max' => '',
				'step' => '',
			),
			array (
				'key' => 'field_558087efa8933',
				'label' => 'Cena (zł)',
				'name' => 'price',
				'type' => 'number',
				'required' => 1,
				'default_value' => 0,
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'min' => 0,
				'max' => '',
				'step' => '',
			),
		),
		'location' => array (
			array (
				array (
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'subscription',
					'order_no' => 0,
					'group_no' => 0,
				),
			),
		),
		'options' => array (
			'position' => 'normal',
			'layout' => 'no_box',
			'hide_on_screen' => array (
			),
		),
		'menu_order' => 0,
	));
