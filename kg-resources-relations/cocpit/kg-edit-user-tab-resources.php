<?php
	
	class KG_Edit_User_Tab_Resources {

		private function get_template_path(){
			return plugin_dir_path( __FILE__ ) . '../relations/' . $this->get_type() . '/cocpit-view/view.php';	
		}

		private function get_type(){
			return ( !empty($_GET['type']) && KG_Get::get('KG_Resource_Relations')->is_corrent_relation_type($_GET['type']) ) ? $_GET['type'] : KG_Config::getPublic('all_relations')[0]['type_name'];
		}

		private function is_active($type){
			return ( $this->get_type() == $type);
		}

		private function is_show_delimiter($index, $max){
			return !($index == $max - 1);
		}

		private function render_tabs() {
			echo '<ul class="subsubsub">';
				foreach (KG_Config::getPublic('all_relations') as $key => $relation) {
					
					$href = KG_Get::get('KG_Cocpit_Edit_Student')->get_url_with_get_param('type', $relation['type_name']);
					$class = $this->is_active($relation['type_name']) ? 'current' : '';
					$user_id = KG_Get::get('KG_Cocpit_Edit_Student')->get_user_id_from_url();
					$count = KG_get_relation_getter_object_by_name($relation['type_name'])->count($user_id);
					
					$pattern = '<li><a href="{{href}}" class="{{active}}">{{name}}<span class="count"> ({{count}})</span></a> {{delimiter}}</li>';
					
					echo str_replace(array(
						'{{href}}',
						'{{active}}',
						'{{name}}',
						'{{count}}',
						'{{delimiter}}'
					), array(
						$href,
						$class,
						$relation['label'],
						$count,
						$this->is_show_delimiter($key, sizeof(KG_Config::getPublic('all_relations')) ) ? ' | ' : ''
					), $pattern);
			
				}
			echo '</ul>';
		} 

		public function get_relation_object(){
			return KG_get_relation_getter_object_by_name($this->get_type())->get(
				KG_Get::get('KG_Cocpit_Edit_Student')->get_user_id_from_url()
			);
		}

		public function __construct(){
			add_filter('kg_add_edit_user_tab', array($this, 'add_tab'), 3, 1);
			add_action('kg_add_edit_user_tab_render_resources', array($this, 'render_page'), 3, 0);
			add_action('kg_add_edit_user_tab_scripts_resources', array($this, 'add_scripts'), 3, 0);
		}

		public function add_tab($config){
			$config['resources'] = __( 'Zasoby', 'kg' );
			return $config;
		}


		public function render_page(){
			$this->render_tabs();

			echo '<div class="my-resources">';
				include $this->get_template_path();
			echo '</div>';
		}

		public function add_scripts(){
			acf_form_head();
			wp_enqueue_script(
			 	'kg-edit-user-cocpit-resources', 
			 	plugins_url( 'assets/js/my-resources-cocpit.js', __FILE__ ),
			 	array( 'jquery' ) 
			);
		}

	}