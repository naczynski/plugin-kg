<?php

	KG_Config::setPublic('api_register',  '/slim/api/register') ;
	KG_Config::setPublic('api_login', '/slim/api/login') ;
	KG_Config::setPublic('api_recovery', '/slim/api/recover') ;
	KG_Config::setPublic('api_buy', '/slim/api/buy') ;
	KG_Config::setPublic('api_like', '/slim/api/like') ;

	KG_Config::setPublic('api_resources', '/slim/api/resources') ;
	KG_Config::setPublic('api_mail', '/slim/api/mail') ;
	KG_Config::setPublic('api_recover', '/slim/api/recover') ;
	
	// messages
	KG_Config::setPublic('api_sent_message', '/slim/api/sent-message') ;
	KG_Config::setPublic('api_sent_chat_messages', '/slim/api/chat-messages') ;

	// my profile
   	KG_Config::setPublic('api_change_field', '/slim/api/change/field') ;
   	KG_Config::setPublic('api_update_fields', '/slim/api/change/fields') ;
	KG_Config::setPublic('api_change_avatar', '/slim/api/avatar') ;   	
   	
   	//settings
   	KG_Config::setPublic('api_change_password_settings', '/slim/api/change/password') ;
	KG_Config::setPublic('api_delete_account_settings', '/slim/api/acount/delete') ;

	// alerts
	KG_Config::setPublic('api_set_as_readed', '/slim/api/alerts/set-as-readed');
	KG_Config::setPublic('api_set_all_as_readed', '/slim/api/alerts/set-all-as-readed');

	KG_Config::setPublic('api_get_alerts', '/slim/api/alerts/get');

	// quizes
	KG_Config::setPublic('api_quiz_check', '/slim/api/quiz/check');
	KG_Config::setPublic('api_quiz_choose_award', '/slim/api/quiz/choose-award');

	// tasks
	KG_Config::setPublic('api_task_get_responses', '/slim/api/task/:task/:page');
	KG_Config::setPublic('api_task_leave_task', '/slim/api/task/:task/leave');
	
	KG_Config::setPublic('api_task_add_response', '/slim/api/task-response/add');
	KG_Config::setPublic('api_task_like_response', '/slim/api/task-response/:id/like');
	KG_Config::setPublic('api_task_set_award', '/slim/api/task-response/:id/add-award');
