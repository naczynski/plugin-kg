<?php

	class KG_Alert_Task_New_Response_Action extends KG_Alert_Actions {

		public function __construct($type, $single_object_name){
			parent::__construct($type, $single_object_name);
			add_action('kg_add_response_to_task', array(&$this, 'add'), $type, 2);
		}

		public function add($task_obj, $task_response_obj){
			$ids = $task_obj->get_user_ids_with_participite_in_task();
			
			foreach ($ids as $user_id) {
				if($user_id == get_current_user_id()) continue;
				KG_Add_Alert(array(
					'type' => $this->type,
					'user_id' => $user_id,
					'action_id' => $task_obj->get_ID()
				));

			}
		}

	}