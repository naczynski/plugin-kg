<?php

	class KG_Alert_Enable_Networking extends KG_Alert {

		public function get_type(){
			return 'user';
		}

		public function get_message(){
			return __( 'Od teraz masz dostęp do funkcji networking', 'kg' );
		}
		
		public function get_action_type(){
			return 'none';
		}

		public function get_lightbox_data(){
			return array();
		}

		public function is_show_action_button(){
			return false;
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
