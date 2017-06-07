<?php

	class KG_Api_Leave_Task extends KG_Ajax {

		private function validate() {

			if(!current_user_can( 'task_get_responses')){
				return new WP_Error('no_caps', __( 'Nie posiadasz wystarczających uprawnień.', 'kg' ) );
			}

		}

		private function make($task_id) {
			return KG_Get::get('KG_Task_Item', $task_id)->leave( get_current_user_id() );
		}

		private function action($task_id) {

			$validate = $this->validate();
			
			if(is_wp_error($validate)){
				return $this->get_object($validate);
			}
		
			$make = $this->make($task_id);

			if(is_wp_error($make)){
				return $this->get_object($make);
			}

			return $this->get_object(false, __( 'Wypisałeś się z zadania', 'kg' ));

		}

		public function leave($task_id) {
			echo json_encode($this->action($task_id));
			die;
		}

		public function __construct(){
       	 	add_action('slim_mapping', array(&$this, 'slim') );            
    	}

   		public function slim($slim){
	        $context = $this;
	        $slim->post(KG_Config::getPublic('api_task_leave_task'), function($task_id )use($context){
	            $context->leave($task_id);      
	        });
  		}
			
	}
