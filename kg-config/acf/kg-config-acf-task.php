<?php

	register_field_group(array (
			'id' => 'acf_tasks',
			'title' => 'Zadania',
			'fields' => array (
				array (
					'key' => 'field_55356f830bd17',
					'label' => 'Zadanie',
					'name' => '',
					'type' => 'tab',
				),
				array (
					'key' => 'field_53434bd653118',
					'label' => 'Zadanie',
					'name' => 'task_question',
					'type' => 'wysiwyg',
					'required' => 1,
					'default_value' => '',
					'toolbar' => 'full',
					'media_upload' => 'no',
				),
				array (
					'key' => 'field_553770029a722',
					'label' => 'Powiązane zasoby',
					'name' => '',
					'type' => 'tab',
				),
				array (
					'key' => 'field_55376fd59a721',
					'label' => 'Powiązane zasoby',
					'name' => 'related_items',
					'type' => 'relationship',
					'return_format' => 'object',
					'post_type' => array (
						0 => 'pdf',
						1 => 'quiz',
						2 => 'event',
						3 => 'ebook',
						4 => 'link',
						5 => 'task'
					),
					'taxonomy' => array (
						0 => 'all',
					),
					'filters' => array (
						0 => 'search',
						1 => 'post_type'
					),
					'result_elements' => array (
						0 => 'featured_image',
						1 => 'post_type',
						2 => 'post_title',
					),
					'max' => 5,
				),
				array (
					'key' => 'field_553450029a722',
					'label' => 'Zasoby do wygrania',
					'name' => '',
					'type' => 'tab',
				),
				array (
					'key' => 'field_554866fd59a721',
					'label' => 'Zasoby',
					'name' => 'resources_to_win',
					'type' => 'relationship',
					'return_format' => 'id',
					'required' => 1,
					'post_type' => array (
						0 => 'pdf',
						1 => 'quiz',
						3 => 'event',
						4 => 'link',
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
					'max' => 15,
				),
				array (
					'key' => 'field_558771588dd07',
					'label' => 'Ilość lików',
					'name' => 'likes_to_win_tab',
					'type' => 'tab',
				),
				array (
					'key' => 'field_545523608dd08',
					'label' => 'Ilość lików potrzebnych do zdobycia nagrody',
					'name' => 'likes_to_win',
					'type' => 'number',
					'required' => 1,
					'default_value' => 25,
					'placeholder' => '',
					'prepend' => '',
					'append' => '',
					'min' => 0,
					'max' => '100',
					'step' => 1,
				),
				array (
					'key' => 'field_564771588dd07',
					'label' => 'Typ zadania',
					'name' => 'task_type',
					'type' => 'tab',
				),
				array (
					'key' => 'field_1432149117677',
					'label' => 'Typ zadania',
					'name' => 'task_type',
					'type' => 'radio',
					'choices' => array (
						'forum' => 'Forum (użytkownik widzi od razu odpowiedzi innych użytkowników, może dodawać wiele odpowiedzi)',
						'private' => 'Prywatne (użytkownik może zobaczyć innych odpowiedzi dopiero gdy sam jej udzieli, max 1 odpowiedź)',
					),
					'other_choice' => 0,
					'save_other_choice' => 0,
					'default_value' => '',
					'layout' => 'vertical',
				),
				array (
					'key' => 'field_564771588fgs07',
					'label' => 'Status zadania',
					'name' => 'task_status',
					'type' => 'tab',
				),
				array (
					'key' => 'field_1423449117677',
					'label' => 'Status zadania',
					'name' => 'task_status',
					'type' => 'radio',
					'choices' => array (
						'active' => 'Aktywne (użytkownicy mogą dodawać odpowiedzi)',
						'closed' => 'Zamknięte (użytkownicy nie mogą dodawać odpowiedzi)',
					),
					'other_choice' => 0,
					'save_other_choice' => 0,
					'default_value' => '',
					'layout' => 'vertical',
				),

			),
			'location' => array (
				array (
					array (
						'param' => 'post_type',
						'operator' => '==',
						'value' => 'task',
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