<?php

	class KG_Activity_Add_Response_Action extends KG_Activity_Actions {

		public function __construct($type, $single_object_name){
			parent::__construct($type, $single_object_name);
			add_action('kg_add_response_to_task', array(&$this, 'add'), $type, 2);
		}

		public function add($task_obj, $task_response_obj){
			return KG_Add_Activity(array(
				'type' => $this->type,
				'user_id' => $task_response_obj->get_user_id(),
				'action_id' => $task_response_obj->get_id(),
				'meta' => array()
			));
		}
		
	}