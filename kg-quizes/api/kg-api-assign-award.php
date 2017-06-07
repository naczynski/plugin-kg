<?php

	class KG_Api_Assign_Award extends KG_Ajax {

		private function validate() {

			if(!current_user_can( 'choose_award_quiz')){
				return new WP_Error('no_caps', __( 'Nie posiadasz wystarczających uprawnień.', 'kg' ) );
			}

			if(empty($_POST['quiz_id'])){
				return new WP_Error('no_quiz_id', __( 'Nie podałeś numeru quizu.', 'kg' ) );
			}

			if(empty($_POST['resource_id'])){
				return new WP_Error('no_resource_id', __( 'Nie podałeś zasobu.', 'kg' ) );
			}

		}

		private function make() {
			$kg_quiz = KG_Get::get('KG_Quiz_Item', (int) $_POST['quiz_id']);
			return $kg_quiz->get_quiz_solve_obj(get_current_user_id())->add_award( (int) $_POST['resource_id']);	
		}

		private function action() {

			$validate = $this->validate();
			
			if(is_wp_error($validate)){
				return $this->get_object($validate);
			}
		
			$make = $this->make();

			if(is_wp_error($make)){
				return $this->get_object($make);
			} else {
				do_action('add_award', (int) $_POST['quiz_id'], (int) $_POST['resource_id'], get_current_user_id());
			}

			return $this->get_object(false, __( 'Poprawnie wybrano nagrodę. Przejdź do strony "Moje zasoby" aby ją pobrać.', 'kg' ), array(
				'quiz' => KG_Get::get('KG_Quiz_Item', (int) $_POST['quiz_id'])->get_serialized_fields_for(get_current_user_id())
			));

		}

		public function choose() {
			echo json_encode($this->action());
			die;
		}

		public function __construct(){
       	 	add_action('slim_mapping', array(&$this, 'slim') );            
    	}

   		public function slim($slim){
	        $context = $this;
	        $slim->post(KG_Config::getPublic('api_quiz_choose_award'), function()use($context){
	            $context->choose();      
	        });
  		}
			
	}
