<?php
	
	class KG_Edit_User_Tab_Activites implements KG_Edit_User_Tab{

		public function __construct(){
			add_filter('kg_add_edit_user_tab', array($this, 'add_tab'), 3, 2);
			add_action('kg_add_edit_user_tab_render_activities', array($this, 'render_page'), 4, 0);
			add_action('kg_add_edit_user_tab_scripts_activities', array($this, 'add_scripts'), 4, 0);
		}

		public function add_tab($config){
			$config['activities'] = __( 'Aktywność', 'kg' );
			return $config;
		}

		public function render_page(){
			include plugin_dir_path( __FILE__ ) . 'views/activity-table.php';
		}

		public function add_scripts(){

		}

	}