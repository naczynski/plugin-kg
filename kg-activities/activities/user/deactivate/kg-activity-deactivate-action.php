<?php

	class KG_Activity_Deactivate_Action extends KG_Activity_Actions {

		public function __construct($type, $single_object_name){
			parent::__construct($type, $single_object_name);
			add_action('kg_user_deactive_cocpit', array(&$this, 'add'), $type, 1);
			add_action('kg_user_deactive_front', array(&$this, 'add'), $type, 1);
		}

		public function add($user_id, $meta = array()){
			return KG_Add_Activity(array(
				'type' => $this->type,
				'user_id' => $user_id,
				'action_id' => null,
				'meta' => array()
			));
		}
		
	}