<?php

	class KG_Activity_Deactivate extends KG_Activity {

		public function get_type(){
			return 'Status konta';
		}

		public function get_class_name(){
			return 'activate';
		}

		public function get_message(){
			return 'Deaktywano konto';
		}
		
	}
