<div class="stats-sort-wrapper kg-count-users-stats">
	
	<label for="column_name">Zakres:</label>
	
	<select name="type">
		<option value="year" selected>Roczne</option>
	</select>

	<select name="year">
		<?php 
			$end = date('Y');
			for ($start = KG_Config::getPublic('show_stats_from_year'); $start <= $end; $start++) :
		?>
			<option value="<?=$start;?>" <?= ($end == $start) ? 'selected' : '';?> ><?=$start;?></option>
		<?php 
			endfor; 
		?>
	</select>

	<select name="week" style="display: none"></select>

</div>

<select style="margin: 10px auto" name="type_data_count_users">
	<option value="count_users">Ilość użytkowników</option>
	<option value="count_active_users">Ilość użytkowników którzy wykonali akcję w danym miesiącu</option>
	<!-- <option value="count_user_spent_more_than_before">Ilość użytkowników którzy w danym miesiącu wydali więcej niż w poprzednim</option> -->
	<option value="count_user_spent_money">Ilość użytkowników którzy wydali pieniądze w danym miesiącu</option>
</select>

<canvas id="kg-count-users-canvas" class="canvas-chart" height="200" style="width: 80%; height: 400px">
	
</canvas>
