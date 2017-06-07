<?php

	class KG_Alerts_Not_Readed_Counter {

		private function set_to_user($user_id, $alerts_not_readed){
			update_user_meta($user_id, KG_Config::getPublic('alerts_not_readed'), (int) $alerts_not_readed );
		}

		public function __construct() {
			add_action('kg_alert_update_status', array($this, 'count_not_read_and_set_to_user'), 1, 1);
		}

		public function get_quantity_not_read($user_id){
			$not_readed = get_user_meta($user_id, KG_Config::getPublic('alerts_not_readed'), true);
			return $not_readed ? (int) $not_readed : 0;
		}

		public function count_not_read_and_set_to_user($user_id){
			global $wpdb;
			$sum_not_readed = $wpdb->get_var( 
				$wpdb->prepare("SELECT COUNT(id) FROM " . KG_Config::getPublic('table_alerts') . " WHERE user_id = %d AND is_readed = 0", (int) $user_id)
			); 
			
			$this->set_to_user($user_id , $sum_not_readed);
		
			return $sum_not_readed;	
		}

		public function set_all_readed($user_id){
			global $wpdb;
			$wpdb->update( 
				KG_Config::getPublic('table_alerts'), 
				array( 
					'is_readed' => 1,
				), 
				array( 'user_id' => (int) $user_id ), 
				array( '%d' ), 
				array( '%d' ) 
			);
			$this->count_not_read_and_set_to_user($user_id);
		}
		
	}