<?php

	class KG_Like_Relation_Single extends KG_Single_Relation {

		public function __construct($data) {
			parent::__construct($data);
		}

		public function get_type(){
			return KG_Config::getPublic('relation_like')['type_name'];
		}
		
	}
