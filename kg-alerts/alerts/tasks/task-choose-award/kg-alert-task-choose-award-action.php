<?php

	class KG_Alert_Task_Choose_Award_Action extends KG_Alert_Actions {

		public function __construct($type, $single_object_name){
			parent::__construct($type, $single_object_name);
			add_action('kg_can_choose_award_for_response', array(&$this, 'add'), $type, 1);
			add_action('kg_remove_task_response', array(&$this, 'remove_when_current_action'), 1, 1);
		}

		public function add($task_response_id){
			return KG_Add_Alert(array(
				'type' => $this->type,
				'user_id' => $task_response_id->get_user_id(),
				'action_id' => $task_response_id->get_ID()
			));
		}

		public function remove_when_current_action($action_id){
			global $wpdb;
			$result = $wpdb->delete( 
				KG_Config::getPublic('table_alerts'), 
				array( 
					'action_id' => $action_id,
					'type' => $this->type
				), 
				array( '%d' ) 
			);
			return $result;
		}

	}