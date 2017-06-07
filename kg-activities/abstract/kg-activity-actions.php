<?php

	abstract class KG_Activity_Actions {

		protected $type;
		protected $alert_single_name_obj;

		public function filter_to_factory($data){
			if( is_object($data) || ((int) $data['type'] != $this->type) ) {
				return $data;
			}			
			return KG_Get::get($this->alert_single_name_obj, $data);
		}

		public function __construct($type, $alert_single_name_obj) {

			$this->type = $type;
			$this->alert_single_name_obj = $alert_single_name_obj;

			add_filter('kg_get_activity_object', array(&$this, 'filter_to_factory') , $this->type, 1);
		}

	}
