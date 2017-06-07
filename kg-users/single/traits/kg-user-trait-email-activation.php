<?php

	trait KG_User_Trait_Email_Activation {

		public function is_email_activated() {
			if($this->is_super_user()) return true;
			return KG_Get::get('KG_Activation_Email')->is_email_activated($this->user_id);
		}

		public function get_activation_key() {
			return KG_Get::get('KG_Activation_Email')->get_user_activation_key($this->user_id);
		}

		public function activate_email() {
			return KG_Get::get('KG_Activation_Email')->active_email_by_user_id($this->user_id);
		} 

		public function get_quantity_sended_email() {
			return KG_Get::get('KG_Activation_Email')->get_quantity_sended_email($this->user_id);
		}

		public function send_activation_email() {
			return KG_Get::get('KG_Activation_Email')->send_activation_email($this->user_id);
		}

	}