<?php

	class KG_Invoice_Factory {

		private $kg_user;

		private function get_transaction_in_current_month(){
			global $wpdb;
			$table = KG_Config::getPublic('table_transactions');
			$data = $wpdb->get_row(
				"SELECT COUNT(id) AS count FROM {$table} 
				 WHERE YEAR(date) = YEAR(NOW())
				 AND MONTH(date) = MONTH(NOW())",
				 ARRAY_A
			);
			return (int) $data['count'];
		}

		private function get_invoice_number(){
			$transaction_in_month = $this->get_transaction_in_current_month();
			return  KG_get_time_obj()->format('d/m/Y/') . ++$transaction_in_month;
		}

		private function get_template() {
			return mb_convert_encoding(
			     file_get_contents(  plugin_dir_path( __FILE__ ) . '../template/invoice.html'),
				'HTML-ENTITIES', 
				'UTF-8');
		}

		private function get_receiver_name($receiver_data) {
			if(!empty($receiver_data['kg_field_name'])) return $receiver_data['kg_field_name'];
			if(!empty($receiver_data['kg_field_company_name'])) return $receiver_data['kg_field_company_name'];
			return '';
		}

		private function get_receiver_surname($receiver_data) {
			if(!empty($receiver_data['kg_field_surname'])) return $receiver_data['kg_field_surname'];
			return '';
		}

		private function get_receiver_address($receiver_data) {
			if(!empty($receiver_data['kg_user_field_address'])) return $receiver_data['kg_user_field_address'];
			if(!empty($receiver_data['kg_field_company_address'])) return $receiver_data['kg_field_company_address'];
			return '';
		}

		private function get_receiver_postcode($receiver_data) {
			if(!empty($receiver_data['kg_user_field_post_code'])) return $receiver_data['kg_user_field_post_code'];
			if(!empty($receiver_data['kg_field_company_post_code'])) return $receiver_data['kg_field_company_post_code'];
			return '';
		}

		private function get_receiver_city($receiver_data) {
			if(!empty($receiver_data['kg_user_field_city'])) return $receiver_data['kg_user_field_city'];
			if(!empty($receiver_data['kg_field_company_city'])) return $receiver_data['kg_field_company_city'];
			return '';
		}

		private function get_receiver_nip($receiver_data) {
			if(!empty($receiver_data['kg_field_company_nip'])) return $receiver_data['kg_field_company_nip'];
			return '';
		}

		private function get_items($transaction_obj) {
			$out = '';
			$items = $transaction_obj->get_items();
			foreach ($items as $index => $item) {
				$out .= str_replace(
						array(
							'{{index}}',
							'{{name}}',
							'{{price_netto}}',
							'{{price_brutto}}',
							'{{vat}}'
						),
						array(
							++$index,
							$item->get_invoice_label(),
							$item->get_price_netto(),
							$item->get_price_brutto(),
							$item->get_vat() 
							
						),'<tr>
							<td>{{index}}</td>
							<td class="Main-productsTableProductName">{{name}}</td>
							<td></td>
							<td>1</td>
							<td class="no-border-right">{{price_netto}}zł</td>
							<td class="blue">{{price_netto}}zł</td>
							<td class="no-border-right">23%</td>
							<td class="blue">{{vat}}zł</td>
							<td>{{price_brutto}}zł</td>
						</tr>');
			}
			return $out;
		}

		private function render_template($template, $transaction_obj, $receiver_data) {

			$replace = array(
				'{{questus_company_name}}' => KG_Config::getPublic('questus_company_name'),
				'{{questus_company_address}}' => KG_Config::getPublic('questus_company_address'),
				'{{questus_company_nip}}' => KG_Config::getPublic('questus_company_nip'),
				'{{questus_company_regon}}' => KG_Config::getPublic('questus_company_regon'),
				'{{questus_company_bank_account}}' => KG_Config::getPublic('questus_company_bank_account'),
				'{{invoice_number}}' => $this->get_invoice_number(),
				
				'{{receiver_name}}' => $this->get_receiver_name($receiver_data),
				'{{receiver_surname}}' => $this->get_receiver_surname($receiver_data),
				'{{receiver_address}}' => $this->get_receiver_address($receiver_data),
				'{{receiver_postcode}}' => $this->get_receiver_postcode($receiver_data),
				'{{receiver_city}}' => $this->get_receiver_city($receiver_data),
				'{{receiver_nip}}' => $this->get_receiver_nip($receiver_data),
				
				'{{current_time}}' => KG_get_time_obj()->format('Y-m-d '),
				'{{payment_deadline}}' => KG_get_time_obj()->plusDays(14)->format('Y-m-d '),

				'{{items}}' => $this->get_items($transaction_obj),

				'{{price_words}}' => ucfirst(KG_Price_Words::getInstance()->get_string( (int) $transaction_obj->get_total_brutto())),
				
				'{{tatal_vat}}' => $transaction_obj->get_total_vat(),
				'{{tatal_brutto}}' => $transaction_obj->get_total_brutto(),
				'{{total_netto}}' => $transaction_obj->get_total_netto()
			
			);

			return str_replace(
				array_keys($replace),
				array_values($replace),
				$template	
			);

		}

		public function generate($transaction_obj){

			$path = $transaction_obj->get_invoice_path();
			if(file_exists($path)){
				return;
			}
			
			ini_set('xdebug.max_nesting_level', 100000);

			$this->kg_user = KG_Get::get('KG_User', $transaction_obj->get_user_id());
			$html = $this->render_template( $this->get_template(), $transaction_obj, $transaction_obj->get_invoice_data());

			$dompdf = new DOMPDF();
			$dompdf->set_paper( 'A4', 'portrait');
			$dompdf->load_html(	$html , 'utf-8');
			$dompdf->set_base_path( plugin_dir_path( __FILE__ ) );
			$dompdf->render();

			file_put_contents($path , $dompdf->output());
		}

	}