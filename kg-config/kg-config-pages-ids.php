<?php

	if( KG_is_production()) {
		
		KG_Config::setPublic('login_page_id', 10) ;
		KG_Config::setPublic('register_page_id', 45) ;
		KG_Config::setPublic('recover_password_page_id', 105) ;
		KG_Config::setPublic('recources_page_id', 43) ;
		KG_Config::setPublic('my_resources_page_id', 314) ;
		KG_Config::setPublic('download_fule_page_id', 317) ;
		KG_Config::setPublic('users_page_id', 818) ;
		KG_Config::setPublic('activation_page_id', 16) ;
		KG_Config::setPublic('setting_page_id', 740) ;
		KG_Config::setPublic('my_profile_page_id', 738) ;
		KG_Config::setPublic('finalize_order_page_id', 829) ;
		KG_Config::setPublic('my_trasaction_page_id', 831) ;
		KG_Config::setPublic('extend_subscription_page_id', 833) ;	

		KG_Config::setPublic('faq_page_id', 981) ;	
		
		KG_Config::setPublic('quizes_page_id', 872) ;

		KG_Config::setPublic('my_tasks_page_id', 983) ;

		KG_Config::setPublic('sent_payment', 874) ;
		KG_Config::setPublic('payment_gateway', 835) ;
		KG_Config::setPublic('change_payment_status', 877) ;	
	

	} else if( KG_is_develop() ) {

		KG_Config::setPublic('login_page_id', 10) ;
		KG_Config::setPublic('register_page_id', 45) ;
		KG_Config::setPublic('recover_password_page_id', 105) ;
		KG_Config::setPublic('recources_page_id', 43) ;
		KG_Config::setPublic('my_resources_page_id', 314) ;
		KG_Config::setPublic('download_fule_page_id', 317) ;
		KG_Config::setPublic('users_page_id', 747) ;
		KG_Config::setPublic('activation_page_id', 16) ;
		KG_Config::setPublic('setting_page_id', 740) ;
		KG_Config::setPublic('my_profile_page_id', 738) ;
		KG_Config::setPublic('finalize_order_page_id', 764) ;
		KG_Config::setPublic('my_trasaction_page_id', 762) ;
		KG_Config::setPublic('extend_subscription_page_id', 749) ;	
		KG_Config::setPublic('quizes_page_id', 848) ;
		KG_Config::setPublic('faq_page_id', 930) ;	

		KG_Config::setPublic('my_tasks_page_id', 910) ;

		KG_Config::setPublic('sent_payment', 868) ;
		KG_Config::setPublic('payment_gateway', 772) ;
		KG_Config::setPublic('change_payment_status', 865) ;

	} else {

		KG_Config::setPublic('login_page_id', 10) ;
		KG_Config::setPublic('register_page_id', 45) ;
		KG_Config::setPublic('recover_password_page_id', 105) ;
		KG_Config::setPublic('recources_page_id', 43) ;
		KG_Config::setPublic('my_resources_page_id', 314) ;
		KG_Config::setPublic('download_fule_page_id', 317) ;
		KG_Config::setPublic('users_page_id', 747) ;
		KG_Config::setPublic('activation_page_id', 16) ;
		KG_Config::setPublic('setting_page_id', 740) ;
		KG_Config::setPublic('my_profile_page_id', 738) ;
		KG_Config::setPublic('finalize_order_page_id', 764) ;
		KG_Config::setPublic('my_trasaction_page_id', 762) ;
		KG_Config::setPublic('extend_subscription_page_id', 749) ;	
		KG_Config::setPublic('quizes_page_id', 895) ;
		KG_Config::setPublic('faq_page_id', 1041) ;	
		
		KG_Config::setPublic('my_tasks_page_id', 1031) ;

		KG_Config::setPublic('sent_payment', 914) ;
		KG_Config::setPublic('payment_gateway', 772) ;
		KG_Config::setPublic('change_payment_status', 865) ;
	}

	KG_Config::setPublic('restricted_pages', array(
		KG_Config::getPublic('recources_page_id')
	)) ;

	KG_Config::setPublic('not_for_logged_in_pages', array(
		KG_Config::getPublic('login_page_id'),
		KG_Config::getPublic('register_page_id') ,
		KG_Config::getPublic('recover_password_page_id'),
		KG_Config::getPublic('activation_page_id')
	)) ;
	
