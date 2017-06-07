<?php

	class KG_Ajax_Add_Subscription extends KG_Ajax {

			private function action() {

			if(!current_user_can( 'add_subscription')){
				return $this->get_object(new WP_Error('bad_fields', __( 'Nie posiadasz wystarczających uprawnień.', 'kg' ) ) );
			}

			if(empty($_POST['user_id']) ) {
				return $this->get_object(new WP_Error('bad_fields', __( 'Nie przesłano użytkownika.', 'kg' ) ) );
			}

			$subcription_obj = KG_Get::get('KG_Item_Subscription', (int) $_POST['subscription_id']);

			$subscription_entry = KG_Get::get('KG_Subscriptions')->add_from_cocpit(
				$subcription_obj,
				(int) $_POST['user_id']
			);

			return $this->get_object(false, __( 'Przyznano użytkownikowi abonament.', 'kg' ));

		}

		public function add_subscription() {
			check_ajax_referer('add_subscription', 'security');
			echo json_encode($this->action());
			die;
		}

		public function __construct() {
			parent::__construct('add_subscription', array($this, 'add_subscription') , '', '');
		}
			
	}
