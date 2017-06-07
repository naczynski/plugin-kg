<?php
	
	trait KG_User_Trait_Active {

		public function is_active() {
			if(	$this->is_super_user()) return true;
			return (int) $this->get_stat_value('is_active') == 1 ? true : false;
		}

		public function set_active() {
			$res = $this->update_data('is_active', 1, '%d');
			if ($res) {
				$this->user_stats_from_db['is_active'] = 1;
				do_action('kg_user_enable', $this->user_id);
			}

			return $res;
		}

		public function set_not_active($from_cocpit = false) {
			$res = $this->update_data('is_active', 0, '%d');
			if ($res) {
				$this->user_stats_from_db['is_active'] = 0;
				$action_name = $from_cocpit ? 'kg_user_deactive_cocpit' : 'kg_user_deactive_front';
				do_action($action_name, $this->user_id);
			}

			return $res;
		}

	}
