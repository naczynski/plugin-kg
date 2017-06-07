<?php

	class KG_Single_Result_From_Db extends KG_Quiz_Result {

		private function get_data_from_db($quiz_id, $user_id) {
			global $wpdb;
			$data = $wpdb->get_row( 
				$wpdb->prepare("
					SELECT * FROM " . KG_Config::getPublic('table_quizes_results') . "
					WHERE user_id = %d AND quiz_id = %d
					", (int) $user_id,
					   (int) $quiz_id 
					 ),
				ARRAY_A 
			); 
			return $data;
		}

		public function __construct($quiz_id, $user_id) {			
			$data_from_db = $this->get_data_from_db($quiz_id, $user_id);
			parent::__construct(array(
				'quiz_id' => $quiz_id,
				'user_id' => $user_id,
				'is_user_solved' => $data_from_db ? true : false,
				'quiz_result_data' => $data_from_db
			));
		}
		
	}