<?php

	class KG_Alert_Apply_Subscription extends KG_Alert {

		public function get_type(){
			return 'subscription';
		}

		public function get_message(){
		
			$subscription_obj = KG_Get::get('KG_Item_Subscription', $this->get_action_id());
			$pattern = $subscription_obj->allow_choose_free_resources() ? 
				'Zatwierdzono abonament na okres {{days}} dni z {{free}} zasobami do wybrania w ramach abonamentu.' :
				'Zatwierdzono abonament na okres {{days}} dni.';

			return str_replace(
				array(
					'{{days}}',
					'{{free}}',
				),
				array(
					$subscription_obj->get_days_durations(),
					$subscription_obj->get_how_many_free_resources()
				),
				$pattern

			); 

		}
		
		public function get_action_type(){
			return 'none';
		}

		public function get_lightbox_data(){
			return array();
		}

		public function get_button_label(){
			return '';
		}

		public function get_button_icon(){
			return '';
		}

		public function get_link(){
			return '';
		}

	}
