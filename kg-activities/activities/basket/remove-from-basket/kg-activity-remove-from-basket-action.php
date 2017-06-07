<?php

	class KG_Activity_Remove_From_Basket_Action extends KG_Activity_Actions {

		public function __construct($type, $single_object_name){
			parent::__construct($type, $single_object_name);
			add_action('kg_remove_from_basket', array(&$this, 'add'), 1, 2);
		}

		public function add($user_id, $order_obj){
			
			return KG_Add_Activity(array(
				'type' => $this->type,
				'user_id' => $user_id,
				'action_id' => null,
				'meta' => $order_obj
			));
			
		}
		
	}