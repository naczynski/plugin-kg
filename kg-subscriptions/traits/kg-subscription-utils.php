<?php	

	trait KG_Subscription_Utils {

		private function get_curr_date(){
			return Ouzo\Utilities\Clock::now()->format('Y-m-d');
		}

		private function get_curr_date_plus_days($day_to_add){
			return Ouzo\Utilities\Clock::now()->plusDays($day_to_add)->format('Y-m-d');
		}

		private function get_date_plus_days($date, $days_to_add){
			return Ouzo\Utilities\Clock::at($date)->plusDays($days_to_add)->format('Y-m-d');
		}

	}
