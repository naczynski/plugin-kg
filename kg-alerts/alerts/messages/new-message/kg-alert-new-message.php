<?php

	class KG_Alert_New_Message extends KG_Alert {

		public function get_type(){
			return 'message';
		}

		public function get_message(){
			$message_obj = KG_Get::get('KG_Single_Message', $this->get_action_id());
			return __( 'Nowa wiadomość od: ', 'kg' ) . $message_obj->get_from_user()->get_name_and_surname();
		}
		
		public function get_action_type(){
			return 'lightbox-message';
		}

		public function get_lightbox_data(){
			return KG_Get::get('KG_Single_Message', $this->get_action_id());
		}

		public function get_button_label(){
			return 'Zobacz i odpowiedz';
		}

		public function get_button_icon(){
			return 'eye';
		}

		public function get_link(){
			return '';
		}

	}
