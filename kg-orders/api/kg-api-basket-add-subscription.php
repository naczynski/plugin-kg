<?php

	class KG_Api_Basket_Add_Subscription extends KG_Ajax {

		private function validate(){

			if(!current_user_can( 'send_present')){
				return new WP_Error('bad_fields', __( 'Nie posiadasz wystarczjących uprawnień.', 'kg' ) );
			}

			// resource
			if(empty($_POST['subscription_id'])) {
				return new WP_Error('bad_fields', __( 'Musisz wybrać jaki abonament chcesz kupić!', 'kg' ) );
			}

			if(KG_Get::get('KG_Basket')->is_in_basket($_POST['resource_id'])){
				return new WP_Error('already_in_basket', __( 'Już posiadasz ten zasób w koszyku.', 'kg' ) );
			}

		}

		private function action() {

			$data = array(
				'type' => 3,
				'subscription_id' => (int) $_POST['subscription_id'],
				'user_id' => get_current_user_id()
			);

			$subscription_obj = KG_get_order_object($data);

			$add = KG_Get::get('KG_Basket')->add($subscription_obj);

			do_action('kg_add_to_basket_subscription', get_current_user_id(), $subscription_obj);

			// validate add
			if(is_wp_error($add)){
				return $this->get_object($add);
			}

			return $this->get_object(
					false, 
					__( 'Abonament został dodany do koszyka.', 'kg'),
					array(
						'basket' => KG_Get::get('KG_Basket') 
					)
				);
		}

		public function add_subscription() {
			echo json_encode($this->action());
			die;
		}
		
		public function __construct(){
       	 	add_action('slim_mapping', array(&$this, 'slim') );            
    	}
    	
   		public function slim($slim){
	        $context = $this;
	        $slim->post('/slim/api/basket/add-subscription', function()use($context){
	            $context->add_subscription();      
	        });
  		}

	}
