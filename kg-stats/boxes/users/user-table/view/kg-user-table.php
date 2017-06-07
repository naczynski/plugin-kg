
<?php echo $pagination; ?>

<div class="stats-sort-wrapper">
		
	<label for="column_name">Sortuj po:</label>

	<select name="column_name" id="column_name" class="with-pagination">
		<option value="ID" <?=$sort_column_name=='ID' ? 'selected' : '';?>>ID</option>
		<option value="sum_log_in" <?=$sort_column_name=='sum_log_in' ? 'selected' : '';?>><?=KG_get_label_for_stat_column('sum_log_in');?></option>
		<option value="sum_downloads" <?=$sort_column_name=='sum_downloads' ? 'selected' : '';?>><?=KG_get_label_for_stat_column('sum_downloads');?></option>
		<option value="sum_messages" <?=$sort_column_name=='sum_messages' ? 'selected' : '';?>><?=KG_get_label_for_stat_column('sum_messages');?></option>
		<option value="sum_donations" <?=$sort_column_name=='sum_donations' ? 'selected' : '';?>><?=KG_get_label_for_stat_column('sum_donations');?></option>
		<option value="sum_time_spent" <?=$sort_column_name=='sum_time_spent' ? 'selected' : '';?>><?=KG_get_label_for_stat_column('sum_time_spent');?></option>
		<option value="sum_likes_resources" <?=$sort_column_name=='sum_likes_resources' ? 'selected' : '';?>><?=KG_get_label_for_stat_column('sum_likes_resources');?></option>
		<option value="sum_quiz_results" <?=$sort_column_name=='sum_quiz_results' ? 'selected' : '';?>><?=KG_get_label_for_stat_column('sum_quiz_results');?></option>
		<option value="sum_task_responses" <?=$sort_column_name=='sum_task_responses' ? 'selected' : '';?>><?=KG_get_label_for_stat_column('sum_task_responses');?></option>
		<option value="sum_presents" <?=$sort_column_name=='sum_presents' ? 'selected' : '';?>><?=KG_get_label_for_stat_column('sum_presents');?></option>	
	</select>
	
	<select name="order">
		<option value="DESC" <?=$sort_direction=='DESC' ? 'selected' : '';?>>Malejąco</option>
		<option value="ASC" <?=$sort_direction=='ASC' ? 'selected' : '';?>>Rosnąco</option>
	</select>

</div>

<table class="widefat stat-table-users">
	<tbody>
		<thead>
			<tr>
				<th>Avatar</th>
				<th>Użytkownik</th>
				<th>Grupa </th>
				<th class=""><?=KG_get_label_for_stat_column('sum_log_in');?></th>
				<th class="">Abonament</th>
				<th class="hide-when-2-column-layout "><?=KG_get_label_for_stat_column('sum_likes_resources');?></th>
				<th class="hide-when-2-column-layout "><?=KG_get_label_for_stat_column('sum_downloads');?></th>
				<th class=""><?=KG_get_label_for_stat_column('sum_time_spent');?></th>
				<th class=""><?=KG_get_label_for_stat_column('sum_donations');?></th>
				<th class="hide-when-2-column-layout "><?=KG_get_label_for_stat_column('sum_messages');?></th>
				<th class="hide-when-2-column-layout "><?=KG_get_label_for_stat_column('sum_quiz_results');?></th>
				<th class="hide-when-2-column-layout "><?=KG_get_label_for_stat_column('sum_task_responses');?></th>
				<th class="hide-when-2-column-layout "><?=KG_get_label_for_stat_column('sum_presents');?></th>
			</tr>
		</thead>
		<?php foreach ($users  as $user): ?>
	
		<tr>
				<td><img src="<?=$user->get_avatar(); ?>" width="25" height="25"></td>
				<td><a target="_blank" href="<?=$user->get_edit_page(); ?>"><?=$user->get_name_and_surname(); ?></a></td>
				<td><span class="role user-<?= KG_get_user_type($user); ?>"><?= KG_get_user_type($user); ?> </span></td>
				<td class=""><?=$user->get_sum_log_in(); ?></td>
				<td>
					<?php
						if( !is_a($user->get_current_subscription(), 'KG_User_Subscription_Entry')){
				     		echo '-';
				     	} else if( $user->get_current_subscription()->is_normal_subscription() ){
				     		echo '<span style="color: #FF6D86; font-weight: bold" >KWARTALNY</span>';
				     	} else if( $user->get_current_subscription()->is_premium_subscription() ){
				     		echo '<span style="color: orange; font-weight: bold">PREMIUM</span>';
				     	} else {
				     		echo '<span>TRIAL</span>';
				     	}
					?>
				</td>
				<td class="hide-when-2-column-layout"><?=$user->get_sum_likes_resources(); ?></td>
				<td class="hide-when-2-column-layout"><?=$user->get_sum_downloads(); ?></td>
				<td><?=$user->get_time_spend(); ?></td>
				<td><?=$user->get_sum_donations(); ?></td>
				<td class="hide-when-2-column-layout"><?=$user->get_sum_message(); ?></td>
				<td class="hide-when-2-column-layout"><?=$user->get_sum_quiz_results(); ?></td>
				<td class="hide-when-2-column-layout"><?=$user->get_sum_tasks_responses(); ?></td>
				<td class="hide-when-2-column-layout"><?=$user->get_sum_presents(); ?></td>
		</tr>

		<?php endforeach ?>

	</tbody>
</table>

<?php echo $pagination; ?>

<div class="clear"></div>