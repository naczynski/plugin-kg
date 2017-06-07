<?php

	class KG_Api_Profile_Avatar extends KG_Ajax {


		private $filename;

		private function save_img($base64) {
			$base64 = str_replace('data:image/jpeg;base64,', '', $base64);
			$base64 = str_replace(' ', '+', $base64);
			$decoded = base64_decode($base64);
			$ret = file_put_contents( KG_Get::get("KG_User_Avatars")->get_avatar_dir($this->filename), $decoded);
			return $ret;
		}
		
		public function change() {

			if ( !check_ajax_referer('kg-change-avatar', 'security') ) {
				echo json_encode($this->get_object(true, __( 'Brak uprawnień aby zmienić avatar', 'kg' ) ));
				return;
			}
	
			if (empty( $_POST['avatartBase64']) ) {
				echo json_encode($this->get_object(true, __( 'Nie przekazałeś avatara', 'kg' ) ));
				return;
			}

			$this->filename = sanitize_file_name( KG_get_curr_user()->get_name_and_surname() . wp_generate_password(4, false, false) .'.jpg');

			// save image

			$save_img = $this->save_img( $_POST['avatartBase64'] );
			if ( !$save_img ) {
				echo json_encode($this->get_object(true, __( 'Wystąpił problem z zapisem avatara na serwerze.', 'kg' ) ));	
				return;
			}

			// save in db

			KG_get_curr_user()->set_avatar($this->filename);
			echo json_encode($this->get_object(false, __( 'Zmieniłeś swojego avatara.', 'kg' ) ));	
			die;

		}

		public function __construct(){
       	 	add_action('slim_mapping', array(&$this, 'slim_mapping') );            
    	}

   		public function slim_mapping($slim){
	        $context = $this;
	        $slim->post('/slim/api/avatar',function()use($context){
	              $context->change();            
	        });
  		}

	}
	