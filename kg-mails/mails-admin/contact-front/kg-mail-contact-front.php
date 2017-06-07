<?php

	/**
	* Send to admin from contact form
	*/
	class KG_Mail_Contact_Front extends KG_Mail{
	
	
		function __construct(){
			$dir = __DIR__;
			parent::__construct($dir);
			add_filter('kg_send_email_to_admin', array($this, 'mail'), 1, 4);
		}
		
		/**
		 * Send message
		 * @param  string $name name and surname
		 * @return [type]       [description]
		 */
		public function mail($email, $user_id, $name, $message) {

			$this->not_show_login_button();

			$subject = __(sprintf('Wiadomość od użytkownika: %s', $name), 'kg');
			
			$tags_html = array(
				'from' => $name,
				'message' =>  apply_filters('kg_message_email_html', $message)
			);

			$tags_plain = array(
				'from' => $name,
				'message' =>  apply_filters('kg_message_email_plain', $message)
			);

			$message_html = $this->get_template_html($tags_html);
			$message_plain = $this->get_template_plain($tags_plain);

			return $this->send_admin(array(
				'subject' => $subject,
				'message_html' => $message_html,
				'message_plain' => $message_plain,
				'reply_name' => $name,
				'reply_email' => $email,
			));
			
		}
		
	}