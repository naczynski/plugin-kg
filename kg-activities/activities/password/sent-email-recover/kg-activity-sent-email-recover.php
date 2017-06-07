<?php

	class KG_Activity_Sent_Email_Recover extends KG_Activity {

		public function get_type(){
			return 'Hasło';
		}

		public function get_class_name(){
			return 'password';
		}

		public function get_message(){
			return 'Wysłano email z nowym hasłem do konta';
		}
		
	}
