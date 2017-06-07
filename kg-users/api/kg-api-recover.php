<?php

	class KG_Api_Recover extends KG_Ajax {

		private $user_email;
		private $new_password;
		private $user_id; 

		private $kg_user;

		private function validate_email($email) {

			//is correct email
			
			if( !is_email( $email ))  {
				return new WP_Error('invalid_email', __( 'To nie jest poprawny adres email.', 'kg' ) );
			}

			// is user in this email
			
			if ( !email_exists( $email) ) {
				return new WP_Error( 'no_user', __( 'Przykro nam ale nie ma użytkownika z takim adresem email.', 'kg' ) );
			} else {
				$this->kg_user = KG_Get::get('KG_User', get_user_by('email', $email) );
				
				if( !$this->kg_user->is_active() ){
					return new WP_Error('account_not_active', __( 'Twoje konto nie jest aktywne. Skontaktuj się z&nbsp;<a href="mailto:' .  KG_Config::getPublic('admin_email')[0] .'">  '. KG_Config::getPublic('admin_email')[0] .'</a>.', 'kg' ) );
				}

				if($this->kg_user->is_questus() || $this->kg_user->is_koda()){
					return new WP_Error('not_user', __( 'Przykro nam ale nie ma użytkownika z takim adresem email.', 'kg' ) );
	
				}

			}

			return $email;

		}
	
		private function validate() {

			if( !check_ajax_referer('kg-recover-password', 'security') ) {
				return new WP_Error( 'security', __( 'Błąd zabezpieczeń- skorzystaj z formularza aby odsyskać hasło.', 'kg' ));	
			}

			if ( empty($_POST['user_email']) ) {
				return new WP_Error('no_email', __( 'Musisz podać adres email przypisany do Twojego konta.', 'kg' ) );
			}

			return $this->validate_email( $_POST['user_email'] );

		}
		
		/**
		 * Reset password callback
		 * @return 
		 */
		public function reset_password($email = null) {

			$validate = $this->validate();

			if ( is_wp_error($validate ) ) {
				echo json_encode( $this->get_object(true, $validate->get_error_message()) );
				return;
			}

			// recover

			$result = KG_get::get('KG_User_Password')->generate_new_password_and_asssign_to_user(
				$this->kg_user->get_ID()
			);

			//send emai;

			if ( is_wp_error($result) ) {
				echo json_encode( $this->get_object($result) );
			} else {
				echo json_encode( $this->get_object(false, __( 'Hasło zostało zresetowane.', 'kg' ) ) );
			}

		}

		public function __construct(){
       	 	add_action('slim_mapping', array(&$this, 'slim_mapping') );            
    	}

   		public function slim_mapping($slim){
	        $context = $this;
	     
	        $slim->post('/slim/api/recover',function()use($context){     
	              $context->reset_password();            
	        });

  		}

	}
	