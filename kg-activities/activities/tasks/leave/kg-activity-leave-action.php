<?php

	class KG_Activity_Leave_Action extends KG_Activity_Actions {

		public function __construct($type, $single_object_name){
			parent::__construct($type, $single_object_name);
			add_action('kg_leave_from_task', array(&$this, 'add'), $type, 2);
		}

		public function add($user_id, $task_obj){
			return KG_Add_Activity(array(
				'type' => $this->type,
				'user_id' => $user_id,
				'action_id' => $task_obj->get_ID(),
				'meta' => array()
			));
		}
		
	}