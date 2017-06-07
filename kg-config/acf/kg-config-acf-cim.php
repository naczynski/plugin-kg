<?php

	register_field_group(array (
			'id' => 'acf_cim_resource',
			'title' => 'CIM',
			'fields' => array (
				array (
					'key' => 'field_551455ee6d539',
					'label' => 'Tylko dla CIM?',
					'name' => 'only_for_cim',
					'type' => 'true_false',
					'message' => 'Materiał przeznaczony tylko dla studentów CIM',
					'default_value' => 0,
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
				array (
					array (
						'param' => 'post_type',
						'operator' => '==',
						'value' => 'link',
						'order_no' => 0,
						'group_no' => 1,
					),
				),
				array (
					array (
						'param' => 'post_type',
						'operator' => '==',
						'value' => 'quiz',
						'order_no' => 0,
						'group_no' => 1,
					),
				),
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
						'value' => 'task',
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