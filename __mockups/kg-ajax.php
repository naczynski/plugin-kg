<?php

	class KG_Ajax_NAME extends KG_Ajax {

		private function validate() {

			if(!wp_verify_nonce($_POST['security'])){
				return new WP_Error('bad_form', __( 'Będna ściężka dostępu.', 'kg' ));
			}

			if(!current_user_can( 'CAP_NAME')){
				return new WP_Error('bad_fields', __( 'Nie posiadasz wystarczających uprawnień.', 'kg' ) );
			}

		}

		private function make() {

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

			return $this->get_object(false, __( 'MESSAGE_ON_TRUE', 'kg' ));

		}

		public function ACTION_NAME() {
			echo json_encode($this->action());
			die;
		}

		public function __construct() {
			parent::__construct('ACTION', array($this, 'ACTION_NAME') , '', '');
		}
			
	}
