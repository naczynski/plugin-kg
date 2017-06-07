<?php
	
	function add_task() {
	
		$labels = array(
			'name'                => __( 'Zadania', 'kg' ),
			'singular_name'       => __( 'Zadania', 'kg' ),
			'add_new'             => _x( 'Dodaj nowe zadanie', 'kg'),
			'add_new_item'        => __( 'Dodaj nowe zadanie', 'kg' ),
			'edit_item'           => __( 'Edytuj zadanie', 'kg' ),
			'new_item'            => __( 'Dodaj zadanie', 'kg' ),
			'view_item'           => __( 'Zobacz zadanie', 'kg' ),
			'search_items'        => __( 'Szukaj w abonamentach', 'kg' ),
			'not_found'           => __( 'Nie znaleziono zadań', 'kg' ),
			'not_found_in_trash'  => __( 'Nie znaleziono zadań w koszu', 'kg' ),
			'parent_item_colon'   => __( 'Rodzice dla zadania:', 'kg' ),
			'menu_name'           => __( 'Zadania', 'kg' ),
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
			'menu_position'       => 3,
			'menu_icon'           => 'dashicons-welcome-learn-more',
			'show_in_nav_menus'   => true,
			'publicly_queryable'  => true,
			'exclude_from_search' => false,
			'has_archive'         => true,
			'query_var'           => true,
			'can_export'          => true,
			'rewrite'             => array(
				'slug' => 'zadanie'
			),
			'capability_type'     => 'post',
			'supports'            => array(
				'title', 'thumbnail'
			 )
		);
		
		register_post_type( 'task', $args );
	}
	
	add_action( 'init', 'add_task' );
