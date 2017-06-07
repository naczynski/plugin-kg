<?php
	if(function_exists("register_field_group")){
		register_field_group(array (
			'id' => 'acf_opcje',
			'title' => 'Opcje',
			'fields' => array (
				array (
					'key' => 'field_558cb318935a6',
					'label' => 'Dymki',
					'name' => '',
					'type' => 'tab',
				),
				array (
					'key' => 'field_555ad7ebd91f3',
					'label' => 'Opis "Abstrakt"',
					'name' => 'desc_abstract',
					'type' => 'textarea',
					'default_value' => '',
					'placeholder' => '',
					'maxlength' => '',
					'rows' => '',
					'formatting' => 'html',
				),
				array (
					'key' => 'field_555ad7fe100ce',
					'label' => 'Opis "Knowledge To Use"',
					'name' => 'desc_ktu',
					'type' => 'textarea',
					'default_value' => '',
					'placeholder' => '',
					'maxlength' => '',
					'rows' => '',
					'formatting' => 'html',
				),
				array (
					'key' => 'field_555ad816100cf',
					'label' => 'Opis "Ideas To Inspire"',
					'name' => 'desc_iti',
					'type' => 'textarea',
					'default_value' => '',
					'placeholder' => '',
					'maxlength' => '',
					'rows' => '',
					'formatting' => 'br',
				),
				array (
					'key' => 'field_558cb330935a7',
					'label' => 'Darmowe zasoby',
					'name' => '',
					'type' => 'tab',
				),
				array (
					'key' => 'field_558cb33b935a8',
					'label' => '',
					'name' => 'free_resources',
					'type' => 'relationship',
					'instructions' => 'Wybierz zasoby spośród których użytkownik może wybierać gdy posiada odpowiedni abonament.',
					'return_format' => 'id',
					'post_type' => array (
						0 => 'pdf',
					),
					'taxonomy' => array (
						0 => 'all',
					),
					'filters' => array (
						0 => 'search',
					),
					'result_elements' => array (
						0 => 'post_type',
						1 => 'post_title',
					),
					'max' => '',
				),
			),
			'location' => array (
				array (
					array (
						'param' => 'options_page',
						'operator' => '==',
						'value' => 'acf-options',
						'order_no' => 0,
						'group_no' => 0,
					),
				),
				array (
					array (
						'param' => 'ef_user',
						'operator' => '==',
						'value' => 'questus-admin',
						'order_no' => 0,
						'group_no' => 1,
					),
				),
				array (
					array (
						'param' => 'ef_user',
						'operator' => '==',
						'value' => 'administrator',
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
	}