<?php 

	/**
	* Send new password for user
	*/
	class KG_Mail_Recover_Password extends KG_Mail{
	
		function __construct(){
			
			$dir = __DIR__;
			parent::__construct($dir);

			add_filter('kg_send_password_email', array($this, 'mail'), 1, 3);

		}

		public function mail($user_id, $password) {

			do_action('kg_sent_recover_password_mail', $user_id);

			$subject = __('Twoje nowe hasło do portalu Knowledge Garden!', 'kg');
			
			$tags = array(
				'password' => $password,
				'password_box' => apply_filters('kg_message_email_html',$password)
			);

			$message_html = $this->get_template_html($tags);
			$message_plain = $this->get_template_plain($tags);

			return $this->send(array(
				'to' => $user_id,
				'subject' => $subject,
				'message_html' => $message_html,
				'message_plain' => $message_plain
			));

		}

	}

?>