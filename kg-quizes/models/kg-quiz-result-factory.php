<?php

	class KG_Quiz_Result_Factory {

		private $quiz_result_id;
		private $correct_answers = 0;
		private $wrong_answers = 0;
		private $user_answers = array();
		private $time_solving;

		private $kg_quiz_result_obj;

		private $kg_quiz_item;

		private function check_answers(){
			$questions = $this->kg_quiz_item->get_questions();
			foreach ($questions as $index => $question) {
				if($question->check_is_correct_answer($this->user_answers[$index])){
					$this->correct_answers++;
				} else {
					$this->wrong_answers++;
				}
			}
		}

		public function get_kg_single_order_obj(){
			if(!empty($this->kg_quiz_result_obj)) return $this->kg_quiz_result_obj;
			$this->kg_quiz_result_obj = KG_Get::get('KG_Single_Result_From_Data', array(
				'correct_answ' => $this->correct_answers,
				'wrong_answ' => $this->wrong_answers,
				'quiz_id' => $this->quiz_id,
				'user_id' => $this->user_id,
				'answers' => $this->user_answers,
				'time' => $this->time_solving
			));

			return $this->kg_quiz_result_obj;
		}

		private function add_to_db(){
			global $wpdb;

			$quiz_solve_obj = $this->get_kg_single_order_obj();

			$insert = $wpdb->insert( 
				KG_Config::getPublic('table_quizes_results'),
				array(
					'quiz_id' => $this->quiz_id,
					'correct_answ' => $this->correct_answers,
					'wrong_answ' => $this->wrong_answers,
					'answers' => json_encode($this->user_answers),
					'time' => $this->time_solving,
					'user_id' => $this->user_id,
					'date' => KG_get_time(),
					'is_passed' => $quiz_solve_obj->is_user_passed_quiz() ? 1 : 0
				),
				array(
					'%d',
					'%d',
					'%d',
					'%s',
					'%s',
					'%d',
					'%s',
					'%d'
				) 
			);

			if($insert) {
				$quiz_solve_obj->set_ID($wpdb->insert_id);
				do_action('kg_solve_quiz', $quiz_solve_obj);
			} else {
				return false;
			}
		}

		private function calculate_time_solving($date_start) {
			return date_diff(new DateTime($date_start),KG_get_time_obj()->toDateTime())->format('%H:%I:%S');
		}

		public function __construct($quiz_id, $user_id, $answers , $date_start) {
			$this->user_id = $user_id;

			$this->quiz_id = $quiz_id;
			$this->kg_quiz_item = KG_Get::get('KG_Quiz_Item', $quiz_id);
			
			$this->time_solving = $this->calculate_time_solving($date_start);

			$this->user_answers = $answers ;
			$this->date_start = $this->calculate_time_solving($date_start);
		}

		public function check_and_add_to_db() {
			if(sizeof($this->user_answers) != $this->kg_quiz_item->get_number_questions() ){
				return new WP_Error('bad_quantitiy_of_questions', __( 'Ilość odpowiedzi nie jest równa ilości pytań.', 'kg' ) );
			}
			$this->check_answers();
			$this->add_to_db();
			return $this->get_kg_single_order_obj();
		}

	}