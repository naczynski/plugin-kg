<?php 


	class KG_Mail_New_Message extends KG_Mail {
		
	
		function __construct(){
		
			$dir = __DIR__;
			parent::__construct($dir);
			add_action( 'kg_sent_message', array($this, 'mail') , 10 , 1 );

		}

		public function mail($message_obj) {

			$this->not_show_login_button();

			$this->show_button('Odpowiedz',  get_permalink( KG_Config::getPublic('login_page_id') ));

			$subject = __('Nowa wiadomość od: ', 'kg') . $message_obj->get_from_user()->get_name_and_surname();
			
			$tags_html = array(
				'from' => $message_obj->get_from_user()->get_name_and_surname(),
				'message' =>  apply_filters('kg_message_email_html', $message_obj->get_message())
			);

			$tags_plain = array(
				'from' => $message_obj->get_from_user()->get_name_and_surname(),
				'message' =>  apply_filters('kg_message_email_plain', $message_obj->get_message_not_formatted())
			);

			$message_html = $this->get_template_html($tags_html);
			$message_plain = $this->get_template_plain($tags_plain);

			$this->send(array(
				'to' => $message_obj->get_to_user()->get_ID(),
				'subject' => $subject,
				'message_html' => $message_html,
				'message_plain' => $message_plain,
				'reply_name' => $message_obj->get_from_user()->get_name_and_surname(),
				'reply_email' => $message_obj->get_from_user()->get_email()
			));

		}

	}