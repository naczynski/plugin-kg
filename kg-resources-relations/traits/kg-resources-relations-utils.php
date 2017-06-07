<?php

	trait KG_Resources_Relations_Utils {

		private function get_types_where_in_string_for_query($types){
	   		return '(' . implode((array) $types, ',') . ')';
	    }

		protected function get_types_id_from_names($types){
			foreach ((array) $types as $key => $type) {
				   $types[$key] = KG_get_relation_name_type($type);
				}
			return $types;
		}

		private function get_ids_from_array($array){
			$out = array();
			foreach ($array as $value) {
				$out[] = (int) $value['resource_id'];
			}

			return $out;
		}

		public function remove_from_db($type, $user_id, $resource_id){
			global $wpdb;

			return $wpdb->delete( 	
				KG_Config::getPublic('table_resources_relations'),
				array(
					'resource_id' => (int) $resource_id,
					'user_id' => (int) $user_id,
					'type' => $type
				),
				array(
					'%d',
					'%d',
				) 
			);

		}


	}