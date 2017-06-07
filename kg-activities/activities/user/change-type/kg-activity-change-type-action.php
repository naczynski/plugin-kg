<?php

	class KG_Activity_Change_Type_Action extends KG_Activity_Actions {

		public function __construct($type, $single_object_name){
			parent::__construct($type, $single_object_name);
			add_action('kg_change_user_type', array(&$this, 'add'), 1, 2);
		}

		public function add($user_id, $name){
			return KG_Add_Activity(array(
				'type' => $this->type,
				'user_id' => $user_id,
				'action_id' => null,
				'meta' => array(
					'name' => $name
				)
			));
		}
		
	}