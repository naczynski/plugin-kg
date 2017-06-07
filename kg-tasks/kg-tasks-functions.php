<?php

	function KG_get_data_for_single_task($task_id, $page = 1, $with_task_data = true) {
		$loop = KG_Get::get('KG_Loop_Tasks_Responses', $task_id, array('page' => $page)); 
		$task_obj = KG_Get::get('KG_Task_Item', $task_id)->get_serialized_fields_for( get_current_user_id() );

		$responses = array(
			'current_page' => $page,
			'pages' => 	$loop->get_page_numbers(),
			'responses' => 	$loop->get()	
		);
		return $with_task_data ? array_merge($task_obj, $responses) : $responses;
	}

	
	function KG_get_data_for_single_task_without_task_data($task_id, $page){
		return KG_get_data_for_single_task($task_id, $page, false);
	}