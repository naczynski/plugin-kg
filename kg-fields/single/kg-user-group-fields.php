<?php

	/**
	 * Represent single user group of fields
	 */
	class KG_User_Group_Fields implements JsonSerializable {

    	use KG_Field_Utils;

		private $on_register_page;
		private $field_names = array();

		private $fields_obj = array();

		public function __construct($name, $user_id = null, $register = false) {			
			$this->add_params($name, $user_id);
		}
		
		protected function add_params($name, $user_id = null) {
			if ($user_id) $this->user_id = $user_id;
			$this->name = $name;
			$this->get_group_params();
		}

		/* ==========================================================================
		   CONFIG
		   ========================================================================== */
		
		protected function get_group_params() {
			$config = KG_Config::getPublic($this->name);

			if ( !$config || !is_array($config) ) return;
			$this->label = !empty( $config['label'] ) ? $config['label'] : '';
			$this->on_register_page = !empty( $config['on_register_page'] ) ? $config['on_register_page'] : false;
			$this->in_cocpit = !empty( $config['in_cocpit'] ) ? $config['in_cocpit'] : false;
			$this->on_my_profile_page = !empty( $config['on_my_profile_page'] ) ? $config['on_my_profile_page'] : false;
			$this->field_names = !empty( $config['fields'] ) ? $config['fields'] : array();
		}

		/* ==========================================================================
		   WHERE SHOW
		   ========================================================================== */
		
		public function is_on_register_page() {
			if ($this->is_error()) return $this->get_no_config_error();
			return $this->on_register_page;
		}


		public function is_in_cocpit() {
			if ($this->is_error()) return $this->get_no_config_error();
			return $this->in_cocpit;
		}


		public function is_on_my_profile_page() {
			if ($this->is_error()) return $this->get_no_config_error();
			return $this->on_my_profile_page;
		}

		/* ==========================================================================
		   FIELDS
		   ========================================================================== */
		
		public function get_fields() {
			if ( !empty($this->fields_obj) ) return $this->fields_obj;
			foreach ($this->field_names as $name) {	
				 $this->fields_obj[] = KG_Get::get('KG_User_Field', $name, $this->user_id);
			}
			return $this->fields_obj;

		}

		/* ==========================================================================
	       JSON
	       ========================================================================== */
		
		public function jsonSerialize() {
        	
			if ($this->is_error()) return array();

			//get group json

        	$out = array(
				'name' => $this->get_name(),
				'label' => $this->get_label(),
				'is_on_register_page' => $this->is_on_register_page(),
				'fields' => array()
			);

			if( $this->user_id ) {
				$out['user_id'] = $this->user_id; 	
			}

			// get fields jsons
			$out['fields']= $this->get_fields();

			return $out;
   		 }	

	}