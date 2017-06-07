<?php

	trait KG_Item_Trait_Related {


		private function get_related_items_objects() {

			if( empty($this->get_resource_meta()['related_items']) || $this->get_resource_meta()['related_items'] == false  ) {
				$this->related = array();
				return;
			}

			foreach ($this->get_resource_meta()['related_items'] as $post_obj) {	
				$this->related[] = KG_get_resource_object($post_obj->ID);
			}

		}

		public function get_related_items() {

			if(empty($this->related)) $this->get_related_items_objects();
			return $this->related;

		}

	}