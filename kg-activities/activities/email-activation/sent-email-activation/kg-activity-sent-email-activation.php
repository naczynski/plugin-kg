<?php

	class KG_Activity_Sent_Email_Activation extends KG_Activity {

		public function get_type(){
			return 'Potwierdzenie email';
		}

		public function get_class_name(){
			return 'email-activation';
		}

		public function get_message(){
			return 'Wysłano wiadomość potwierdzającą adres email.';
		}
		
	}
