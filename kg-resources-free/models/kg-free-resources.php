<?php

	class KG_Free_Resources {


		private $resources_available_ids;

		public function get_list_of_available(){
			if( !empty($this->resources_available_ids) ) return $this->resources_available_ids;

			$ids = get_field('free_resources', 'option');

			$this->resources_available_ids = ( !empty($ids) ) ? $ids : array();
			return $this->resources_available_ids;
		}

		public function can_get_as_free_resource($resource_id) {
			if ( !(KG_get_resource_object($resource_id)->can_buy()) ) return false;

			$active_subscription = KG_get_curr_user()->get_current_subscription();

			if(!$active_subscription) return false;
			if( !$active_subscription->is_enable_free_resources()) return false;
			if($active_subscription->is_all_free_resources_used()) return false;	
	
			return in_array($resource_id, $this->get_list_of_available());
		}

	}