
<div class="stats-sort-wrapper kg-count-log-in">
	
	<label for="column_name">Zakres:</label>
	
	<select name="type">
		<option value="week">Tygodnione</option>
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

<canvas id="count-log-in-canvas" class="canvas-chart" height="200" style="width: 80%; height: 400px">
	
</canvas>
