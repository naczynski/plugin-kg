<?php

	class KG_Activity_Add_To_Basket_Subscription_Action extends KG_Activity_Actions {

		public function __construct($type, $single_object_name){
			parent::__construct($type, $single_object_name);
			add_action('kg_add_to_basket_subscription', array(&$this, 'add'), 1, 2);
		}

		public function add($user_id, $subscription_order_obj){
			
			return KG_Add_Activity(array(
				'type' => $this->type,
				'user_id' => $user_id,
				'action_id' => null,
				'meta' => $subscription_order_obj
			));
			
		}
		
	}