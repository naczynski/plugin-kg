<?php

	abstract class KG_Single_Relation {

		protected $relation_id;		
		protected $user_id;
		protected $resource_id;
		protected $date;

		public function __construct($data){
			$this->relation_id = $data['relation_id'];
			$this->resource_id = $data['resource_id'];
			$this->user_id = $data['user_id'];
			$this->date = $data['date'];
		}

		public function get_ID(){
			return $this->relation_id;
		}

		public function get_date(){
			return $this->date;
		}

		public function get_relation_id(){
			return $this->relation_id;
		}

		public function get_resource() {
			return KG_get_resource_object($this->resource_id);
		}

		public function get_user(){
			return KG_Get::get('KG_User', $this->user_id);
		}

		abstract function get_type();

	}