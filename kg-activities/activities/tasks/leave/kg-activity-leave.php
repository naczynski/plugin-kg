<?php

	class KG_Activity_Leave extends KG_Activity {

		public function get_type(){
			return 'Zadanie';
		}

		public function get_class_name(){
			return 'task';
		}

		public function get_message(){
			$task_item = KG_Get::get('KG_Task_Item', $this->get_action_id());

			return str_replace(
				array(
					'{{task_url}}',
					'{{task_name}}'
				), array(
					$task_item->get_admin_edit_link(),
					$task_item->get_name_with_subtype()
				), 
				'Użytkownik wypisał się z zadania <a target="_blank" href="{{task_url}}">{{task_name}}</a>'
			);
		}
		
	}
