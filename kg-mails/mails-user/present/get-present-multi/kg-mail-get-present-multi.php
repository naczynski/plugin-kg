<?php 

	class KG_Mail_Get_Present_Multi extends KG_Mail {
		
		private $template_html = '<strong>{{resource}}</strong> ({{type}})<br/>';
		private $template_plain = "\n{{resource}}";

		private function get_resources_list($resources){
			$out = '';
			foreach ((array) $resources as $resource) {
				$resource = KG_get_resource_object($resource);
				$out.= str_replace(
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
			return $out;
		}

		private function get_resources_list_plain($resources){
			$out = '';
			foreach ((array) $resources as $resource) {
				$out.= str_replace('{{resource}}', KG_get_resource_object($resource)->get_name_with_subtype(), $this->template_plain );	
			}
			return $out;
		}

		function __construct(){			
			$dir = __DIR__;
			parent::__construct($dir);

			add_action('kg_add_present_multi', array($this, 'mail'), 1, 4);
		}

		public function mail($resources_ids, $from_user_id, $to_user_id, $message) {

			$subject = __('Niespodzianka!', 'kg');
			$coach_name = KG_Get::get('KG_User', $from_user_id)->get_name_and_surname();
			$tags_html = array();

			if($message!= " "){
				$tags_html['resources'] =  apply_filters('kg_message_email_html', $this->get_resources_list($resources_ids));
				$tags_html['with_message_text'] = '<p style="margin-bottom:15px;">z wiadomością</p>';
				$tags_html['message'] = apply_filters('kg_message_email_html', $message);
			
			} else {
				$tags_html['resources'] = apply_filters('kg_message_email_html', $this->get_resources_list($resources_ids) );
				$tags_html['with_message_text'] = '';
				$tags_html['message'] = '';
			}

			$tags_html['it'] = ( sizeof($resources_ids) == 1 ) ? 'go' : 'je';
			$tags_html['coach'] = $coach_name;

			$tags_plain = array(
				'coach' => $coach_name,
				'resources' => $this->get_resources_list_plain($resources_ids),
				'message' => apply_filters('kg_message_email_plain', $message),
				'it' => ( sizeof($resources_ids) == 1 ) ? 'go' : 'je'
			);

			$message_html = $this->get_template_html($tags_html);
			$message_plain = $this->get_template_plain($tags_plain);

			$this->send(array(
				'to' => $to_user_id,
				'subject' => $subject,
				'message_html' => $message_html,
				'message_plain' => $message_plain
			));

		}

	}