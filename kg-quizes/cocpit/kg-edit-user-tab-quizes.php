<?php
	
	class KG_Edit_User_Tab_Quizes implements KG_Edit_User_Tab{

		public function __construct(){
			add_filter('kg_add_edit_user_tab', array($this, 'add_tab'), 3, 2);
			add_action('kg_add_edit_user_tab_render_quizes', array($this, 'render_page'), 4, 0);
			add_action('kg_add_edit_user_tab_scripts_quizes', array($this, 'add_scripts'), 4, 0);
		}

		public function add_tab($config){
			$config['quizes'] = __( 'Quizy', 'kg' );
			return $config;
		}

		public function render_page(){
			include plugin_dir_path( __FILE__ ) . 'views/quiz-edit-user-tab.php';
		}

		public function add_scripts(){

		}

	}