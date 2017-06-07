<?php

	register_field_group(array (
			'id' => 'acf_hide_from_front',
			'title' => 'Ukryty',
			'fields' => array (
				array (
					'key' => 'field_551235ee6d539',
					'label' => 'Ukryć z serwisu?',
					'name' => 'hide_from_front',
					'type' => 'true_false',
					'message' => 'Nie pokazuj danego zasobu na portalu (materiały szkoleniowe dla CIM- przekazanie jako prezent)',
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