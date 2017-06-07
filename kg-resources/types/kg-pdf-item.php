<?php


	class KG_Pdf_Item extends KG_Item implements JsonSerializable {


		public function __construct($quiz_id) {
			parent::__construct($quiz_id);
		}

		/* ==========================================================================
		   FILE
		   ========================================================================== */
			
		public function get_private_file() {
			return $this->get_resource_meta()['private_file'];		
		}

		public function get_private_file_link() {
			return '/pobierz/?type=resource&resource_id=' . $this->id;
		
		}

		/* ==========================================================================
		   BUY
		   ========================================================================== */

		public function get_price() {
			if (!empty( $this->get_resource_meta()['price'] )){
				$price = (int) $this->get_resource_meta()['price']; 
				return ($price > 0) ? $price : 0;
			}
			return 0;
		}

		public function can_buy() {
			if( in_array($this->get_sub_category_id(), KG_Config::getPublic('categories_can_buy')) ) return true;
			return false;
		}

		public function can_like() {
			return true;
		}

		public function can_present() {
			return $this->can_buy();
		}

		public function get_tooltip_for_award_lighhtbox(){
			return $this->get_short_desc();
		}

		/* ==========================================================================
		   SERIALIZATION
		   ========================================================================== */

		public function get_serialized_fields_for($user_id){
			$fields = parent::get_serialized_fields_for($user_id);
			$fields['price'] = $this->get_price();
			$fields['private_file_link'] = $this->get_private_file_link();
			return $fields;
		}

		public function jsonSerialize() {
      	  return array(
      	  	'id' => $this->get_ID(),
       		'download_link' => $this->get_private_file_link(),
       		'name' => $this->get_name(),
       		'short_desc' => $this->get_short_desc(),
       		'name_with_subtype' => $this->get_name_with_subtype(),
       		'thumbnail_big' => $this->get_thumbnail_big(),
       		'category_id' => $this->get_sub_category_id(),
       		'link'=> $this->get_link(),
       		'tooltip' => $this->get_tooltip(),
       		'short_desc' => $this->get_short_desc(),
       		'short_description' => $this->get_short_desc(),
       		'type' => $this->get_subtype_short_name()
      	  );
    	}

	}