<?php

	class KG_Multi_Relation_Getter extends KG_Resource_Relation_Getter {

		private $types;

		public function __construct($types){
			$this->types = $types;
		}

		public function get($user_id){
			return $this->get_from_db(
					$this->get_types_id_from_names($this->types),
					$user_id
				);
		}

		public function get_ids($user_id){
			return $this->get_ids_from_db(
					$this->get_types_id_from_names($this->types),
					$user_id
				);
		}

		public function count($user_id){
			return $this->count_from_db(
					$this->get_types_id_from_names($this->types),
					$user_id
				);
		}
			
	}