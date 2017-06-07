<?php

	class KG_Present_Relation extends KG_Relation {

		private $from_user_id;
		private $to_user_id;
		private $resource_id;
		private $message;
		private $relation_id;

		public $present_id;

		public function __construct($from_user_id, $to_user_id, $resource_id, $message){
			$this->from_user_id = $from_user_id;
			$this->to_user_id = $to_user_id;
			$this->resource_id = $resource_id; 
			$this->message = $message;	
		}

		private function add_to_relations_table($present_id_from_present_table){

			return $this->add(
						KG_Config::getPublic('relation_present')['type_db'], 
						$this->to_user_id, 
						$this->resource_id, 
						$present_id_from_present_table
					);

		}	

		private function add_to_presents_table(){
			global $wpdb;

			$insert = $wpdb->insert( 
				KG_Config::getPublic('table_presents'),
				array(
					'resource_id' => (int) $this->resource_id,
					'user_id_from' => (int) $this->from_user_id,
					'user_id_to' => (int) $this->to_user_id,
					'message' => $this->message,
					'date' => date( 'Y-m-d H:i:s')
				),
				array( '%d', '%d', '%d', '%s', '%s') 
			);

			return ($insert) ?  $wpdb->insert_id : false;
	
		}

		public function add_to_db(){			
			$this->present_id = $this->add_to_presents_table();
			$this->relation_id = $this->add_to_relations_table($this->present_id);
			return $this->relation_id;
		}

	}