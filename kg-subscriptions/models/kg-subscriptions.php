<?php

	class KG_Subscriptions {

		use KG_Subscription_Utils;

		private $current_subscriptions = array();
		private $add_hook_label = '';

		public function get_all_available_subscriptions(){
			$query = new WP_Query(array(
				'post_type' => 'subscription',
				'post_per_page' => -1
			));
			$subscriptions = $query->get_posts();

			$out = array();
			foreach ($subscriptions as $subscription) {
				$out[] = KG_Get::get('KG_Item_Subscription', $subscription->ID);
			}
			return $out;
		}

		public function get_all_user_subscriptions($user_id){
			global $wpdb;
			$subscr = $wpdb->get_results( 
				$wpdb->prepare(
					  "SELECT * FROM " . 
					   KG_Config::getPublic('table_subscriptions') . 
					  " WHERE user_id = %d" . 
					  " ORDER BY date_end DESC", 
				  (int)$user_id
			   	  ),
				ARRAY_A 
			);
		 	if(!$subscr)  return array();

		 	$out = array();
		 	foreach ($subscr as $single_subscription_data) {
		 		$out[] =  KG_Get::get('KG_User_Subscription_Entry', $single_subscription_data);
		 	}
		 	return $out;
		}
	
		public function is_user_have_active_subscription($user_id){
			return $this->get_current_subscription_object($user_id) == false ? false : true;
		}

		public function clear_cache(){
			$this->current_subscription = null;
		}

		public function get_current_subscription_object($user_id){
			if(!empty($this->current_subscription[$user_id])) return $this->current_subscription[$user_id]; 

			global $wpdb;
			$subscr = $wpdb->get_row( 
				$wpdb->prepare(
					  "SELECT * FROM " . 
					   KG_Config::getPublic('table_subscriptions') . 
					  " WHERE user_id = %d AND" . 
					  " %s BETWEEN date_start and date_end", 
				  (int)$user_id, 
				  $this->get_curr_date()
			   	  ),
				ARRAY_A 
			); 

			if($subscr) {
				$this->current_subscription[$user_id] = KG_Get::get('KG_User_Subscription_Entry', $subscr);
				return $this->current_subscription[$user_id];
			} else {
				return false;
			}

		}


		/* ==========================================================================
		   DATA ABOUT ALL SUBSCRIPTIONS
		   ========================================================================== */
		

		public function get_days_to_end_all_subscriptions($user_id){
			if( !$this->is_user_have_active_subscription($user_id) ) return 0;
			$datediff = strtotime( $this->get_date_end_all_subscriptions($user_id) ) - strtotime( $this->get_curr_date() );
   			return ceil( $datediff / (60*60*24));
		}

		public function get_date_start_all_subscriptions($user_id){
			$subscr_obj =  $this->get_current_subscription_object($user_id);
			return $subscr_obj->get_start_date();
		}


		private function get_subscriptions_sum_days($user_id){
			$datediff = strtotime($this->get_date_end_all_subscriptions($user_id)) - strtotime($this->get_date_start_all_subscriptions($user_id));
   			return ceil( $datediff / (60*60*24)); 
		}


		public function get_time_elapsed_in_percange_for_all_subscriptions($user_id){
		
			if( !$this->is_user_have_active_subscription($user_id) ) return 100; 
 
   			$days_from_start = $this->get_current_subscription_object($user_id)->days_from_start();
   			$ret = ($days_from_start / $this->get_subscriptions_sum_days($user_id) ) * 100;
   			return 100 - ceil($ret);
		}	

		public function get_date_end_all_subscriptions($user_id){
			global $wpdb;
			$max = $wpdb->get_var( 
				$wpdb->prepare(
					  "SELECT MAX(date_end) FROM " . 
					   KG_Config::getPublic('table_subscriptions') . 
					  " WHERE user_id = %d ",
				  	(int)$user_id
			   	)
			);
			return $max;
		}

		/* ==========================================================================
		   ADD
		   ========================================================================== */
		
		private function get_start_date_for_new_subscription($user_id){
			return ( $this->is_user_have_active_subscription($user_id) ) ? 
				$this->get_date_plus_days(
					$this->get_date_end_all_subscriptions($user_id), 1
					) :
				$this->get_curr_date() ;
		}

		private function get_end_date_for_new_subscription($date_start, $days_remaining){
			return Ouzo\Utilities\Clock::at($date_start)->plusDays($days_remaining)->format('Y-m-d');
		}

		private function add_to_db($data){
			global $wpdb;
			$insert = $wpdb->insert( 
				KG_Config::getPublic('table_subscriptions'),
				$data,
				array( '%d', '%d', '%s', '%s', '%d', '%d') 
			);

			return $insert ? $wpdb->insert_id : false;
		}

		public function get_subscription_entry_obj_from_data($subscription_object, $user_id){

			if ( !is_a($subscription_object, 'KG_Item_Subscription') ){
				return new WP_Error('no_kg_item_object', __( 'Musisz przekazać obiekt "KG_Item_Subscription"', 'kg' ) );
			}

			$days_durations = $subscription_object->get_days_durations();
			$free_resources = $subscription_object->get_how_many_free_resources();
			$subscr_id = $subscription_object->get_ID();

			$date_start = $this->get_start_date_for_new_subscription($user_id);
			$date_end = $this->get_end_date_for_new_subscription($date_start, $days_durations);

			return KG_Get::get('KG_User_Subscription_Entry', array(
				'subscr_id' => $subscr_id,
				'user_id' => $user_id,
				'date_start' => $date_start,
				'date_end' => $date_end,
				'resourced_used' => 0,
				'resources_all' => $free_resources
			));

		}


		/* ==========================================================================
		   ASSIGN
		   ========================================================================== */
		
		public function add_from_cocpit($subscription_object, $user_id){
			$this->add_hook_label = 'kg_assing_subscription_cocpit';
			$this->add($subscription_object, $user_id);
		}

		public function add_from_front($subscription_object, $user_id){
			$this->add_hook_label = 'kg_assing_subscription_front';
			$this->add($subscription_object, $user_id);
		}

		public function add($subscription_object, $user_id){
			if ( !is_a($subscription_object, 'KG_Item_Subscription') ){
				return new WP_Error('no_kg_item_object', __( 'Musisz przekazać obiekt "KG_Item_Subscription"', 'kg' ) );
			}

			$days_durations = $subscription_object->get_days_durations();
			$free_resources = $subscription_object->get_how_many_free_resources();
			$subscr_id = $subscription_object->get_ID();

			$date_start = $this->get_start_date_for_new_subscription($user_id);
			$date_end = $this->get_end_date_for_new_subscription($date_start, $days_durations);

			$added = $this->add_to_db(array(
				'subscr_id' => $subscr_id,
				'user_id' => $user_id,
				'date_start' => $date_start,
				'date_end' => $date_end,
				'resourced_used' => 0,
				'resources_all' => $free_resources
			));

			$subscription_entry = KG_Get::get('KG_User_Subscription_Entry', array(
				'subscr_id' => $subscr_id,
				'user_id' => $user_id,
				'date_start' => $date_start,
				'date_end' => $date_end,
				'resourced_used' => 0,
				'resources_all' => $free_resources
			));

			do_action('kg_add_subscription', $subscription_object , $subscription_entry, $user_id );
			do_action($this->add_hook_label, $user_id,  $subscription_entry, $subscription_object);
			return $subscription_entry;

		}

	}