<?php 

	class KG_Mail_New_Response extends KG_Mail {
		
		function __construct(){
			$dir = __DIR__;
			parent::__construct($dir);
			add_action( 'kg_add_response_to_task', array($this, 'mail') , 10 , 2 );
		}

		public function mail($task_obj, $task_response_obj) {

			$subject = __('Nowa odpowiedź do zadania', 'kg');
			
			$tags_html = array(
				'name' => $task_response_obj->get_task_obj()->get_name(),
				'response' =>  apply_filters('kg_message_email_html', $task_response_obj->get_content()),
				'user_from' => $task_response_obj->get_user()->get_name_and_surname()
			);

			$tags_plain =  array(
				'name' => $task_response_obj->get_task_obj()->get_name(),
				'response' => $task_response_obj->get_content(),
				'user_from' => $task_response_obj->get_user()->get_name_and_surname()
			);

			$message_html = $this->get_template_html($tags_html);
			$message_plain = $this->get_template_plain($tags_plain);
			
			$ids = $task_obj->get_user_ids_with_participite_in_task();
			
			foreach ($ids as $user_id) {
				if($user_id == get_current_user_id()) continue;
				$this->send(array(
					'to' => $user_id,
					'subject' => $subject,
					'message_html' => $message_html,
					'message_plain' => $message_plain
				));
			}

		}

	}