<?php

	abstract class KG_Alert implements JsonSerializable {

		private $alert_id;
		private $user_id;
		private $is_readed;
		private $date;
		private $action_id; // action connected with alert e.g message_id, present_id 

		private function get_correct_boolean_is_readed($type){
			return ($type == '1') ? true : false;
		}

		private function get_data_from_db(){
			global $wpdb;
			$data = $wpdb->get_row( 
				$wpdb->prepare("SELECT * FROM " . KG_Config::getPublic('table_alerts') . " WHERE id=%d", (int) $this->alert_id ),
				ARRAY_A 
			); 

			if($data) {
				$this->	set_objects_properties($data);
				return true;
			} else {
				return false;
			}
		}

		private function is_init_by_alert_id($data){
			return is_int($data);
		}

		private function set_objects_properties($data){
			$this->alert_id = (int) $data['id'];
			$this->user_id = (int) $data['user_id'];
			$this->is_readed = $this->get_correct_boolean_is_readed($data['is_readed']);
			$this->date = $data['date'];
			$this->action_id = (int) $data['action_id'];
		}

		public function __construct($data) {
			if($this->is_init_by_alert_id($data)){
				$this->alert_id = $data;
			} else if(is_array($data)){
				$this->set_objects_properties($data);
			}
		}

		/* ==========================================================================
		   GETTERS
		   ========================================================================== */
		
		public function get_alert_id() {
			return $this->alert_id;
		}

		public function get_user_id() {

			if ( empty($this->user_id) ) $this->get_data_from_db();
			return $this->user_id;
		}

		protected function get_action_id(){
			if ( empty($this->action_id) ) $this->get_data_from_db();
			return $this->action_id ? $this->action_id  : false;
		}

		public function get_date(){
			if ( empty($this->date) ) $this->get_data_from_db();
			return $this->date;
		}

		/* ==========================================================================
		   MARK READ / UNREAD
		   ========================================================================== */
		
		private function change_status($type = '1'){
			global $wpdb;
			$result =  $wpdb->update( 
				KG_Config::getPublic('table_alerts'), 
				array( 
					'is_readed' => $type
				), 
				array('id'=> $this->alert_id), 
				array('%d'), 
				array('%d') 
			);
			if($result){
				$this->is_readed = $this->get_correct_boolean_is_readed($type);
				do_action('kg_alert_update_status', $this->get_user_id());
			}
			return $result;
		}

		public function set_as_readed(){
			return $this->change_status('1');
		}

		public function set_as_not_readed(){
			return $this->change_status('0');
		}

		public function is_readed(){
			if ( empty($this->is_readed) ) $this->get_data_from_db();
			return $this->is_readed;
		}

		abstract function get_type();
		abstract function get_message();
		abstract function get_action_type();
		abstract function get_lightbox_data();
		abstract function get_button_label();
		abstract function get_button_icon();
		abstract function get_link();

		/* ==========================================================================
		   SERIALIZE
		   ========================================================================== */
	
		public function jsonSerialize() {
      	  $out = array(
      	  	'alert_id' => $this->get_alert_id(),
      	  	'type' => $this->get_type(),
      	  	'user_id' => $this->get_user_id(),
      	  	'message' => $this->get_message(),
      	  	'action' => $this->get_action_type(),
      	  	'date' => $this->get_date(),
      	  	'is_readed' => $this->is_readed()
      	  );

      	  if($this->get_action_type() != 'none'){
      	  	 $out['button_label'] = $this->get_button_label();
      	  	 $out['button_icon'] = $this->get_button_icon();
      	  }

      	  if( !empty($this->get_lightbox_data()) ){
      	  	 $out['lightbox_data'] = $this->get_lightbox_data();
      	  }

      	  if($this->get_action_type() != 'none'){
      	  	$out['link'] = $this->get_link();
      	  }

      	  return $out;
    	}
	}