<?php

	class KG_Activity_Solve_Quiz_Action extends KG_Activity_Actions {

		public function __construct($type, $single_object_name){
			parent::__construct($type, $single_object_name);
			add_action('kg_solve_quiz', array(&$this, 'add'), $type, 1);
		}

		public function add($solve_object){
			return KG_Add_Activity(array(
				'type' => $this->type,
				'user_id' => $solve_object->get_user_id(),
				'action_id' => $solve_object->get_ID(),
				'meta' => array()
			));
		}		
	}