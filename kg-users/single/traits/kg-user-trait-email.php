<?php

	  trait KG_User_Trait_Email {
		
			public function get_email(){
				return $this->get_wp_user_object()->user_email;
			}

			public function change_email($new_email) {

				$old_email = $this->get_email(); 

				if( $old_email == $new_email) return; // the same, not change

				$res = wp_update_user( array(
			 		'ID' => $this->user_id, 
					'user_email' => $new_email ) 
				);

				do_action('kg_change_email', $this->user_id, $old_email, $new_email);

				return $res;

			}

	  }