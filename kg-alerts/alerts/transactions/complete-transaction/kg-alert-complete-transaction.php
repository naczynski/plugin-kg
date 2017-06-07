<?php

	class KG_Alert_Complete_Transaction extends KG_Alert {

		public function get_type(){
			return 'transaction';
		}

		public function get_message(){
			return __( 'Potwierdzamy przyjęcie płatności', 'kg' );
		}
		
		public function get_action_type(){
			return 'link';
		}

		public function get_lightbox_data(){
			return array();
		}

		public function get_button_label(){
			return 'Pobierz fakturę';
		}

		public function get_button_icon(){
			return 'download';
		}

		public function get_link(){
			return '/pobierz?type=invoice&id=' . $this->get_action_id();
		}

	}
