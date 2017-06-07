
<h2>Dodaj użytkownika</h2>

<form id="add-user-form" method="post" onsubmit="return false;" novalidate="novalidate">
	
	<!-- Main message -->
	<div class="main-message">
		<p></p>
	</div>

	<input type="hidden" name="action" value="add_user_cocpit" />
	<input type="hidden" name="type" value="student" />

   <h3 class="title">Podstawowe informacje</h3>

   <table class="form-table">

      <tbody>
         
		<tr>
			<th scope="row"><label for="signup_email"><?php _e( 'E-mail', 'kg' ); ?></label></th>
			<td>
				<input name="signup_email" type="email" id="blogname" value="" class="regular-text">
				<p class="error"></p>
			</td>
		</tr>

		<tr>
			<th scope="row"><label for="signup_password"><?php _e( 'Hasło', 'kg' ); ?></label></th>
			<td>
				<input name="signup_password" type="password" value="<?=KG_Config::getPublic('default_password');?>" class="regular-text">
				<p class="error"></p>
			</td>
		</tr>
		
		<div id="pass-strength-result"></div>

		<tr>
			<th scope="row"><label for="signup_password_confirm"><?php _e( 'Powtórz hasło', 'kg' ); ?></label></th>
			<td>
				<input name="signup_password_confirm" type="password" id="pass2" class="regular-text" size="16" value="<?=KG_Config::getPublic('default_password');?>" autocomplete="off">
				<p class="error"></p>
				<p class="description">Domyślne hasło: <?=KG_Config::getPublic('default_password');?></p>
			<!-- 	<br>
				<div id="pass-strength-result" style="display: block;">Siłomierz</div>
				<p class="description indicator-hint">Rada: hasło powinno zawierać przynajmniej siedem znaków. Aby było silniejsze, użyj małych i wielkich liter, cyfr oraz znaków takich jak: ! " ? $ % ^ &amp; ).</p>
			 -->
			</td>
		</tr>

      </tbody>
   
   </table>
	
   <?php wp_nonce_field( 'add_user', 'security' ); ?>

				<?php

					$group_fields = KG_Get::get('KG_User_Fields_Loop')->get_in_cocpit_groups_fields();
					
					foreach($group_fields as $group) : 
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
										<p class="error"></p>
									</td>
								</tr>

								<?php endforeach; ?>
						
						      </tbody>
						   
						</table>

					<?php endforeach; ?>

   <p class="submit">
   
   	<input type="submit" name="submit" id="submit" class="button button-primary" value="Dodaj">
	<span style="float: left" class="spinner spinner-add-user"></span>
   
   </p>
 	
</form>