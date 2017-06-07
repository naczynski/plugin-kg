<?php

	trait KG_Item_Trait_Likes {

		public function number_likes() {
			return $this->get_stat_value('sum_likes');
		}

		public function is_user_like($user_id) {
			return KG_Get::get('KG_Likes')->is_liked_by_user($this->id, $user_id);
		}

		public function like($user_id) {
			return KG_Get::get('KG_Likes')->like($this->id, $user_id);
		}

		public function remove_like($user_id) {
			return KG_Get::get('KG_Likes')->remove_like($this->id, $user_id);
		}

	}