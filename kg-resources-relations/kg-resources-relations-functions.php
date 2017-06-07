<?php

	function KG_get_relation_number_type($type_db) {
		foreach (KG_Config::getPublic('all_relations') as $key => $relation) {
			if($relation['type_db'] == $type_db) {
				return $relation['type_name'];
			}
		}
		return 0;
	}

	function KG_get_relation_name_type($type_name) {
		foreach (KG_Config::getPublic('all_relations') as $key => $relation) {
			if($relation['type_name'] == $type_name) {
				return $relation['type_db'];
			}
		}
		return 0;
	}

	function KG_get_relation_single_object($type_db, $data){
		return KG_Get::get('KG_' . ucfirst(KG_get_relation_number_type($type_db)) .'_Relation_Single', $data);
	}

	function KG_get_relation_getter_object_by_name($type_name){
		return KG_Get::get('KG_' . ucfirst($type_name) .'_Relation_Getter');
	}

	function KG_remove_relation($relation_id){
		global $wpdb;
		$remove = $wpdb->delete( 
			KG_Config::getPublic('table_resources_relations'),
			array( 'relation_id' => (int) $relation_id ),
			array( '%d' )
		);
		do_action('kg_remove_relation', $relation_id);
		
	}
