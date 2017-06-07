<?php

	class KG_Resource_Relations {

		use KG_Resources_Relations_Utils;

		private function get_enable_to_download_relations_types(){
			$out = array();
			foreach (KG_Config::getPublic('all_relations') as $key => $relation) {
				if($relation['enable_download'] == true) {
					$out[] = $relation['type_db'];
				}
			}
			return $out;
		}

		public function is_corrent_relation_type($type){
			foreach (KG_Config::getPublic('all_relations') as $key => $relation) {
				if($relation['type_name'] == $type) {
					return true;
				}
			}
			return false;
		}

		public function get_all_relation_types(){
			$out = array();
			foreach (KG_Config::getPublic('all_relations') as $key => $relation) {
				$out[] =  $relation['type_name'];
			}
			return $out;
		}


		public function can_download($user_id, $resource_id){
		
			$kg_user = KG_Get::get('KG_User', $user_id);

			if($kg_user->is_super_user()) return true;


			if (!in_array(
				KG_get_resource_object($resource_id)->get_sub_category_id(), 
				KG_Config::getPublic('categories_can_buy')
			)) return true;

			global $wpdb;
			$types = $this->get_types_where_in_string_for_query($this->get_enable_to_download_relations_types());

			$data = $wpdb->get_row( 
				$wpdb->prepare(
				  "SELECT * FROM " . KG_Config::getPublic('table_resources_relations') . " WHERE type IN {$types} AND user_id = %d AND resource_id = %d ORDER BY date DESC ", (int)$user_id, (int)$resource_id 
			     ),
				ARRAY_A 
			);
			return $data ? true : false;
		}


		public function get_ids_not_show_on_resorce_page($user_id){
			global $wpdb;
			
			$types = $this->get_types_where_in_string_for_query($this->get_enable_to_download_relations_types());
			$data = $wpdb->get_results( 
				$wpdb->prepare(
				  "SELECT resource_id FROM " . KG_Config::getPublic('table_resources_relations') . " WHERE type IN {$types} AND user_id = %d", (int)$user_id 
			     ),
				ARRAY_A 
			); 

			return $this->get_ids_from_array($data);
		}

	}