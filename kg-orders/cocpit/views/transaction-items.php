<?php
	$kg_transaction = $this->get_transaction_obj();
	$items = $kg_transaction->get_items();
?>

<table class="widefat">
	<thead>
		
		<tr>
			<td>Typ</td>
			<td>
				Treść	
			</td>
			<td>Cena</td>
		</tr>

	</thead>

	<tbody>
		
		<?php  foreach ($items as $key => $item): ?>

			<tr class="<?=$item->get_class_cocpit();?>">
				<td><?=$item->get_type(); ?></td>
				<td>
					<strong><?=stripslashes($item->get_headline()); ?></strong>
					<p><?=$item->get_desc(); ?></p>
				</td>
				<td><?=$item->get_price(); ?>zł</td>
			</tr> 

		<?php endforeach; ?>

	</tbody>

</table>
