<?php

	class KG_Api_Choose_Award extends KG_Ajax {

		private function validate($task_response_id) {

			if(!current_user_can( 'task_get_responses')){
				return new WP_Error('no_caps', __( 'Nie posiadasz wystarczających uprawnień.', 'kg' ) );
			}

			if(empty($_POST['resource_id'])){
				return new WP_Error('no_response', __( 'Nie wybrałeś zasobu.', 'kg' ) );
			}

		}

		private function make($task_response_id) {
			$response = KG_Get::get('KG_Task_Response', (int) $task_response_id);
			return $response->add_award( (int) $_POST['resource_id'] );
		}

		private function action($task_response_id) {

			$validate = $this->validate($task_response_id);
			
			if(is_wp_error($validate)){
				return $this->get_object($validate);
			}
		
			$make = $this->make($task_response_id);

			if(is_wp_error($make)){
				return $this->get_object($make);
			}

			return $this->get_object(false, __( 'Poprawnie wybrałeś nagrodę.', 'kg' ));

		}

		public function add_award($task_response_id) {
			echo json_encode($this->action($task_response_id));
			die;
		}

		public function __construct(){
       	 	add_action('slim_mapping', array(&$this, 'slim') );            
    	}

   		public function slim($slim){
	        $context = $this;
	        $slim->post(KG_Config::getPublic('api_task_set_award'), function($task_response_id)use($context){
	            $context->add_award($task_response_id);      
	        });
  		}

	}
