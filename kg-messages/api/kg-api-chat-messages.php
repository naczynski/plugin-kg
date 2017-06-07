<?php

	class KG_Api_Chat_Messages extends KG_Ajax {

		private function validate() {

			if(!current_user_can( 'get_messages')){
				return new WP_Error('no_caps', __( 'Nie posiadasz wystarczających uprawnień.', 'kg' ) );
			}

			if(empty($_POST['second_user_id'])){
				return new WP_Error('no_user_id', __( 'Nie podałeś drugiego użytkownika.', 'kg' ) );
			}

		}

		private function get_message() {
			return KG_Get::get('KG_Loop_Messages')->get_chat( (int) $_POST['second_user_id']);
		}

		private function action() {

			$validate = $this->validate();
			
			if(is_wp_error($validate)){
				return $this->get_object($validate);
			}
		
			$messages = $this->get_message();

			if(is_wp_error($messages)){
				return $this->get_object($messages);
			}

			return $this->get_object(false, __( 'Poprawnie pobrano rozmowę', 'kg' ), array(
				'messages' => $messages 
			));

		}

		public function get_messages() {
			echo json_encode($this->action());
			die;
		}

		public function __construct(){
       	 	add_action('slim_mapping', array(&$this, 'slim') );            
    	}

   		public function slim($slim){
	        $context = $this;
	        $slim->post(KG_Config::getPublic('api_sent_chat_messages'), function()use($context){
	            $context->get_messages();      
	        });
  		}
			
	}
