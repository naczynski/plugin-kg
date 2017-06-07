<?php
	$relations = KG_Get::get('KG_Edit_User_Tab_Resources')->get_relation_object();
?>

<?php if (empty($relations)): ?>	
	<p class="update-nag message-no-relations">Brak wyników dla zaznaczonych zagadnień.</p>	
<?php else: ?>

<table class="widefat my-resources">
		<thead>
			<tr>
				<th>Miniaturka</th>
				<th>Nazwa</th>
				<th>Data</th>
				<!-- <th></th> -->
			</tr>
		</thead>
		<tbody>
			<?php foreach ($relations as $key => $relation) : 
				$alternate = $key % 2;
			?>	
				<tr class="<?= $alternate ? 'alternate' : ''; ?>">
					<td><img width="50" height="50" src="<?=$relation->get_resource()->get_thumbnail_small() ;?>" /></td>
					<td>
						<a href="<?= $relation->get_resource()->get_admin_edit_link(); ?>">
						     <?= $relation->get_resource()->get_name(); ?>
						</a>
					</td>
					<td><?=$relation->get_date() ;?></td>
					<!-- <td> 
						<form class="remove-relation">
							<?php wp_nonce_field( 'remove_relation', 'security' ); ?>
							<input type="hidden" name="action" value="remove_relation">
							<input type="hidden" name="relation_id" value="<?= $relation->get_relation_id();?>">
							<button class="preview button remove-relation">Usuń</a>
						</form>
					</td> -->
				</tr>
			<?php endforeach; ?>
		</tbody>
</table>

<?php endif; ?>