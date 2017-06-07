<?php

	// global $task_id, $page;
	
	$responses_loop = KG_Get::get('KG_Loop_Tasks_Responses', $task_id, array(
		'page' => $page
	));

	$responses = $responses_loop->get();
	$params_pagination = array(
		'current' => $page,
		'total' => $responses_loop->get_page_numbers(),
		'format' => '?paged=%#%',
		'prev_next' => false,
	);

	$pagination = KG_pagination($params_pagination, true);
?>

<?php if(sizeof($responses) > 0): 
	echo $pagination
?>
	
<table class="widefat my-resources">
	<thead>
		<tr class="task-responses">
			<th>Użytkownik</th>
			<th>Odpowiedź</th>
			<th>Data</th>
			<th>Polubienia</th>
			<th>Nagroda</th>
			<th>Edytuj</th>
			<th>Usuń</th>
		</tr>
	</thead>
	<tbody>

		<?php foreach ($responses as $response) : ?>
			<tr class="task-responses <?=$response->get_cocpit_class(); ?>" style="border-bottom: #000 solid 1px">
				<td class="center">
					<img style="border: 1px solid #fff" src="<?=$response->get_user()->get_avatar(); ?>" width="40" height="40">
					<br>
					<a href="<?=$response->get_user()->get_edit_page(); ?>" target="_blank"><?=$response->get_user()->get_name_and_surname(); ?></a>
				</td>
				<td style="width: 40%"><?=$response->get_content(); ?></td>
				<td style="width: 70px" class="center"><?=$response->get_date(); ?></td>
				<td class="center"><?=$response->get_number_likes(); ?></td>
				<td>
					<?php if($response->is_user_choose_award()): ?>
						Użytkownik wygrał za tą odpowiedź : <a target="_blank" href="<?=$response->get_award_resource()->get_admin_edit_link();?>"><?=$response->get_award_resource()->get_name_with_subtype();?></a> 				
					<?php elseif($response->is_get_prize()) : ?>
						Użytkownik jeszcze nie wybrał nagrody
					<?php else: ?>
						-
					<?php endif; ?>
				</td>
				<td>
					<a style="margin-top: 24px" href="<?=$response->get_admin_edit_url(); ?>" class="preview button">Więcej</a>
				</td>
				<td style="width: 94px" class="action-col"> 
					<span class="spinner preloader-task-remove-response" ></span>
					<a data-id="<?=$response->get_ID(); ?>" class="remove-response-button button delete-but">Usuń</a> 
				</td>
			</tr>
		<?php endforeach; ?>
	</tbody>
</table>

<?php 
	echo $pagination;
	echo '<div class="clear"></div>';
else: 
?>
	<p class="update-nag">Żaden użytkownik nie odpowiedział jeszcze na to zadanie.</p>	
<?php endif; ?>