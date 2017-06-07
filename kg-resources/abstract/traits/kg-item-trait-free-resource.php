<?php

	trait KG_Item_Trait_Free_Resource  {


		public function can_use_as_free(){
			return KG_Get::get('KG_Free_Resources')->can_get_as_free_resource($this->id);
		}

		public function is_choosen_as_free(){
			
		}


	}