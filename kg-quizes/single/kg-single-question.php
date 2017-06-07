<?php

	class KG_Single_Question implements JsonSerializable {

		private $question;

		private $answer_a;
		private $answer_b;
		private $answer_c;
		private $answer_d;

		private $correct_answer;
		private $user_answer;

		public function __construct($data, $user_answer = false, $show_correct_answer = false) {
			$this->question = !empty($data['question']) ? $data['question']  : ''; 
			$this->answer_a = !empty($data['a']) ? $data['a']  : '';
			$this->answer_b = !empty($data['b']) ? $data['b']  : '';
			$this->answer_c = !empty($data['c']) ? $data['c']  : '';
			$this->answer_d = !empty($data['d']) ? $data['d']  : '';
			$this->correct_answer = !empty($data['correct_answer']) ? $data['correct_answer']  : '';
			$this->user_answer = $user_answer ? $user_answer  : '';
			$this->show_correct_answer = $show_correct_answer; 
		}

		/* ==========================================================================
		   GETTERS
		   ========================================================================== */
		
		public function get_question() {
			return $this->question;
		}

		public function get_answer_a() {
			return $this->answer_a;
		}

		public function get_answer_b() {
			return $this->answer_b;
		}

		public function get_answer_c() {
			return $this->answer_c;
		}

		public function get_answer_d() {
			return $this->answer_d;
		}

		public function get_correct_answer() {
			return $this->correct_answer;
		}

		public function get_user_answer() {
			return $this->user_answer;
		}

		/* ==========================================================================
		   SETTERS
		   ========================================================================== */
		
		public function set_user_answer($answer){
			$this->user_answer = $answer;
		}

		/* ==========================================================================
		   ANSWER
		   ========================================================================== */

		public function is_correct_user_answer() {
			return strtolower($this->correct_answer) == strtolower($this->user_answer);  
		}

		public function check_is_correct_answer($answer) {
			return strtolower($this->correct_answer) == strtolower($answer);  
		}

		public function check_is_user_answer($answer) {
			return $this->get_user_answer() == strtolower($answer);  
		}

		public function jsonSerialize(){
			$out = array(
				'question' => $this->get_question(),
				'a' => $this->get_answer_a(),
				'b' => $this->get_answer_b(),
				'c' => $this->get_answer_c(),
				'd' => $this->get_answer_d(),
				'user_answer' => $this->get_user_answer(),
				'is_correct_answer' => $this->is_correct_user_answer()
			);
			if($this->show_correct_answer){
				$out['correct_answer'] = $this->get_correct_answer();
			}
			return $out;
		}
		
	}