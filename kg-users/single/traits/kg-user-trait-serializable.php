<?php

	trait KG_User_Trait_Serialization {

		public function jsonSerialize() {
        	
			return array(
				'name' => $this->get_name_and_surname(),
				'type' => $this->get_type(),
				'desc' => $this->get_job_and_trade(),
				'avatar' => $this->get_avatar(),
				'id' => $this->get_ID(),
				'isHavePremiumSubscription' => $this->is_have_premium_subscription(),
				'lastLogged' => $this->get_last_login_formatted()
			);

   		 }	
   		  
	}