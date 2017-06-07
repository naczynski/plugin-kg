<?php

	class KG_Activity_Apply_Subscription_Cocpit_Action extends KG_Activity_Actions {

		public function __construct($type, $single_object_name){
			parent::__construct($type, $single_object_name);
			add_action('kg_assing_subscription_cocpit', array(&$this, 'add'), $type, 3);
		}

		public function add($user_id,  $subscription_entry, $subcription_obj){
			return KG_Add_Activity(array(
				'type' => $this->type,
				'user_id' => $user_id,
				'action_id' => null,
				'meta' => array(
					'subscr_id' => $subcription_obj->get_ID(),
					'start' => $subscription_entry->get_start_date(),
					'end' => $subscription_entry->get_end_date(),
				)
			));
		}
		
	}