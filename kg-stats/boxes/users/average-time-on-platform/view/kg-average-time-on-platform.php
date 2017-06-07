
<div class="stats-sort-wrapper sort-average-time-spent">
	
	<label for="column_name">Zakres:</label>
	
	<select name="type">
		<option value="year" selected>Roczne</option>
		<option value="week">Tygodniowe</option>
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

<canvas id="average-time-canvas" class="canvas-chart" height="200" style="width: 80%; height: 400px">
	
</canvas>
