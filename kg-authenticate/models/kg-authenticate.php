<?php

 class KG_Authenticate {

 	public function __construct() {

 		remove_filter( 'authenticate', 'wp_authenticate_username_password', 20, 3 );
		
		add_filter( 'authenticate', array($this, 'email_authenticate') , 20, 3 );
		add_filter( 'authenticate', array($this, 'check_account_status') , 24, 3 );

 	}

 	/**
 	 * Authenticate by email
 	 * @param  null|WP_User $user     
 	 * @param  string $username 
 	 * @param  string $password 
 	 * @return mixed
 	 */
 	public function email_authenticate( $user, $username, $password ) {
		
		if ( is_a( $user, 'WP_User' ) )
			return $user;

		if ( !empty( $username ) ) {
			$username = str_replace( '&', '&amp;', stripslashes( $username ) );
			$user = get_user_by( 'email', $username );
			if ( isset( $user, $user->user_login, $user->user_status ) && 0 == (int) $user->user_status )
				$username = $user->user_login;
		}

		return wp_authenticate_username_password( null, $username, $password );
	
	}

	public function check_account_status( $user, $username, $password ) {

		if ( is_a( $user, 'WP_User' ) ){

			$kg_user = KG_Get::get('KG_User', $user->ID);

			if( !$kg_user->is_active() ) {
				return new WP_Error('account_not_active', __( 'Twoje konto nie jest aktywne. Skontaktuj się z&nbsp;<a href="mailto:' .  KG_Config::getPublic('admin_email')[0] .'">  '. KG_Config::getPublic('admin_email')[0] .'</a>.', 'kg' ) );
			}

			if( !$kg_user->is_email_activated() ) {
				return new WP_Error('email_not_activated', __( 'Twój adres email nie został jeszcze potwierdzony. Kliknij w link aktywacyjny, który otrzymałeś na swój adres mailowy.', 'kg' ) );
			}

			do_action('kg_correct_authenticate', $user->ID, $kg_user);
		}

		return $user;

	}
	
 }