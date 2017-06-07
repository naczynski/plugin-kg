<?php

	/**
	 * Add avatar 
	 */
	
	class KG_Cocpit_Users_Table_Name {


		public function __construct() {

		
			add_filter("manage_users_columns", array($this, "add_name_column") , 13 );
			add_filter("manage_users_custom_column",  array($this, 'add_name_content'), 11, 3);
			
		}

		public function add_name_content($val, $column_name, $user_id) {
	    	
	
	    	if( $column_name == 'details' ) {

	    		return KG_Get::get('KG_User', $user_id)->get_name_and_surname();
	    	
	     	} else {

	     		return $val;
	     	}
	
		}

		public function add_name_column($columns) {
		    
		    $columns['details'] = __('Imię i Nazwisko', 'kg');

		    return $columns;
		    
		}
	   
	}
	