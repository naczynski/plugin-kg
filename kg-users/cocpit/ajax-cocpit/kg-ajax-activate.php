<?php

	class KG_Ajax_Activate extends KG_Ajax {

			private function action_enable() {

			if(empty($_POST['user_id']) ) {
				return $this->get_object(new WP_Error('bad_fields', __( 'Nie przekazano popranie wszystkich danych', 'kg' ) ) );
			}

			$user = KG_Get::get('KG_User', (int) $_POST['user_id'] );

			$res = $user->set_active();

			if (is_wp_error($res)) {
				return $this->get_object($res);
			} else {		
				return $this->get_object(false, __( 'Odblokowano pomyślnie użytkownika', 'kg' ));
			}

		}

		private function action_disable(){

			if(empty($_POST['user_id']) ) {
				return $this->get_object(new WP_Error('bad_fields', __( 'Nie przekazano popranie wszystkich danych', 'kg' ) ) );
			}

			$user = KG_Get::get('KG_User', (int) $_POST['user_id'] );
			
			$res = $user->set_not_active(true);

			if (is_wp_error($res)) {
				return $this->get_object($res);
			} else {		
				return $this->get_object(false, __( 'Zablokowano użytkownika', 'kg' ));
			}

		}

		public function enable() {

			check_ajax_referer('change_active', 'security');

			echo json_encode($this->action_enable());
			die;

		}

		public function disable() {

			check_ajax_referer('change_active', 'security');

			echo json_encode($this->action_disable());
			die;

		}

		public function __construct() {
			
			parent::__construct('account_enable', array($this, 'enable') , '', '');
			parent::__construct('account_disable', array($this, 'disable') , '', '');

		}
		
	}
