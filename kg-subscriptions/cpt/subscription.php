<?php
	
	function add_subscription() {
	
		$labels = array(
			'name'                => __( 'Abonament', 'kg' ),
			'singular_name'       => __( 'Abonament', 'kg' ),
			'add_new'             => _x( 'Dodaj nowy abonament', 'kg'),
			'add_new_item'        => __( 'Dodaj nowy abonament', 'kg' ),
			'edit_item'           => __( 'Edytuj abonament', 'kg' ),
			'new_item'            => __( 'Dodaj abonament', 'kg' ),
			'view_item'           => __( 'Zobacz abonament', 'kg' ),
			'search_items'        => __( 'Szukaj w abonamentach', 'kg' ),
			'not_found'           => __( 'Nie znaleziono abonamentów', 'kg' ),
			'not_found_in_trash'  => __( 'Nie znaleziono  w koszu', 'kg' ),
			'parent_item_colon'   => __( 'Parent Zasoby (Wydarzenia):', 'kg' ),
			'menu_name'           => __( 'Abonamenty', 'kg' ),
		);

		$args = array(
			'labels'                   => $labels,
			'hierarchical'        => false,
			'description'         => 'description',
			'taxonomies'          => array(),
			'public'              => true,
			'show_ui'             => true,
			'show_in_menu'        => true,
			'show_in_admin_bar'   => true,
			'menu_position'       => 5,
			'menu_icon'           => 'dashicons-backup',
			'show_in_nav_menus'   => true,
			'publicly_queryable'  => true,
			'exclude_from_search' => false,
			'has_archive'         => true,
			'query_var'           => true,
			'can_export'          => true,
			'rewrite'             => true,
			'capability_type'     => 'post',
			'supports'            => array(
				'title'
			 )
		);
		
		register_post_type( 'subscription', $args );
	}
	
	add_action( 'init', 'add_subscription' );
