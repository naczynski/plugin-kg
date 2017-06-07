<?php

	class KG_Linkedin {

		private $li;

		public function log_in_user($email){
			wp_logout();	

			if(email_exists($email)){
				$user = get_user_by('email',$email);
				var_dump($user);
				wp_set_auth_cookie($user->ID);
				wp_set_current_user($user->ID); 
				wp_redirect('/');
			} 
		}

		public function __construct(){
			$url = get_permalink(KG_Config::getPublic('login_page_id'));
			$this->li = new LinkedIn(
			  array(
			    'api_key' => KG_Config::getProtected('linkein_clinet_id'), 
			    'api_secret' => KG_Config::getProtected('linkein_secret'), 
			    'callback_url' => substr($url, 0, strlen($url) - 1 )
			  )
			);			
		}

		public function log_in_action(){
			if(empty($_REQUEST['code'])) return;

			try{		
				$token = $this->li->getAccessToken($_REQUEST['code']);
				$this->li->setAccessToken($token);
				$info = $this->li->get('/people/~:(email-address)');
			} catch(Exception $e){
				
			} 

			if(!empty($info['emailAddress'])){
				$this->log_in_user($info['emailAddress']);
			}
		}

		public function get_url(){
			return  $this->li->getLoginUrl(
			  array(
			    LinkedIn::SCOPE_EMAIL_ADDRESS,
			  )
			);
		}

	}
