
<div class="sent-message-wrapper">
			
	<h2>Wyślij wiadomość</h2>

	<form id="sent_message">	
		<?php wp_nonce_field( 'send_message', 'security' ); ?>
		<p>Od: <strong><?= KG_get_curr_user()->get_name_and_surname(); ?></strong></p>

			<ul>
				<li>
					<span style="width: 50px;display:block"> <em>Grupy:</em> </span>
					<input type="checkbox" name="user_type[]" value="coach" checked><span style="margin-right: 10px">Coach</span>
					<input type="checkbox" name="user_type[]" value="vip" checked><span style="margin-right: 10px">Vip</span>
					<input type="checkbox" name="user_type[]" value="cim" checked><span style="margin-right: 10px">Cim</span>
					<input type="checkbox" name="user_type[]" value="default" checked><span style="margin-right: 10px">Zwykli</span>
				</li>

				<li>
					<span style="width: 50px;display:block"> <em>Stan:</em> </span>
					<input type="checkbox" name="only_enable" value="true" checked> <span style="margin-right: 10px">Tylko aktywni</span>
					<input type="checkbox" name="only_enable-networking" value="true" checked> <span style="margin-right: 10px">Tylko z funkcją networkingu</span>
					<input type="checkbox" name="only_email-activated" value="true" checked> <span style="margin-right: 10px">Tylko z potwierdzonym adresem email</span>
				</li>
				
			</ul>

		</p>

		<input type="hidden" name="action" value="sent_message_to_all">
					
		<textarea name="message" placeholder="Wpisz wiadomość"></textarea>
	
		<span style="float: right; margin-top: 15px" class="spinner spinner-send-message"></span>
		<input type="submit" class="button button-primary button-large button-send-message" value="<?=__( 'Wyślij', 'kg' ) ;?>">
	</form>

	<div style="clear: both"></div>

	<p>Uwaga. W zależności od ilości użytkowników wysyłanie może chwile potrwać.</p>

</div>
