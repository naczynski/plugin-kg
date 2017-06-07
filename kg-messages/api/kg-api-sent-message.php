<?php

	class KG_Api_Sent_Message extends KG_Ajax {

		private function validate() {

			if(!current_user_can( 'sent_message')){
				return new WP_Error('no_caps', __( 'Nie posiadasz wystarczających uprawnień.', 'kg' ) );
			}

			if(empty($_POST['to_user_id'])){
				return new WP_Error('no_caps', __( 'Nie podałeś do kogo chcesz wysłać wiadomość.', 'kg' ) );
			}

			if(empty($_POST['message'])){
				return new WP_Error('no_caps', __( 'Nie wpisałeś treści wiadomości.', 'kg' ) );
			}
			return true;

		}

		private function make() {

			$message = KG_Get::get('KG_Single_Message', 
						get_current_user_id(),
						(int) $_POST['to_user_id'],
						$_POST['message']
					);

			return $message->sent();

		}

		private function action() {

			$validate = $this->validate();
			
			if(is_wp_error($validate)){
				return $this->get_object($validate);
			}
		
			$make = $this->make();

			if(is_wp_error($make)){
				return $this->get_object($make);
			}

			return $this->get_object(false, __( 'Wiadomość została wysłana.', 'kg' ));

		}

		public function sent_message() {
			echo json_encode($this->action());
			die;
		}

		public function __construct(){
       	 	add_action('slim_mapping', array(&$this, 'slim') );            
    	}

   		public function slim($slim){
	        $context = $this;
	        $slim->post(KG_Config::getPublic('api_sent_message'), function() use($context){
	            $context->sent_message();      
	        });
  		}

	}
