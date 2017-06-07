<?php

	trait KG_Item_Trait_Thumnail {


		public function get_thumbnail_small() {

			if ( !has_post_thumbnail($this->id) ) {
				return KG_Config::getPublic('default_resource_thumb');
			}

			$thumb_id = get_post_thumbnail_id($this->id);
			$thumb_url = wp_get_attachment_image($thumb_id, 'thumb_big');
			preg_match('/src="(.*?)"/', $thumb_url , $matches);

			return !empty($matches[1]) ? $matches[1] : '';

		}

		public function get_thumbnail_big() {
			return $this->get_thumbnail_small();
		}

	}