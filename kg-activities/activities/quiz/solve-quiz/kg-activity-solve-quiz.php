<?php

	class KG_Activity_Solve_Quiz extends KG_Activity {

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
					'{{percange}}',
					'{{quiz_result_url}}',
				), array(
					$quiz_solve->get_kg_quiz_item()->get_admin_edit_link(),
					$quiz_solve->get_kg_quiz_item()->get_name(),
					$quiz_solve->get_result_in_percange(),
					$quiz_solve->get_solve_page_cocpit()
				), 'Rozwiązał <a href="{{quiz_url}}">{{quiz_name}}</a> z wynikiem {{percange}}%. <a href="{{quiz_result_url}}">Zobacz odpowiedzi</a>');

		}
		
	}
