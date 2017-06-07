<?php
	
	function add_events() {
	
		$labels = array(
			'name'                => __( 'Wydarzenia', 'kg' ),
			'singular_name'       => __( 'Wydarzenia', 'kg' ),
			'add_new'             => _x( 'Dodaj nowe wydarzenie', 'kg'),
			'add_new_item'        => __( 'Dodaj nowe wydarzenie', 'kg' ),
			'edit_item'           => __( 'Edytuj wydarzenie', 'kg' ),
			'new_item'            => __( 'Dodaj wydarzenie', 'kg' ),
			'view_item'           => __( 'Zobacz wydarzenie', 'kg' ),
			'search_items'        => __( 'Szukaj w wydarzeniach', 'kg' ),
			'not_found'           => __( 'Nie znaleziono wydarzeń', 'kg' ),
			'not_found_in_trash'  => __( 'Nie znaleziono wydarzeń w koszu', 'kg' ),
			'parent_item_colon'   => __( 'Wydarzenia:', 'kg' ),
			'menu_name'           => __( 'Wydarzenia', 'kg' ),
		);
	
	
		$args = array(
			'labels'                   => $labels,
			'hierarchical'        => false,
			'description'         => 'description',
			'taxonomies'          => array('category','subtype'),
			'public'              => true,
			'show_ui'             => true,
			'show_in_menu'        => true,
			'show_in_admin_bar'   => true,
			'menu_position'       => 5,
			'menu_icon'           => 'dashicons-store',
			'show_in_nav_menus'   => true,
			'publicly_queryable'  => true,
			'exclude_from_search' => false,
			'has_archive'         => true,
			'query_var'           => true,
			'can_export'          => true,
			'rewrite'             => true,
			'capability_type'     => 'post',
			'supports'            => array(
				'title', 'editor', 'thumbnail'
				)
		);
	
		register_post_type( 'event', $args );
	}
	
	add_action( 'init', 'add_events' );
	