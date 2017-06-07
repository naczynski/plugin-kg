<?php

	class KG_Present_Relation_Getter extends KG_Resource_Relation_Getter {


		public function get($user_id){
			return $this->get_from_db(
				KG_Config::getPublic('relation_present')['type_db'],
				$user_id
			);
		}

		public function get_ids($user_id){
			return $this->get_ids_from_db(
				KG_Config::getPublic('relation_present')['type_db'],
				$user_id
			);
		}

		public function count($user_id){
			return $this->count_from_db(
				KG_Config::getPublic('relation_present')['type_db'],
				$user_id
			);
		}
	}