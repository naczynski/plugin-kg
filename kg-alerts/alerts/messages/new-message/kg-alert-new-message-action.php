<?php

	class KG_Alert_New_Message_Action extends KG_Alert_Actions {

		public function __construct($type, $single_object_name){
			parent::__construct($type, $single_object_name);
			add_action('kg_sent_message', array(&$this, 'add'), $type, 1);
		}

		public function add($message_obj){
			return KG_Add_Alert(array(
				'type' => $this->type,
				'user_id' => $message_obj->get_to_user_id(),
				'action_id' => $message_obj->get_message_id()
			));
		}

	}