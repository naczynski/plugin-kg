<?php

	register_field_group(array (
			'id' => 'acf_group_users',
			'title' => 'Przypisanie użytkowników',
			'fields' => array (
				array (
					'key' => 'field_557f95asx56s8f9Da',
					'label' => '',
					'name' => 'users_assign',
					'type' => 'relationship',
					'return_format' => 'id',
					'post_type' => array (
						0 => 'Cim',
						1 => 'Coach',
						2 => 'Vip',
						3 => 'Zwykli'
					),
					'taxonomy' => array (
						0 => 'all',
					),
					'filters' => array (
						0 => 'search',
						1 => 'post_type',
					),
					'result_elements' => array (
						0 => 'featured_image',
						1 => 'post_type',
						2 => 'post_title',
					),
					'max' => 99,
				),
			),
			'location' => array (
				array (
					array (
						'param' => 'post_type',
						'operator' => '==',
						'value' => 'user-groups',
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
