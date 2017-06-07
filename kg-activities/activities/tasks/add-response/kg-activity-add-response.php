<?php

	class KG_Activity_Add_Response extends KG_Activity {

		public function get_type(){
			return 'Zadanie';
		}

		public function get_class_name(){
			return 'task';
		}

		public function get_message(){
			$response = KG_Get::get('KG_Task_Response', $this->get_action_id());

			return str_replace(
				array(
					'{{response_url}}',
					'{{task_url}}',
					'{{task_name}}'
				), array(
					$response->get_admin_edit_url(),
					$response->get_task_obj()->get_admin_edit_link(),
					$response->get_task_obj()->get_name_with_subtype()
				), 
				'Użytkownik dodał <a target="_blank" href="{{response_url}}">odpowiedź</a> do zadania <a target="_blank" href="{{task_url}}">{{task_name}}</a>'
			);
		}
		
	}
