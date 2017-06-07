<?php

	class KG_Ajax_Email_Activation extends KG_Ajax {

		private function action_activate() {

			if(empty($_POST['user_id']) ) {
				return $this->get_object(new WP_Error('bad_fields', __( 'Nie przekazano popranie wszystkich danych', 'kg' ) ) );
			}

			$user = KG_Get::get('KG_User', (int) $_POST['user_id'] );

			$res = $user->activate_email();

			if (is_wp_error($res)) {
				return $this->get_object($res);
			} else {		
				return $this->get_object(false, __( 'Zaakceptowano adres email użytkonika. Może się już teraz zalogować.', 'kg' ));
			}

		}

		private function action_send_email_activation(){

			if(empty($_POST['user_id']) ) {
				return $this->get_object(new WP_Error('bad_fields', __( 'Nie przekazano popranie wszystkich danych', 'kg' ) ) );
			}

			$user = KG_Get::get('KG_User', (int) $_POST['user_id'] );
			
			$res = $user->send_activation_email();

			if (is_wp_error($res)) {
				return $this->get_object($res);
			} else {		
				return $this->get_object(false, __( 'Wysłano ponownie wiadomość aktywacyjną do użytkownika', 'kg' ));
			}

		}

		public function activate() {

			check_ajax_referer('activate_email', 'security');

			echo json_encode($this->action_activate());
			die;

		}


		public function send_email_activation() {

			check_ajax_referer('send_email_activation', 'security');

			echo json_encode($this->action_send_email_activation());
			die;

		}

		public function __construct() {
			
			parent::__construct('email_activate', array($this, 'activate') , '', '');
			parent::__construct('send_email_activation', array($this, 'send_email_activation') , '', '');

		}

	}
