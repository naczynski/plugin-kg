
<?php echo $pagination; ?>

<div class="stats-sort-wrapper">
		
	<label for="column_name">Sortuj po:</label>

	<select name="column_name" id="column_name" class="with-pagination">
		<option value="ID" <?=$sort_column_name=='ID' ? 'selected' : '';?>>ID</option>
	    <option value="quiz_id" <?=$sort_column_name=='quiz_id' ? 'selected' : '';?>><?=KG_get_label_for_stat_column('quiz_id');?></option>	
		<option value="date" <?=$sort_column_name=='date' ? 'selected' : '';?>><?=KG_get_label_for_stat_column('quiz_date_solve');?></option>
		<option value="user_id" <?=$sort_column_name=='user_id' ? 'selected' : '';?>><?=KG_get_label_for_stat_column('user_id');?></option>
		<option value="is_passed" <?=$sort_column_name=='is_passed' ? 'selected' : '';?>><?=KG_get_label_for_stat_column('is_passed');?></option>
		<option value="time" <?=$sort_column_name=='time' ? 'selected' : '';?>><?=KG_get_label_for_stat_column('time_solving');?></option>
	</select>
	
	<select name="order">
		<option value="DESC" <?=$sort_direction=='DESC' ? 'selected' : '';?>>Malejąco</option>
		<option value="ASC" <?=$sort_direction=='ASC' ? 'selected' : '';?>>Rosnąco</option>
	</select>

</div>

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

		<?php foreach ($quizes_results  as $result): 
			$quiz = $result->get_kg_quiz_item();
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

<?php echo $pagination; ?>

<div class="clear"></div>