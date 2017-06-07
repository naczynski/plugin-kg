<?php

	register_field_group(array (
			'id' => 'acf_cena-zl',
			'title' => 'Cena (zł)',
			'fields' => array (
				array (
					'key' => 'field_5552f6305a31e',
					'label' => 'Cena (zł)',
					'name' => '',
					'type' => 'tab',
				),
				array (
					'key' => 'field_5552f63b5a31f',
					'label' => 'Cena (zł)',
					'name' => 'price',
					'type' => 'number',
					'required' => 1,
					'default_value' => 0,
					'placeholder' => '',
					'prepend' => '',
					'append' => '',
					'min' => 0,
					'max' => 9999,
					'step' => 1,
				),
			),
			'location' => array (
				array (
					array (
						'param' => 'post_type',
						'operator' => '==',
						'value' => 'event',
						'order_no' => 0,
						'group_no' => 1,
					),
				),
				array (
					array (
						'param' => 'post_type',
						'operator' => '==',
						'value' => 'pdf',
						'order_no' => 0,
						'group_no' => 2,
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