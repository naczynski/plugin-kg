<?php

	class KG_Present_Relation_Single extends KG_Single_Relation implements JsonSerializable {

		private $present_data = array(
			'user_id_from' ,
			'user_id_to',
			'message',
		);

		private $default_data = array(
			'relation_id' => 0,
			'user_id_from' => 0,
			'user_id_to'=> 0,
			'message' => '',
			'resource_id' => 0,
			'user_id' => 0,
			'date' => '2012-12-12 08:00',
			'action_id' => 0
			
		);
		
		private function is_only_relation_id($data){
			return is_int($data);
		} 

		private function in_array_multiple($target, $haystack){
			return (count(array_intersect($haystack, $target)) == count($target));
		}

		private function are_atached_present_data($data){
			return $this->in_array_multiple( (array) $this->present_data, array_keys( (array) $data));
		}

		public function __construct($data) {
			
			if($this->is_only_relation_id($data)){
				$relation_id = $data;
				$data = $this->get_relation_data($relation_id);
			} 

			if(!$this->are_atached_present_data($data)){
				$data = $this->get_data_from_db($data);
			}
			parent::__construct($data);
			$this->user_from_id = $data['user_id_from'];
			$this->user_to_id = $data['user_id_to'];
			$this->message = $data['message'];
		}

		public function get_relation_id() {
			return $this->relation_id;
		}

		public function get_resource() {
			return KG_get_resource_object($this->resource_id);
		}

		public function get_message(){
			return apply_filters('kg_present_message', $this->message, $this->relation_id );
		}	

		public function is_message_attached(){
			return (strlen($this->message) != 1);
		}

		public function get_price(){
			return $this->get_resource()->get_price();
		}

		public function get_from_user(){
			return KG_Get::get('KG_User', $this->user_from_id);
		}

		public function get_from_user_id(){
			return $this->user_from_id;
		} 

		public function get_to_user(){
			return KG_Get::get('KG_User', $this->user_to_id);
		}

		public function get_to_user_id(){
			return $this->user_to_id;
		} 

		public function get_type(){
			return KG_Config::getPublic('relation_present')['type_name'];
		}


		public function get_relation_data($relation_id){
			global $wpdb;
			$relation_data = $wpdb->get_row( 
				$wpdb->prepare(
				  "SELECT * FROM " . KG_Config::getPublic('table_resources_relations') . 
				  " WHERE relation_id=%d",
				  (int) $relation_id 
			     ),
				ARRAY_A 
			); 
			return $relation_data;
		}

		public function get_data_from_db($data){
			global $wpdb;

			$present_id = $data['action_id'];
			$present_data = $wpdb->get_row( 
				$wpdb->prepare("SELECT * FROM " . KG_Config::getPublic('table_presents') . " WHERE id = %d", (int) $present_id),
				ARRAY_A 
			);
			unset($present_data['date']);

			if(!$present_data) return $this->default_data;
			return array_merge($data, $present_data);

		}

		public function jsonSerialize() {
      	  $out = array(
      	  	'relation_id' => $this->get_relation_id(),
      	  	'resource' => $this->get_resource(),
      	  	'user_from' => $this->get_from_user(),
      	  	'user_to' => $this->get_to_user(),
      	  	'message' => $this->get_message(),
      	  	'date' => $this->get_date()	  
      	  );
      	  return $out;
    	}
		
	}
