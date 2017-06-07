<?php

	/**
	 * Recover User Password
	 */
	class KG_User_Password {


		public function change_password($new_password, $user_id) {

			return ( wp_set_password($new_password, $user_id) ) ? true : false;

		}

		public function check_password($password, $user_id) {

			$userdata = get_user_by('id', $user_id);

			if( !is_a($userdata, 'WP_User')) return false;

			return wp_check_password($password, $userdata->user_pass, $userdata->ID);
		
		}

		/**
		 * Recover User Password
		 * @param  string $user_email 	
		 * @return string|WP_Error new password for user
		 */
		public function generate_new_password_and_asssign_to_user($user_id) {

			$password = wp_generate_password();	 	
	
			$update_user = wp_update_user( array ( 'ID' => $user_id, 'user_pass' => $password ) );

			//update user	
			if( $update_user ) {

				if( !apply_filters('kg_send_password_email', $user_id, $password) ){
					return new WP_Error( 'error_send', __( 'Nie mogliśmy wysłać wiadomości email. Spróbuj ponownie później.', 'domain' ) );
				} else {
					return $password;
				}

			} else {
				return new WP-Error('update_user_fail', __( 'Coś poszło nie tak podczas aktualizacji użytkownika, spróbuj zresetować hasło jeszcze raz.', 'kg' ));
			}
		
		}

		public function set_new_password_from_settings_page($user_id, $curr_password, $new_password) {

			if( !$this->check_password($curr_password, $user_id) ) {
				return new WP_Error('bad_curr_password', __( 'To nie jest twoje aktualne hasło.', 'kg' ) );
			}
			
			$this->change_password($new_password,  $user_id);

			do_action('kg_change_password_front', $user_id, $curr_password, $new_password);

			return true;

		}

	}