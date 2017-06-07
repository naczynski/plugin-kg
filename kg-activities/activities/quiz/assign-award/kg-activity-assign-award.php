<?php

	class KG_Activity_Assign_Award extends KG_Activity {

		public function get_type(){
			return 'Quiz';
		}

		public function get_class_name(){
			return 'quiz';
		}

		public function get_message(){
			$quiz_solve = KG_Get::get('KG_Single_Result_From_Solve_Id', $this->get_action_id());
			return str_replace(
				array(
					'{{quiz_url}}',
					'{{quiz_name}}',
					'{{resource_name}}',
					'{{resource_url}}',
					'{{quiz_result_url}}',
				), array(
					$quiz_solve->get_kg_quiz_item()->get_admin_edit_link(),
					$quiz_solve->get_kg_quiz_item()->get_name(),
					$quiz_solve->get_award_resource()->get_name_with_subtype(),
					$quiz_solve->get_award_resource()->get_admin_edit_link(),
					$quiz_solve->get_solve_page_cocpit()
				), 'Wybrał nagrodę <a href="{{resource_url}}">{{resource_name}}</a> za wygraną w quizie <a href="{{quiz_url}}">{{quiz_name}}</a> <a href="{{quiz_result_url}}">Zobacz rozwiązanie</a>');
		}
		
	}
