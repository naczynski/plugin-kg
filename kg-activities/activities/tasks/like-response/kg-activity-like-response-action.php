<?php

	class KG_Activity_Like_Response_Action extends KG_Activity_Actions {

		public function __construct($type, $single_object_name){
			parent::__construct($type, $single_object_name);
			add_action('kg_like_task_response', array(&$this, 'add'), $type, 2);
		}

		public function add($user_id_who_liked, $task_response_obj){
			return KG_Add_Activity(array(
				'type' => $this->type,
				'user_id' => $user_id_who_liked,
				'action_id' => $task_response_obj->get_id(),
				'meta' => array()
			));
		}
		
	}