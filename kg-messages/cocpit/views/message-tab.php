<?php	
	$messages = KG_Get::get('KG_Loop_Messages')->get_chat($_GET['id']);
?>

<?php if (empty($messages)): ?>
	<p class="update-nag">Użytkownik nie prowadziłeś konwersacji z użytkownikiem</p>
<?php else: ?>
		
	<div class="messages-chat">
		
		<?php foreach ($messages as $key => $message) : 
			$show_message = (
				$message->get_from_user()->show_message_in_cocpit() ||
				$message->get_to_user()->show_message_in_cocpit()
			);
			$is_left = $message->get_from_user()->get_ID() != get_current_user_id();
		?>

		<span class="<?=$is_left ? 'left' : 'right';?>">
			<a href="<?= $message->get_from_user()->get_edit_page(); ?>">
				<?= $message->get_from_user()->get_name_and_surname(); ?>
			</a>
			<mark class="date"><?=$message->get_date(); ?></mark>
			<?=$message->get_message();?>

		</span>
		<div class="clear"></div>

		
		<?php endforeach; ?>
		
	</div>

<?php endif; ?>

<div class="sent-message-wrapper">
			
	<h2>Wyślij wiadomość</h2>

	<form id="sent_message">	
		<?php wp_nonce_field( 'send_message', 'security' ); ?>
		<p>Od: <strong><?= KG_get_curr_user()->get_name_and_surname(); ?></strong></p>
		<p>Do: <strong><?= KG_Get::get('KG_User', $_GET['id'])->get_name_and_surname();?></strong></p>

		<input type="hidden" name="action" value="sent_message">
		<input type="hidden" name="to_user_id" value="<?=$_GET['id'];?>">
		<input type="hidden" name="from_user_id" value="<?= KG_get_curr_user()->get_ID(); ?>">
					
		<textarea name="message" placeholder="Wpisz wiadomość"></textarea>
	
		<span style="float: right; margin-top: 15px" class="spinner spinner-send-message"></span>
		<input type="submit" class="button button-primary button-large button-send-message" value="<?=__( 'Wyślij', 'kg' ) ;?>">
	</form>

	<div style="clear: both"></div>

</div>
