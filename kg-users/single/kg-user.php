<?php

	/**
	 * User object
	 */
	class KG_User implements JsonSerializable {

		protected $user_id;
		protected $wp_user;

		public function __construct($user = null) {
			if( is_a($user, 'WP_User') ) {
				$this->wp_user = $user;
				$this->user_id = $this->wp_user->ID;
				return;
			}
			$this->user_id = $user;	
		}

		public function get_wp_user_object() {
			if( empty($this->wp_user) ) {
				$this->wp_user = new WP_User($this->user_id);
			}

			return $this->wp_user;
		}

		private function update_data($column_name, $value, $format){
			return KG_update_user($this->user_id, $column_name, $value, $format);
		}

		public function get_ID(){
			return $this->get_wp_user_object()->ID;
		}

		/* ==========================================================================
		   AVATARS
		   ========================================================================== */
		
		use KG_User_Trait_Avatar;

		/* ==========================================================================
		   EMAIL ACTIVATION
		   ========================================================================== */
		
		use KG_User_Trait_Email_Activation;	

		/* ==========================================================================
		   USER ACTIVE (DELETE)
		   ========================================================================== */
		
		use KG_User_Trait_Active;

		/* ==========================================================================
		   NETWORKING
		   ========================================================================== */
		
		use KG_User_Trait_Networking;	
		
		/* ==========================================================================
		   EMAIL
		   ========================================================================== */
		
		use KG_User_Trait_Email;

		/* ==========================================================================
		   DEFAUTL FIELDS
		   ========================================================================== */
	
		use KG_User_Trait_Fields;


		/* ==========================================================================
		   TYPE
		   ========================================================================== */
		
		use KG_User_Trait_Type;


		/* ==========================================================================
		   SUBSCRIPTIONS
		   ========================================================================== */
		
		use KG_User_Trait_Subscriptions;

		/* ==========================================================================
	   		STATS
	   		========================================================================== */
		
		use KG_User_Trait_Stats;


		/* ==========================================================================
		   SERIALIZATION
		   ========================================================================== */
		
		use KG_User_Trait_Serialization;


		/* ==========================================================================
		   PAYU
		   ========================================================================== */

		public function get_payu_data() {
			return array(
				'email' => $this->get_email(),
				'firstName' => $this->get_name(),
				'lastName' => $this->get_surname()
			);
		}

		/* ==========================================================================
   	   MESSAGES
   	   ========================================================================== */

	   	public function sent_message($message){
	   		$message_obj = KG_Get::get('KG_Single_Message', 
				get_current_user_id(),
				$this->user_id,
				$message
			);

			return $message_obj->sent();
	   	}

		public function get_edit_page(){
			if($this->can_admin()) return '';
			return KG_Get::get('KG_Cocpit_Edit_Student')->get_url($this->user_id);
		} 
		
	}