<?php

	class KG_Activity_Change_Field_Action extends KG_Activity_Actions {

		public function __construct($type, $single_object_name){
			parent::__construct($type, $single_object_name);
			add_action('kg_update_field_obj', array(&$this, 'add'), $type, 1);
		}

		public function add($field){
			return KG_Add_Activity(array(
				'type' => $this->type,
				'user_id' => $field->get_user_id(),
				'action_id' => null,
				'meta' => array(
					'label' => $field->get_label(),
					'value' => $field->get_value() 
				)
			));
		}
		
	}