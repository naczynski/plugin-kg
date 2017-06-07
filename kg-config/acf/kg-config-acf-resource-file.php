<?php

	register_field_group(array (
		'id' => 'acf_zasob-plik',
		'title' => 'Zasób (plik)',
		'fields' => array (
			array (
				'key' => 'field_55433ddf02898',
				'label' => 'Zasób',
				'name' => 'private_file',
				'type' => 'file',
				'required' => 1,
				'save_format' => 'object',
				'library' => 'all',
			),
			array (
				'key' => 'field_5559c2be6f444',
				'label' => 'Dostępność',
				'name' => 'is_free',
				'type' => 'true_false',
				'message' => 'Zasób darmowy',
				'default_value' => 0,
			)
		),
		'location' => array (
			array (
				array (
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'ebook',
					'order_no' => 0,
					'group_no' => 0,
				),
			),
			array (
				array (
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'pdf',
					'order_no' => 0,
					'group_no' => 1,
				),
			),
		),
		'options' => array (
			'position' => 'side',
			'layout' => 'default',
			'hide_on_screen' => array (
			),
		),
		'menu_order' => 0,
	));