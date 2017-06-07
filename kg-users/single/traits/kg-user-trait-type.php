<?php

	trait KG_User_Trait_Type {

		public function get_type(){
			return implode($this->get_wp_user_object()->roles, '');	
		}

		public function get_pretty_type(){
			switch($this->get_type()){
				case 'cim' : return 'Cim'; break;
				case 'coach' : return 'Coach'; break;
				case 'vip' : return 'Vip'; break;
				case 'default': return 'Zwykły'; break;
				default : return 'Zwykły';
			}
		}

		public function is_super_user(){
			return ($this->is_koda() || $this->is_questus() || $this->is_vip());
		}

		public function show_message_in_cocpit(){
			return ($this->is_questus() || $this->is_koda() ||  $this->is_coach());
		}

		public function is_not_super_user(){
			return !$this->is_super_user();
		}

		public function can_admin() {
			return $this->is_koda() || $this->is_questus();
		}

		/* ==========================================================================
		   COACH
		   ========================================================================== */
		
		public function is_coach() {
			return user_can($this->user_id, 'coach');
		}

		public function set_coach() {
			$res = $this->get_wp_user_object()->set_role('coach');
			do_action('kg_change_type_to_coach', $this->user_id);
			do_action('kg_change_user_type', $this->user_id, 'Coach');
			return $res;
		}

		/* ==========================================================================
		   VIP
		   ========================================================================== */
		
		public function is_vip() {
			return user_can($this->user_id, 'vip');
		}

		public function set_vip() {
			$res = $this->get_wp_user_object()->set_role('vip');
			do_action('kg_change_type_to_vip', $this->user_id);
			do_action('kg_change_user_type', $this->user_id, 'Vip');
			return $res;
		}


		/* ==========================================================================
		   CIM
		   ========================================================================== */

		
		public function is_cim() {	
			return user_can($this->user_id, 'cim');
		}

		public function set_cim() {
			$res = $this->get_wp_user_object()->set_role('cim');
			do_action('kg_change_type_to_cim', $this->user_id);
			do_action('kg_change_user_type', $this->user_id, 'Cim');
			return $res;		
		}

		/* ==========================================================================
		   QUESTUS
		   ========================================================================== */
		

		public function is_questus() {	
			return user_can($this->user_id, 'questus');
		}

		public function set_questus() {
			$res = $this->get_wp_user_object()->set_role('questus');
			do_action('kg_change_type_to_questus', $this->user_id);
			do_action('kg_change_user_type', $this->user_id, 'Questus');
			return $res;
		}


		/* ==========================================================================
		   KODA (ADMIN)
		   ========================================================================== */
		
		public function is_koda() {
			return user_can($this->user_id, 'administrator');
		}

		public function set_koda() {
			$res = $this->get_wp_user_object()->set_role('administrator');
			do_action('kg_change_type_to_koda', $this->user_id);
			do_action('kg_change_user_type', $this->user_id, 'Administrator');
			return $res;
		}

		/* ==========================================================================
		   DEFAULT
		   ========================================================================== */
		
		public function is_default() {		
			return user_can($this->user_id, 'default');
		}

		public function set_default() {
			$res = $this->get_wp_user_object()->set_role('default');
			do_action('kg_change_type_to_default', $this->user_id);
			do_action('kg_change_user_type', $this->user_id, 'Zwykły');
			return $res;
		}

	}