<?php

	class KG_Task_Relation extends KG_Relation {

		use KG_Resources_Relations_Utils;

		public function __construct($user_id, $resource_id, $action_id){
			$this->user_id = $user_id;
			$this->resource_id = $resource_id;
			$this->action_id = $action_id;

		}

		public function add_to_db(){			
			return $this->add(
						KG_Config::getPublic('relation_task')['type_db'], 
						$this->user_id, 
						$this->resource_id, 
						$this->action_id
				);
		}

		public function remove(){
			return $this->remove_from_db(KG_Config::getPublic('relation_quiz')['type_db'], $this->user_id, $this->resource_id );
		}

	}