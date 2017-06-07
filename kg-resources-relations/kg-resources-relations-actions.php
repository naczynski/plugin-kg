<?php

	class KG_Resources_Relations_Actions {

		public function __construct(){
			add_action('kg_resource_like', array($this, 'on_like'), 1, 3);
			add_action('kg_use_free_resource', array($this, 'on_free_resource'), 1, 3);
		}

		public function on_like($user_id, $resource_id, $like_id){
			KG_Get::get('KG_Like_Relation', $user_id, $resource_id , $like_id)->add_to_db();
		}

		public function on_free_resource($user_id, $resource_id, $subscription_entry_id){
			KG_Get::get('KG_Buy_Relation', $user_id, $resource_id , $subscription_entry_id)->add_to_db();
		}

	}