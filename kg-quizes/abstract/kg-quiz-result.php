<?php

	abstract class KG_Quiz_Result implements JsonSerializable {

		private $quiz_id;
		private $user_id;
		
		private $is_user_solved;

		private $quiz_result_data;

		public function __construct($data) {
			$this->id = !empty($data['quiz_result_data']['id']) ? $data['quiz_result_data']['id'] : false;
			$this->quiz_id = !empty($data['quiz_id']) ? $data['quiz_id'] : false;
			$this->user_id = !empty($data['user_id']) ? $data['user_id'] : false;
			$this->is_user_solved = !empty($data['is_user_solved']) ? $data['is_user_solved'] : false;
			$this->quiz_result_data = !empty($data['quiz_result_data']) ? $data['quiz_result_data'] : false;	
		}

		public function is_user_solved(){
			return $this->is_user_solved;
		}

		public function is_correcnt_id(){
			return !empty($this->quiz_result_data['time']);
		}

		public function set_ID($id){
			$this->id = (int) $id;
		}

		public function get_solve_page_cocpit(){
			return KG_Get::get('KG_Cocpit_Page_Quiz_Result')->get_url($this->get_ID());
		}

		/* ==========================================================================
		   GETTERS
		   ========================================================================== */

		public function get_ID(){
			return $this->id;
		}

		public function get_kg_quiz_item(){
			return KG_Get::get('KG_Quiz_Item', $this->quiz_id);
		}

		public function get_quiz_id(){
			return $this->quiz_id;
		}

		public function get_user(){
			return KG_Get::get('KG_User', $this->get_user_id());
		}

		public function get_user_id(){
			return $this->user_id;
		}

		public function get_date(){
			return !empty($this->quiz_result_data['date']) ? $this->quiz_result_data['date'] : '-';
		}

		public function get_correct_answers(){
			if(!$this->is_user_solved) return 0;
			return $this->quiz_result_data['correct_answ'];
		}

		public function get_wrong_answers(){
			if(!$this->is_user_solved) return 0;
			return $this->quiz_result_data['wrong_answ'];
		}

		public function get_result_in_percange(){
			return round($this->get_correct_answers() / $this->get_kg_quiz_item()->get_number_questions() * 100);
		}

		public function get_user_answers(){
			if(!$this->is_user_solved) return array();
			if ( is_string($this->quiz_result_data['answers']) ) {
				$this->quiz_result_data['answers'] = json_decode($this->quiz_result_data['answers'], true);
			}
			return $this->quiz_result_data['answers'];
		}

		public function get_time_solving(){
			if(!$this->is_user_solved) return '00:00:00';
			return $this->quiz_result_data['time'];
		}

		public function is_user_passed_quiz(){
			return $this->get_kg_quiz_item()->get_percange_to_pass_quiz() <= $this->get_result_in_percange();
		}

		public function get_questions_with_user_answer(){
			$questions_meta = $this->get_kg_quiz_item()->get_question_data();
			$user_answers = $this->get_user_answers();
			$out = array();
			foreach ($questions_meta as $index => $question) {
				$out[]= KG_Get::get('KG_Single_Question', $question, $user_answers[$index], true);
			}
			return $out;
		}

		/* ==========================================================================
		   AWARD
		   ========================================================================== */
		
		public function is_user_choose_award(){
			if(!$this->is_user_solved) return false;
			return $this->quiz_result_data['award_resource_id'] != null ? true : false ;
		}

		public function get_award_resource(){
			if(!$this->is_user_choose_award()) return false;
			return KG_get_resource_object( (int) $this->quiz_result_data['award_resource_id']);
		}

		public function get_award_relation_id(){
			if(!$this->is_user_choose_award()) return false;
			return (int) $this->quiz_result_data['award_relation_id'];
		}

		private function assign_award_in_db($resource_id, $relation_id){
			global $wpdb;

			return $wpdb->update( 
				KG_Config::getPublic('table_quizes_results'), 
				array( 
					'award_resource_id' => $resource_id,
					'award_relation_id' => $relation_id
				), 
				array( 'id' => $this->quiz_result_data['id'] ), 
				array( 
					'%d',
					'%d'
				), 
				array('%d') 
			);
		}

		public function add_award($resource_id){
			if($this->is_user_choose_award()) {
				return new WP_Error('no_passed_quiz', __( 'Nagroda została wybrana.. Przejdź do zakładki Zasoby->Moje->Wygrane w quizach, aby ją pobrać.', 'kg' ));
			}

			if(!$this->is_user_passed_quiz()) {
				return new WP_Error('no_passed_quiz', __( 'Przykro nam ale nie zaliczyłeś quizu pozytywnie, nie możesz wygrać nagrody.', 'kg' ));
			}

			if(!$this->get_kg_quiz_item()->is_can_win_this_resource($resource_id)){
				return new WP_Error('bad_resource', __( 'Przykro nam, ale nie możesz wybrać tego zasobu jako nagrody.', 'kg' ));
			}

			if(KG_Get::get('KG_Resource_Relations')->can_download($this->get_user_id(), $resource_id)){
				return new WP_Error('bad_resource', __( 'Już posiadasz dany zasób.', 'kg' ));
			}

			$relation_obj = KG_Get::get('KG_Quiz_Relation', 
					$this->user_id, 
					$resource_id, 
					$this->quiz_result_data['id']);

			$relation_id = $relation_obj->add_to_db();
			$result = $this->assign_award_in_db($resource_id, $relation_id);
			
			if($result) {
				$this->quiz_result_data['award_resource_id'] = $resource_id;
				$this->quiz_result_data['award_relation_id'] = $relation_id;
				do_action('kg_quiz_assign_award', $this);
			}

			return $result;
		}


		public function remove_award() {
			global $wpdb;

			$result = $wpdb->update( 
				KG_Config::getPublic('table_quizes_results'), 
				array( 
					'award_resource_id' => null,
					'award_relation_id' => null
				), 
				array( 'id' => $this->quiz_result_data['id'] ), 
				array( 
					'%d',
					'%d'
				), 
				array( '%d' ) 
			);

			if($result) {
				$this->quiz_result_data['award_resource_id'] = $resource_id;
				$this->quiz_result_data['award_relation_id'] = $relation_id;
			}

			return $result;
		}

		/* ==========================================================================
		   SERIALIZATION
		========================================================================== */

		public function jsonSerialize(){
			$out = array(
				'solved_quiz' => $this->is_user_solved(),
				'quiz_id' => $this->get_quiz_id(),
				'user_id' => $this->get_user_id(),
				'date' => $this->get_date(),
				'percange_result' => $this->get_result_in_percange(),
				'correct_answers' => $this->get_correct_answers(),
				'wrong_answers' => $this->get_wrong_answers(),
				'passed_quiz' => $this->is_user_passed_quiz(),
				'user_answers' => $this->get_user_answers(),
				'time_solving' => $this->get_time_solving(),
				'choose_award' => $this->is_user_choose_award(),
				'questions_with_user_answers' => $this->get_questions_with_user_answer()
			);

			if($this->is_user_choose_award()){
				$out['award_resource_id'] = $this->quiz_result_data['award_resource_id'];
				$out['award_relation_id'] = $this->quiz_result_data['award_relation_id'];
			}
			return $out;
		}

	}