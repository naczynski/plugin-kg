<?php

	class KG_User_Fields_Loop {

		private function get_all_groups_name() {
			return KG_Config::getPublic('fields_groups');
		}

		public function get_register_groups_fields($user_id = null) {
			$out = array();
			foreach ( $this->get_all_groups_name() as $group_name) {			
				$groupInst = KG_Get::Get('KG_User_Group_Fields', $group_name, $user_id );
				if( $groupInst->is_on_register_page()) $out[] = $groupInst;  
			}
			return $out;
		}

		public function get_in_cocpit_groups_fields($user_id = null) {
			$out = array();
			foreach ( $this->get_all_groups_name() as $group_name) {			
				$groupInst = KG_Get::Get('KG_User_Group_Fields', $group_name, $user_id );
				if( $groupInst->is_in_cocpit()) $out[] = $groupInst;  
			}
			return $out;
		}

		public function get_on_my_profile_page_groups_fields($user_id = null) {
			$out = array();
			foreach ( $this->get_all_groups_name() as $group_name) {			
				$groupInst = KG_Get::Get('KG_User_Group_Fields', $group_name, $user_id );
				if( $groupInst->is_on_my_profile_page()) $out[] = $groupInst;  
			}
			return $out;
		}

		public function get_group_fields($group_name, $user_id) {
			return KG_Get::get('KG_User_Group_Fields', $group_name, $user_id );
		}


		public function get_all_groups($user_id = null) {
			$out = array();
			foreach ( $this->get_all_groups_name() as $group_name) {			
				$out[] = KG_Get::Get('KG_User_Group_Fields', $group_name, $user_id );
			}
			return $out;
		}

		public function get_all_groups_json($user_id = null) {
			return json_encode( $this->get_all_groups($user_id) );
		}
		
	}
