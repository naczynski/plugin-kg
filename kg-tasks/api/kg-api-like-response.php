<?php

	class KG_Api_Like_Response extends KG_Ajax {

		private function validate($response_id) {

			if(!current_user_can( 'task_get_responses')){
				return new WP_Error('no_caps', __( 'Nie posiadasz wystarczających uprawnień.', 'kg' ) );
			}

		}

		private function make($response_id) {
			$response = KG_Get::get('KG_Task_Response', (int) $response_id);
			return $response->like( get_current_user_id() );
		}

		private function action($response_id) {

			$validate = $this->validate($response_id);
			
			if(is_wp_error($validate)){
				return $this->get_object($validate);
			}
		
			$make = $this->make($response_id);

			if(is_wp_error($make)){
				return $this->get_object($make);
			}

			return $this->get_object(false, __( 'Polubiono odpowiedź', 'kg' ));

		}

		public function like($response_id) {
			echo json_encode($this->action($response_id));
			die;
		}

		public function __construct(){
       	 	add_action('slim_mapping', array(&$this, 'slim') );            
    	}

   		public function slim($slim){
	        $context = $this;
	        $slim->post(KG_Config::getPublic('api_task_like_response'), function($response_id)use($context){
	            $context->like($response_id);      
	        });
  		}
			
	}
