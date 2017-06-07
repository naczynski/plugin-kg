<?php

	class KG_Ajax_Sent_Message_Group extends KG_Ajax {

		private function validate() {

			check_ajax_referer('send_message', 'security');

			if(!current_user_can( 'sent_message_group')){
				return new WP_Error('no_caps', __( 'Nie posiadasz wystarczających uprawnień.', 'kg' ) );
			}

			if(empty($_POST['post_ID'])){
				return new WP_Error('no_caps', __( 'Nie podałeś numeru grupy.', 'kg' ) );
			}

			if(empty($_POST['message'])){
				return new WP_Error('no_caps', __( 'Nie podałeś treści wiadomości.', 'kg' ) );
			}
			return true;
		}

		private function make() {
			
			return KG_Get::get('KG_Single_Users_Group', (int) $_POST['post_ID'] )->sent_message( $_POST['message'] );
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
			parent::__construct('sent_message_group', array($this, 'sent_message') , '', '');
		}
			
	}
