<?php

/**
* Plugin Name: Kokpit (KG)
* Plugin URI:  http://kodafive.com
* Description: Zarządza wyglądem ekranu kokpitu w zależności od typu użytkownika
* Author:      KodaFive Team
* Author URI:  http://kodafive.com
*/

	if ( ! defined( 'WPINC' ) ) {
		die;
	}


class KG_Cocpit_Loader extends KG_Component {


	public $name = 'Cocpit';

	public $dir = 'kg-cocpit';

	public $des = '';

	protected $includes = array(

		'abstract/kg-cocpit-view',
		
		'views/kg-cocpit-coach',
		'views/kg-cocpit-admin-questus',
		'views/kg-cocpit-admin',
		'views/kg-cocpit-default',

		'kg-cocpit-functions'

	);

	public function init_hooks() {

		$this->start_without_create_instances();
		
		$role1 = !empty( wp_get_current_user()->roles[1] ) ? wp_get_current_user()->roles[1] : false ;
		$role2 = !empty( wp_get_current_user()->roles[0] ) ? wp_get_current_user()->roles[0] : false ;

		if( $role1 || $role2 ) {
			$role = $role1 ? $role1 : $role2;
			switch($role ) {
				case 'coach': KG_Get::get('KG_Cocpit_Coach'); break;
				case 'questus-admin': KG_Get::get('KG_Cocpit_Admin_Questus'); break;
				case 'administrator': KG_Get::get('KG_Cocpit_Admin'); break;
			}		
		} else {
			// not logged user
			KG_Get::get('KG_Cocpit_Default');	
		}

	}

	public function init(){

	}

}
