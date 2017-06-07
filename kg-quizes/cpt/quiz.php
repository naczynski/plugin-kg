<?php 


	function register_quiz() {
	
		$labels = array(
			'name'                => __( 'Quizy', 'text-domain' ),
			'singular_name'       => __( 'Quiz', 'text-domain' ),
			'add_new'             => _x( 'Dodaj nowy quiz', 'text-domain', 'text-domain' ),
			'add_new_item'        => __( 'Dodaj nowy quiz', 'text-domain' ),
			'edit_item'           => __( 'Edytuj Quiz', 'text-domain' ),
			'new_item'            => __( 'Dodaj nowy quiz', 'text-domain' ),
			'view_item'           => __( 'Zobacz quiz', 'text-domain' ),
			'search_items'        => __( 'Szukaj w quizach', 'text-domain' ),
			'not_found'           => __( 'Nie znaleziono żadnych quizów', 'text-domain' ),
			'not_found_in_trash'  => __( 'Nie znaleziono quizów', 'text-domain' ),
			'parent_item_colon'   => __( 'Parent Zasoby (Ankiety):', 'text-domain' ),
			'menu_name'           => __( 'Quizy', 'text-domain' ),
		);

		$args = array(

			'labels'              => $labels,
			'hierarchical'        => false,
			'description'         => 'description',
			'taxonomies'          => array('category','subtype'),
			'public'              => true,
			'show_ui'             => true,
			'show_in_menu'        => true,
			'show_in_admin_bar'   => true,
			'menu_position'       => 5,
			'menu_icon'           => 'dashicons-clipboard',
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
	
		register_post_type( 'quiz', $args );
	}
	
	add_action( 'init', 'register_quiz' );
