<?php 

 	class KG_Likes {

 		public function like($resource_id, $user_id) {
 			if($this->is_liked_by_user($resource_id, $user_id)) return; // dont like again

 			global $wpdb;
			$insert = $wpdb->insert( 
				KG_Config::getPublic('table_likes'),
				array(
					'resource_id' => (int) $resource_id,
					'user_id' => (int) $user_id,
					'date' => date( 'Y-m-d H:i:s')
				),
				array(
					'%d',
					'%d',
					'%s',
				) 
			);

			$like_id = $wpdb->insert_id;
			do_action('kg_resource_like', $user_id, $resource_id, $like_id);
			
			return $like_id;

 		}

 		public function remove_like($resource_id, $user_id) {
 			global $wpdb;

			$remove_id = $wpdb->delete( 	
				KG_Config::getPublic('table_likes'),
				array(
					'resource_id' => (int) $resource_id,
					'user_id' => (int) $user_id,
				),
				array(
					'%d',
					'%d',
				) 
			);
			
			do_action('kg_remove_like', $resource_id, $user_id);
			return $remove_id;
 		}

 		
 		public function is_liked_by_user($resource_id, $user_id) {
 			global $wpdb;

			$data = $wpdb->get_row( 
				$wpdb->prepare("SELECT * FROM " . KG_Config::getPublic('table_likes') . " WHERE user_id = %d AND resource_id = %d ", (int)$user_id, (int)$resource_id ),
				ARRAY_A 
			); 
			return (bool) $data;
 		}

 	}