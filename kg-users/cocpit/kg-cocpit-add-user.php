<?php

	class KG_Cocpit_Add_User {

		public function __construct() {
			add_action('admin_menu', array($this, 'add_page_to_menu'));
			add_action( 'admin_enqueue_scripts', array($this, 'add_styles') );
		}

		public function render() {
			include plugin_dir_path( __FILE__ ) . 'views/add-user.php';
		}

		public function add_styles() {

			 if(get_current_screen()->base == 'toplevel_page_add_kg_user') {
				
				// styles		 	
	
				 wp_register_style( 
				 	'kg_users_styles', 
				 	plugins_url( '../assets/css/style-users.css', __FILE__ )
				 );	

				 wp_enqueue_style( 'kg_users_styles' );		 	

				 // scripts
				 
				 wp_enqueue_script( 	 	
				 	'kg-add-user', 
				 	plugins_url( 'assets/add-user.js', __FILE__ ),
				 	array( 'jquery' ) 		 
				 );		

			 }

		}

		public function add_page_to_menu() {

			add_menu_page( 			
				'Dodaj',
				'Dodaj',
				'add_kg_user', 
				'add_kg_user',
				array($this, 'render' ),
				'dashicons-admin-users',
				71
				);

		}

	}
	