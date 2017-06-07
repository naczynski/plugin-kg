<?php 


	class KG_Mail_New_Transaction extends KG_Mail {
		
		private $template_html = '{{index}}) <strong>{{headline}}</strong>, {{desc}} ({{type}}) <br />';
		private $template_plain = "\n{{headline}}, {{desc}} ({{type}})}";

		private function get_items_list($items, $template){
			$out = '';
			foreach ((array) $items as $index => $item) {
				$out.= str_replace(array(
					'{{headline}}',
					'{{desc}}',
					'{{type}}',
					'{{index}}'
					), array(
					 $item->get_headline(),
					 $item->get_desc(),
					 $item->get_type(),
					 $index + 1
					) 
				, $this->template_html );	
			}
			return $out;
		}

		function __construct(){
			
			$dir = __DIR__;
			parent::__construct($dir);

			add_filter( 'kg_create_transaction', array($this, 'mail') , 1, 1 );

		}

		public function mail($transaction_obj ) {

			$subject = __('Nowe zamówienie', 'kg');
			
			$tags_html = array(
				'items' => apply_filters('kg_message_email_html', $this->get_items_list($transaction_obj->get_items(), $this->template_html)),
				'total_brutto' => $transaction_obj->get_total_brutto(),
				'total_netto' => $transaction_obj->get_total_netto()
			);

			$tags_plain = array(
				'items' => $this->get_items_list($transaction_obj->get_items(), $this->template_plain),
				'total_brutto' => $transaction_obj->get_total_brutto(),
				'total_netto' => $transaction_obj->get_total_netto()
			);

			$message_html = $this->get_template_html($tags_html);
			$message_plain = $this->get_template_plain($tags_plain);

			$this->send(array(
				'id' => $transaction_obj->get_user()->get_ID(),
				'subject' => $subject,
				'message_html' => $message_html,
				'message_plain' => $message_plain
			));

		}

	}