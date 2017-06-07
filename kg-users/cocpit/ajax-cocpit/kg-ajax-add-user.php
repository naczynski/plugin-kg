<?php

	class KG_Ajax_Add_User extends KG_Ajax {

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

				return $this->get_object(true , 'W formularzu występują błędy', array(
					'fieldsErrors' => $fields_errors
					) 
				);

			} else {

				KG_Get::get('KG_Add_User')->add_user(
					KG_Get::get('KG_Registration_Validation')->get_properly_data()
				);	

				return $this->get_object(false, 'Poprawnie dodano użytkownika' );

			}

		}

		public function add_student() {

			check_ajax_referer( 'add_user', 'security');
			echo json_encode($this->action());
			die;

		}

		public function __construct() {

			parent::__construct('add_user_cocpit', array($this, 'add_student') , '', '');

		}

	}
