<?php 


	class KG_Mail_Disable_Networking extends KG_Mail{
		
	
		function __construct(){
			
			$dir = __DIR__;
			parent::__construct($dir);

			add_action( 'kg_disable_networking', array($this, 'mail') , 2 , 1 );

		}

		public function mail($user_id) {

			$subject = __('Aktualizacja danych konta w Knowledge Garden', 'kg');
			
			$tags = array(
				
			);

			$message_html = $this->get_template_html($tags);
			$message_plain = $this->get_template_plain($tags);

			$this->send(array(
				'to' => $user_id,
				'subject' => $subject,
				'message_html' => $message_html,
				'message_plain' => $message_plain
			));

		}

	}