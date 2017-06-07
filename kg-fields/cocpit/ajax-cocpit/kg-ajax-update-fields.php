<?php

	class KG_Ajax_Update_Fields extends KG_Ajax {

		private $user_id;

		private $error;

		private $exlude = array('security', 'user_id', 'action', 'email', '_wp_http_referer');

		private function update_email() {

			$user= KG_Get::get('KG_User', $this->user_id);

			if( empty($_POST['email']) ) {
				$this->error->add('no_email', __( 'Nie wpisałeś adresu email', 'kg' ));
				return;
			}

			if( !is_email($_POST['email']) ) {
				$this->error->add('no_email', __( 'Wpisałeś niepoprawny adres email', 'kg' ));
				return;
			}

			$res = $user->change_email( sanitize_email($_POST['email']) );

			if (is_wp_error($res)) {
				return $this->error->add($res->get_error_code, $res->get_error_message($res->get_error_code));
			} 

		}

		private function update_fields() {

			foreach ($_POST as $key => $value) {
			
				if(in_array($key, $this->exlude)) continue;

				$field = new KG_User_Field($key, $this->user_id);
				$reg_exp_validation = $field->validate_reg_exp($value);

				if ($field->is_required() && $value==''){
					$this->error->add('field_required', __( 'Wypełnij wszystkie wymagane pola.', 'kg' ));
				} else if($value=='') {
					
				} else if(is_wp_error($reg_exp_validation)) {
					$this->error->add($key, $reg_exp_validation->get_error_message() );
				} else {
					$ret = $field->set_value( sanitize_text_field( $value ) );
					
				}

			}

		}

		private function action() {

			if(empty($_POST['user_id'])) return $this->get_object(true, __( 'Nie przekazano id użytkownika.', 'kg' ));

			$this->user_id = $_POST['user_id'];
			$this->error = new WP_Error();

			$this->update_email();
			$this->update_fields();

			if( sizeof($this->error->get_error_codes()) != 0 ){
			   return $this->get_object($this->error);
			} else {
			   return $this->get_object(true, __( 'Poprawnie zaaktualizowano użytkownika', 'kg' ));
			}

		}

		public function change_fields() {

			check_ajax_referer('change_fields_edit_page', 'security');
			echo json_encode($this->action());
			die;

		}

		public function __construct() {
			parent::__construct('change_fields', array($this, 'change_fields') , '', '');
		}
		
	}
