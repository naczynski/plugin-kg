<?php

	class KG_Api_Login extends KG_Ajax {


		private function get_field_error_object($field_name, $message) {
			$out = array();
			$out[] = array(
				'field' => $field_name,
				'message' => $message
			);

			return $out;
		}


		public function validate_fields() {
			if(empty($_POST['username'])) {
				echo json_encode( $this->get_object(true, __('Wprowadź wymagane dane.', 'kg'), array(

					'fieldsErrors' => $this->get_field_error_object('username', __('Nie ma w systemie użytkownika z takim adresem email.', 'kg')))
				));
				return false;
			}

			if(empty($_POST['password'])) {
				echo json_encode( $this->get_object(true, __('Wprowadź wymagane dane.', 'kg'), array(
					'fieldsErrors' => $this->get_field_error_object('user_password', __('Podaj hasło do swojego konta.', 'kg')))
				));
				return false;
			}

			return true;
		}


		private function logged_in() {
			$info = array();
		    $info['user_login'] = $_POST['username'];
		    $info['user_password'] = $_POST['password'];
		    $info['remember'] = true;

		    $user_signon = wp_signon( $info, false );

		    if ( is_wp_error($user_signon) ){
		    	switch($user_signon->get_error_code()) {
		    		case 'incorrect_password' :  echo json_encode( $this->get_object(true, __( 'Nie pamiętasz hasła? Odzyskaj je, wybierając poniższą opcję.', 'kg') )); break; 
		    		case 'invalid_username' : echo json_encode( $this->get_object(true, __( 'Nie ma na portalu takiego uzytkownika.', 'kg')) ); break;
		    		default: echo json_encode( $this->get_object(true, $user_signon->get_error_message()) );
		    	}
		    } 

		    else {
		        echo json_encode($this->get_object(false, __('Logowanie powiodło się.', 'kg')));
		    }

		}


		public function login() {

			$obj = array();

			if( !check_ajax_referer( 'ajax-login-nonce', 'security' ) ) {
				echo json_encode($this->get_object(true, __('Logowanie z niedozwolonego miejsca.', 'kg')));
				return;
			}

			if(	$this->validate_fields() ) {
				$this->logged_in();
			}

		    die;
			
		}

		public function __construct(){
       	 	add_action('slim_mapping', array(&$this, 'slim_mapping') );            
    	}

   		public function slim_mapping($slim){
	        $context = $this;     
	        $slim->post('/slim/api/login',function()use($context){
	              $context->login();            
	        });
  		}

	}
