<?php

	class KG_Api_Delete_User_Settings extends KG_Ajax {

		private function is_correct_nonce() {

			return empty( $_POST['security'] ) || !wp_verify_nonce($_POST['security'], KG_Config::getPublic('remove_settings_nonce')) ;

		}

		private function validate() {

			// referer
			
			if( $this->is_correct_nonce()){
				return new WP_Error('bad_nonce', __( 'Błąd bezpieczeństwa. Próba zmiany poza stroną.', 'kg' ) );
			}

			// caps
			if( !user_can(get_current_user_id(), 'deactive_own_account') ) {
				return new WP_Error('no_cap', __( 'Nie posiadasz wystarczających uprawnień aby zmienić swoje hasło.', 'kg' ) );
			}

		}

		public function deactive_account() {

			echo json_encode($this->action());

			wp_logout();

		}

		public function action() {
			
			$validate = $this->validate();

			if (is_wp_error($validate)) {
				return $this->get_object($validate);
			} 
			
			$result = KG_get_curr_user()->set_not_active(false);			

			return ( is_wp_error($result) ) ? 
				$this->get_object($result) :
				$this->get_object(false, __( 'ź', 'kg' ));

		}

		public function __construct(){

       	 	add_action('slim_mapping', array(&$this, 'slim_mapping') );            
    	
    	}

   		public function slim_mapping($slim){
	        
	        $context = $this;
	     
	        $slim->post( KG_Config::getPublic('api_delete_account_settings') ,function()use($context){
	             $context->deactive_account();                 			
	        });

  		}

	}
	