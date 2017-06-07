<?php

	class KG_User_Stats {

		public function __construct(){	
			add_action('kg_solve_quiz', array($this, 'increase_sum_quiz_results'), 1, 1);
			add_action('kg_add_response_to_task', array($this, 'increase_sum_tasks_responses'), 1, 2);
			add_action('kg_resource_like', array($this, 'increase_sum_likes_resources'), 1, 3);
			add_action('kg_like_task_response', array($this, 'increase_sum_likes_responses'), 1, 2);
			add_action('kg_correct_authenticate', array($this, 'increase_sum_log_in'), 1, 2);
			add_action('kg_download_resource', array($this, 'increase_sum_downloads'), 1, 2);
			add_action('kg_sent_message', array($this, 'increse_sum_message'), 1, 1);
			add_action('kg_close_session', array($this, 'increse_time_spend'), 1, 2);	
			add_action('kg_correct_authenticate', array($this, 'add_last_logged_date'), 1, 2);

			add_action('kg_payment_complete', array($this, 'increse_sum_donations'), 1, 1);
			add_action('kg_payment_complete', array($this, 'increase_sum_presents'), 1, 1);	

		}

		private function update_data($user_id, $column_name, $value, $format){
			return KG_update_user($user_id, $column_name, $value, $format);
		}

		private function increse_user_stat_data($user_id, $column_name, $how_many = 1){
			do_action('kg_increase_user_stat_data', $user_id, $column_name);
			if( !in_array($column_name, KG_Config::getPublic('columns_user_table') ) ) return;
			global $wpdb;
			return $wpdb->query( $wpdb->prepare( 
				"UPDATE {$wpdb->users} SET {$column_name} = {$column_name} + %d WHERE `ID` = %d", 
				$how_many, 
				$user_id 
			));
		}

		public function increase_sum_downloads($user_id, $resource_id){
			return $this->increse_user_stat_data($user_id, 'sum_downloads');
		}

		public function increase_sum_log_in($user_id, $kg_user){
			return $this->increse_user_stat_data($user_id, 'sum_log_in');
		}

		public function increse_time_spend($user_id, $time_spent){
			global $wpdb;
			return $wpdb->query( $wpdb->prepare( 
				"UPDATE {$wpdb->users} SET sum_time_spent = ADDTIME(sum_time_spent, %s) WHERE `ID` = %d", 
				$time_spent,
				$user_id 
			));
		}

		public function add_last_logged_date($user_id, $kg_user){
			return $this->update_data( $user_id, 'last_logged', KG_get_time(), '%s'); 
		}

		public function increse_sum_donations($transaction_obj){
			return $this->increse_user_stat_data($transaction_obj->get_user_id(), 'sum_donations', $transaction_obj->get_total_brutto());	
		}

		public function increse_sum_message($message_obj){
			return $this->increse_user_stat_data($message_obj->get_from_user_id(), 'sum_messages');
		}

		public function increase_sum_likes_resources($user_id, $resource_id, $like_id ){
			return $this->increse_user_stat_data($user_id, 'sum_likes_resources');
		}

		public function increase_sum_likes_responses($user_id, $task_response_obj){
			return $this->increse_user_stat_data($user_id, 'sum_likes_tasks_responses');
		}

		public function increase_sum_quiz_results($kg_quiz_solve_obj){
			return $this->increse_user_stat_data($kg_quiz_solve_obj->get_user_id(), 'sum_quiz_results');
		}

		public function increase_sum_tasks_responses($kg_task_obj, $kg_task_response){
			return $this->increse_user_stat_data($kg_task_response->get_user_id(), 'sum_task_responses');
		}

		public function increase_sum_presents($transaction_obj){
			return $this->increse_user_stat_data($transaction_obj->get_user_id(), 'sum_presents', $transaction_obj->get_count_presents());
		}

	}