<?php

	function KG_Get_Alert_Object($data){
		$alert = apply_filters('kg_get_alert_object', $data);
		return $alert;
	}

	function KG_Add_Alert($data){
		global $wpdb;
		$insert = $wpdb->insert( 
			KG_Config::getPublic('table_alerts'),
			array(
				'type' => $data['type'],
				'user_id' => $data['user_id'],
				'is_readed' => 0,
				'date' => KG_get_time(),
				'action_id' => $data['action_id']
			),
			array(
				'%d',
				'%d',
				'%d',
				'%s',
				'%s'
			) 
		);

		if($insert) {
			$alert_id = $wpdb->insert_id;
			do_action('kg_alert_update_status', $data['user_id']);
			return $alert_id; 
		} else {
			return false;
		}
	
	}
