<?php

	class KG_Activity_Change_Password extends KG_Activity {

		public function get_type(){
			return 'Hasło';
		}

		public function get_class_name(){
			return 'password';
		}

		public function get_message(){
			return 'Użytkownik zmienił swoje hasło';
		}
		
	}
