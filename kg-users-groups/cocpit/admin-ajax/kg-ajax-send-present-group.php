<?php

	class KG_Ajax_Send_Present_Group extends KG_Ajax {


		private function action() {

			if(!current_user_can( 'send_cocpit_present')){
				return $this->get_object(new WP_Error('bad_fields', __( 'Nie posiadasz wystarczjących uprawnień.', 'kg' ) ) );
			}

			$resources_ids = !empty($_POST['ids']) ? json_decode($_POST['ids'], true) : array();

			if(empty($resources_ids[0])) {
				return $this->get_object(new WP_Error('bad_fields', __( 'Musisz wybrać jaki zasób chcesz sprezentować!', 'kg' ) ) );
			}

			if(empty($_POST['message_present'])) {
				$this->message = " ";
			} else {
				$this->message = $_POST['message_present']; 
			}
			
			KG_Get::get('KG_Single_Users_Group', (int) $_POST['post_ID'])->sent_presents($resources_ids, $this->message);
			return $this->get_object(false, __( 'Przyznano użytkownikom zasoby poprawnie.', 'kg' ));
			
		}

		public function send_present() {
			echo json_encode($this->action());
			die;
		}

		public function __construct() {
			parent::__construct('send_present_group', array($this, 'send_present') , '', '');
		}
		
	}
