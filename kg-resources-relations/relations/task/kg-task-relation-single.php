<?php

	class KG_Task_Relation_Single extends KG_Single_Relation {

		public function __construct($data) {
			parent::__construct($data);
		}

		public function get_type(){
			return KG_Config::getPublic('relation_task')['type_name'];
		}
		
	}
	