<?php

	class KG_Ajax_Remove_Relation extends KG_Ajax {

		private function validate() {

			// if(!wp_verify_nonce('security', 'remove_relation')){
			// 	return new WP_Error('bad_form', __( 'Będna ściężka dostępu.', 'kg' ));
			// }

			if(!current_user_can( 'remove_relation')){
				return new WP_Error('bad_fields', __( 'Nie posiadasz wystarczających uprawnień.', 'kg' ) );
			}

			if(empty($_POST['relation_id'])){
				return new WP_Error('no_relation_id', __( 'Nie wpisałeś di relacji.', 'kg' ) );
			}

		}

		private function make() {
			return KG_remove_relation( (int) $_POST['relation_id'] ); 
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

			return $this->get_object(false, __( 'Poprawnie usunięto zależność', 'kg' ));

		}

		public function remove_relation() {
			echo json_encode($this->action());
			die;
		}

		public function __construct() {
			parent::__construct('remove_relation', array($this, 'remove_relation') , '', '');
		}
			
	}
