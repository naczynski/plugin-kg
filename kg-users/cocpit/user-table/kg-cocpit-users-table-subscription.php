<?php

	class KG_Cocpit_Users_Table_Subscription {

		public function __construct() {
			add_filter("manage_users_columns", array($this, "add_subscription_column"), 12 );
			add_filter("manage_users_custom_column",  array($this, 'add_subscription_content'), 10, 3);
		}

		public function add_subscription_content($val, $column_name, $user_id) {
	    		
	    	if( $column_name == 'subscription' ) {
	     		$kg_user = KG_Get::get('KG_User', $user_id);
				
		     	if( !is_a($kg_user->get_current_subscription(), 'KG_User_Subscription_Entry')){
		     		return '-';
		     	} else if( $kg_user->get_current_subscription()->is_normal_subscription() ){
		     		return '<span style="color: #FF6D86; font-weight: bold" >KWARTALNY</span>';
		     	} else if( $kg_user->get_current_subscription()->is_premium_subscription() ){
		     		return '<span style="color: orange; font-weight: bold">PREMIUM</span>';
		     	} else {
		     		return '<span>TRIAL</span>';
		     	}
	 
	     	}

	     	return $val;
		}

		public function add_subscription_column($columns) {
		    $columns['subscription'] = __('Abonament', 'kg');
		    return $columns;

		}
			
	}