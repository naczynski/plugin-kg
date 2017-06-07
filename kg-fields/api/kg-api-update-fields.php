<?php

	class KG_Api_Update_Fields extends KG_Ajax {

		private $errors;
		private $fields_errors;
		private $fields_correct;

		private $exlude = array(
				'security', 
				'user_id', 
				'action', 
				'_wp_http_referer',
				'type',
			);

		private function validate() {

			if(!wp_verify_nonce('security', 'change_fields')){
				$res = new WP_Error('bad_form', __( 'Będna ściężka dostępu.', 'kg' ));
			}

			if(!current_user_can( 'update_fields')){
				return new WP_Error('no_caps', __( 'Nie posiadasz wystarczających uprawnień.', 'kg' ) );
			}

		}

		private function validate_fields() {

			foreach ($_POST as $key => $value) {
			
				if(in_array($key, $this->exlude)) continue;

				$field = new KG_User_Field($key, get_current_user_id());
				$reg_exp_validation = $field->validate_reg_exp($value);

				if ($field->is_required() && $value==''){
					$this->fields_errors[$key] = true;
				} else if($value!='' && is_wp_error($reg_exp_validation)) {
					$this->fields_errors[$key] = true;
				} else {
					$this->fields_correct[$key] = $value;
					$field->set_value($value);
				}

			}
			
		}

		private function action() {

			$this->errors = new WP_Error();

			$validate = $this->validate();
			
			if(is_wp_error($validate)){
				return $this->get_object($validate);
			}
		
			$make = $this->validate_fields();

			if(!empty($this->fields_errors)) {
				return $this->get_object(true , 'W formularzu występują błędy.', array(
					'fieldsErrors' => $this->fields_errors
					) 
				);
			} else {
				return $this->get_object(false, __( 'Dane zostały zaktualizowane.', 'kg' ), array(
					'fieldsCorrect' => $this->fields_correct
					) 
				);
			}

		}

		public function change_fields() {
			echo json_encode($this->action());
			die;
		}

		public function __construct(){
       	 	add_action('slim_mapping', array(&$this, 'slim') );            
    	}

   		public function slim($slim){
	        $context = $this;
	        $slim->post(KG_Config::getPublic('api_update_fields'), function()use($context){
	            $context->change_fields();      
	        });
  		}
			
	}
