<?php

	/**
	 * Represent single user field
	 */
	class KG_User_Field implements JsonSerializable {

		use KG_Field_Utils;

		protected $is_required;

		private $value;

		public function __construct($name, $user_id = null) {
			$this->add_params($name, $user_id);
		}

		protected function add_params($name, $user_id = null) {
			if ($user_id) $this->user_id = $user_id;
			$this->name = $name;
			$this->get_field_params();
		}

		/* ==========================================================================
		   CONFIG
		   ========================================================================== */
		
		protected function get_field_params() {

			$config = KG_Config::getPublic($this->name);

			if ( !$config || !is_array($config) ) return;

			$this->label = !empty( $config['label'] ) ? $config['label'] : '';
			$this->is_required = !empty( $config['required'] ) ? $config['required'] : false;
			$this->reg_exp = !empty( $config['reg_exp'] ) ? $config['reg_exp'] : false;
			$this->placeholder = !empty( $config['placeholder'] ) ? $config['placeholder'] : '';
			$this->error_message = !empty( $config['error_message'] ) ? $config['error_message'] : false;

		}

		/* ==========================================================================
		   VALUE
		   ========================================================================== */


		public function validate_reg_exp($value){
			if(empty($this->reg_exp)) return $value;

			$error_message = (!empty($this->error_message)) ? $this->error_message : __( 'To pole jest niepoprawnie wypełnione.', 'kg' );

			if (!preg_match($this->reg_exp, $value)) {
				return new WP_Error('bad_reg_exp_validation', $error_message);
			}

			return $value;
		}

		/**
		 * Set value for field in db
		 * @param string $value 
		 */
		public function set_value($value) {

			if($this->is_error()) return $this->get_no_config_error();
			if( !$this->user_id ) return $this->get_no_user_error();
			

			// check if correct
			$value = $this->validate_reg_exp($value);
			if(is_wp_error($value)) {
				return $value;
			}

			if($this->get_value() == $value ){
				return true;
			}

			$this->value = sanitize_text_field($value);
			$ret = update_user_meta($this->user_id, $this->name, $this->value );
			do_action('kg_update_field_' . $this->name , $this->user_id, $this->value);
			do_action('kg_update_field' , $this->name, $this->user_id, $this->value);
			do_action('kg_update_field_obj' , $this);
			
			return (bool) $ret; 

		}

		/**
		 * Get value of vield from db
		 * @return sting 
		 */
		public function get_value() {

			if ($this->is_error()) return $this->get_no_config_error();
			if( !$this->user_id ) return ''; // if not user return blank (registration)
			if ( !empty($this->value) ) return $this->value;  
			$this->value = get_user_meta($this->user_id, $this->name, true);

			return ( $this->value ) ? $this->value : '';

		}

		public function get_placeholder() {
			if ($this->is_error()) return $this->get_no_config_error();
			return $this->placeholder;
		}

		/* ==========================================================================
		   OTHERS
		   ========================================================================== */
		
		public function is_required() {
			if ($this->is_error()) return $this->get_no_config_error();
			return $this->is_required;
		}

		public function get_user_id(){
			return $this->user_id;
		}

		/* ==========================================================================
		   JSON
		   ========================================================================== */
		
		public function jsonSerialize() {
			if ($this->is_error()) return array();
			return $this->get_array();
   		 }	

   		 public function get_array() {

   		 	$out = array(
				'name' => $this->get_name(),
				'label' => $this->get_label(),
				'value' => $this->get_value(),
				'required' => $this->is_required(),
				'placeholder' => $this->get_placeholder()
			);

			if( $this->user_id ) {
				$out['user_id'] = $this->user_id; 	
			}

			if( $this->reg_exp ) {
				$out['regExp'] = $this->reg_exp; 	
			}

			if( $this->error_message ) {
				$out['errorMessage'] = $this->error_message; 	
			}

			return $out;

   		 }
	}