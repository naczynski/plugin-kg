<?php

	/**
	 * Add User to system
	 */
	class KG_Add_User {

		private function send_activation_email($user_id, $password) {
			KG_Get::get('KG_Activation_Email')->send_activation_email($user_id, $password);
		}

		private function add_fields($fields, $user_id) {
			foreach ($fields as $field => $value) {	
				$User_Field = KG_Get::get('KG_User_Field', $field, $user_id);
				$User_Field->set_value( $value );
			}
		}

		public function add_user($data) {

			$user_id = wp_insert_user($data);		

			if(is_wp_error($user_id )) {
				return $user_id;
			}

			$this->add_fields($data['fields'], $user_id);
			$this->send_activation_email($user_id, $data['user_pass']);
				
			return $user_id;

		}

	}
