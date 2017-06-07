<?php

	trait KG_User_Trait_Subscriptions{

		public function get_all_subscriptions(){
			return KG_Get::get('KG_Subscriptions')->get_all_user_subscriptions($this->user_id);
		}

		public function is_have_active_subscription(){
			if(	$this->is_super_user()) return true;
			return KG_Get::get('KG_Subscriptions')->is_user_have_active_subscription($this->user_id);
		}

		public function get_current_subscription(){
			return KG_Get::get('KG_Subscriptions')->get_current_subscription_object($this->user_id);
		}

		public function get_days_subscription_remaining(){
			return KG_Get::get('KG_Subscriptions')->get_days_to_end_all_subscriptions($this->user_id);
		}

		public function get_days_subscription_elapsed_percange(){
			return KG_Get::get('KG_Subscriptions')->get_time_elapsed_in_percange_for_all_subscriptions($this->user_id);
		}

		public function get_end_date_subscritpions(){
			return KG_Get::get('KG_Subscriptions')->get_date_end_all_subscriptions($this->user_id);
		}

		public function get_days_to_end_all_subscriptions(){
			return KG_Get::get('KG_Subscriptions')->get_days_to_end_all_subscriptions($this->user_id);
		}

		public function is_user_on_end_of_subscription(){
			return KG_Get::get('KG_Subscriptions')->get_days_to_end_all_subscriptions($this->user_id) <= 7;
		}

		public function is_have_premium_subscription(){
			if( $this->get_current_subscription() ) {
			    return $this->get_current_subscription()->get_subscription_id() == KG_Config::getPublic('subscription_premium_id');
			} 
			return false;
		}

	}