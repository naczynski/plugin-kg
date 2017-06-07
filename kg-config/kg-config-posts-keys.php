<?php


	/* ==========================================================================
	   SETTINGS PAGE
	   ========================================================================== */

	   /* Change password
	      ========================================================================== */
	   
	    KG_Config::setPublic('change_password_settings_nonce', 'change_password_settings');  

		KG_Config::setPublic('name_current_password', 'curr_password');
		KG_Config::setPublic('name_new_password_01', 'new_password');
		KG_Config::setPublic('name_new_password_02', 'new_password_repeat');

		/* Delete account
		   ========================================================================== */
		
		KG_Config::setPublic('remove_settings_nonce', 'remove_account_settings'); 

		
	/* ==========================================================================
	   REGISTER PAGE
	   ========================================================================== */
	
	