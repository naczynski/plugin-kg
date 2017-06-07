<?php 


	class KG_Mail_Cancel_Transaction extends KG_Mail {
		
		function __construct(){
			
			$dir = __DIR__;
			parent::__construct($dir);

			add_filter( 'kg_cancel_transaction', array($this, 'mail') , 10 , 1 );

		}

		public function mail($kg_transaction) {

			$this->not_show_login_button();
			$this->show_button('Powtórz transakcję', $kg_transaction->get_sent_to_payu_url());

			$subject = __('Transakcja anulowana', 'kg');
			
			$tags = array(
				'transaction_nr' => $kg_transaction->get_number_for_user(),
				'pay_again_url' => $kg_transaction->get_sent_to_payu_url()
			);

			$message_html = $this->get_template_html($tags);
			$message_plain = $this->get_template_plain($tags);

			$this->send(array(
				'to' => $kg_transaction->get_user_id(),
				'subject' => $subject,
				'message_html' => $message_html,
				'message_plain' => $message_plain
			));

		}

	}