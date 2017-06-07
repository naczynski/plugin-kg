
<div class="stats-sort-wrapper">
		
	<label for="column_name">Sortuj po:</label>

	<select name="column_name" id="column_name">
		<option value="sum_log_in"><?=KG_get_label_for_stat_column('sum_log_in');?></option>
		<option value="sum_downloads"><?=KG_get_label_for_stat_column('sum_downloads');?></option>
		<option value="sum_messages"><?=KG_get_label_for_stat_column('sum_messages');?></option>
		<option value="sum_donations"><?=KG_get_label_for_stat_column('sum_donations');?></option>
		<option value="sum_time_spent"><?=KG_get_label_for_stat_column('sum_time_spent');?></option>
		<option value="sum_likes_resources"><?=KG_get_label_for_stat_column('sum_likes_resources');?></option>
		<option value="sum_quiz_results"><?=KG_get_label_for_stat_column('sum_quiz_results');?></option>
		<option value="sum_task_responses"><?=KG_get_label_for_stat_column('sum_task_responses');?></option>
		<option value="sum_presents"><?=KG_get_label_for_stat_column('sum_presents');?></option>	
	</select>
	
</div>

<canvas id="top-users-chart-canvas" class="canvas-chart" height="200" style="width: 80%; height: 400px">
	
</canvas>
