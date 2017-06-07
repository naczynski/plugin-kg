<?php 

	class KG_Mail_Complete_Transaction extends KG_Mail {
		
		private $template_html = '<p style="margin-top:0px;margin-left: 10px;line-height:1.25em;"><span style="font-weight:bold;">{{headline}}, {{desc}} ({{type}})</span></p>';
		private $template_plain = "\n{{headline}}, {{desc}} ({{type}})}";

		private function get_items_list($items, $template){
			$out = '';
			foreach ((array) $items as $item) {
				$out.= str_replace(array(
					'{{headline}}',
					'{{desc}}',
					'{{type}}'
					), array(
					 $item->get_headline(),
					 $item->get_desc(),
					 $item->get_type()
					) 
				, $this->template_html );	
			}
			return $out;
		}

		function __construct(){
			
			$dir = __DIR__;
			parent::__construct($dir);

			add_filter( 'kg_payment_complete', array($this, 'mail') , 1, 1 );

		}

		public function mail($transaction_obj) {

			$subject = __('Potwierdzono wpłatę.', 'kg');
			
			if($transaction_obj->is_containt_only_event()){
				$info = "Skontaktujemy się z Tobą w celu potwierdzenia szczegółów wydarzenia.";
			} else if($transaction_obj->is_contain_only_resources()){
				$info = "Przejdź do portalu i zobacz kupione zasoby.";
			} else if($transaction_obj->is_contain_only_subscription()){
				$info = "Przejdź do Platformy i swobodnie korzystaj z zasobów, które dla Ciebie zgromadziliśmy.";
			} else if($transaction_obj->is_containt_event()){
				$info = "Skontaktujemy się z Tobą w celu potwierdzenia szczegółów wydarzenia.";
			} else {
				$info = "";
			}

			$tags_html = array(
				'items' => $this->get_items_list($transaction_obj->get_items(), $this->template_html),
				'total_brutto' => $transaction_obj->get_total_brutto(),
				'total_netto' => $transaction_obj->get_total_netto(),
				'information' => $info,
				'number' => $transaction_obj->get_number_for_user()
			);

			$tags_plain = array(
				'items' => $this->get_items_list($transaction_obj->get_items(), $this->template_plain),
				'total_brutto' => $transaction_obj->get_total_brutto(),
				'total_netto' => $transaction_obj->get_total_netto(), 
				'information' => $info,
				'number' => $transaction_obj->get_number_for_user()
			);

			$message_html = $this->get_template_html($tags_html);
			$message_plain = $this->get_template_plain($tags_plain);

			$transaction_obj->generate_invoice(); // if before not generated

			$this->send(array(
				'to' => $transaction_obj->get_user()->get_ID(),
				'subject' => $subject,
				'message_html' => $message_html,
				'message_plain' => $message_plain,
				'attachments' => $transaction_obj->get_invoice_path()
 			));
			
		}

	}