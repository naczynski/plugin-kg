<?php
	
	$user = KG_Get::get('KG_User', $_GET['id']);
	$group_fields = $user->get_in_cocpit_groups_fields();

?>
<script type="text/javascript">
	
	acf.o = {};
	acf.o.ajaxurl = ajaxurl;
	acf.screen = {};
	acf.o.post_id = 0;
	acf.screen.post_id = 0;

	acf.l10n = {"core":{"expand_details":"Expand Details","collapse_details":"Collapse Details"},"validation":{"error":"Walidacja nie powiod\u0142a si\u0119. Jedno lub wi\u0119cej p\u00f3l jest wymaganych."},"image":{"select":"Wybierz obrazek","edit":"Edytuj zdj\u0119cie","update":"Aktualizuj obrazek","uploadedTo":"uploaded to this post"},"file":{"select":"Wybierz plik","edit":"Edytuj plik","update":"Aktualizuj plik","uploadedTo":"uploaded to this post"},"relationship":{"max":"Maksymalna liczba zosta\u0142a osi\u0105gni\u0119ta ( {max} )","tmpl_li":"\n\t\t\t\t\t\t\t<li>\n\t\t\t\t\t\t\t\t<a href=\"#\" data-post_id=\"<%= post_id %>\"><%= title %><span class=\"acf-button-remove\"><\/span><\/a>\n\t\t\t\t\t\t\t\t<input type=\"hidden\" name=\"<%= name %>[]\" value=\"<%= post_id %>\" \/>\n\t\t\t\t\t\t\t<\/li>\n\t\t\t\t\t\t\t"},"google_map":{"locating":"Locating","browser_support":"Sorry, this browser does not support geolocation"},"date_picker":{"closeText":"Done","currentText":"Today","monthNames":["Stycze\u0144","Luty","Marzec","Kwiecie\u0144","Maj","Czerwiec","Lipiec","Sierpie\u0144","Wrzesie\u0144","Pa\u017adziernik","Listopad","Grudzie\u0144"],"monthNamesShort":["sty","lut","mar","kwi","maj","cze","lip","sie","wrz","pa\u017a","lis","gru"],"monthStatus":"Show a different month","dayNames":["niedziela","poniedzia\u0142ek","wtorek","\u015broda","czwartek","pi\u0105tek","sobota"],"dayNamesShort":["nie","pon","wt","\u015br","czw","pt","sob"],"dayNamesMin":["N","P","W","\u015a","C","P","S"],"isRTL":false},"repeater":{"min":"Minimum rows reached ( {min} rows )","max":"Maximum rows reached ( {max} rows )"}};
	

</script>
<div style="max-width: 99%"  id="poststuff">

	<div id="post-body" class="metabox-holder columns-2">
		
		<div id="post-body-content">
				
			<img class="float-left" width="100" height="100" src="<?= $user->get_avatar(); ?>">

			<h1 class="float-left name-edit-page"><?= $user->get_name_and_surname(); ?></h1>

			<p class="float-left last-login-edit-profile" ><?= $user->get_last_login_formatted(); ?> </p>
			
			<h3 class="role-edit-profile role user-<?= KG_get_user_type($user); ?>"><?= KG_get_user_type($user); ?> </h3>
	   			
	   		   <form id="change-filelds-form">
				
				   <?php wp_nonce_field( 'change_fields_edit_page', 'security' ); ?>

				   <input type="hidden" name="user_id" value="<?= $_GET['id']; ?>" >
				   <input type="hidden" name="action" value="change_fields" >

				   <table class="form-table">
					
					      <tbody>
					         
							<tr>
								<th scope="row"><label for="signup_email"><?php _e( 'E-mail', 'kg' ); ?></label></th>
								<td>
									<input style="float: left" name="email" type="email" id="blogname" value="<?= $user->get_email(); ?>" class="regular-text">
									<p class="error"></p>
									<span style="float: left" class="spinner spinner-edit-email"></span>
								</td>
							</tr>
					
					      </tbody>

				        </form>
					   
					</table>

					<?php foreach($group_fields as $group) : 

						$fields = $group->get_fields();

					?>

						<h2><?= $group->get_label(); ?></h2>

						<table class="form-table">
						
						      <tbody>
						        
								<?php foreach($fields as $field) : ?>			
				
								<tr>
									<th scope="row">
										<label for="signup_email">
											<?= $field->get_label(); ?>
											<?php if( $field->is_required() ): ?>
												(wymagane)
											<?php endif; ?>
										</label>
									</th>
									<td>
										<input name="<?= $field->get_name(); ?>" type="text" value="<?= $field->get_value(); ?>" class="regular-text">
									</td>
								</tr>

								<?php endforeach; ?>
						
						      </tbody>
						   
						</table>

					<?php endforeach; ?>

					 <p class="submit">

			   			<input type="submit" name="submit" id="submit" class="button button-primary" value="Aktualizuj">
						<span style="float: left" class="spinner spinner-change-fields"></span>
			   
			  		 </p>
		
			</form>
		
		</div>

		<div id="postbox-container-1" class="postbox-container-1">
			
			<div id="postimagediv" class="postbox ">
				<div class="handlediv" title="Kliknij, aby przełączyć"><br></div><h3><span>Networking</span></h3>
				<div class="inside">
					
					<p>Dostęp do networkingu: 
						
						<?php if( $user->can_networking()): ?>
							<span class="yes">Tak</span>
						<?php else: ?>
							<span class="no">Nie</span>
						<?php endif; ?>

					</p>

					<form id="form-networking">

						<?php wp_nonce_field( 'change_networking_state', 'security' ); ?>
						
						<input type="hidden" name="user_id" value="<?= $_GET['id']; ?>" >
						<span style="float: left" class="spinner spinner-change-networking"></span>
						
						<?php if( $user->can_networking()): ?>
							<input type="submit" class="button red-text" value="Zabierz dostęp" />
						    <input type="hidden" name="action" value="networking_disable" >
						<?php else: ?>
							<input type="submit" class="button green-text" value="Przyznaj dostęp" />
							<input type="hidden" name="action" value="networking_enable" >
						<?php endif; ?>
					
					</form>

				</div>
				
			</div>

		 <div id="postimagediv" class="postbox ">
				<div class="handlediv" title="Kliknij, aby przełączyć"><br></div><h3><span>Aktywacja maila</span></h3>
				<div class="inside">
					
					<p>Email zaakceptowany: 
						
						<?php if( $user->is_email_activated()): ?>
							<span class="yes">Tak</span>
						<?php else: ?>
							<span class="no">Nie</span>
						<?php endif; ?>

					</p>
				
					<?php if( !$user->is_email_activated()): ?>
				
					<p>Ilość wysłanych wiadomości: <?=$user->get_quantity_sended_email() ;?></p>

					<form style="float: left" id="form-email-activate">

						<?php wp_nonce_field( 'activate_email', 'security' ); ?>
						<input type="hidden" name="action" value="email_activate" >
						<input type="hidden" name="user_id" value="<?= $_GET['id']; ?>" >
						
						<span style="float: left" class="spinner spinner-change-email-activate"></span>
						<input type="submit" class="button green-text" value="Aktywuj" />
						
					</form>

					<form style="float: left;margin-left: 5px;" id="form-email-send">

						<?php wp_nonce_field( 'send_email_activation', 'security' ); ?>
						<input type="hidden" name="user_id" value="<?= $_GET['id']; ?>" >
						<input type="hidden" name="action" value="send_email_activation" >

						<span style="float: left" class="spinner spinner-change-email-send"></span>
						<input type="submit" class="button green-text" value="Wyślij ponownie" />
						
					</form>

					<br style="clear: both" />

					<?php endif; ?>

				</div>

			</div>

	
   		     <div id="postimagediv" class="postbox ">
				<div class="handlediv" title="Kliknij, aby przełączyć"><br></div><h3><span>Aktywuj konto</span></h3>
				<div class="inside">
					
					<p>Konto aktywne: 
						
						<?php if( $user->is_active()): ?>
							<span class="yes">Tak</span>
						<?php else: ?>
							<span class="no">Nie</span>
						<?php endif; ?>

					</p>

					<form id="form-active">

						<?php wp_nonce_field( 'change_active', 'security' ); ?>
						
						<input type="hidden" name="user_id" value="<?= $_GET['id']; ?>" >
						<span style="float: left" class="spinner spinner-change-active"></span>
						
						<?php if( $user->is_active()): ?>
							<input type="submit" class="button red-text" value="Zablokuj" />
						    <input type="hidden" name="action" value="account_disable" >
						<?php else: ?>
							<input type="submit" class="button green-text" value="Odblokuj" />
							<input type="hidden" name="action" value="account_enable" >
						<?php endif; ?>

					</form>

				</div>
				
			</div>


			<div id="postimagediv" class="postbox ">
				<div class="handlediv" title="Kliknij, aby przełączyć"><br></div><h3><span>Typ konta</span></h3>
				<div class="inside">
				
					<form id="form-type">

						<?php wp_nonce_field( 'change_user_type', 'security' ); ?>
						
						<input type="hidden" name="user_id" value="<?= $_GET['id']; ?>" >
						<input type="hidden" name="action" value="change_type" >

						<span style="float: left" class="spinner spinner-change-type"></span>
						
						<select name="type">
							
							<option value="coach" <?= $user->is_coach() ? 'selected' : '' ;?>>Coach</option>
							<option value="vip" <?= $user->is_vip() ? 'selected' : '' ;?>>VIP</option>
							<option value="cim" <?= $user->is_cim() ? 'selected' : '' ;?>>CIM</option>
							<option value="default" <?= $user->is_default() ? 'selected' : '' ;?>>Zwykły</option>

						</select>	
						
					</form>

				</div>
				
			</div>
			
	</div>

</div>
	
