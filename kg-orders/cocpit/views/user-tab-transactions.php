<?php  
	$transactons = KG_Get::get('KG_My_Transactions_Loop', (int) $_GET['id'])->get();
?>

<?php if (empty($transactons)): ?>
	<p class="update-nag">Użytkownik nie wydał żadnych pieniędzy na portalu.</p>	
<?php else: ?>
<table class="wp-list-table widefat fixed striped posts">
	<thead>
		<tr>
			<th scope="col" id="index" class="manage-column column-index" style="">Numer</th>
			<th scope="col" id="price_brutto" class="manage-column column-price_brutto" style="">Suma (brutto)</th>
			<th scope="col" id="price_netto" class="manage-column column-price_netto" style="">Suma (netto)</th>
			<th scope="col" id="items_count" class="manage-column column-items_count" style="">Wielkość zamówienia</th>
			<th scope="col" id="paid" class="manage-column column-paid" style="">Płatność</th>
			<th scope="col" id="trans_date" class="manage-column column-trans_date" style="">Data</th>	
		</tr>
	</thead>

	<tbody id="the-list">
	
		<?php foreach ($transactons as $kg_transaction): 
			$nr = $kg_transaction->get_number_for_user();
			$link = $kg_transaction->get_admin_edit_link();
		?>

		<tr id="post-1040" class="iedit ">
			<td class="index column-index"><?='<a href="'. $link.  '">' . $nr . '</a>';?></td>
			<td><?=$kg_transaction->get_total_brutto();?>zł</td>
			<td><?=$kg_transaction->get_total_netto();?>zł</td>
			<td><?=$kg_transaction->get_count_items();?></td>
			<td><?php
				if($kg_transaction->is_payment_complete()){
					echo '<span class="yes">Zapłacono</span>';	
				} else if($kg_transaction->is_canceled()){
					echo '<span class="no">Anulowana</span>';	
				} else {
					echo '<span style="color: orange; text-transform: uppercase">Oczekiwanie</span>';	
				}
			?></td>
			<td><?=$kg_transaction->get_date();?></td>
		</tr>

		<?php endforeach ?>

	</tbody>
</table>
<?php endif; ?>