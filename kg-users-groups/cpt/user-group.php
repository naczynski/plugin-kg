<?php
	

	function add_user_group() {
	
		$labels = array(
			'name'                => __( 'Grupy', 'kg' ),
			'singular_name'       => __( 'Grupy', 'kg' ),
			'add_new'             => _x( 'Dodaj nową grupę', 'kg'),
			'add_new_item'        => __( 'Dodaj nową grupę', 'kg' ),
			'edit_item'           => __( 'Edytuj grupę', 'kg' ),
			'new_item'            => __( 'Dodaj gruep', 'kg' ),
			'view_item'           => __( 'Zobacz grupy', 'kg' ),
			'search_items'        => __( 'Szukaj w grupach', 'kg' ),
			'not_found'           => __( 'Nie znaleziono danej grupy', 'kg' ),
			'not_found_in_trash'  => __( 'Nie znaleziono w koszu', 'kg' ),
			'parent_item_colon'   => __( 'Grupy:', 'kg' ),
			'menu_name'           => __( 'Grupy', 'kg' ),
		);

		$args = array(
			'labels'                   => $labels,
			'hierarchical'        => false,
			'description'         => 'description',
			'taxonomies'          => array(),
			'public'              => true,
			'show_ui'             => true,
			'show_in_menu'        => true,
			'show_in_admin_bar'   => false,
			'menu_position'       => 72,
			'menu_icon'           => 'dashicons-admin-users',
			'show_in_nav_menus'   => false,
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
	
		register_post_type( 'user-groups', $args );

	}
	
	add_action( 'init', 'add_user_group' );
