<?php

	class KG_Api_Change_Password_Settings extends KG_Ajax {

		private function is_correct_nonce() {

			return empty( $_POST['security'] ) || !wp_verify_nonce($_POST['security'], KG_Config::getPublic('change_password_settings_nonce')) ;

		}

		private function validate() {

			// referer
			
			if( $this->is_correct_nonce()){
				return new WP_Error('bad_nonce', __( 'Błąd bezpieczeństwa. Próba zmiany poza stroną.', 'kg' ) );
			}

			// caps
			if( !user_can(get_current_user_id(), 'change_own_password') ) {
				return new WP_Error('no_cap', __( 'Nie posiadasz wystarczających uprawnień aby zmienić swoje hasło.', 'kg' ) );
			}

			// current password

			if( empty( $_POST[KG_Config::getPublic('name_current_password')] ) ) {	
				return new WP_Error('no_current_password', __( 'Musisz podać swoje aktualne hasło.', 'kg' ) );
			}

			// new password

			if( empty( $_POST[KG_Config::getPublic('name_new_password_01')] ) ) {	
				return new WP_Error('no_new_password', __( 'Nie wpisałeś nowego swojego nowego hasła.', 'kg' ) );
			}

			// repeat password

			if( empty( $_POST[KG_Config::getPublic('name_new_password_02')] ) ) {	
				return new WP_Error('no_new_password_repeat', __( 'Nie powtórzyłeś swojego nowego hasła.', 'kg' ) );
			}

			// not the same passwords

			$pass1 = $_POST[KG_Config::getPublic('name_new_password_01')];
			$pass2 = $_POST[KG_Config::getPublic('name_new_password_02')];

			if( $pass1 != $pass2 ) {	
				return new WP_Error('no_the_same_passwords', __( 'Wprowadzone hasła się różnią.', 'kg' ) );
			}

		}

		public function reset_password_settings() {

			echo json_encode($this->action());

			wp_logout();

		}

		public function action() {
			
			$validate = $this->validate();

			if (is_wp_error($validate)) {
				return $this->get_object($validate);
			} 

			$result = KG_Get::get('KG_User_Password')->set_new_password_from_settings_page(
				get_current_user_id(),
				$_POST[KG_Config::getPublic('name_current_password')],
				$_POST[KG_Config::getPublic('name_new_password_01')]
			);

			return ( is_wp_error($result) ) ? 
				$this->get_object($result) :
				$this->get_object(false, __( 'Poprawnie zmieniłeś swoje hasło.', 'kg' ));

		}

		public function __construct(){

       	 	add_action('slim_mapping', array(&$this, 'slim_mapping') );            
    	
    	}

   		public function slim_mapping($slim){
	        
	        $context = $this;
	     
	        $slim->post( KG_Config::getPublic('api_change_password_settings') ,function()use($context){
	             $context->reset_password_settings();                 			
	        });

  		}

	}
	