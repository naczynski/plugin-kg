<?php

	class KG_Api_Check_Quiz extends KG_Ajax {

		private function validate() {

			if(!current_user_can( 'check_quiz')){
				return new WP_Error('no_caps', __( 'Nie posiadasz wystarczających uprawnień.', 'kg' ) );
			}

			if(empty($_POST['quiz_id'])){
				return new WP_Error('no_quiz_id', __( 'Nie podałeś jaki quiz chcesz sprawdzić.', 'kg' ) );
			}

			if(empty($_POST['user_answers'])){
				return new WP_Error('no_answers', __( 'Nie przekazałeś odpowiedzi użytkownika.', 'kg' ) );
			}

			if(empty($_POST['date_start'])){
				return new WP_Error('no_date_start', __( 'Nie przekazałeś czasu rozpoczęcia quizu.', 'kg' ) );
			}

		}

		private function make() {
			$factory = KG_Get::get('KG_Quiz_Result_Factory', 
					(int) $_POST['quiz_id'],
					get_current_user_id(),
					(array) $_POST['user_answers'],
					$_POST['date_start']
				);
			return $factory->check_and_add_to_db();
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

			return $this->get_object(false, __( 'Sprawdziliśmy twoje odpowiedzi.', 'kg' ), array(
				'quiz' => KG_Get::get('KG_Quiz_Item', (int) $_POST['quiz_id'])->get_serialized_fields_for(get_current_user_id())
			));

		}

		public function check() {
			echo json_encode($this->action());
			die;
		}

		public function __construct(){
       	 	add_action('slim_mapping', array(&$this, 'slim') );            
    	}

   		public function slim($slim){
	        $context = $this;
	        $slim->post(KG_Config::getPublic('api_quiz_check'), function()use($context){
	            $context->check();      
	        });
  		}
			
	}
