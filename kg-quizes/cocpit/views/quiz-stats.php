	
	<?php if (empty($this->quizes_results)): ?>
		<p class="update-nag">Żaden użytkownik nie rozwiązał quizu.</p>
	<?php else: ?>

		<h2>Statystyki</h2>

		<p>Najlepiej rozwiązali : <?=$this->get_best_solved_users() ;?></p>
		<p>Średni wynik : <?=$this->get_average_result_in_percange() ;?>%</p>
		<p>Najczęściej wybierany zasób jako nagroda: <?=$this->most_frequently_choose_award() ;?></p>
		
		<h2>Rozwiązania</h2>


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

				<?php foreach ($this->quizes_results as $result): 
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
								<span>Nie wybrał(a)</span>
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
	<?php endif; ?>