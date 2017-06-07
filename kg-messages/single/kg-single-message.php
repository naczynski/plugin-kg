<?php 

	class KG_Single_Message implements JsonSerializable {

		private $message_id;
		private $user_id_from;
		private $user_id_to;
		private $message;
		private $date = '';

		private function get_data_from_db($message_id) {
			global $wpdb;
			$data = $wpdb->get_row( 
				$wpdb->prepare("SELECT * FROM " . KG_Config::getPublic('table_messages') . " WHERE id=%d", (int) $message_id ),
				ARRAY_A 
			); 

			if($data) {
				$this->user_id_from = $data['user_id_from'];
				$this->user_id_to = $data['user_id_to'];
				$this->message = $data['message'];
				$this->date = $data['date'];
				return true;
			} else {
				return false;
			}

		}

		private function is_init_by_message_id($from_id, $to_id , $message,  $date){
			return (is_int($from_id) && !$to_id && !$message && !$date );
		}

		public function __construct($from_id, $to_id = false , $message = false, $date = false){
			if($this->is_init_by_message_id($from_id, $to_id , $message,  $date)){
				$this->message_id = $from_id;
				$this->get_data_from_db($this->message_id );
			} else {
				$this->user_id_from = $from_id;
				$this->user_id_to = $to_id;
				$this->message = $message;
				$this->date = $date;
			}
		}

		public function sent() {
			$this->date = KG_get_time();
			global $wpdb;
			$insert = $wpdb->insert( 
				KG_Config::getPublic('table_messages'),
				array(
					'user_id_from' => (int) $this->user_id_from,
					'user_id_to' => (int) $this->user_id_to,
					'message' => apply_filters('kg_message_save_in_db', $this->message) ,
					'date' => $this->date
				),
				array(
					'%d',
					'%d',
					'%s',
					'%s'
				) 
			);
		
			if($insert){
				$this->message_id = $wpdb->insert_id;
				do_action('kg_sent_message', $this);	
				return $this->message_id;
			} else {
				return false; 
			}
		}

		/* ==========================================================================
		   GETTER
		   ========================================================================== */
		
		public function get_message_id() {
			return $this->message_id;
		}

		public function get_message() {
			return apply_filters('kg_message_content', $this->message);
		}

		public function get_message_not_formatted(){
			return $this->message;
		}

		public function get_from_user() {
			return KG_Get::get('KG_User', $this->user_id_from);
		}

		public function get_from_user_id() {
			return $this->user_id_from;
		}

		public function get_to_user() {
			return KG_Get::get('KG_User', $this->user_id_to);
		}

		public function get_to_user_id() {
			return $this->user_id_to;
		}

		public function get_date() {
			return $this->date;
		}

		public function is_sent($user_id) {
			return ($this->user_id_from == $user_id) ;
		}

		public function is_receive($user_id) {
			return ($this->user_id_TO == $user_id) ;
		}

		public function get_class_name($user_id) {
			return ( $this->is_sent($user_id) ) ? 'sent' : 'recive';
		}

		public function get_label($user_id){
			return ( $this->is_sent($user_id) ) ? 'Wysłał' : 'Otrzymał';
		}

		public function jsonSerialize() {
      	  $out = array(
      	  	'message_id' => $this->get_message_id(),
      	  	'message' => $this->get_message(),
      	  	'user_from' => $this->get_from_user(),
      	  	'user_to' => $this->get_to_user(),
      	  	'date' => $this->get_date() 	  
      	  );
      	  return $out;
    	}

	}