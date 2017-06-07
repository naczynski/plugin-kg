<?php

	class KG_Activity_Add_To_Basket_Resource extends KG_Activity {

		public function get_type(){
			return 'Koszyk (Dodał)';
		}

		public function get_class_name(){
			return 'basket-add';
		}

		public function get_message(){
			return KG_get_order_object($this->get_meta())->get_add_activity_message();
		}
		
	}
