<?php

	class KG_Alert_Set_Default_Action extends KG_Alert_Actions {

		public function __construct($type, $single_object_name){
			parent::__construct($type, $single_object_name);
			add_action('kg_change_type_to_default', array(&$this, 'add'), $type, 1);
		}

		public function add($user_id){
			return KG_Add_Alert(array(
				'type' => $this->type,
				'user_id' => $user_id,
				'action_id' => null
			));
		}

	}