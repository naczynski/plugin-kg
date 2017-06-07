<?php

	function KG_Get_Activity_Object($data){
		$activity = apply_filters('kg_get_activity_object', $data);
		return $activity;
	}

	function KG_Add_Activity($data){
		global $wpdb;
		$insert = $wpdb->insert( 
			KG_Config::getPublic('table_users_activities'),
			array(
				'type' => $data['type'],
				'user_id' => $data['user_id'],
				'date' => KG_get_time(),
				'action_id' => $data['action_id'],
				'meta' => json_encode($data['meta']),
				'browser' => $_SERVER['HTTP_USER_AGENT']
			),
			array(
				'%d',
				'%d',
				'%s',
				'%d',
				'%s',
				'%s'
			) 
		);

		if($insert) {
			$activity_id = $wpdb->insert_id;
			do_action('kg_activity_update_status', $data['user_id']);
			return $wpdb->insert_id; 
		} else {
			return false;
		}
	
	}