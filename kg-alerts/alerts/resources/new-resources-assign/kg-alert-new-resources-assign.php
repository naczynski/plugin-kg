<?php

	class KG_Alert_New_Resources_Assign extends KG_Alert {

		public function get_type(){
			return 'resource';
		}

		public function get_message(){
			return __( 'Przyznaliśmy Ci nowe zasoby', 'kg' );
		}
		
		public function get_action_type(){
			return 'link';
		}

		public function get_lightbox_data(){
			return array();
		}

		public function get_button_label(){
			return 'Moje zasoby';
		}

		public function get_button_icon(){
			return 'download';
		}

		public function get_link(){
			return get_permalink( KG_Config::getPublic('my_resources_page_id') );
		}

	}
