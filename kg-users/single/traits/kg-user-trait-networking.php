<?php 

	trait KG_User_Trait_Networking {

		public function can_networking() {
			if(	$this->is_super_user()) return true;
			return (int) $this->get_stat_value('is_networking') == 1 ? true : false;
		}

		public function set_can_networking() {
			$res = $this->update_data('is_networking', 1, '%d');
			if ($res) {
				$this->user_stats_from_db['is_networking'] = 1;
				do_action('kg_enable_networking', $this->user_id);
			}

			return $res;
		}

		public function set_not_can_networkig() {
			$res = $this->update_data('is_networking', 0, '%d');
			if ($res) {
				$this->user_stats_from_db['is_networking'] = 0;
				do_action('kg_disable_networking', $this->user_id);
			}

			return $res;
		}

	}

?>