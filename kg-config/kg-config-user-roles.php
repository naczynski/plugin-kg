<?php


	/* ==========================================================================
	   COMMON
	   ========================================================================== */
	
	KG_Config::setPublic('kg_user_role_common', array(
		
		'buy_resource',
		'like_resource',
		'get_resources',
		'modify_own_field',
		'change_own_password',
		'deactive_own_account',
		'send_present',

		'get_resources_lightbox',
		'sent_message',
		'get_messages',

		'set_alert_as_readed',

		'update_fields',

		'check_quiz',
		'choose_award_quiz',

		'task_get_responses'

	));

	KG_Config::setPublic('kg_user_role_common_admin', array(
		
		//default wordpress

        'edit_users' ,
        'edit_files' ,
        'manage_categories' ,
        'upload_files' ,
        'edit_posts' ,
        'edit_others_posts' ,
        'edit_published_posts' ,
        'publish_posts' ,
        'edit_pages' ,
        'read' ,
        'edit_others_pages' ,
        'edit_published_pages' ,
        'publish_pages' ,
        'delete_pages' ,
        'delete_published_pages' ,
        'delete_posts' ,
        'delete_others_posts' ,
        'delete_published_posts' ,
        'delete_private_posts' ,
        'edit_private_posts' ,
        'read_private_posts' ,
        'delete_private_pages' ,
        'edit_private_pages' ,
        'read_private_pages' ,
        'delete_users' ,
        'create_users' ,
        'edit_user' ,
        'unfiltered_upload' ,
        'edit_dashboard' ,
        'list_users' ,
        'remove_users ' ,
        'add_users' ,
        'promote_users' ,

        'unfiltered_html',

        // kg

	    'edit_kg_user',
	    'add_kg_user',

	    'modify_own_field',
	    'send_cocpit_present',
	    'add_subscription',

	    'remove_relation',

	    'sent_message_group',
	    'sent_message_to_all',

	    'show-responses',
	    'remove-response',

	    'quiz_result',

	    'stat-user-table',

	    'show-transactions',

	    'show-task-response-cocpit'

	));

	/* ==========================================================================
	   ADMINISTRATOR (KODA)
	   ========================================================================== */


	KG_Config::setPublic('kg_user_role_administrator', array(
		'koda',
		'maintance_actions'
	));

	/* ==========================================================================
	   QUESTUS
	   ========================================================================== */
	

	KG_Config::setPublic('kg_user_role_questus', array(
		
		'questus',

	));


	/* ==========================================================================
	   COACH
	   ========================================================================== */

	KG_Config::setPublic('kg_user_role_coach', array(

		'coach',
		'edit_kg_user'
	
	));


	/* ==========================================================================
	   CIM
	   ========================================================================== */
	

	KG_Config::setPublic('kg_user_role_cim', array(

		'cim',
		'show-cim-category'
		
	));


	/* ==========================================================================
	   VIP
	   ========================================================================== */
	
	KG_Config::setPublic('kg_user_role_vip', array(

		'vip'
		
	));

	/* ==========================================================================
	   NORMAL
	   ========================================================================== */

	KG_Config::setPublic('kg_user_role_default', array(

		'default',

	));
