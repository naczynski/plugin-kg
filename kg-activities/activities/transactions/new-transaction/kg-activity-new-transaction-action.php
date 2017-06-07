<?php

	class KG_Activity_New_Transaction_Action extends KG_Activity_Actions {

		public function __construct($type, $single_object_name){
			parent::__construct($type, $single_object_name);
			add_action('kg_create_transaction', array(&$this, 'add'), $type, 1);
		}

		public function add($transaction_obj){
			return KG_Add_Activity(array(
				'type' => $this->type,
				'user_id' => $transaction_obj->get_user_id(),
				'action_id' => $transaction_obj->get_ID(),
				'meta' => array()
			));
		}

	}