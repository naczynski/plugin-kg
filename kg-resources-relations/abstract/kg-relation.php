<?php
	
	abstract class KG_Relation {

		protected function add($type, $user_id, $resource_id, $action_id){
			global $wpdb;

			$insert = $wpdb->insert( 
				KG_Config::getPublic('table_resources_relations'),
				array(
					'resource_id' =>  $resource_id,
					'user_id' => $user_id,
					'type' =>  $type,
					'action_id' => $action_id,
					'date' => date( 'Y-m-d H:i:s')
				),
				array( '%s', '%s', '%s', '%s', '%s') 
			);

			return $insert ? $wpdb->insert_id : false;

		}

		abstract function add_to_db();

	}