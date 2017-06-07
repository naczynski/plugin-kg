<?php	

	class KG_Fields_Actions {

		public function __construct(){
			add_action('kg_update_field_kg_field_name', array($this, 'update_wp_user_name'), 1, 2);
			add_action('kg_update_field_kg_field_surname', array($this, 'update_wp_user_surname'), 1, 2);
		}

		public function update_wp_user_name($user_id, $value){
			$kg_user = KG_Get::get('KG_User', $user_id);
			$kg_user->get_wp_user_object()->first_name = $value;
		}

		public function update_wp_user_surname($user_id, $value){
			$kg_user = KG_Get::get('KG_User', $user_id);
			$kg_user->get_wp_user_object()->first_name = $value;
		}

	}