<?php

	class KG_Alert_Get_Present extends KG_Alert {

		private function get_present_relation_object(){
			return KG_Get::get('KG_Present_Relation_Single', (int) $this->get_action_id());
		}

		public function get_type(){
			return 'present';
		}

		public function get_message(){
			return __( 'Dostałeś prezent od ', 'kg' ) . $this->get_present_relation_object()->get_from_user()->get_name_and_surname() ;
		}
		
		public function get_action_type(){
			return 'lightbox-present';
		}

		public function get_lightbox_data(){
			return $this->get_present_relation_object();
		}

		public function get_button_label(){
			return 'Otwórz';
		}

		public function get_button_icon(){
			return 'eye';
		}

		public function get_link(){
			return '';
		}

	}
