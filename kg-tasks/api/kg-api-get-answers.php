<?php

	class KG_Api_Get_Answers extends KG_Ajax {

		private function validate($task_id, $page_id) {
			if(!current_user_can( 'task_get_responses')){
				return new WP_Error('no_caps', __( 'Nie posiadasz wystarczających uprawnień.', 'kg' ) );
			}

			if(empty($task_id)){
				return new WP_Error('no_task_id', __( 'Nie podałeś numeru zadania.', 'kg' ));
			}

			if(empty($page_id)){
				return new WP_Error('no_page_number', __( 'Nie podałeś numeru strony.', 'kg' ));
			}
		}

		private function make($task_id, $page_id) {
			return KG_get_data_for_single_task_without_task_data((int) $task_id, (int) $page_id);
		}

		private function action($task_id, $page_id) {
			$validate = $this->validate($task_id, $page_id);
			
			if(is_wp_error($validate)){
				return $this->get_object($validate);
			}
		
			$make = $this->make($task_id, $page_id);

			if(is_wp_error($make)){
				return $this->get_object($make);
			}

			return $this->get_object(false, __( 'Poprawnie pobrano odpowiedzi', 'kg' ), $make);		
		}

		public function get($task_id, $page_id) {
			echo json_encode($this->action($task_id, $page_id));
			die;
		}

		public function __construct(){
       	 	add_action('slim_mapping', array(&$this, 'slim') );            
    	}

   		public function slim($slim){
	        $context = $this;
	        $slim->get(KG_Config::getPublic('api_task_get_responses'), function($task, $page)use($context){
	            $context->get($task, $page);      
	        });
  		}
			
	}
