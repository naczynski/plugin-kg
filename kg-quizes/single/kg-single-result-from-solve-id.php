<?php

	class KG_Single_Result_From_Solve_Id extends KG_Quiz_Result {

		private function get_data_from_db($solve_id) {
			global $wpdb;
			$data = $wpdb->get_row( 
				$wpdb->prepare("
					SELECT * FROM " . KG_Config::getPublic('table_quizes_results') . "
					WHERE id = %d
					", (int) $solve_id),
				ARRAY_A 
			); 
			return $data;
		}

		public function __construct($solve_id) {			
			$data_from_db = $this->get_data_from_db($solve_id);

			if(empty($data_from_db)) return;
			parent::__construct(array(
				'quiz_id' => $data_from_db['quiz_id'],
				'user_id' => $data_from_db['user_id'],
				'is_user_solved' => $data_from_db ? true : false,
				'quiz_result_data' => $data_from_db,
				'id' => $data_from_db['id']
			));
		}
		
	}