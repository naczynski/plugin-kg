<?php

	class KG_Ajax_Sent_Message_To_All extends KG_Ajax {

		private function validate() {

			check_ajax_referer('send_message', 'security');

			if(!current_user_can( 'sent_message_to_all')){
				return new WP_Error('no_caps', __( 'Nie posiadasz wystarczających uprawnień.', 'kg' ) );
			}

			if(empty($_POST['message'])){
				return new WP_Error('no_caps', __( 'Nie podałeś treści wiadomości.', 'kg' ) );
			}
			return true;
		}

		private function get_query_params() {
			return array(
				'user_type' => !empty($_POST['user_type']) ? $_POST['user_type'] : array() 
			);
		}

		private function get_loop_options() {
			return array(
				'pagination' => false,
				'only_enable' => !empty($_POST['only_enable']) ? (bool) $_POST['only_enable'] : false,
				'only_enable_networking' => !empty($_POST['only_enable_networking']) ? (bool) $_POST['only_enable_networking'] : false,
				'only_email' => !empty($_POST['only_email']) ? (bool) $_POST['only_email'] : false,
			);
		}

		private function make() {

			$user_loop = KG_Get::get('KG_User_Loop', $this->get_query_params(), $this->get_loop_options());
			$users = $user_loop->get();

			foreach ($users as $user) {
				$user->sent_message($_POST['message']);
			}

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

			return $this->get_object(false, __( 'Poprawnie wysłano wiadomość.', 'kg' ));

		}

		public function sent_message() {
			echo json_encode($this->action());
			die;
		}

		public function __construct() {
			parent::__construct('sent_message_to_all', array($this, 'sent_message') , '', '');
		}
			
	}
