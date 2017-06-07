<?php
	// 'profile' => 'Profil'
	
	class KG_Edit_User_Tab_Subscriptions {

		public function __construct(){
			add_filter('kg_add_edit_user_tab', array($this, 'add_tab'), 3, 2);
			add_action('kg_add_edit_user_tab_render_subscriptions', array($this, 'render_page'), 4, 0);
			add_action('kg_add_edit_user_tab_scripts_subscriptions', array($this, 'add_scripts'), 4, 0);
		}

		public function add_tab($config){
			$config['subscriptions'] = __( 'Abonament', 'kg' );
			return $config;
		}

		public function render_page(){
			include plugin_dir_path( __FILE__ ) . 'views/edit-student-subscriptions.php';
		}

		public function add_scripts(){
			acf_form_head();
			wp_enqueue_script(
			 	'kg-edit-user-cocpit-subscription', 
			 	plugins_url( 'assets/subscriptions-cocpit.js', __FILE__ ),
			 	array( 'jquery' ) 
			);
		}

	}