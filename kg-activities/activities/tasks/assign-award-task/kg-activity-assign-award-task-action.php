<?php

	class KG_Activity_Assign_Award_Task_Action extends KG_Activity_Actions {

		public function __construct($type, $single_object_name){
			parent::__construct($type, $single_object_name);
			add_action('kg_task_assign_award', array(&$this, 'add'), $type, 1);
		}

		public function add($task_response){
			return KG_Add_Activity(array(
				'type' => $this->type,
				'user_id' => $task_response->get_user_id(),
				'action_id' => $task_response->get_ID(),
				'meta' => array()
			));
		}

	}
