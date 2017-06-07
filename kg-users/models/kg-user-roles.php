<?php 

	/**
	 * Manage roles nad caps
	 */
	class KG_User_Roles {

		private function get_formatted_array($array) {
			$out = array();
			foreach ($array as $cap) {	
				$out[$cap] = true;
			}
			return $out;
		}

		public function setAdmin() {

			 $role = get_role( 'administrator' );

			 $caps = array_merge(
				KG_Config::getPublic('kg_user_role_common_admin'),
				KG_Config::getPublic('kg_user_role_administrator'),
				KG_Config::getPublic('kg_user_role_common')
			 );

		 	 foreach ($caps as $cap) {
		 	 	$role->add_cap($cap);
		 	 }

		}

		public function setQuestusAdmin() {

			$caps = array_merge(
				KG_Config::getPublic('kg_user_role_common_admin'),
				KG_Config::getPublic('kg_user_role_questus'),
				KG_Config::getPublic('kg_user_role_common')
			);

			$result = add_role( 'questus-admin' , __('Admin (Questus)', 'kg'), $this->get_formatted_array($caps) );

		}

		public function setCoach() {

			$caps = array_merge(
				KG_Config::getPublic('kg_user_role_common_admin'),
				KG_Config::getPublic('kg_user_role_coach'),
				KG_Config::getPublic('kg_user_role_common')
			);

			add_role( 'coach' , __('Coach', 'kg'), $this->get_formatted_array($caps) );

		}

		public function setVip() {

			$caps = array_merge(
				KG_Config::getPublic('kg_user_role_vip'),
				KG_Config::getPublic('kg_user_role_common')
			);

			add_role( 'vip' , __('VIP', 'kg'), $this->get_formatted_array($caps) );


		}

		public function setCim() {

			$caps = array_merge(
				KG_Config::getPublic('kg_user_role_cim'),
				KG_Config::getPublic('kg_user_role_common')
			);

			add_role( 'cim' , __('CIM', 'kg'), $this->get_formatted_array($caps) );

		}

		public function setDefault() {

			$caps = array_merge(
				KG_Config::getPublic('kg_user_role_default'),
				KG_Config::getPublic('kg_user_role_common')
			);

			add_role( 'default' , __('Zwykły', 'kg'), $this->get_formatted_array($caps) );

		}
	

		/**
		 * Remove default wordpress, buddypress, bbpress, woocommerce roles
		 * @return void
		 */
		public function clear() {

			// wp
			remove_role( 'subscriber' );
			remove_role( 'editor' );
			remove_role( 'author' );
			remove_role( 'contributor' );

			remove_role( 'questus-admin' );
			remove_role( 'vip' );
			remove_role( 'cim' );
			remove_role( 'coach' );
			remove_role( 'default' );

			remove_role('shop_manager');
			remove_role('customer');	
			remove_role('bbp_participant');
			remove_role('bbp_moderator');		
			remove_role('bbp_blocked');
			remove_role('bbp_spectator');		
			remove_role('bbp_keymaster');	
			remove_role('student');	
		
		}
		
		function __construct(){

			$this->clear();
			
			$this->setAdmin();
			$this->setQuestusAdmin();

			$this->setCoach();
			$this->setVip();
			$this->setCim();

			$this->setDefault();

		}
	
	}

?>