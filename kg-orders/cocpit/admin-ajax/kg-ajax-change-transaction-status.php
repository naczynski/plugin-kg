<?php

	class KG_Ajax_Change_Transaction_Status extends KG_Ajax {

		private function action(){

			$res = true;

			if(!wp_verify_nonce($_POST['security'])){
				$res = new WP_Error('bad_form', __( 'Będna ściężka dostępu.', 'kg' ));
			}

			if(empty($_POST['transaction_id'])){
				$res = new WP_Error('bad_form', __( 'Nie podałeś identyfikatora transakcji.', 'kg' ));
			}

			$transaction = KG_Get::get('KG_Transaction', (int) $_POST['transaction_id']);

			$res = $transaction->pay();

			if (is_wp_error($res)) {
				return $this->get_object($res);
			} else {		
				return $this->get_object(false, __( 'Poprawnie zapłacono za zamówienie.', 'kg' ));
			}

		}

		public function pay() {
			echo json_encode($this->action());
			die;
		}


		public function __construct() {		
			parent::__construct('transaction_pay', array($this, 'pay') , '', '');
		}
		
	}
