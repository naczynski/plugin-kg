<?php

	/**
	 *  Adde email address to user table
	 */
	
	class KG_Cocpit_Users_Table_Networking {


		public function __construct() {

			add_filter("manage_users_custom_column",  array($this, 'add_edit_column'), 10, 3);	
			add_filter("manage_users_columns", array($this, "add_edit_column_content"), 14 );

		}

		public function add_edit_column($val, $column_name, $user_id) {
	    	
	    	if($column_name != 'networking') return $val;

	    	if ( KG_Get::get('KG_User', $user_id)->can_networking() ){
	    		return '<span class="yes">tak</span>';
	    	} else {
	    		return '<span class="no">nie</span>';
	    	}

		}

		public function add_edit_column_content($columns) {
		    $columns['networking'] = __('Networking', 'kg');
		    return $columns;
		}
	   
	}
