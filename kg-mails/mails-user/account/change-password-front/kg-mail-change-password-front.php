<?php 


	class KG_Mail_Change_Password_Front extends KG_Mail{
		
	
		function __construct(){
			
			$dir = __DIR__;
			parent::__construct($dir);

			add_filter( 'kg_change_password_front', array($this, 'mail') , 10 , 3 );

		}

		public function mail($user_id, $curr_password, $new_password ) {

			$subject = __('Twoje nowe hasło do portalu Knowledge Garden!', 'kg');
			
			$tags_html = array(
				'password' => apply_filters('kg_message_email_html', $new_password)
			);

			$tags_plain = array(
				'password' => $new_password
			);

			$message_html = $this->get_template_html($tags_html);
			$message_plain = $this->get_template_plain($tags_plain);

			$this->send(array(
				'to' => $user_id,
				'subject' => $subject,
				'message_html' => $message_html,
				'message_plain' => $message_plain
			));

		}

	}