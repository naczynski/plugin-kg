<?php

	class KG_Resources_Stats {

		public function __construct(){	
			add_action('kg_use_free_resource', array($this, 'increase_choose_from_free'), 1, 3);
			add_action('kg_sent_present', array($this, 'increase_sum_presents'), 1, 1);
			add_action('kg_buy_resource', array($this, 'increase_sum_bought'), 1, 1);
			
			// awards
			add_action('kg_task_assign_award', array($this, 'increase_sum_as_task_award'), 1, 1);
			add_action('kg_quiz_assign_award', array($this, 'increase_sum_as_quiz_award'), 1, 1);

			// likes
			add_action('kg_resource_like', array($this, 'increase_sum_likes'), 10, 3);
			add_action('kg_remove_like', array($this, 'decrease_sum_likes'), 10, 2);
			add_action('kg_download_resource', array($this, 'insrese_actions'), 10, 2);
		}

		private function increse_resource_stat_data($resource_id, $column_name, $how_many = 1){
			do_action('kg_increase_resources_stat_data', $resource_id, $column_name);
			if( !in_array($column_name, KG_Config::getPublic('columns_posts_table') ) ) return;

			global $wpdb;
			return $wpdb->query( $wpdb->prepare( 
				"UPDATE {$wpdb->posts} SET {$column_name} = {$column_name} + %d WHERE `ID` = %d", 
				$how_many, 
				$resource_id 
			));
		}
		
		public function increase_choose_from_free($user_id, $resource_id, $subscription_id){
			return $this->increse_resource_stat_data($resource_id, 'sum_choose_as_free');
		}

		public function increase_sum_presents($present_order_obj){
			return $this->increse_resource_stat_data($present_order_obj->get_resource()->get_ID(), 'sum_as_present');
		}

		public function increase_sum_bought($resource_order_obj){
			return $this->increse_resource_stat_data($resource_order_obj->get_resource()->get_ID(), 'sum_bought');
		}

		public function increase_sum_as_task_award($task_response_obj){
			return $this->increse_resource_stat_data($task_response_obj->get_award_resource()->get_ID(), 'sum_choose_as_task_award');
		}

		public function increase_sum_as_quiz_award($solve_obj){
			return $this->increse_resource_stat_data($solve_obj->get_award_resource()->get_ID(), 'sum_choose_as_quiz_award');
		}

		public function increase_sum_likes($user_id, $resource_id, $like_id){
			return $this->increse_resource_stat_data($resource_id, 'sum_likes', 1);
		}

		public function decrease_sum_likes($resource_id, $user_id){
			return $this->increse_resource_stat_data($resource_id, 'sum_likes', -1);
		}

		public function insrese_actions($user_id, $resource_id){
			return $this->increse_resource_stat_data($resource_id, 'sum_actions', 1);
		}
	}