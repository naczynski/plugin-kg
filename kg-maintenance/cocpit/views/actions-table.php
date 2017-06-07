
<table class="widefat my-resources">
	<thead>
		<tr>
			<th>Opis</th>
			<th>Akcja</th>
		
		</tr>
	</thead>
	<tbody>

		<?php foreach ($_GLOBAL['maintance_actions'] as $action) : 
		?>
			<tr>	
				<td><?=$action['message'] ;?></td>
				<td><a class="button button-primary" href="<?= KG_Get::get('KG_Cocpit_Maintance_Actions')->get_action_url($action['name']);?>"><?=$action['but'] ;?></a></td>
			</tr>
		<?php endforeach; ?>
	</tbody>
</table>