<?php


	class KG_Api_Register extends KG_Ajax{


		private function action() {

			$validate = KG_Get::get('KG_Registration_Validation')->validate();

			if ( is_wp_error($validate) && sizeof($validate->get_error_codes()) != 0 ) {

				$fields_errors = array();

				foreach( $validate->get_error_codes() as $error_code ) {
					$fields_errors[] = array(
						'message' => $validate->get_error_message($error_code),
						'field' =>  $error_code
					);
				}
				
				return $this->get_object(true , 'W formularzu występują błędy.', array(
					'fieldsErrors' => $fields_errors
					) 
				);

			} else if(empty($_POST['agree_personal_data'])) {
				return $this->get_object(
					new WP_Error('no_agrees', __( 'Musisz zgodzić się na przetwarzanie danych osobowych.', 'kg' ) )
				);
			} else if(empty($_POST['regulamin_accepted'])){
				return $this->get_object(
					new WP_Error('no_agrees', __( 'Musisz zaakceptować regulamin naszego serwisu.', 'kg' ) )
				);
			} else {
				KG_Get::get('KG_Add_User')->add_user(
					KG_Get::get('KG_Registration_Validation')->get_properly_data()
				);	

				return $this->get_object(false, 'Poprawnie dodano użytkownika.' );
			}

		}

		public function add_student() {
			echo json_encode($this->action());
		}

		public function __construct(){
      	 	add_action('slim_mapping', array(&$this, 'slim_mapping') );            
    	}

   		public function slim_mapping($slim){
	        $context = $this;
	     
	        $slim->post('/slim/api/register',function()use($context){
	              $context->add_student();            
	        });

  	  }

		
	}
