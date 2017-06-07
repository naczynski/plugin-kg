<?php
	register_field_group(array (
		'id' => 'acf_prezent',
		'title' => 'Prezent',
		'fields' => array (
			array (
				'key' => 'field_557f65b48f9cb',
				'label' => '',
				'name' => 'present',
				'type' => 'relationship',
				'return_format' => 'id',
				'post_type' => array (
					0 => 'pdf',
					1 => 'link',
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
				'max' => 1,
			),
		),
		'location' => array (
			array (
				array (
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'post',
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