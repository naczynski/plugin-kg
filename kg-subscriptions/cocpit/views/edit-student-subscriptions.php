<?php

	$user = KG_Get::get('KG_User', $_GET['id']);
	$subscriptions_user = $user->get_all_subscriptions();
	$all_subscritions = KG_Get::get('KG_Subscriptions')->get_all_available_subscriptions();

?>
	<div class="add-subscription-wrapper">

		<h2>Przyznaj abonament</h2>

		<form id="add-subscription">
			
			<?php wp_nonce_field( 'add_subscription', 'security' ); ?>
			<input type="hidden" name="action" value="add_subscription">
			<input type="hidden" name="user_id" value="<?=$_GET['id']; ?>">

			<select name="subscription_id">
				<?php foreach ($all_subscritions as $subscritpion_obj): ?>
					<option value="<?=$subscritpion_obj->get_ID();?>"><?=$subscritpion_obj->get_label();?></option>
				<?php endforeach ?>
			</select>

			<input type="submit" class="button button-primary button-large button-send" value="<?=__( 'Przyznaj abonament', 'kg' ) ;?>">
			<span style="float: right;margin-top: 20px" class="spinner spinner-add-subscription"></span>

		</form>

	</div>

<?php if (empty($subscriptions_user)): ?>
	<p class="update-nag">Użytkownik nie posiada żadnego przypisanego abonamentu.</p>
<?php else: ?>

	<table class="widefat my-resources">
		<thead>
			<tr>
				<th>Stan</th>
				<th>Darmowe zasoby</th>
				<th>Od</th>
				<th>Do</th>
			</tr>
		</thead>
		<tbody>

			<?php foreach ($subscriptions_user as $subscription_entry) :
			 ?>	
				<tr class="<?=$subscription_entry->get_state() ;?>">
					<td><?=$subscription_entry->get_state_label(); ?></td>
					<td><?=$subscription_entry->get_free_resources_used();?> / <?=$subscription_entry->get_free_resources_all();?> </td>
					<td><?=$subscription_entry->get_start_date();?></td>
					<td><?=$subscription_entry->get_end_date() ;?></td>
				</tr>
			<?php endforeach; ?>
		</tbody>
	</table>

<?php endif; ?>