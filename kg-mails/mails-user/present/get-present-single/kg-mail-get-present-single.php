<?php 

	class KG_Mail_Get_Present_Single extends KG_Mail {
		
		private $template_html = '<strong>{{resource}}</strong> ({{type}})<br/>';

		function __construct(){			
			$dir = __DIR__;
			parent::__construct($dir);

			add_action('kg_add_present_single', array($this, 'mail'), 1, 4);
		}

		private function get_resource_text($resource){
			return str_replace(
				array(
					'{{resource}}',
					'{{type}}'
				), array(
					$resource->get_name(), 
					$resource->get_subtype_name()
				),
				$this->template_html
			);
		}

		public function mail($persent_relation_obj) {

			$subject = 'Dostałeś zasób w prezencie od ' . $persent_relation_obj->get_from_user()->get_name_and_surname() ;
			
			$tags_html = array();
			if($persent_relation_obj->is_message_attached()){
				$tags_html['resource'] =  apply_filters('kg_message_email_html', $this->get_resource_text($persent_relation_obj->get_resource()));
				$tags_html['with_message_text'] = '<p style="margin-bottom:15px;">z wiadomością</p>';
				$tags_html['message'] = apply_filters('kg_message_email_html', $persent_relation_obj->get_message());
			
			} else {
				$tags_html['resource'] = apply_filters('kg_message_email_html', $this->get_resource_text($persent_relation_obj->get_resource()));
				$tags_html['with_message_text'] = '';
				$tags_html['message'] = '';
			}

			$tags_html['from'] = $persent_relation_obj->get_from_user()->get_name_and_surname();

			$tags_plain = array(
				'resources' => $persent_relation_obj->get_resource()->get_name_with_subtype(),
				'message' => apply_filters('kg_message_email_plain', $persent_relation_obj->get_message())
			);

			$message_html = $this->get_template_html($tags_html);
			$message_plain = $this->get_template_plain($tags_plain);

			$this->send(array(
				'to' => $persent_relation_obj->get_to_user()->get_ID(),
				'subject' => $subject,
				'message_html' => $message_html,
				'message_plain' => $message_plain
			));

		}

	}