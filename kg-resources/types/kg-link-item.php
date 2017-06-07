<?php

	class KG_Link_Item extends KG_Item {


		public function __construct($quiz_id) {
			parent::__construct($quiz_id);
		}
	
		public function get_read_more_link() {
			return ( !empty($this->get_resource_meta()['read_more']) ) ? $this->get_resource_meta()['read_more'] : false;
		}

		public function can_buy() {
			return false;
		}

		public function can_like() {
			return true;
		}

		public function can_download($user_id) {
			return false;
		}

		public function can_present() {
			return false;
		}
		
		public function get_serialized_fields_for($user_id){	
			$fields = parent::get_serialized_fields_for($user_id);
			$fields['link_read_more'] = $this->get_read_more_link();
			return $fields;
		}

	}