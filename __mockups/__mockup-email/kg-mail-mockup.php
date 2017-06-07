<?php 


	class KG_Mail_Mockup extends KG_Mail {
		
	
		function __construct(){
			
			$dir = __DIR__;
			parent::__construct($dir);

			add_filter( 'HOOK', array($this, 'mail') , 10 , 4 );

		}

		public function mail($user_id, $user_email, $key, $password ) {

			$subject = __('TITLE', 'kg');
			
			$tags = array(
				
			);

			$message_html = $this->get_template_html($tags);
			$message_plain = $this->get_template_plain($tags);

			$this->send(
				$user_id,
				$subject,
				$message_html,
				$message_plain
			);

		}

	}