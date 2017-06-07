<?php

	if(function_exists("register_field_group")){

	register_field_group(array (
		'id' => 'acf_sacasc',
		'title' => 'Pytania',
		'fields' => array (
			array (
				'key' => 'field_55b6fd5ff5d0b',
				'label' => 'Pytania',
				'name' => 'answers',
				'type' => 'repeater',
				'sub_fields' => array (
					array (
						'key' => 'field_55b6fd6bf5d0c',
						'label' => 'Pytanie',
						'name' => 'question',
						'type' => 'textarea',
						'required' => 1,
						'column_width' => '',
						'default_value' => '',
						'placeholder' => '',
						'maxlength' => '',
						'rows' => '',
						'formatting' => 'html',
					),
					array (
						'key' => 'field_55b6fd80f5d0d',
						'label' => 'Odpowiedź',
						'name' => 'answer',
						'type' => 'wysiwyg',
						'required' => 1,
						'column_width' => '',
						'default_value' => '',
						'toolbar' => 'full',
						'media_upload' => 'yes',
					),
				),
				'row_min' => '',
				'row_limit' => '',
				'layout' => 'row',
				'button_label' => 'Dodaj odpowiedź',
			),
		),
		'location' => array (
			array (
				array (
					'param' => 'page',
					'operator' => '==',
					'value' => KG_Config::getPublic('faq_page_id'),
					'order_no' => 0,
					'group_no' => 0,
				),
			),
		),
		'options' => array (
			'position' => 'normal',
			'layout' => 'no_box',
			'hide_on_screen' => array (
				0 => 'permalink',
				1 => 'the_content',
				2 => 'excerpt',
				3 => 'custom_fields',
				4 => 'discussion',
				5 => 'comments',
				6 => 'revisions',
				7 => 'slug',
				8 => 'author',
				9 => 'format',
				10 => 'featured_image',
				11 => 'categories',
				12 => 'tags',
				13 => 'send-trackbacks',
			),
		),
		'menu_order' => 0,
	));
}
