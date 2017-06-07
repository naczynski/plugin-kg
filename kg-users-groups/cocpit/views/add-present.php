<?php
	global $post;
?>

<div class="my-resources">
	<div class=" add-present-wrapper" style="width: 97%; min-height: 516px;margin: 0px">
			
		<form id="add_present">	

			<!-- START -->
				
				<div id="poststuff">
				<div id="acf_744" class="postbox acf_postbox no_box">
					<h3 class="hndle"><span>Prezent</span></h3>
					<div class="inside"><div id="acf-present" class="field field_type-relationship field_key-resources_ids" data-field_name="present" data-field_key="resources_ids" data-field_type="relationship">

						<p class="label"><label for="acf-field-present"></label></p><div style="width: 42%" class="acf_relationship has-search has-post_type" data-max="10" data-s="" data-paged="1" data-post_type="pdf,link" data-taxonomy="all" data-field_key="field_557f65b48f9cb">
					
				<!-- Hidden Blank default value -->
				<input type="hidden" name="fields[resources_ids]" value="" />
				
				<!-- Left List -->
				<div class="relationship_left" style="width: 111%">
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
				<div class="relationship_right" style="height: 195px;top: 0px;right: -135%;left: auto;width: 121%">
					<ul style="margin-left: 0;" class="bl relationship_list">
					</ul>
				</div>
				<!-- / Right List -->
			
				<div style="top: 0; margin-top: 0; top: 100%; right: -135%;margin-left: 4px;width: 121%;position: absolute" class="to">
					<p>z wiadomością: </p>	
					<textarea name="message_present" placeholder="Treść wiadomości dla użytkownika"></textarea>

					<a style="float: right; margin: 10px;" class="button button-primary button-large button-send-present" ><?=__( 'Wyślij prezent', 'kg' ) ;?></a>
					<span style="float: right;margin-top: 20px" class="spinner spinner-send-present"></span>
						
				</div>
			
			</div>	
					</div></div></div>	
					
				</div><!-- <div id="poststuff"> -->

				<div style="clear: both"></div>

			<!-- END -->
	
			<div style="clear: both"></div>

		</form>



	</div>

	<div style="clear: both"></div>

</div>

<div style="clear: both"></div>
