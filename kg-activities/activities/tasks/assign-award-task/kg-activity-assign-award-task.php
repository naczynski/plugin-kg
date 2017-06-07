<?php

	class KG_Activity_Assign_Award_Task extends KG_Activity {

		public function get_type(){
			return 'Zadanie';
		}

		public function get_class_name(){
			return 'task';
		}

		public function get_message(){
			$task_response = KG_Get::get('KG_Task_Response', $this->get_action_id());
			
			return str_replace(
				array(
					'{{task_url}}',
					'{{task_name}}',
					'{{resource_name}}',
					'{{resource_url}}',
					'{{task_respponse_url}}',
				), array(
					$task_response->get_task_obj()->get_admin_edit_link(),
					$task_response->get_task_obj()->get_name(),
					$task_response->get_award_resource()->get_name_with_subtype(),
					$task_response->get_award_resource()->get_admin_edit_link(),
					$task_response->get_admin_edit_url()
				), 'Wybrał nagrodę <a href="{{resource_url}}">{{resource_name}}</a> za poprawną <a href="{{task_respponse_url}}">odpowiedź</a> w zadaniu <a href="{{task_url}}">{{task_name}}</a> ');
		}
		
	}
