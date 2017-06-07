<?php 


	class KG_Mail_Choose_Award extends KG_Mail {
		
		function __construct(){
			$dir = __DIR__;
			parent::__construct($dir);
			add_action( 'kg_can_choose_award_for_response', array($this, 'mail') , 10 , 1 );
		}

		public function mail($task_response_obj) {

			$subject = __('Twoja odpowiedź otrzymała wymaganą ilość polubień', 'kg');
			
			$tags_html = array(
				'name' => $task_response_obj->get_task_obj()->get_name(),
				'response' =>  apply_filters('kg_message_email_html', $task_response_obj->get_content())
			);

			$tags_plain =  array(
				'name' => $task_response_obj->get_task_obj()->get_name(),
				'response' => $task_response_obj->get_content()
			);

			$message_html = $this->get_template_html($tags_html);
			$message_plain = $this->get_template_plain($tags_plain);
			
			$this->send(array(
				'to' => $task_response_obj->get_user_id(),
				'subject' => $subject,
				'message_html' => $message_html,
				'message_plain' => $message_plain
			));

		}

	}