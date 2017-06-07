
	<div class="stats-sort-wrapper kg-count-total">
		
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
		<p>Suma zysków w wybranym okresie: <span class="sum-total"></span>zł</p>
		<p>Suma zysków z prezentów w wybranym okresie: <span class="sum-presents"></span>zł</p>
		<p>Suma zysków z abonamantów w wybranym okresie: <span class="sum-subsctiptions"></span>zł</p>
		<p>Suma zysków z kupna zasobów w wybranym okresie: <span class="sum-resources"></span>zł</p>	
	</div>

	<canvas id="kg-count-total-canvas" class="canvas-chart" height="200" style="width: 80%; height: 400px">
		
	</canvas>
