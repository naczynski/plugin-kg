<?php

	class KG_Activity_Payment_Complete extends KG_Activity {

		public function get_type(){
			return 'Transakcja';
		}

		public function get_class_name(){
			return 'transaction';
		}

		public function get_message(){
			$meta = $this->get_action_id();
			$transaction_obj = KG_Get::get('KG_Transaction',$this->get_action_id());

			$pattern = 'Zapłacił za zamówienie <a href="{{link}}">{{number}}</a>';

			return str_replace(
				array(
					'{{link}}',
					'{{number}}'
				), array(
					$transaction_obj->get_admin_edit_link(),
					$transaction_obj->get_number_for_user()
				), $pattern);

		}
		
	}
