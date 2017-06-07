<?php

	class KG_Cocpit_Sent_Message_To_All {


		public function __construct() {
			add_action('admin_menu', array($this, 'add_page_to_menu'));
			add_action( 'admin_enqueue_scripts', array($this, 'add_styles') );
		}

		public function render() {
			include plugin_dir_path( __FILE__ ) . 'views/sent-message-to-all-user.php';
		}

		public function add_styles() {

			 if(get_current_screen()->base == 'toplevel_page_sent_message_to_all_users') {		 
				 wp_enqueue_script( 		 	
				 	'kg-sent-message-to-all', 
				 	plugins_url( 'assets/messages.js', __FILE__ ),
				 	array( 'jquery' ) 
				 );		
			 }

		}

		public function add_page_to_menu() {
			add_menu_page( 			
				'sent_message_to_all_users',
				'Wyślij wiadomość',
				'add_kg_user', 
				'sent_message_to_all_users',
				array($this, 'render' ),
				'dashicons-testimonial',
				91
				);
		}

	}
	