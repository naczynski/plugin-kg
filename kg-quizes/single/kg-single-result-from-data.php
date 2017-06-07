<?php

	class KG_Single_Result_From_Data extends KG_Quiz_Result {

		public function __construct($data){
			parent::__construct(array(
				'id' => $data,
				'quiz_id' => $data['quiz_id'],
				'user_id' => $data['user_id'],
				'is_user_solved' => true,
				'quiz_result_data' => $data
			));
		}

	}