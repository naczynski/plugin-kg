<?php
	$page = !empty($_GET['paged']) ? (int) $_GET['paged']  : 1 ;
	$activities_loop = KG_Get::get('KG_Loop_Activities', $_GET['id'], array(
		'page' => $page 
	));
	$activities= $activities_loop->get();
	$total = $activities_loop->get_page_numbers();

	$params_pagination = array(
		'current' => $page,
		'total' => $total,
		'format' => '?paged=%#%',
	);

	$pagination = KG_pagination($params_pagination);

?>

	<?php if (empty($activities)): ?>	
		<p class="update-nag">System nie zarejestrował żadnej aktywności użytkownika.</p>	
	<?php else: ?>
		<?=	$pagination; ?>
		<table class="widefat">
				<thead>
					<tr>
						<th>Typ</th>
						<th>Akcja</th>
						<th>Data</th>
						<th>Przeglądarka</th>
						<th>Platforma</th>
					</tr>
				</thead>
				<tbody>

					<?php foreach ($activities as $key => $activity) : ?>

						<tr class="activity <?= $activity->get_class_name($_GET['id']); ?>" >
							
							<td><?=$activity->get_type(); ?></td>
							<td style="max-width: 500px"><?=$activity->get_message();?></td>
							<td><?=$activity->get_date(); ?></td>
							<td><?=$activity->get_browser(); ?></td>
							<td><?=$activity->get_device(); ?></td>
						</tr>
					<?php endforeach; ?>
				</tbody>
		</table>

		<?=	$pagination; ?>
	<?php endif; ?>

