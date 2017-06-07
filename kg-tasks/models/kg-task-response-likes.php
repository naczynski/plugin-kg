<?php 

 	class KG_Task_Response_Likes {

 		public function like($response_id, $user_id) {
 			if($this->is_liked_by_user($response_id, $user_id)) return; // dont like again
 			
 			global $wpdb;
			$insert = $wpdb->insert( 
				KG_Config::getPublic('table_tasks_reponses_likes'),
				array(
					'response_id' => (int) $response_id,
					'user_id' => (int) $user_id,
					'date' => KG_get_time()
				),
				array(
					'%d',
					'%d',
					'%s',
				) 
			);

			$this->calc_likes($response_id);
			$like_id = $wpdb->insert_id;

			do_action('kg_response_like', $user_id, $response_id, $like_id );
			
			return $like_id;
 		}

 		public function remove_like($response_id, $user_id) {
 			global $wpdb;

			$remove_id = $wpdb->delete( 	
				KG_Config::getPublic('table_tasks_reponses_likes'),
				array(
					'response_id' => (int) $response_id,
					'user_id' => (int) $user_id,
				),
				array(
					'%d',
					'%d',
				) 
			);
			
			do_action('kg_remove_like', $response_id, $user_id);

			$this->calc_likes($response_id);
			return $remove_id;
 		}

 		public function is_liked_by_user($response_id, $user_id) {
 			global $wpdb;
			$data = $wpdb->get_row( 
				$wpdb->prepare("SELECT * FROM " . KG_Config::getPublic('table_tasks_reponses_likes') . " WHERE user_id = %d AND response_id = %d ", (int)$user_id, (int)$response_id ),
				ARRAY_A 
			); 
			return (bool) $data;
 		}

 		private function set_like_to_resource($likes, $response_id) {
 			return KG_Get::get('KG_Task_Response', $response_id)->update_number_likes($likes);
 		}
 		
 		private function calc_likes($response_id) {
 			global $wpdb;

			$sum_likes = $wpdb->get_var( 
				$wpdb->prepare("SELECT COUNT(id) FROM " . KG_Config::getPublic('table_tasks_reponses_likes') . " WHERE response_id = %d", (int) $response_id)
			); 

			if($sum_likes || $sum_likes >= 0){
				$this->set_like_to_resource($sum_likes, $response_id);
			}

			return $sum_likes;
 		}
 		
 	}