<?php

	/* ==========================================================================
	   RESOURCE PAGE
	   ========================================================================== */

	function KG_is_resource_page() {
		if( is_singular('quiz') ||  is_singular('task')) return false;
		return is_page( KG_Config::getPublic('recources_page_id') ) || is_single() ;
	}

	function KG_get_active_resource_page() {
		return ( KG_is_resource_page() ) ? 'active' : '';
	}

	/* ==========================================================================
	   MY RESOURCES
	   ========================================================================== */

	function KG_is_my_resources_page() {
		return is_page( KG_Config::getPublic('my_resources_page_id') );
	}

	function KG_get_active_my_resource_page() {
		return( KG_is_my_resources_page() ) ? 'active' : '';
	}

   /* ==========================================================================
   SETTINGS
   ========================================================================== */

	function KG_is_settings_page() {
		return is_page( KG_Config::getPublic('setting_page_id') );
	}

	function KG_get_active_settings_page() {
		return ( KG_is_settings_page() ) ? 'active' : '';
	}

    /* ==========================================================================
   PROFILE
   ========================================================================== */

	function KG_is_profile_page() {
		return is_page( KG_Config::getPublic('my_profile_page_id') );
	}

	function KG_get_active_profile_page() {
		return ( KG_is_profile_page() ) ? 'active' : '';
	}

	/* ==========================================================================
	   LOGIN
	   ========================================================================== */
	
	function KG_is_register_page() {
		return is_page( KG_Config::getPublic('register_page_id') );
	}

	/* ==========================================================================
   FINALIZE
   ========================================================================== */

	function KG_is_finalize_page() {
		return is_page( KG_Config::getPublic('finalize_order_page_id') );
	}

	function KG_get_active_finalize_page() {
		return ( KG_is_finalize_page() ) ? 'active' : '';
	}

	/* ==========================================================================
   TASKS
   ========================================================================== */

	function KG_get_active_task_tab(){
		// echo ( is_page( KG_Config::getPublic('quizes_page_id') ) || is_singular('quiz') ) ? 'active' : '.';
	}

	/* ==========================================================================
	   CURRENT PAGE
	   ========================================================================== */
	
	function KG_get_curr_page_name(){
		if(KG_is_my_resources_page()){
			return 'my-resources';
		}
		if(KG_is_finalize_page()){
			return 'finalize';
		}
		return 'page';
	}

