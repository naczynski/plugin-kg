<?php 


	/**
	* Send activation link to user
	*/
	class KG_Mail_Email_Activation extends KG_Mail{
		
	
		function __construct(){
			
			$dir = __DIR__;
			parent::__construct($dir);

			add_filter( 'kg_send_user_activate_email', array($this, 'mail') , 10 , 4 );

		}

		public function mail($user_id, $user_email, $key, $password ) {

			do_action('kg_sent_user_activattion_email', $user_id);

			$this->show_button('Aktywuj', get_permalink( KG_Config::getPublic('activation_page_id') ) . '?key=' . $key);

			$subject = __('Witaj na platformie Knowledge Garden!', 'kg');
			
			$tags = array(
				'title' => __( 'Witaj', 'kg' ),
				'email' => $user_email,
				'account_data' => apply_filters('kg_message_email_html', "
					<strong>login</strong>: {$user_email} <br/>
					<strong>hasło</strong>: {$password}
				"),
				'password' => $password
			);

			$message_html = $this->get_template_html($tags);
			$message_plain = $this->get_template_plain($tags);

			$terms_path = wp_upload_dir()['basedir'] . '/public/regulamin.pdf';

			$this->send(array(
				'to' => $user_id,
				'subject' => $subject,
				'message_html' => $message_html,
				'message_plain' => $message_plain,
				'attachments' => array(
					$terms_path
				)
			));

		}

	}