<?php

	abstract class KG_Resource_Relation_Getter {

		use KG_Resources_Relations_Utils;

		/* ==========================================================================
		   PARSE
		   ========================================================================== */

		private function parse_results($results){
			$out = array();
			foreach ($results as $relation_data) {
				$out[] = KG_get_relation_single_object($relation_data['type'], $relation_data);
			}
			
			return $out;

		}

		/* ==========================================================================
		   GET
		   ========================================================================== */
		
		protected function get_from_db($types, $user_id){
			global $wpdb;

			$types = $this->get_types_where_in_string_for_query($types);
			$data = $wpdb->get_results( 
				$wpdb->prepare(
				  "SELECT * FROM " . KG_Config::getPublic('table_resources_relations') . " WHERE type IN {$types} AND user_id = %d ORDER BY date DESC ", (int)$user_id 
			     ),
				ARRAY_A 
			); 

			return $this->parse_results($data);
		}

	
		protected function get_ids_from_db($types, $user_id){
			global $wpdb;
			
			$types = $this->get_types_where_in_string_for_query($types);
			$data = $wpdb->get_results( 
				$wpdb->prepare(
				  "SELECT resource_id FROM " . KG_Config::getPublic('table_resources_relations') . " WHERE type IN {$types} AND user_id = %d", (int)$user_id 
			     ),
				ARRAY_A 
			); 

			return $this->get_ids_from_array($data);
		}


		protected function count_from_db($types, $user_id){
			global $wpdb;
			
			$types = $this->get_types_where_in_string_for_query($types);
			$how_many = $wpdb->get_var( 
				$wpdb->prepare(
				  "SELECT COUNT(resource_id) FROM " . KG_Config::getPublic('table_resources_relations') . " WHERE type IN {$types} AND user_id = %d ORDER BY date DESC ", (int)$user_id 
			     )
			); 

			return (int) $how_many;
		}

		abstract public function get($user_id);
		abstract public function count($user_id);
		abstract public function get_ids($user_id);
		
	}