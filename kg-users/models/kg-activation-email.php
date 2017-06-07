<?php

	/**
	 * Manage email activation 
	 */
	class KG_Activation_Email {

		/* ==========================================================================
		   KEY
		   ========================================================================== */

		private function generate_key() {
			return wp_generate_password( 20, false, false );
		}

		private function assign_activation_key($key, $user_id) {
			KG_update_user($user_id, 'user_activation_key', $key, '%s');
			return $key;
		}


		private function get_activation_key_from_db($user_id) {
			return KG_Get::get('KG_User', $user_id)->get_stat_value('user_activation_key');
		}

		public function get_user_activation_key($user_id) {
			return ( $this->get_quantity_sended_email($user_id) == 0) ?
				 		 $this->assign_activation_key($this->generate_key(), $user_id) :
				   		 $this->get_activation_key_from_db($user_id);	
		}

		private function get_user_id_from_key($key) {
			global $wpdb;
			$users = $wpdb->get_results(
				$wpdb->prepare("SELECT ID FROM {$wpdb->users} WHERE user_activation_key =  %s", $key),
				ARRAY_A
			); 
			return !empty($users[0]['ID']) ? $users[0]['ID'] : false; 
		}

		/* ==========================================================================
		   EMAIL
		   ========================================================================== */

		private function set_activation_email($user_id) {
			return KG_update_user($user_id, 'is_email_activated', 1, '%d');
		}

		public function active_email_by_user_id($user_id){
			$res = $this->set_activation_email($user_id);
			if($res){
				do_action('kg_email_accept_activation', $user_id);
			}
			return $res;
		}

		public function activate_email_by_key($key) {
			$user_id = $this->get_user_id_from_key($key);
			return $this->active_email_by_user_id($user_id);
		}

		public function is_email_activated($user_id){
			return ((int) KG_Get::get('KG_User', $user_id)->get_stat_value('is_email_activated') == 1) ? true : false;
		}

		public function is_email_activated_by_key($key) {
			$user_id = $this->get_user_id_from_key($key);
			if($user_id) {
				return $this->is_email_activated($user_id);
			} else {
				return false;
			}

		}

		/* ==========================================================================
		   COUNT
		   ========================================================================== */
		
		public function increse_sended_emails($user_id) {
			$quantity = (int) $this->get_quantity_sended_email($user_id);
			return update_user_meta( $user_id, KG_Config::getPublic('user_email_sended_email_activation') , ++$quantity );
		}


		public function get_quantity_sended_email($user_id) {
			$quantity = get_user_meta( $user_id, KG_Config::getPublic('user_email_sended_email_activation') , true );
			return $quantity ? $quantity : 0;
		}

		public function send_activation_email($user_id, $password = '*********') {

			if($this->is_email_activated($user_id)) return false;

			$send = apply_filters( 
					'kg_send_user_activate_email' , 
					$user_id, 
					KG_Get::get('KG_User', $user_id)->get_email(), 
					$this->get_user_activation_key($user_id), 
					$password
			);

			$this->increse_sended_emails($user_id);

			return $send;

		}
		
	}