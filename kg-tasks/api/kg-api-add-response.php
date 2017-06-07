<?php

	class KG_Api_Add_Response extends KG_Ajax {

		private function validate() {

			if(!current_user_can( 'task_get_responses')){
				return new WP_Error('no_caps', __( 'Nie posiadasz wystarczających uprawnień.', 'kg' ) );
			}

			if(empty($_POST['response'])){
				return new WP_Error('no_response', __( 'Nie wpisałeś swojej odpowiedzi.', 'kg' ) );
			}

			if(empty($_POST['task_id'])){
				return new WP_Error('no_task_id', __( 'Nie podałeś swojego numeru zadania.', 'kg' ) );
			}

		}

		private function make() {
			$task_obj = KG_Get::get('KG_Task_Item', (int) $_POST['task_id']);
			return $task_obj->add_response( $_POST['response'], get_current_user_id() );
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

			return $this->get_object(false, __( 'Dodano odpowiedź.', 'kg' ), array(
				'page' => KG_Get::get('KG_Loop_Tasks_Responses', (int) $_POST['task_id'])->get_page_numbers()
			));

		}

		public function add() {
			echo json_encode($this->action());
			die;
		}

		public function __construct(){
       	 	add_action('slim_mapping', array(&$this, 'slim') );           
    	}

   		public function slim($slim){
	        $context = $this;
	        $slim->post(KG_Config::getPublic('api_task_add_response'), function()use($context){
	            $context->add();      
	        });
  		}
			
	}
