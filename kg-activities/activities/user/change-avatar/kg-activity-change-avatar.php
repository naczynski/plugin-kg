<?php

	class KG_Activity_Change_Avatar extends KG_Activity {

		public function get_type(){
			return 'Avatar';
		}

		public function get_class_name(){
			return 'change-avatar';
		}

		public function get_message(){
			return 'Zmienił avatar';
		}
		
	}
