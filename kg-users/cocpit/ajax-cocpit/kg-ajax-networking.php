<?php

	class KG_Ajax_Networking extends KG_Ajax {


		private function action_enable() {

			if(empty($_POST['user_id']) ) {
				return $this->get_object(new WP_Error('bad_fields', __( 'Nie przekazano popranie wszystkich danych', 'kg' ) ) );
			}

			$user = KG_Get::get('KG_User', (int) $_POST['user_id'] );

			$res = $user->set_can_networking();

			if (is_wp_error($res)) {
				return $this->get_object($res);
			} else {		
				return $this->get_object(false, __( 'Przyznano prawo do networkingu dla użytkownika', 'kg' ));
			}

		}

		private function action_disable(){

			if(empty($_POST['user_id']) ) {
				return $this->get_object(new WP_Error('bad_fields', __( 'Nie przekazano popranie wszystkich danych', 'kg' ) ) );
			}

			$user = KG_Get::get('KG_User', (int) $_POST['user_id'] );
			
			$res = $user->set_not_can_networkig();

			if (is_wp_error($res)) {
				return $this->get_object($res);
			} else {		
				return $this->get_object(false, __( 'Odebrano prawo do networkingu', 'kg' ));
			}

		}

		public function enable() {

			check_ajax_referer('change_networking_state', 'security');

			echo json_encode($this->action_enable());
			die;

		}

		public function disable() {

			check_ajax_referer('change_networking_state', 'security');

			echo json_encode($this->action_disable());
			die;

		}


		public function __construct() {
			
			parent::__construct('networking_enable', array($this, 'enable') , '', '');
			parent::__construct('networking_disable', array($this, 'disable') , '', '');

		}
		
	}
