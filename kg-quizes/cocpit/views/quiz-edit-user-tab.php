<?php 
	$quizes = KG_Get::get('KG_Loop_My_Quizes_Results', $_GET['id'], array(
		'as_array' => false
	))->get();
?>
<?php if (empty($quizes)): ?>
	<p class="update-nag">Użytkownik jeszcze nie rozwiązał żadnego quizu.</p>
<?php else: ?>

<table class="widefat stat-table-users" style="top: 5px;position: relative">
	<tbody>
		<thead>
			<tr>
				<th>Miniaturka</th>
				<th class=""><?=KG_get_label_for_stat_column('quiz_id');?></th>
				<th><?=KG_get_label_for_stat_column('user_id');?></th>
				<th class="hide-when-2-column-layout "><?=KG_get_label_for_stat_column('time_solving');?></th>
				<th class="hide-when-2-column-layout "><?=KG_get_label_for_stat_column('date');?></th>
				<th><?=KG_get_label_for_stat_column('is_passed');?></th>
				<th class="hide-when-2-column-layout "><?=KG_get_label_for_stat_column('price');?></th>
				<th><?=KG_get_label_for_stat_column('percange_solve');?></th>
				<th>Zobacz</th>
			</tr>
		</thead>

		<?php foreach ($quizes as $quiz):
			$result = $quiz->get_quiz_solve_obj($_GET['id']);
		?>
		
		<tr>	
			<td><img src="<?=$quiz->get_thumbnail_small() ;?>" width="25" height="25"></td>
			<td><a target="_blank" href="<?=$quiz->get_admin_edit_link(); ?>"><?=$quiz->get_name(); ?></a></td>
			<td><a target="_blank" href="<?=$result->get_user()->get_edit_page(); ?>"><?=$result->get_user()->get_name_and_surname(); ?></a></td>
			<td class="hide-when-2-column-layout "><?=$result->get_time_solving() ;?></td>
			<td class="hide-when-2-column-layout "><?=$result->get_date() ;?></td>
			<td ><?=$result->is_user_passed_quiz() ? '<span class="yes">TAK</span>' : '<span class="no">NIE</span>' ;?></td>
			<td class="hide-when-2-column-layout ">
				<?php if ($result->is_user_passed_quiz()): ?>
					
					<?php if ($result->is_user_choose_award()): ?>
						<span> <a target="_blank" href="<?=$result->get_award_resource()->get_admin_edit_link();?>"><?=$result->get_award_resource()->get_name_with_subtype();?></a> </span>
					<?php else: ?>
						<span>Nie wybrał</span>
					<?php endif ?>

				<?php else: ?>
					-
				<?php endif; ?>
			</td>
			<td><?=$result->get_result_in_percange() ;?>%</td>
			<td><a target="_blank" href="<?=KG_Get::get('KG_Cocpit_Page_Quiz_Result')->get_url($result->get_ID()); ?>">Zobacz</a></td>
		</tr>

		<?php endforeach ?>

	</tbody>
</table>

<?php endif ?>