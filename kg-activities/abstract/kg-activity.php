<?php

	abstract class KG_Activity {

		private $activity_id;
		private $user_id;
		private $date;
		private $action_id; // action connected with alert e.g message_id, present_id 
		private $meta;

		private function get_data_from_db(){
			global $wpdb;
			$data = $wpdb->get_row( 
				$wpdb->prepare("SELECT * FROM " . KG_Config::getPublic('table_users_activities') . " WHERE id=%d", (int) $this->activity_id ),
				ARRAY_A 
			); 

			if($data) {
				$this->	set_objects_properties($data);
				return true;
			} else {
				return false;
			}
		}

		private function is_init_by_activity_id($data){
			return is_int($data);
		}

		private function set_objects_properties($data){
			$this->activity_id = (int) $data['id'];
			$this->user_id = (int) $data['user_id'];
			$this->date = $data['date'];
			$this->action_id = (int) $data['action_id'];
			$this->meta = is_string(($data['meta'])) ? json_decode($data['meta'], true) : $data['meta'];
			$this->browser = !empty($data['browser']) ? $data['browser'] : '';
		}

		public function __construct($data) {
			if($this->is_init_by_activity_id($data)){
				$this->activity_id = $data;
			} else if(is_array($data)){
				$this->set_objects_properties($data);
			}
		}

		/* ==========================================================================
		   GETTERS
		   ========================================================================== */
		
		public function get_activity_id() {
			return $this->activity_id;
		}

		public function get_user_id() {
			if ( empty($this->user_id) ) $this->get_data_from_db();
			return $this->user_id;
		}

		public function get_meta(){
			if ( empty($this->meta) ) $this->get_data_from_db();
			return $this->meta ? $this->meta  : false;
		}

		public function get_browser(){
			return apply_filters('kg_parse_browser_string', $this->browser);
		}

		public function get_device(){
			return apply_filters('kg_parse_device_string', $this->browser);
		}

		public function get_action_id(){
			if ( empty($this->action_id) ) $this->get_data_from_db();
			return $this->action_id ? $this->action_id  : false;
		}

		public function get_date(){
			if ( empty($this->date) ) $this->get_data_from_db();
			return $this->date;
		}

		abstract function get_type();
		abstract function get_message();
		abstract function get_class_name();
		
	}