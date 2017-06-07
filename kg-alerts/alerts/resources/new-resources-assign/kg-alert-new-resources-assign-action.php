<?php

	class KG_Alert_New_Resources_Assign_Action extends KG_Alert_Actions {

		public function __construct($type, $single_object_name){
			parent::__construct($type, $single_object_name);
			add_action('kg_payment_complete', array(&$this, 'add'), 1, 1);
			add_action('kg_quiz_assign_award', array(&$this, 'assing_award_quiz'), 1, 1);
			add_action('kg_task_assign_award', array(&$this, 'assing_award_task'), 1, 1);
		}

		public function assing_award_quiz($quiz_solve_obj){
			return KG_Add_Alert(array(
				'type' => $this->type,
				'user_id' => $quiz_solve_obj->get_user_id(),
				'action_id' => null
			));
		}

		public function assing_award_task($response_obj){
			return KG_Add_Alert(array(
				'type' => $this->type,
				'user_id' => $response_obj->get_user_id(),
				'action_id' => null
			));
		}

		public function add($transaction_obj){
			if( !$transaction_obj->is_containt_resource() ) return;
			return KG_Add_Alert(array(
				'type' => $this->type,
				'user_id' => $transaction_obj->get_user_id(),
				'action_id' => null
			));
		}

	}