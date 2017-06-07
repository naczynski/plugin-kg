<?php

	class KG_Api_Finalize extends KG_Ajax {

		private $field_errors;
		private $receiver_data = array(); 

		private function validate_fields() {

			$group_name = ( empty($_POST['type']) || $_POST['type'] == 'user') ?
				'group_fields_default' :
				'group_fields_company';

			$fields = KG_get_curr_user()->get_field_group($group_name)->get_fields();

			foreach ($fields as $field) {	
				$new_value = !empty($_POST[$field->get_name()]) ? $_POST[$field->get_name()] : '';
				$reg_exp_validation = $field->validate_reg_exp($new_value);

				if($new_value=='') {
					$this->field_errors[$field->get_name()] = __( 'To pole jest wymagane.', 'kg' );
				} else if(is_wp_error($reg_exp_validation)) {
					$this->field_errors[$field->get_name()] = $reg_exp_validation->get_error_message();
				} else if( $group_name == 'group_fields_company'){
					$field->set_value($new_value) ;	
				} 

				$this->receiver_data[$field->get_name()] = sanitize_text_field($_POST[$field->get_name()]);		
			
			}

		}

		private function is_cuurent_user_have_filled_data(){
			return KG_get_curr_user()->get_field('kg_user_field_address') == '';
		}

		private function update_values_if_not_before_save_on_my_profile_page(){
			if( !$this->is_cuurent_user_have_filled_data() ||
				empty($this->receiver_data) || 
				sizeof($this->receiver_data) != 5) return;

			foreach ($this->receiver_data as $key => $value) {
				$field = KG_Get::get('KG_User_Field', $key, get_current_user_id())->set_value($value);
			}
		}

		private function create_transaction(){
			$invoice_type = ( empty($_POST['type']) || $_POST['type'] == 'user') ? 'user' : 'customer';
			$this->update_values_if_not_before_save_on_my_profile_page();
			return KG_Transaction_Factory(KG_Get::get('KG_Basket')->data_for_order(), $this->receiver_data);
		}

		private function action(){
			$this->field_errors = [];

			$this->validate_fields();

			if( sizeof($this->field_errors) > 0 ){
				return $this->get_object(true, 
					__( 'Wystąpiły błędy w formularzu.', 'kg' ),
					array(
						'field_errors' => $this->field_errors
					)
				);
			}

			$kg_transaction = $this->create_transaction();
	
			if(is_wp_error($kg_transaction)){
				return $this->get_object($kg_transaction);
			}

			if( !is_a($kg_transaction , 'KG_Transaction') ){
				return $this->get_object(true, __( 'Coś poszło nie tak, nie udało się złożyć zamówienia.', 'kg' ));
			}

			return $this->get_object( false, __( 'Finalizacja zamówienia przebiegła pomyślnie.', 'kg' ), array(
						'order_id' => $kg_transaction->get_ID()
			));

		}

		public function finalize() {
			echo json_encode($this->action());
			die;
		}

		public function __construct(){
       	 	add_action('slim_mapping', array(&$this, 'slim') );            
    	}

   		public function slim($slim){
	        $context = $this;
	        $slim->post('/slim/api/finalize/', function() use($context){
	            $context->finalize();      
	        });
  		}

	}