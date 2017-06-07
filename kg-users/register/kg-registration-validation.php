<?php

	/**
	 * Valdiate new user fields
	 */
	class KG_Registration_Validation extends KG_Ajax {

		private $fields = array();

		private $exlude = array(
					'security', 
					'user_id', 
					'action', 
					'_wp_http_referer',
					'type',
				);

		private $errors;

		private function validate_fields() {

			foreach ($_POST as $key => $value) {
			
				if(in_array($key, $this->exlude)) continue;

				$field = new KG_User_Field($key);
				$reg_exp_validation = $field->validate_reg_exp($value);

				if ($field->is_required() && $value==''){
					$this->errors->add($key, __( 'To pole jest wymagane.', 'kg' ) );
				} else if($value=='') {
					// not required 
				} else if(is_wp_error($reg_exp_validation)) {
					$this->errors->add($key, $reg_exp_validation->get_error_message() );
				} else {
					$this->fields[$key] = $value;
				}

			}
			
		}

		private function validate_password() {

			if( empty($_POST['signup_password']) ) {
				$this->errors->add('signup_password', __( 'Musisz wpisać swoje hasło.', 'kg' ) );
			} else if( empty($_POST['signup_password_confirm']) ) {
				$this->errors->add('signup_password_confirm', __( 'Musisz wpisać swoje hasło ponownie.', 'kg' ) );
			} else if( $_POST['signup_password'] != $_POST['signup_password_confirm'] ) {
				$this->errors->add('signup_password_confirm', __( 'Wprowadzone hasła się różnią.', 'kg' ) );
			}

		}

		private function validate_email() {

			if( empty($_POST['signup_email']) ) {
				$this->errors->add('signup_email', __( 'Nie wpisałeś swojego adresu email.', 'kg' ) );
			} else if( !is_email($_POST['signup_email']) ){
				$this->errors->add('signup_email', __( 'To nie jest poprawny adres email.', 'kg' ) );
			} else if( email_exists($_POST['signup_email']) ){
				$this->errors->add('signup_email', __( 'Przykro nam, ale ten adres e-mail jest już zajęty.', 'kg' ) );
			}

		}

		public function validate() {
			$this->validate_email();
			$this->validate_password();
			$this->validate_fields();

			return $this->errors;
		}

		public function __construct() {
			$this->errors = new WP_Error();
		}

		public function get_properly_data() {

			return array(
				'user_email' => $_POST['signup_email'],
			    'user_login'  =>  $_POST['kg_field_name'] . ' ' . $_POST['kg_field_surname'],
			    'user_pass'   =>  $_POST['signup_password'],
				'fields' => $this->fields,
				'role' => 'default'
			);
			
		}

	}