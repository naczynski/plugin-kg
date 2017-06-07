<?php
	
	if(function_exists("register_field_group")){
		register_field_group(array (
			'id' => 'acf_wydarzenia',
			'title' => 'Wydarzenia',
			'fields' => array (
				array (
					'key' => 'field_5538990a6db8d',
					'label' => 'Krótki opis',
					'name' => '',
					'type' => 'tab',
				),
				array (
					'key' => 'field_553899136db8e',
					'label' => 'Krótki opis',
					'name' => 'excerpt',
					'type' => 'wysiwyg',
					'required' => 1,
					'default_value' => '',
					'placeholder' => '',
					'maxlength' => 254,
					'rows' => '',
					'formatting' => 'html',
				),
				array (
					'key' => 'field_553899370fa0c',
					'label' => 'Powiązane zasoby',
					'name' => '',
					'type' => 'tab',
				),
				array (
					'key' => 'field_553899450fa0d',
					'label' => 'Powiązane zasoby',
					'name' => 'related_items',
					'type' => 'relationship',
					'required' => 0,
					'return_format' => 'object',
					'post_type' => array (
						0 => 'pdf',
						1 => 'quiz',
						2 => 'event',
						3 => 'ebook',
						4 => 'link',
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
				array (
					'key' => 'field_553899eb0ccbf',
					'label' => 'Miejsce',
					'name' => '',
					'type' => 'tab',
				),
				array (
					'key' => 'field_553899d30ccbe',
					'label' => 'Miejsce',
					'name' => 'place',
					'type' => 'google_map',
					'required' => 1,
					'center_lat' => '',
					'center_lng' => '',
					'zoom' => '',
					'height' => '',
				),
				array (
					'key' => 'field_553345seb0ccbf',
					'label' => 'Data',
					'name' => '',
					'type' => 'tab',
				),
				array (
					'key' => 'field_559ed649f5ec6',
					'label' => 'Data i czas wydarzenia',
					'name' => 'date',
					'type' => 'date_time_picker',
					'show_date' => 'true',
					'date_format' => 'dd-mm-yy',
					'time_format' => 'HH:mm',
					'show_week_number' => 'false',
					'picker' => 'slider',
					'save_as_timestamp' => 'true',
					'get_as_timestamp' => 'false',
					
				),
				array (
					'key' => 'field_55389a44161f5',
					'label' => 'Ilość miejsc',
					'name' => '',
					'type' => 'tab',
				),
				array (
					'key' => 'field_55389a4f161f6',
					'label' => 'Dostępne miejsca',
					'name' => 'avaliable_places',
					'type' => 'number',
					'required' => 1,
					'default_value' => '100',
					'placeholder' => '',
					'prepend' => '',
					'append' => '',
					'min' => 0,
					'max' => '',
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