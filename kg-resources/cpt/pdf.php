<?php

	/**
	* Registers a new post type
	* @uses $wp_post_types Inserts new post type object into the list
	*
	* @param string  Post type key, must not exceed 20 characters
	* @param array|string  See optional args description above.
	* @return object|WP_Error the registered post type object, or an error object
	*/
	function register_pdf() {
	
		$labels = array(
			'name'                => __( 'Zasoby (PDF)', 'kg' ),
			'singular_name'       => __( 'PDF', 'kg' ),
			'add_new'             => _x( 'Dodaj nowy zasób', 'kg' ),
			'add_new_item'        => __( 'Dodaj nowy zasób', 'kg' ),
			'edit_item'           => __( 'Edytuj zasoby', 'kg' ),
			'new_item'            => __( 'Dodaj nowy zasób', 'kg' ),
			'view_item'           => __( 'Zobacz w zasobach', 'kg' ),
			'search_items'        => __( 'Szukaj w zasobach (PDF)', 'kg' ),
			'not_found'           => __( 'Nie znaleziono żadnych zasobów', 'kg' ),
			'not_found_in_trash'  => __( 'Nie ma ądnych zasobów w koszu', 'kg' ),
			'parent_item_colon'   => __( 'Parent Zasoby (PDF):', 'kg' ),
			'menu_name'           => __( 'Zasoby do pobrania', 'kg' ),
		);
	
		$args = array(

			'labels'              => $labels,
			'menu_icon'			  => 'dashicons-media-text',
			'hierarchical'        => false,
			'description'         => 'description',
			'taxonomies'          => array('category','subtype'),
			'public'              => true,
			'show_ui'             => true,
			'show_in_menu'        => true,
			'show_in_admin_bar'   => true,
			'menu_position'       => 5,
			'show_in_nav_menus'   => true,
			'publicly_queryable'  => true,
			'exclude_from_search' => false,
			'has_archive'         => true,
			'query_var'           => true,
			'can_export'          => true,
			'rewrite'             => true,
			'capability_type'     => 'post',
			// 'capabilities' => array(

				// 	// meta caps (don't assign these to roles)
				// 'edit_post'              => 'edit_example',
				// 'read_post'              => 'read_example',
				// 'delete_post'            => 'delete_example',

				// // primitive/meta caps
				// 'create_posts'           => 'create_examples',

				// // primitive caps used outside of map_meta_cap()
				// 'edit_posts'             => 'edit_examples',
				// 'edit_others_posts'      => 'manage_examples',
				// 'publish_posts'          => 'manage_examples',
				// 'read_private_posts'     => 'read',

				// // primitive caps used inside of map_meta_cap()
				// 'read'                   => 'read',
				// 'delete_posts'           => 'manage_examples',
				// 'delete_private_posts'   => 'manage_examples',
				// 'delete_published_posts' => 'manage_examples',
				// 'delete_others_posts'    => 'manage_examples',
				// 'edit_private_posts'     => 'edit_examples',
				// 'edit_published_posts'   => 'edit_examples'


			// ),
			'supports'            => array(
				'title', 'editor', 'thumbnail'
				)
		);
	
		register_post_type( 'pdf', $args );

	}
	
	add_action( 'init', 'register_pdf' );
