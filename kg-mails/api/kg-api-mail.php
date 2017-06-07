<?php

	class KG_Api_Mail extends KG_Ajax {


		private function mail($not_logged) {

			if( $not_logged && empty($_POST['name']) ) {
				echo json_encode( $this->get_object(true, __('Musisz podać imię i nazwisko.', 'kg')) );
				return;
			}

			if( $not_logged && empty($_POST['email']) && !is_email($_POST['email']) ) {
				echo json_encode( $this->get_object(true, __('Musisz podać e-mail.', 'kg')) );
				return;
			}

			if( empty($_POST['message']) ) {
				echo json_encode( $this->get_object(true, __('Musisz wpisać wiadomość.', 'kg')) );
				return;
			}

			$name = $not_logged ? $_POST['name'] : KG_get_curr_user()->get_name_and_surname();
			$email = $not_logged ? $_POST['email'] : KG_get_curr_user()->get_email();
			$user_id = $not_logged ? false : KG_get_curr_user()->get_id();
			
			$ok = apply_filters('kg_send_email_to_admin', $email , $user_id , $name, $_POST['message']);

			if( $ok ) {
				echo json_encode( $this->get_object(false, __('Dziękujemy za wiadomość. Odpowiemy Ci błyskawicznie.', 'kg')) );
				return;
			} else {
				echo json_encode( $this->get_object(true, __('Nie udało się wysłać wiadomości.', 'kg')) );
				return;
			}

		}

		public function __construct(){
       	 	add_action('slim_mapping', array(&$this, 'slim_mapping') );            
    	}

   		public function slim_mapping($slim){
	        
	        $context = $this;
	     
	        $slim->post('/slim/api/mail',function()use($context){
	              $context->mail(false);            
	        });

	        $slim->post('/slim/api/contact',function()use($context){
	              $context->mail(true);            
	        });
  		}

	}