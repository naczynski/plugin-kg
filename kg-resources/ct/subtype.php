<?php

	function subtype() {
	
		$labels = array(
			'name'					=> _x( 'Tagi', 'Taxonomy plural name', 'text-domain' ),
			'singular_name'			=> _x( 'Tag', 'Taxonomy singular name', 'text-domain' ),
			'search_items'			=> __( 'Szukaj w tagach', 'text-domain' ),
			'popular_items'			=> __( 'Popularne tagi', 'text-domain' ),
			'all_items'				=> __( 'Wszystkie tagi', 'text-domain' ),
			'parent_item'			=> __( 'Rodzic dla tag', 'text-domain' ),
			'parent_item_colon'		=> __( 'Rodzic dla tag', 'text-domain' ),
			'edit_item'				=> __( 'Edytuj tag', 'text-domain' ),
			'update_item'			=> __( 'Aktualizuj tag', 'text-domain' ),
			'add_new_item'			=> __( 'Dodaj nowy tag ', 'text-domain' ),
			'new_item_name'			=> __( 'Nowy tag', 'text-domain' ),
			'add_or_remove_items'	=> __( 'Add or remove Plural Name', 'text-domain' ),
			'choose_from_most_used'	=> __( 'Wybierz z najbardziej popularnych', 'text-domain' ),
			'menu_name'				=> __( 'Podkategorie', 'text-domain' ),
		);
	
		$args = array(
			'labels'            => $labels,
			'public'            => true,
			'show_in_nav_menus' => true,
			'show_admin_column' => false,
			'hierarchical'      => true,
			'show_tagcloud'     => true,
			'show_ui'           => true,
			'query_var'         => true,
			'rewrite'           => true,
			'query_var'         => true,
			'capabilities'      => array(),
		);
	
		register_taxonomy( 'subtype', array( 'post' ), $args );
	}
	
	add_action( 'init', 'subtype' );