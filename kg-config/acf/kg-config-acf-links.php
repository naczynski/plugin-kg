<?php

	if(function_exists("register_field_group")){
		register_field_group(array (
			'id' => 'acf_linki',
			'title' => 'Linki',
			'fields' => array (
				array (
					'key' => 'field_55389bca53117',
					'label' => 'Krótki opis',
					'name' => '',
					'type' => 'tab',
				),
				array (
					'key' => 'field_55389bd653118',
					'label' => 'Krótki opis',
					'name' => 'excerpt',
					'type' => 'wysiwyg',
					'required' => 1,
					'default_value' => '',
					'toolbar' => 'full',
					'media_upload' => 'no',
				),
				array (
					'key' => 'field_55389becadbeb',
					'label' => 'Powiązane zasoby',
					'name' => '',
					'type' => 'tab',
				),
				array (
					'key' => 'field_55389c06adbec',
					'label' => 'Powiązane zasoby',
					'name' => 'related_items',
					'type' => 'relationship',
					'return_format' => 'object',
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
					'max' => 5,
				),
				array (
					'key' => 'field_5552f8283dc7b',
					'label' => 'Link',
					'name' => '',
					'type' => 'tab',
				),
				array (
					'key' => 'field_5552f84a3dc7c',
					'label' => 'Link do pełnego artykuły (czytaj więcej)',
					'name' => 'read_more',
					'type' => 'text',
					'instructions' => 'Zawsze z przedrostkiem http://',
					'default_value' => '',
					'placeholder' => '',
					'prepend' => '',
					'append' => '',
					'formatting' => 'html',
					'maxlength' => '',
				)
			),
			'location' => array (
				array (
					array (
						'param' => 'post_type',
						'operator' => '==',
						'value' => 'link',
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
	}