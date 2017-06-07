<?php

	/**
	 *  Adde email address to user table
	 */
	
	class KG_Cocpit_Users_Table_Active {


    	public function __construct() {

			add_filter("manage_users_custom_column",  array($this, 'add_edit_column'), 15, 3);	
			add_filter("manage_users_columns", array($this, "add_edit_column_content"), 16 );

		}

		public function add_edit_column($val, $column_name, $user_id) {
	    	
	    	if($column_name != 'active') return $val;

	    	if ( KG_Get::get('KG_User', $user_id)->is_active() ){
	    		return '<span class="yes">tak</span>';
	    	} else {
	    		return '<span class="no">nie</span>';
	    	}

		}

		public function add_edit_column_content($columns) {

		    $columns['active'] = __('Aktywny', 'kg');

		    return $columns;
		
		}
	   
	}
