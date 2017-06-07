<?php 


	class KG_Mail_User_Enable extends KG_Mail{
		

		function __construct(){
			
			$dir = __DIR__;
			parent::__construct($dir);

			add_action( 'kg_user_enable', array($this, 'mail') , 10 , 1 );

		}

		public function mail($user_id) {

			$subject = __('Twoje konto jest już aktywne.', 'kg');
			
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