<?php

	trait KG_Item_Trait_Serialization {

		private function get_serialized_fields_of_related_items(){
			$related_items = $this->get_related_items();
			$related_fields = array_map(function($item){
				return [
                	'id' => $item->get_ID(),
					'name' => $item->get_name(),
					'thumbnail_small' => $item->get_thumbnail_small(),
					'link' => $item->get_link(),
					'label' => $item->get_label(),
					'category_id' =>  $this->get_sub_category_id(),
					'tooltip' => $item->get_tooltip(),
					'short_desc' => strip_tags($item->get_short_desc()),
					'subtype_type' => $item->get_subtype_type()
				];
			},$related_items);

    		shuffle($related_fields);
    		return $related_fields;
		}

		public function get_serialized_fields_for($user_id){
			$out = array(                
                'related' =>  $this->get_serialized_fields_of_related_items(),
                'thumbnail_big' => $this->get_thumbnail_big(),
                'link'=> $this->get_link(),
				'type' => $this->get_type(),
                'name' => $this->get_name(),
                'name_with_subtype' => $this->get_name_with_subtype(),
                'short_desc' => $this->get_short_desc(),
                'long_desc' => $this->get_long_desc(),
                'id' => $this->get_ID(),

                'date_creation' => $this->get_item_date_creation(),
               
                'tooltip' => $this->get_tooltip(),
                'tooltip_icon' => $this->get_tooltip_icon(),

                'subtype_type' => $this->get_subtype_type(),

                'category_id' =>  $this->get_sub_category_id(),
                'is_cim_resource' => $this->is_cim_resource(), 
 				'tags' => $this->get_item_tags(),


                'is_promoted' => $this->is_promoted(),
                'icon' => $this->get_icon_name(),
                'filter' => $this->get_filter_type(),

                'label' => $this->get_label(),
                'short_type' => $this->get_subtype_short_name(),
                
                // like
                'number_likes'=> $this->number_likes(),   
                'is_user_like'=> $this->is_user_like($user_id),
                'can_like' => $this->can_like(),
                'like_tooltip' => 'Dodaj do ulubionych',

                // present
                'can_present' => $this->can_present(),
                'count_as_presents' => (int) $this->get_stat_value('sum_as_present'),
                'count_actions' => (int) $this->get_stat_value('sum_actions'),

                // is bought
				'can_buy' => $this->can_buy(), // (show folder icon)              
				'bought_label' => 'Kupiłeś już ten zasób',
			
			);

			if($this->show_download_button()){
				$out['show_download_button'] = true;
			}

			if($this->can_use_as_free()){
				$out['as_free_resource'] = true;
			}

			if($this->can_download($user_id)){
				$out['can_download'] = true;
			}

			if($this->is_in_basket($user_id)){
				$out['is_in_basket'] = true;
			}
			
			return $out;
		}


	}