<?php

	class KG_Alert_Disable_Networking_Action extends KG_Alert_Actions {

		public function __construct($type, $single_object_name){
			parent::__construct($type, $single_object_name);
			add_action('kg_disable_networking', array(&$this, 'add'), 1, 1);
		}

		public function add($user_id){
			return KG_Add_Alert(array(
				'type' => $this->type,
				'user_id' => $user_id,
				'action_id' => null
			));
		}

	}