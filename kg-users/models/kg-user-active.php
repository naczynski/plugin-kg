<?php

	/**
	 * Activate / Deactivate User
	 */
	class KG_User_Active {

	
		public function set_user_not_active($user_id, $from_cocpit = false) {

			$res = update_user_meta( $user_id, KG_Config::getPublic('user_deactivate') , 'true' );

			if($res){
				$action_name = $from_cocpit ? 'kg_user_deactive_cocpit' : 'kg_user_deactive_front';
				do_action($action_name, $user_id);
			}

			return $res;

		}


	}