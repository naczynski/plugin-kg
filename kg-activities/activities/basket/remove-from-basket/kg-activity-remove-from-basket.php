<?php

	class KG_Activity_Remove_From_Basket extends KG_Activity {

		public function get_type(){
			return 'Koszyk (Usunął)';
		}

		public function get_class_name(){
			return 'basket-remove';
		}

		public function get_message(){
			return KG_get_order_object($this->get_meta())->get_remove_activity_message();
		}
		
	}
