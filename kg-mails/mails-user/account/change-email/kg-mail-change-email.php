<?php 


	class KG_Mail_Change_Email extends KG_Mail{
		
	
		function __construct(){
			
			$dir = __DIR__;
			parent::__construct($dir);

			add_action( 'kg_change_email', array($this, 'mail') , 10 , 3 );

		}

		public function mail($user_id, $old_email, $new_email ) {

			$subject = __('Zmieniliśmy Twój adres email', 'kg');
			
			$tags = array(
				'old_email' => $old_email,
				'new_email' =>  $new_email
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