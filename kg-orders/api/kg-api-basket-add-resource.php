<?php

	class KG_Api_Basket_Add_Resource extends KG_Ajax {

		private function validate(){

			if(!current_user_can( 'send_present')){
				return new WP_Error('bad_fields', __( 'Nie posiadasz wystarczjących uprawnień.', 'kg' ) );
			}

			if(!KG_get_curr_user()->is_have_active_subscription()){
				return new WP_Error('no_subscription', __( 'Musisz posiadać abonament.', 'kg' ) );
			}

			// resource
			if(empty($_POST['resource_id'])) {
				return new WP_Error('bad_fields', __( 'Musisz wybrać jaki zasób chcesz dodać!', 'kg' ) );
			}

			if(KG_Get::get('KG_Basket')->is_in_basket($_POST['resource_id'])){
				return new WP_Error('already_in_basket', __( 'Już posiadasz ten zasób w koszyku.', 'kg' ) );
			}
		}

		private function action() {

			$validate = $this->validate();

			if(is_wp_error($validate)){
				return $this->get_object($validate);
			}

			$data = array(
				'type' => 1,
				'resource_id' => (int) $_POST['resource_id'],
				'user_id' => get_current_user_id()
			);

			$resource_obj = KG_get_order_object($data);

			$add = KG_Get::get('KG_Basket')->add($resource_obj);

			// validate add
			if(is_wp_error($add)){
				return $this->get_object($add);
			}

			do_action('kg_add_to_basket_resource', get_current_user_id(), $resource_obj);

			return $this->get_object(
					false, 
					__( 'Zasób został dodany do koszyka.', 'kg'),
					array(
						'basket' => KG_Get::get('KG_Basket') 
					)
				);
		}

		public function add_resource() {
			echo json_encode($this->action());
			die;
		}

		public function __construct(){
       	 	add_action('slim_mapping', array(&$this, 'slim') );            
    	}
    	
   		public function slim($slim){
	        $context = $this;
	        $slim->post('/slim/api/basket/add-resource', function()use($context){
	            $context->add_resource();      
	        });
  		}

	}
