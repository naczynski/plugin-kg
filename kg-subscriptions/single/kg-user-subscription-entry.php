<?php


	class KG_User_Subscription_Entry implements JsonSerializable{

		use KG_Subscription_Utils;

		private $data;

		public function __construct($data){
			$this->data = $data;
		}

		public function get_subscription_id(){
			return !empty($this->data['subscr_id']) ? $this->data['subscr_id'] : false;	
		}

		public function is_active(){
			if($this->get_curr_date() == $this->get_end_date()) return true;

			$result1 = Ouzo\Utilities\Clock::now()->isAfter(Ouzo\Utilities\Clock::at($this->get_start_date()));
			$result2 = Ouzo\Utilities\Clock::now()->isBefore(Ouzo\Utilities\Clock::at($this->get_end_date()));
			return $result1 && $result2;
		}

		public function is_future(){
			if($this->is_active()) return false;
			return Ouzo\Utilities\Clock::now()->isBefore(Ouzo\Utilities\Clock::at($this->get_start_date()));
		}
		
		public function is_history(){
			if($this->is_active()) return false;
			return Ouzo\Utilities\Clock::now()->isAfter(Ouzo\Utilities\Clock::at($this->get_start_date()));
		}

		public function get_state(){
			if($this->is_active()) return 'active';
			if($this->is_future()) return 'future';
			if($this->is_history()) return 'history';
			return '';
		}

		public function get_state_label(){
			if($this->is_active()) return __( 'Aktywny', 'kg' );
			if($this->is_future()) return __( 'Oczekuje', 'kg' );
			if($this->is_history()) return __( 'Wyczerpany', 'kg' );
			return '';
		}

		/* ==========================================================================
		   FREE RESOURCES
		   ========================================================================== */
		
		public function get_free_resources_all(){
			return !empty($this->data['resources_all']) ? $this->data['resources_all'] : 0;
		}

		public function get_free_resources_used(){
			return !empty($this->data['resourced_used']) ? (int) $this->data['resourced_used'] : 0;
		}

		public function get_free_resources_remaining(){
			return $this->get_free_resources_all() - $this->get_free_resources_used();
		}

		public function get_percange_free_resources_used(){
			if( $this->get_free_resources_all() == 0) return 0;
			return 100 - ceil( $this->data['resourced_used'] / $this->get_free_resources_all() * 100);
		}

		public function is_all_free_resources_used(){
			return ($this->get_free_resources_remaining() == 0);
		}

		public function is_enable_free_resources(){
			return ($this->get_free_resources_all() > 0);
		}

		public function is_few_free_resources(){
			return ($this->get_free_resources_remaining() < 3);
		}

		public function use_free_resource($resource_id){
			if($this->is_all_free_resources_used()){
				return new WP_Error('not_enought_free_resource', __( 'Wykorzystałeś już swój limit darmowcyh zasobów.', 'kg' ) );
			}
			if(!KG_Get::get('KG_Free_Resources')->can_get_as_free_resource($resource_id)){
				return new WP_Error('not_correct_resource', __( 'Nie możesz użyć tego zasobu jako darmowego.', 'kg' ) );
			}

			global $wpdb;
			
			$update = $wpdb->update( 
				KG_Config::getPublic('table_subscriptions'), 
				array( 
					'resourced_used' => $this->get_free_resources_used() + 1
				), 
				array('id'=> $this->data['id'] ), 
				array('%d'), 
				array('%d') 
			);

			do_action('kg_use_free_resource', $this->data['user_id'], $resource_id, $this->data['id']);

			if($update){
				$this->data['resourced_used']++; 
			}

			return $update;

		}

		/* ==========================================================================
		   DATE
		   ========================================================================== */
		
		public function get_start_date(){
			return !empty($this->data['date_start']) ? $this->data['date_start'] : false;
		}

		public function get_end_date(){
			return !empty($this->data['date_end']) ? $this->data['date_end'] : false;
		}

		public function get_percange_time_elapsed(){
			return ceil( $this->data['resourced_used'] / $this->get_free_resources_all() * 100);
		}

		public function days_from_start(){
    		$datediff = strtotime($this->get_curr_date()) - strtotime($this->get_start_date());
   			return ceil( $datediff / (60*60*24));
		}

		public function days_to_end(){
			if(!$this->is_active()) return 999;

    		$datediff = strtotime($this->get_end_date()) - strtotime($this->get_curr_date());
   			return ceil( $datediff / (60*60*24));
		}

		public function is_close_to_end(){
			return ($this->days_to_end() < 7) ? true : false;
		}

		/* ==========================================================================
		   META
		   ========================================================================== */
		
		public function get_user_id(){
		   	return $this->data['user_id'];
		}

		/* ==========================================================================
		   IS SUBSCRIPTION
		   ========================================================================== */

		public function is_normal_subscription(){
			return $this->get_subscription_id() == KG_Config::getPublic('subscription_normal_id');
		}

		public function is_premium_subscription(){
			return $this->get_subscription_id() == KG_Config::getPublic('subscription_premium_id');
		}


		/* ==========================================================================
		   STATUS
		   ========================================================================== */
		
		public function get_status(){
			return array(
				'free_resources_used' => $this->get_free_resources_used(),
				'free_resources_remaining' => $this->get_free_resources_remaining(),
				'free_resources_all' => $this->get_free_resources_all(),
				'free_resources_percange_used' => $this->get_percange_free_resources_used(),
				'is_all_free_resources_used' => $this->is_all_free_resources_used(),
				'is_few_free_resources' => $this->is_few_free_resources()
			); 		
		}

	   /* ==========================================================================
	   SERIALIZATION
	   ========================================================================== */

		public function jsonSerialize() {	
     		return $this->get_status();		
    	}
	}