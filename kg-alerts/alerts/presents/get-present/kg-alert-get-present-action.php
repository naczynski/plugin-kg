<?php

	class KG_Alert_Get_Present_Action extends KG_Alert_Actions {

		public function __construct($type, $single_object_name){
			parent::__construct($type, $single_object_name);
			add_action('kg_add_present_single', array(&$this, 'add_single'), $type, 1);
			add_action('kg_add_present_multi_relations_obj', array(&$this, 'add_multiple'), $type, 2);

		}

		public function add_single($present_relation_obj){
			return KG_Add_Alert(array(
				'type' => $this->type,
				'user_id' => $present_relation_obj->get_to_user()->get_ID(),
				'action_id' => $present_relation_obj->get_relation_id()
			));
		}

		public function add_multiple($relations_ids, $to_user_id){
			foreach ($relations_ids as $relation_id) {
				KG_Add_Alert(array(
					'type' => $this->type,
					'user_id' => $to_user_id,
					'action_id' => $relation_id
				));
			}
		}
		
	}