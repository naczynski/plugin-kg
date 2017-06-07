<?php

	// Integrate old db data to newer portal version
	class KG_Portal_Integraton {

		private $default_wp_user = array(
			'order' => 'ASC',
			'orderby' => 'display_name',
		);

		public function __construct(){
			add_action('kg_integrate', array($this, 'integrate'), 1, 0);
			add_action('kg_user_integrate', array($this, 'copy_name_to_default_wp_names_field'), 1 , 1);
			// add_action('kg_user_integrate', array($this, 'change_job_information'), 1 , 1);
		}

		public function integrate(){
			$this->run_for_users();
			$this->run_for_resources();
			// $this->set_properly_roles_for_main_users();
		}

		/* ==========================================================================
		   LOOPS
		   ========================================================================== */

	   public function run_for_resources(){

	   }

		public function run_for_users(){
			$users = (new WP_User_Query($this->default_wp_user))->get_results();
			foreach ($users as $wp_user) {
				do_action('kg_user_integrate', KG_Get::get('KG_User', $wp_user));
			}
		}

	   /* ==========================================================================
	   ACTIONS USERS
	   ========================================================================== */
	
		public function set_properly_roles_for_main_users() {

			$user_koda = KG_Get::get('KG_User', KG_Config::getPublic('koda_user_id'));
			$user_koda->set_koda();

			$user_questus= KG_Get::get('KG_User', KG_Config::getPublic('questus_user_id'));
			$user_questus->set_questus();
		}

		public function copy_name_to_default_wp_names_field($kg_user){
			
			update_user_meta($kg_user->get_ID(), 'first_name', $kg_user->get_name());
			update_user_meta($kg_user->get_ID(), 'last_name', $kg_user->get_surname());
			
		}

		/* ==========================================================================
		   ACTIONS RESOURCES
		   ========================================================================== */
		
		public function add_promoted_value_for_all_posts() {
			$resources = new WP_Query(array(
				'post_type' => array('link', 'pdf'),
				'posts_per_page' => -1
			));
			$resources = $resources->get_posts();

			foreach ($resources as $resource) {
				if(!get_post_meta($resource->ID, 'promoted', true) ){
					update_post_meta($resource->ID, 'promoted', 0);				
				}
			}
		}

		public function change_job_information($kg_user){

			$kg_user->set_job('Praca');
			$kg_user->set_trade('Specjalizacja');

		}

	}
