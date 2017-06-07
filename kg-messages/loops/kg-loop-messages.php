<?php  
	
	class KG_Loop_Messages extends KG_Loop {

		private $wp_query;

		public function render($messages_data) {
			if (empty($messages_data) ) return array(); 
			$out = [];
			foreach ($messages_data as $item) {
				$out[] = KG_Get::get('KG_Single_Message',
					 $item['user_id_from'],
					 $item['user_id_to'], 
					 $item['message'],
					 $item['date']
				);
			}
			return $out;
		}

		private function get_from_db($user_id) {
			global $wpdb;
			$data = $wpdb->get_results( 
				$wpdb->prepare("SELECT * FROM " .
				 KG_Config::getPublic('table_messages') . 
				 " WHERE user_id_from= %d  OR user_id_to=%d 
				 ORDER BY date ASC", 
				  (int) $user_id,
				  (int) $user_id ),
				ARRAY_A 
			); 
			return $data;
		}

		private function get_chat_from_db($user_id_01, $user_id_02) {
			global $wpdb;
			$data = $wpdb->get_results( 
				$wpdb->prepare("SELECT * FROM " . 
					KG_Config::getPublic('table_messages') . 
					" WHERE user_id_from IN (%d,%d) AND user_id_to IN (%d,%d) 
					ORDER BY date ASC", 
					(int) $user_id_01,
					(int) $user_id_02, 
					(int) $user_id_01, 
					(int) $user_id_02 ),
				ARRAY_A 
			); 
			return $data;
		}		

		public function get_chat($second_user) {
			$messages_data = $this->get_chat_from_db(get_current_user_id(), $second_user);
			return $this->render($messages_data);
		}

		public function get($user_id) {
			$messages_data = $this->get_from_db($user_id);
			return $this->render($messages_data);
		}

		public function get_default() {

		}
		
		public function is_last_page() {
			return true;
		}
		
		public function get_page_numbers() {
			 return 1;
		}

		public function get_curr_page() {
			return 1;
		}

		public function get_numbers_found() {
			return 1;
		}

	}