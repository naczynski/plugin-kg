<?php

	class KG_Activity_Sent_Email_Recover_Action extends KG_Activity_Actions {

		public function __construct($type, $single_object_name){
			parent::__construct($type, $single_object_name);
			add_action('kg_sent_recover_password_mail', array(&$this, 'add'), $type, 1);
		}

		public function add($user_id){
			return KG_Add_Activity(array(
				'type' => $this->type,
				'user_id' => $user_id,
				'action_id' => null,
				'meta' => array()
			));
		}
		
	}