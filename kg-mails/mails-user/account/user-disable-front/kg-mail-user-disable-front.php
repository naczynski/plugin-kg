<?php 


	class KG_Mail_User_Disable_Front extends KG_Mail{
		
	
		function __construct(){
			
			$dir = __DIR__;
			parent::__construct($dir);

			add_filter( 'kg_user_deactive_front', array($this, 'mail') , 10 , 1 );

		}

		public function mail($user_id) {

			$this->not_show_login_button();

			$subject = __('Wyłączenie konta na Knowledge Garden.', 'kg');
			
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
	