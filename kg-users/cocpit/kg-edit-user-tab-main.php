<?php
	// 'profile' => 'Profil'
	
	class KG_Edit_User_Tab_Main {

		public function __construct(){
			add_filter('kg_add_edit_user_tab', array($this, 'add_tab'), 1, 1);
			add_action('kg_add_edit_user_tab_render_profile', array($this, 'render_page'), 1, 0);
			add_action('kg_add_edit_user_tab_scripts_profile', array($this, 'add_scripts'), 1, 0);
		}

		public function add_tab($config){
			$config['profile'] = __( 'Profil', 'kg' );
			return $config;
		}

		public function render_page(){
			include plugin_dir_path( __FILE__ ) . 'views/edit-student-profile.php';
		}

		public function add_scripts(){
			wp_enqueue_script(
			 	'kg-edit-user-cocpit', 
			 	plugins_url( 'assets/edit-user.js', __FILE__ ),
			 	array( 'jquery' ) 
			);
		}

	}