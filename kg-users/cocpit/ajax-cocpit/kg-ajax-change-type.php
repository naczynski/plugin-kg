<?php

	class KG_Ajax_Change_Type extends KG_Ajax {

		private $correct_types = array('coach', 'cim', 'vip', 'default');

		private function action(){

			if (empty($_POST['user_id'])){
				return $this->get_object(new WP_Error('no_type', __( 'Nie podałeś dla kogo chcesz zmienić typ.', 'kg' ) ) );
			}

			if( empty($_POST['type']) ) {
				return $this->get_object(new WP_Error('no_type', __( 'Nie przekazano popranie typu konta do zmiany.', 'kg' ) ) );
			}

			if ( !in_array($_POST['type'], $this->correct_types )) {
				return $this->get_object(new WP_Error('bad_type', __( 'Niedozwolony typ konta.', 'kg' ) ) );
			}

			$user = KG_Get::get('KG_User', (int) $_POST['user_id'] );
			
			switch( $_POST['type'] ) {
				case 'coach': $res = $user->set_coach(); break;
				case 'vip' : $res = $user->set_vip(); break;
				case 'cim' : $res = $user->set_cim(); break;
				case 'default' : $res = $user->set_default(); break;
				default : $res = new WP_Error('bad_type', __( 'Niedozwolony typ konta.', 'kg' ) );
			}

			if (is_wp_error($res)) {
				return $this->get_object($res);
			} else {		
				return $this->get_object(false, __( 'Poprawnie zmieniono typ użytkonika.', 'kg' ));
			}

		}

		public function change() {

			check_ajax_referer('change_user_type', 'security');

			echo json_encode($this->action());
			die;

		}


		public function __construct() {
			
			parent::__construct('change_type', array($this, 'change') , '', '');
	
		}
		
	}
