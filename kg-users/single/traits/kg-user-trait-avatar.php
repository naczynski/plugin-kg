<?php

	trait KG_User_Trait_Avatar {

		public function set_avatar($file_name) {
			do_action('kg_change_avatar', $this->user_id);
			$this->update_data('avatar_file_name', $file_name, '%s');		
		}

		public function reset_avatar() {
			return $this->update_data('avatar_file_name', null, '%s');
		}

		public function get_avatar() {
			$avatar_file_name = $this->get_stat_value('avatar_file_name') ?  $this->get_stat_value('avatar_file_name') : 'default_avatar.jpg';
			return KG_Get::get('KG_User_Avatars')->get_avatar_url($avatar_file_name);
		}

	}