<?php

	class KG_Activity_Enought_Likes_Action extends KG_Activity_Actions {

		public function __construct($type, $single_object_name){
			parent::__construct($type, $single_object_name);
			add_action('kg_can_choose_award_for_response', array(&$this, 'add'), $type, 1);
		}

		public function add($task_response_obj){
			return KG_Add_Activity(array(
				'type' => $this->type,
				'user_id' => $task_response_obj->get_user_id(),
				'action_id' => $task_response_obj->get_id(),
				'meta' => array()
			));
		}
		
	}