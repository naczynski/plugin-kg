<?php

	class KG_Event_Item extends KG_Item {

		public function __construct($quiz_id) {
			parent::__construct($quiz_id);
		}

		/* EVENT
		   ========================================================================== */

		public function get_available_seats() {
			return (int) $this->get_resource_meta()['avaliable_places'];
		}

		public function is_enought_seats( $seats_to_buy = 1) {
			return ( $this->get_available_seats() >= (int) $seats_to_buy) ? true : false;
		}

		private function reserve_seat() {
			if( !$this->is_enought_seats() ) return false;
			update_field('avaliable_places', $this->get_available_seats()-1, $this->id);
		}

		public function get_place() {
			if(empty($this->get_resource_meta()['place'])) return '';
			return str_replace(', Polska',  '', $this->get_resource_meta()['place']['address']);	
		}

		public function get_date() {
			return !empty($this->get_resource_meta()['date']) ? 
				'<span class="white-text" layout-margin> | </span>' . $this->get_resource_meta()['date'] : 
				'';	
		}

		public function get_info() {
			return str_replace(
				array(
					'{{place}}',
					'{{date}}',
					'{{seats}}'
				), array(
					$this->get_place(),
					$this->get_date(),
					$this->get_available_seats()
				),
				'{{place}} {{date}} <span class="white-text" layout-margin> | </span>  Ilość wolnych miejsc: {{seats}}'
			);
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
			return true;
		}

		public function can_like() {
			return true;
		}

		public function can_present() {
			return false;
		}

		public function after_buy(){
			$this->reserve_seat();
		}

		/* ==========================================================================
		   SERIALIZATION
		   ========================================================================== */

		public function get_serialized_fields_for($user_id){
			$fields = parent::get_serialized_fields_for($user_id);
			$fields['available_seats'] = $this->get_available_seats();
			$fields['info'] = $this->get_info();
			$fields['price'] = $this->get_price();
			return $fields;
		}
	}
