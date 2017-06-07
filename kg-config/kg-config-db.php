<?php

	global $wpdb;
	
	/* ==========================================================================
	   TABLES
	   ========================================================================== */
	
	//Likes
	KG_Config::setPublic('table_likes', $wpdb->prefix.'likes');	

	//Quizes
	KG_Config::setPublic('table_quizes_results', $wpdb->prefix.'quizes_results');

	//Presents
	KG_Config::setPublic('table_presents', $wpdb->prefix.'presents');

	//Resource Realations
	KG_Config::setPublic('table_resources_relations', $wpdb->prefix.'resource_relations');

	//Subscriptions
	KG_Config::setPublic('table_subscriptions', $wpdb->prefix.'subscriptions');
	
	// Messages
	KG_Config::setPublic('table_messages', $wpdb->prefix . 'messages');

	// Alerts
	KG_Config::setPublic('table_alerts', $wpdb->prefix . 'alerts');

	// Activity
	KG_Config::setPublic('table_users_activities', $wpdb->prefix . 'users_activities');

	// Tasks
	KG_Config::setPublic('table_tasks_reponses', $wpdb->prefix . 'tasks_responses');
	KG_Config::setPublic('table_tasks_user_relations', $wpdb->prefix . 'tasks_user_relations');
	KG_Config::setPublic('table_tasks_reponses_likes', $wpdb->prefix . 'tasks_responses_likes');

	// Stats
	KG_Config::setPublic('table_sessions', $wpdb->prefix . 'sessions');

	// Transactions
	KG_Config::setPublic('table_transactions', $wpdb->prefix . 'transactions');

	// Basket
	KG_Config::setPublic('table_basket', $wpdb->prefix . 'basket');

	/* ==========================================================================
	   COLUMNS
	   ========================================================================== */
	
	KG_Config::setPublic('columns_user_table', array(
		'sum_log_in',
		'sum_downloads',
		'sum_messages',
		'sum_donations',
		'sum_time_spent',
		'sum_likes_resources',
		'sum_likes_tasks_responses',
		'sum_quiz_results',
		'sum_task_responses',
		'sum_presents',
		'avatar_file_name',
		'is_active',
		'is_networking',
		'is_email_activated',
		'last_logged',
		'user_activation_key'
	));	

	KG_Config::setPublic('columns_posts_table', array(
		'sum_likes',
		'sum_actions',
		'sum_as_present',
		'sum_bought',
		'sum_choose_as_free',
		'sum_choose_as_quiz_award',
		'sum_choose_as_task_award'
	));	

	KG_Config::setPublic('columns_quiz_results_table', array(
		'quiz_id',
		'id',
		'correct_answ',
		'wrong_answ',
		'answers',
		'time',
		'user_id',
		'award_resource_id',
		'award_relation_id',
		'date',
		'is_passed'
	));	

