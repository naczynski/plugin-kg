<?php

	class KG_Alert_NAME extends KG_Alert {

		public function get_type(){
			return 'user';
		}

		public function get_message(){
			return __( 'MESSAGE', 'kg' );
		}
		
		public function get_action_type(){
			return 'none';
		}

		public function get_lightbox_data(){
			return array();
		}

		public function get_button_label(){
			return '';
		}

		public function get_button_icon(){
			return '';
		}

		public function get_link(){
			return '';
		}

	}
