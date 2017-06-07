<?php

	class KG_Ajax_Remove_Response extends KG_Ajax {

		private function validate() {

			if(!current_user_can( 'remove-response')){
				return new WP_Error('no_caps', __( 'Nie posiadasz wystarczających uprawnień.', 'kg' ) );
			}

			if(empty($_POST['response_id'])){
				return new WP_Error('no_response_id', __( 'Nie podałeś numeru odpowiedzi', 'kg' ));
			}

		}

		private function make() {
			$kg_response = KG_Get::get('KG_Task_Response', (int) $_POST['response_id']);
			return $kg_response->remove();
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

			return $this->get_object(false, __( 'Poprawnie usunięto odpowiedź.', 'kg' ));

		}

		public function remove_response() {
			echo json_encode($this->action());
			die;
		}

		public function __construct() {
			parent::__construct('remove_response', array($this, 'remove_response') , '', '');
		}
			
	}
