<?php
	global $post;
?>

<div class="sent-message-wrapper" style="margin: 0px; width: 97%">
			
	<form id="sent_message">	
		<?php wp_nonce_field( 'send_message', 'security' ); ?>
		<p>Od: <strong><?= KG_get_curr_user()->get_name_and_surname(); ?></strong></p>
						
		<textarea style="width: 95%;margin: 10px auto" name="message" placeholder="Wpisz wiadomość"></textarea>
	
		<span style="float: right; margin-top: 15px" class="spinner spinner-send-message"></span>
		<a class="button button-primary button-large button-send-message" ><?=__( 'Wyślij', 'kg' ) ;?></a>
	</form>

	<div style="clear: both"></div>

</div>