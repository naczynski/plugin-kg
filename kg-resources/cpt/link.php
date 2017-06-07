<?php
	
	/**
	* Registers a new post type
	* @uses $wp_post_types Inserts new post type object into the list
	*
	* @param string  Post type key, must not exceed 20 characters
	* @param array|string  See optional args description above.
	* @return object|WP_Error the registered post type object, or an error object
	*/
	function register_cpt_link() {

		$labels = array(
			'name'                => __( 'Zasoby (Linki)', 'kg' ),
			'singular_name'       => __( 'Link', 'kg' ),
			'add_new'             => _x( 'Dodaj nowy link', 'kg'),
			'add_new_item'        => __( 'Dodaj nowe link', 'kg' ),
			'edit_item'           => __( 'Edytuj link', 'kg' ),
			'new_item'            => __( 'Dodaj link', 'kg' ),
			'view_item'           => __( 'Zobacz link', 'kg' ),
			'search_items'        => __( 'Szukaj w linkach', 'kg' ),
			'not_found'           => __( 'Nie znaleziono linków', 'kg' ),
			'not_found_in_trash'  => __( 'Nie znaleziono  linków w koszu', 'kg' ),
			'parent_item_colon'   => __( 'Parent Zasoby (Wydarzenia):', 'kg' ),
			'menu_name'           => __( 'Linki', 'kg' ),
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
			'menu_icon'           => 'dashicons-admin-links',
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
	
		register_post_type( 'link', $args );

	}
	
	add_action( 'init', 'register_cpt_link' );

