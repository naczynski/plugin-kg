<?php

	class KG_Alert_Apply_Subscription_Action extends KG_Alert_Actions {

		public function __construct($type, $single_object_name){
			parent::__construct($type, $single_object_name);
			add_action('kg_add_subscription', array(&$this, 'add'), $type, 3);
		}

		public function add( $subcription_obj , $subscription_entry, $user_id){
			return KG_Add_Alert(array(
				'type' => $this->type,
				'user_id' => $subscription_entry->get_user_id(),
				'action_id' => $subcription_obj->get_ID()
			));
		}

	}