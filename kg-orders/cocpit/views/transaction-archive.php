<?php  
	$page = !empty($_GET['paged']) ? (int) $_GET['paged'] : 1;
	$loop =  KG_Get::get('KG_Loop_Transactions', array(
		'page' => $page,
		'sort_column' => !empty($_GET['sorted']) ? $_GET['sorted'] : 'id'
	));
	$transactons = $loop->get();

	$params_pagination = array(
		'current' => $page,
		'total' => $loop ->get_page_numbers(),
		'format' => '?paged=%#%',
	);
	$pagination = KG_pagination($params_pagination);
	$link = KG_Get::get('KG_Cocpit_Page_Transaction_Archive')->get_url();
?>

<h1>Transakcje</h1>

<?=$pagination ;?>
<table class="wp-list-table widefat center fixed striped posts">
	<thead>
		<tr>
			<th scope="col" id="index" class="manage-column column-index" style=""><a href="<?=$link;?>&sorted=id">Numer</a></th>
			<th scope="col" id="price_brutto" class="manage-column column-price_brutto" style=""><a href="<?=$link;?>&sorted= total_brutto">Suma (brutto)</a></th>
			<th scope="col" id="price_netto" class="manage-column column-price_netto" style=""><a href="<?=$link;?>&sorted=total_netto">Suma (netto)</a></th>
			<th scope="col" id="user" class="manage-column column-user" style=""><a href="<?=$link;?>&sorted=user_id">Użytkownik</a></th>
			<th scope="col" id="items_count" class="manage-column column-items_count" style="<?=$link;?>&sorted=">Wielkość zamówienia</th>
			<th scope="col" id="paid" class="manage-column column-paid" style=""><a href="<?=$link;?>&sorted=status">Płatność</a></th>
			<th scope="col" id="trans_date" class="manage-column column-trans_date" style=""><a href="<?=$link;?>&sorted=date">Data</a></th>	
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
			<td><?='<a href="' . $kg_transaction->get_user()->get_edit_page()  . '">' . $kg_transaction->get_user()->get_name_and_surname() . ' </a>';?></td>
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
<?=$pagination ;?>