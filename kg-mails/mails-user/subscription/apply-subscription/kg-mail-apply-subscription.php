<?php 


	class KG_Mail_Apply_Subscription extends KG_Mail{
		
		function __construct(){			
			$dir = __DIR__;
			parent::__construct($dir);

			add_action('kg_add_subscription', array($this, 'mail'), 1, 3);
		}

		public function mail( $subcription_obj , $subscription_entry, $user_id) {

			$subject = __('Aktualizacja danych konta w Knowledge Garden', 'kg');

			if( $subcription_obj->get_ID() ==  KG_Config::getPublic('subscription_normal_id') ){
				$ktm = 10;
				$another = 12;
			} else {
				$ktm = 60;
				$another = 48;
			}

			$tags = array(
				'date_start' => $subscription_entry->get_start_date(),
				'date_end' => $subscription_entry->get_end_date(),
				'free_resources' => $subcription_obj->get_how_many_free_resources(),
				'ktm' => $ktm,
				'another' => $another
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