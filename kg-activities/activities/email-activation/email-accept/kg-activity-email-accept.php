<?php

	class KG_Activity_Email_Accept extends KG_Activity {

		public function get_type(){
			return 'Potweirdzenie email';
		}

		public function get_class_name(){
			return 'email-activation';
		}

		public function get_message(){
			return 'Potwierdzono adres email';
		}
		
	}
