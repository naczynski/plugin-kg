<div class="stats-sort-wrapper kg-count">
	
	<label for="column_name">Zakres:</label>
	
	<select name="type">
		<option value="week">Tygodnione</option>
		<option value="year" selected>Roczne</option>
	</select>

	<select name="year">
		<?php 
			$end = date('Y');
			for ($start = 2015; $start <= $end; $start++) :
		?>
			<option value="<?=$start;?>" <?= ($end == $start) ? 'selected' : '';?> ><?=$start;?></option>
		<?php 
			endfor; 
		?>
	</select>

	<select name="week" style="display: none"></select>

</div>

<div class="stat-box">
	<p>Ilość prezentów kupionych w danym okresie: <span class="sum-presents"></span></p>
	<p>Ilość abonamentów kupionych w wybranym okresie: <span class="sum-subsctiptions"></span></p>
	<p>Ilość zasobów kupionych w danym okresie: <span class="sum-resources"></span></p>	
</div>

<canvas id="kg-count-canvas" class="canvas-chart" height="200" style="width: 80%; height: 400px">
	
</canvas>