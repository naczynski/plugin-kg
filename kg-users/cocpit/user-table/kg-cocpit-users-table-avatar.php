<?php

	/**
	 * Add avatar 
	 */
	
	class KG_Cocpit_Users_Table_Avatar {

		public function __construct() {

			add_filter("manage_users_columns", array($this, "add_avatar_column"), 12 );
			add_filter("manage_users_custom_column",  array($this, 'add_avatar_content'), 10, 3);
			
		}

		public function add_avatar_content($val, $column_name, $user_id) {
	    		
	    	if( $column_name == 'avatar' ) {

	    		$img_src = KG_Get::get('KG_User', $user_id)->get_avatar();
	     		
	    		return "<img src=\"{$img_src}\" width=\"50\" height=\"50\" alt=\"\" />";

	     	}

	     	return $val;
	     		
		}

		public function add_avatar_column($columns) {
		    
			$tmp = array();

		    return array(

		    	'cb' => '<input type="checkbox" />',
		    	'avatar' =>  __('Zdjęcie', 'kg'),
		    );

		}
	   
	}
	