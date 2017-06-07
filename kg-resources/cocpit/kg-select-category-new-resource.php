<?php

class KG_Select_Category_New_Resource {

	private function get_selector_for_toggle_parent_category(){
		$taxonomies = apply_filters('super_category_toggler',array());
		
		for($x=0;$x<count($taxonomies);$x++){
			$taxonomies[$x] = '#'.$taxonomies[$x].'div .selectit input';
		}
		
		$selector = implode(',',$taxonomies);
		if($selector == '') $selector = '.selectit input';
		return $selector;
	}

	// tooggle parent category and require select category when add resource
	public function add_scripts(){

		?>
			<script>
				
				jQuery("<?=$this->get_selector_for_toggle_parent_category() ;?>").change(function(){
					var $chk = jQuery(this);
					var ischecked = $chk.is(":checked");
					$chk.parent().parent().siblings().children("label").children("input").each(function(){
					var b = this.checked;
					ischecked = ischecked || b;
					})
					checkParentNodes(ischecked, $chk);
				});
				
				function checkParentNodess(b, $obj){
					$prt = findParentObj($obj);
					if ($prt.length != 0)
					{
					 $prt[0].checked = b;
					 checkParentNodes(b, $prt);
					}
				}
				function findParentObj($obj){
					return $obj.parent().parent().parent().prev().children("input");
				}

				jQuery('#publish').click(function(){
				   	var cats = jQuery('[id^=\"taxonomy\"]')
				      .find('.selectit')
				      .find('input');
					
				    var selectedCategory = false;
				    var selectedTag = false;

					if(cats.length){

						for (counter=0; counter<cats.length; counter++) {
							var el = cats.get(counter),
								name = el.getAttribute('name');

							if (el.checked === true && name === 'post_category[]') {
								selectedCategory=true;
							}
						
							if (el.checked === true && name === 'tax_input[subtype][]') {
								selectedTag=true;
							}

						}

						var error, selctor;

						if(!selectedCategory) {
							error = 'Musisz zaznaczyć kategorię zasobu.',
							seletor = 'category-all';
						}	

						if(!selectedTag) {
							error = 'Musisz zaznaczyć tag.',
							seletor = 'subtype-all';
						}

						jQuery('[id^="taxonomy"]').find('.tabs-panel').css({
								'background' : '#fff',
								'border' : 'none'
						});

						if(!selectedCategory || !selectedTag){
							alert(error);
							setTimeout("jQuery('#ajax-loading').css('visibility', 'hidden');", 100);
							jQuery('[id^="taxonomy"]').find('.tabs-panel#' + seletor).css({
								'background' : '#FFEBE8',
								'border' : '#CC0000 solid 1px'
							});
							setTimeout("jQuery('#publish').removeClass('button-primary-disabled');", 100);
							return false;
						} 
					
					}
				  });

			</script>
		<?php
	}

	public function __construct(){
		add_action('admin_footer-post.php', array($this, 'add_scripts') );
		add_action('admin_footer-post-new.php', array($this, 'add_scripts') );	
	}

}
