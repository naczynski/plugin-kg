<?php

	class KG_Cocpit_Edit_Student {

		private $sections = array();

		public function __construct() {
			add_action('admin_menu', array($this, 'add_page_to_menu'));
			add_action('admin_enqueue_scripts', array($this, 'add_styles') );
			$this->sections = apply_filters('kg_add_edit_user_tab', array());
		}

		public function add_styles() {
			 if(get_current_screen()->base == 'toplevel_page_edit-student') {
				
				 wp_register_style( 
				 	'kg_users_styles', 
				 	plugins_url( '../assets/css/style-users.css', __FILE__ )
				 );	

				 wp_enqueue_style( 'kg_users_styles' );

				 do_action('kg_add_edit_user_tab_scripts_' . $this->get_section_from_url());
			}
		}

		/* parse Url
		   ========================================================================== */

		public function get_user_id_from_url() {
			return !empty($_GET['id']) ? $_GET['id'] : false;
		}

		private function get_section_from_url() {
			return !empty($_GET['section']) ? $_GET['section'] : array_keys($this->sections)[0];
		}

		private function get_page_url() {
			return 'archidesk/wp-admin/admin.php?page=edit-student';
		}

		private function get_section_url($section) {
			return $this->get_page_url().'&section='.$section.'&id='.$this->get_user_id_from_url();
		}

		public function get_url_with_get_param($key, $value){
			return $this->get_section_url($this->get_section_from_url()) . '&' . $key . '=' . $value;
		}

		private function is_active($section) {
			return (
					$section == $this->get_section_from_url() ||
					($this->get_section_from_url() === false && $section  == $this->default_section)
				);
		}

		private function render_tabs() {
			echo '<h2 class="nav-tab-wrapper">';
				foreach ($this->sections as $section => $label) {
					if($this->is_active($section)) {
						echo '<a href="'.$this->get_section_url($section).'" class="nav-tab nav-tab-active">'.$label.'</a>';
					} else {
						echo '<a href="'.$this->get_section_url($section).'" class="nav-tab">'.$label.'</a>';
					}
			
				}
			echo '</h2>';
		} 

		public function get_url($id) {
			return $this->get_page_url() . '&id='. $id;
		}

		public function render() {

			if(empty($_GET['id'])) {
				echo '<p class="update-nag">Nie podałeś dla jakiego użtkownika chcesz wyśwetlić informacje</p>';
				return;
			}

			if( !KG_user_exist_by_id($_GET['id']) ) {
				echo '<p class="update-nag">Nie posiadamy takie użytkownika w serwisie</p>';
				return;
			}

			$this->render_tabs();
			do_action('kg_add_edit_user_tab_render_' . $this->get_section_from_url());
		
		}

		public function add_page_to_menu() {

			add_menu_page( 
				
				'Edytuj użytkownika',
				'Edytuj użytkownia',
				'edit_kg_user', 
				'edit-student',
				array($this, 'render' ),
				'dashicons-admin-users'

				);

		}

	}
	