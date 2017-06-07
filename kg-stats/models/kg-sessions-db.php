<?php

	class KG_Sessions_Db {

		public function __construct(){
			add_action('kg_correct_authenticate', array($this, 'end_current_session'), 1, 0);
			add_action('kg_correct_authenticate', array($this, 'create_session_in_db'), 2, 2);

			add_action('clear_auth_cookie', array($this, 'end_current_session'), 1, 0);
			add_action('kg_increase_user_stat_data', array($this, 'increase_current_session_actions_numbers'), 1, 2);
			add_action('kg_payment_complete', array($this, 'increse_sum_donations'), 1, 1);
		}

		public function end_current_session(){
			global $wpdb, $current_user;
			$table = KG_Config::getPublic('table_sessions');
			$ret = $wpdb->query( $wpdb->prepare( 
				"UPDATE {$table} 
				SET date_end = %s , time_spent = TIMEDIFF(%s, date_start)
				WHERE user_id = %d AND browser = %s;", 
				KG_get_time(),
				KG_get_time(),
				$current_user->ID, 
				$_SERVER['HTTP_USER_AGENT']
			));
			do_action('kg_close_session', $current_user->ID, $this->get_last_session_time_spent($current_user->ID));
		}

		public function get_last_session_time_spent($user_id){
			global $wpdb;
			return $wpdb->get_var(
				$wpdb->prepare(
					"SELECT time_spent FROM " .
					KG_Config::getPublic('table_sessions') .
					" WHERE user_id = %d AND time_spent IS NOT NULL
					 ORDER BY date_end DESC ",
					 $user_id
					)
			);			
		}

		public function create_session_in_db($user_id, $kg_user){
			global $wpdb;
			$wpdb->insert( 
				KG_Config::getPublic('table_sessions'), 
				array( 
					'user_id' => $user_id,
					'date_start' => KG_get_time(),
					'have_subscription' => (int) $kg_user->is_have_active_subscription(),
					'browser' => $_SERVER['HTTP_USER_AGENT']
				), 
				array( 
					'%d', 
					'%s',
					'%d',
					'%s'
				) 
			);
		}

		public function increse_sum_donations($transaction_obj){
			global $wpdb;
			$table = KG_Config::getPublic('table_sessions');
			$wpdb->query( $wpdb->prepare( 
				"UPDATE {$table} 
				SET spent_money = spent_money + %d
				WHERE user_id = %d AND browser = %s", 
				$transaction_obj->get_total_brutto(),
				$transaction_obj->get_user_id(), 
				$_SERVER['HTTP_USER_AGENT']
			));		
		}

		public function increase_current_session_actions_numbers($user_id, $column_name){
			global $wpdb, $current_user;
			$table = KG_Config::getPublic('table_sessions');
			$wpdb->query( $wpdb->prepare( 
				"UPDATE {$table} 
				SET actions = actions + 1
				WHERE user_id = %d AND browser = %s", 
				$user_id, 
				$_SERVER['HTTP_USER_AGENT']
			));			
		}

	}