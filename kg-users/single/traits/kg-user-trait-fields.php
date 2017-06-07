<?php

	trait KG_User_Trait_Fields{


		public function get_all_group_fields() {
			return KG_Get::get('KG_User_Fields_Loop')->get_all_groups($this->user_id);
		}

		public function get_in_cocpit_groups_fields() {
			return KG_Get::get('KG_User_Fields_Loop')->get_in_cocpit_groups_fields($this->user_id);
		}

		public function get_on_my_profile_page_groups_fields() {
			return KG_Get::get('KG_User_Fields_Loop')->get_on_my_profile_page_groups_fields($this->user_id);
		}

		public function get_field_group($name) {
			return KG_Get::get('KG_User_Group_Fields', $name, $this->user_id);
		}

		public function get_field($name) {
			return KG_Get::get('KG_User_Field', $name, $this->user_id)->get_value();
		}

		/* ==========================================================================
		   NAME
		   ========================================================================== */
		
		public function get_name() {
			if ($this->is_questus() ) return 'questus';
			return KG_Get::get('KG_User_Field', 'kg_field_name', $this->user_id)->get_value();
		}

		public function set_name($name) {
			return KG_Get::get('KG_User_Field', 'kg_field_name', $this->user_id)->set_value($name);
		}		

		/* ==========================================================================
		   SURNAME
		   ========================================================================== */
		
		public function get_surname() {
			if ($this->is_questus() ) return '';
			return KG_Get::get('KG_User_Field', 'kg_field_surname', $this->user_id)->get_value();
		}

		public function set_surname($surname) {
			return KG_Get::get('KG_User_Field', 'kg_field_surname', $this->user_id)->set_value($surname);
		}

		/* ==========================================================================
		   SURNAME
		   ========================================================================== */
		

		public function get_job() {
			return KG_Get::get('KG_User_Field', 'kg_field_job', $this->user_id)->get_value();
		}


		public function set_job($job) {
			return KG_Get::get('KG_User_Field', 'kg_field_job', $this->user_id)->set_value($job);
		}


		public function get_trade() {
			return KG_Get::get('KG_User_Field', 'kg_field_trade', $this->user_id)->get_value();
		}

		public function set_trade($trade) {
			return KG_Get::get('KG_User_Field', 'kg_field_trade', $this->user_id)->set_value($trade);
		}

		public function get_job_and_trade(){
			return $this->get_job() . ', ' . $this->get_trade();
		}

		/* ==========================================================================
		   NAME & SURNAME
		   ========================================================================== */
	
		
		public function get_name_and_surname() {
			return $this->get_name() . ' ' . $this->get_surname();
		}


	}