<?php
	register_field_group(array (
		'id' => 'acf_pdf-2',
		'title' => 'Pdf',
		'fields' => array (
			array (
				'key' => 'field_55472e9c3fc12',
				'label' => 'Krótki opis',
				'name' => '',
				'type' => 'tab',
			),
			array (
				'key' => 'field_55472e9c4089b',
				'label' => 'Krótki opis',
				'name' => 'excerpt',
				'type' => 'wysiwyg',
				'required' => 1,
				'default_value' => '',
				'toolbar' => 'full',
				'media_upload' => 'no',
			),
			array (
				'key' => 'field_55472e9c414b9',
				'label' => 'Powiązane zasoby',
				'name' => '',
				'type' => 'tab',
			),
			array (
				'key' => 'field_55472e9c420e5',
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
				),
				'result_elements' => array (
					0 => 'featured_image',
					1 => 'post_type',
					2 => 'post_title',
				),
				'max' => 5,
			),
		),
		'location' => array (
			array (
				array (
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'pdf',
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
	