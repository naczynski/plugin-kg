<?php 

	/**
	* Redirect to login page if page only for logged in
	*/
	class KG_Redirections {


		private function redirect_to_resource_page() {
			wp_redirect( get_permalink( KG_Config::getPublic('recources_page_id') ) );
			exit();
		}

		public function redirect(){

			if(	is_page(KG_Config::getPublic('change_payment_status')) ){
				return;
			}

			if(is_front_page() && is_user_logged_in()) {
				$this->redirect_to_resource_page();
				return;
			}

			if(is_front_page()) {
				return;
			}

			// render file or redirect to page
			if(is_page( KG_Config::getPublic('download_fule_page_id'))) {
				KG_Get::get('KG_Download_Handler')->init();
				return;
			}

			if(	is_page(KG_Config::getPublic('faq_page_id')) ){
				return;
			}

			foreach (KG_Config::getPublic('not_for_logged_in_pages') as $page_id ) {
				
				if( is_page( $page_id ) && !is_user_logged_in() ){
				   return;
			    } else if( is_user_logged_in() && is_page( $page_id) ) {
			    	$this->redirect_to_resource_page();
			    }

			}

			if( !is_user_logged_in() && 
				!is_page(KG_Config::getPublic('login_page_id'))
				) {
				wp_redirect( get_permalink( KG_Config::getPublic('login_page_id') ) );
				exit();
			}

		}
		
		function __construct(){
			 add_action( 'template_redirect', array($this, 'redirect') );
		}
	
	}

?>