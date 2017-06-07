<?php 

	class KG_Quiz_Item extends KG_Item {

		private $questions_objs = array();
		private $awards_resources = array();

		private $quiz_solve_obj = null;

		public function __construct($quiz_id) {
			parent::__construct($quiz_id);
		}
	
		/* ==========================================================================
		   QUESTIONS
		   ========================================================================== */

		public function get_question_data(){
			return $this->get_resource_meta()['questions'];
		}

		public function get_questions() {
			if(!empty($this->questions_objs)) return $this->questions_objs;
			$questions = $this->get_resource_meta()['questions'];
			foreach ($questions as $question) {
				$this->questions_objs[] = KG_Get::get('KG_Single_Question', $question);	
			}
			return $this->questions_objs;
		}

		public function get_number_questions() {
			return sizeof($this->get_resource_meta()['questions']);
		}

		public function get_percange_to_pass_quiz() {
			return !empty($this->get_resource_meta()['percange_to_pass_quiz']) ? 
				$this->get_resource_meta()['percange_to_pass_quiz'] :
				'';
		}

		public function can_buy() {
			return false;
		}

		public function can_like() {
			return false;
		}

		public function can_present() {
			return false;
		}

		/* ==========================================================================
		   SOLVE
		   ========================================================================== */

		public function get_quiz_solve_obj($user_id){
			return KG_Get::get('KG_Single_Result_From_Db', $this->id, $user_id);
		}

		public function is_user_solved($user_id){
			return $this->get_quiz_solve_obj($user_id)->is_user_solved();
		}

		/* ==========================================================================
		   AWARDS
		   ========================================================================== */

		private function get_awards_resources_ids(){
			return !empty($this->get_resource_meta()['resources_to_win']) ? 
					$this->get_resource_meta()['resources_to_win'] :
					array();
		}

		public function get_awards_resources() {
			if(!empty($this->awards_resources)) return $this->awards_resources;
			$award_resources_ids = $this->get_awards_resources_ids();

			foreach ($award_resources_ids as $resource_id) {
				$this->awards_resources[] = KG_get_resource_object($resource_id);	
			}
			return $this->awards_resources;	
		}

		public function is_can_win_this_resource($resource_id) {
			return in_array($resource_id, $this->get_awards_resources_ids());
		}

		/* ==========================================================================
		   SERIALIZATION
		   ========================================================================== */

		public function get_serialized_fields_for($user_id){
			$fields = parent::get_serialized_fields_for($user_id);
			
			$fields['questions'] = $this->get_questions();
			$fields['number_questions'] = $this->get_number_questions();
			$fields['awards'] = $this->get_awards_resources();
			$fields['is_user_solved'] = $this->is_user_solved($user_id);
			$fields['percange_to_pass_quiz'] = $this->get_percange_to_pass_quiz();

			if($this->is_user_solved($user_id)){
				$fields['solve'] = $this->get_quiz_solve_obj($user_id);
			}

			return $fields;
		}

	}
