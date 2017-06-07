<?php
	
	function KG_get_curr_user() {
		return KG_Get::get('KG_User', get_current_user_id());
	}
	
	function KG_user_exist_by_id($user_id) {
	    global $wpdb;
    	return (bool) $wpdb->get_var(    		
    			$wpdb->prepare( 'SELECT COUNT(*) FROM '.$wpdb->users.' WHERE ID = %d', (int) $user_id )
    		);
	}

	function KG_get_user_type($user) {

		if ( !is_a($user, 'KG_User') ) return false;

		if($user->is_coach()){
    		return 'coach';
    	} else if($user->is_vip()) {
    		return 'vip';
    	} else if($user->is_cim()) {
    		return 'cim';
    	} else if($user->is_questus()) {
    		return 'questus';
    	} else if($user->is_koda()) {
    		return 'koda';
    	} else {
    		return 'zwykły';
    	}

	}

    function KG_update_user($user_id, $column_name, $value, $format) {
       if( !in_array($column_name, KG_Config::getPublic('columns_user_table') ) ) return;
            
        global $wpdb;
        return $wpdb->update(
            $wpdb->users,
            array(
                $column_name => $value  
            ),
            array(
                'ID' => $user_id
            ),
            (array) $format,
            array('%d')
        ); 
    }
