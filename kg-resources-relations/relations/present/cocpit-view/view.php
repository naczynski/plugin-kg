<?php
	$relations = KG_Get::get('KG_Edit_User_Tab_Resources')->get_relation_object();
	$user = KG_Get::get('KG_User',  KG_Get::get('KG_Cocpit_Edit_Student')->get_user_id_from_url() );
?>
<div class=" add-present-wrapper">
			
			<h2>Podaruj zasób</h2>

			<form id="add_present">	

				<?php wp_nonce_field( 'send_present', 'security' ); ?>

				<input type="hidden" name="action" value="send_present">
				<input type="hidden" name="to_user_id" value="<?=$_GET['id'];?>">
				<input type="hidden" name="from_user_id" value="<?= KG_get_curr_user()->get_ID(); ?>">
				
				<!-- START -->
					
					<div id="poststuff">
					<div id="acf_744" class="postbox acf_postbox no_box">
						<h3 class="hndle"><span>Prezent</span></h3>
						<div class="inside"><div id="acf-present" class="field field_type-relationship field_key-resources_ids" data-field_name="present" data-field_key="resources_ids" data-field_type="relationship">

							<p class="label"><label for="acf-field-present"></label></p><div class="acf_relationship has-search has-post_type" data-max="10" data-s="" data-paged="1" data-post_type="pdf,link" data-taxonomy="all" data-field_key="field_557f65b48f9cb">
						
					<!-- Hidden Blank default value -->
					<input type="hidden" name="fields[resources_ids]" value="" />
					
					<!-- Left List -->
					<div class="relationship_left">
						<table class="widefat">
							<thead>
												<tr>
									<th>
										<input class="relationship_search" placeholder="Szukaj..." type="text" id="relationship_fields[resources_ids]" />
									</th>
								</tr>
											</thead>
						</table>
						<ul class="bl relationship_list">
							<li class="load-more">
								<div class="acf-loading"></div>
							</li>
						</ul>
					</div>
					<!-- /Left List -->
					
					<!-- Right List -->
					<div class="relationship_right">
						<ul class="bl relationship_list">
								</ul>
					</div>
					<!-- / Right List -->
					
				</div>
						</div></div></div>	
						
					</div><!-- <div id="poststuff"> -->

				<!-- END -->
		
				<div class="to float-right">
					<h4>Dla: <?= $user->get_name_and_surname(); ?></h4>	
					<h4>Od: <?= KG_get_curr_user()->get_name_and_surname(); ?></h4>	
					<p class="space-after">z wiadomością: </p>	
					<textarea name="message" placeholder="Treść wiadomości dla użytkownika"></textarea>

					<input type="submit" class="button button-primary button-large button-send" value="<?=__( 'Wyślij prezent', 'kg' ) ;?>">
					<span style="float: right;margin-top: 20px" class="spinner spinner-send-present"></span>
				
				</div>

			</form>

		<div style="clear: both"></div>

		</div>

<?php if (empty($relations)): ?>	
	<p style="clear: both" class="update-nag message-no-relations">Brak wyników dla zaznaczonych zagadnień</p>	
<?php else: ?>

	<table class="widefat my-resources">
		<thead>
			<tr>
				<th>Miniaturka</th>
				<th>Nazwa</th>
				<th>Od</th>
				<th>Wiadomość</th>
				<th>Data</th>
				<!-- <th></th> -->
			</tr>
		</thead>
		<tbody>

			<?php foreach ($relations as $key => $relation) :
				$alternate = $key % 2;
			 ?>	
				<tr>
					<td><img width="50" height="50" src="<?= $relation->get_resource()->get_thumbnail_small() ;?>" /></td>
					<td>
						<a href="<?= $relation->get_resource()->get_admin_edit_link(); ?>">
						     <?= $relation->get_resource()->get_name(); ?>
						</a>
					</td>
					<td><?=$relation->get_from_user()->get_name_and_surname();?></td>
					<td style="max-width: 500px"><?=$relation->get_message();?></td>
					<td><?=$relation->get_date() ;?></td>
					<!-- <td> 
						<form class="remove-relation">
							<?php wp_nonce_field( 'remove_relation', 'security' ); ?>
							<input type="hidden" name="action" value="remove_relation">
							<input type="hidden" name="relation_id" value="<?= $relation->get_relation_id();?>">
							<button class="preview button remove-relation">Usuń</a>
						</form>
					</td> -->
				</tr>
			<?php endforeach; ?>
		</tbody>
	</table>

<?php endif; ?>