<?php

	trait KG_Item_Trait_Subtype {

			public function get_desc_knowledge_to_share_category() {
				return "Knowledge to Share to gotowa do użycia prezentacja, w której zawarliśmy praktyczną wiedzę i podpowiadamy Ci w jaki sposób przekazać ją innym. ";
			}

			public function get_desc_knowledge_to_master_category() {
				return "Knowledge to Master to résumé tego, co najbardziej wartościowe w danej publikacji książkowej; pozwoli Ci zagłębić się w prezentowane zagadnienia, zastępując właściwą lekturę lub stanowiąc dla niej formę przyjemnego preludium.";
			}

			public function get_desc_knowledge_to_listen_category() {
				return "Knowledge to Listen to Knowledge to Master, ale w wersji audio. Jeżeli nie masz czasu na czytanie, bądź umiejętnie łączysz bieganie czy jazdę autem z pogłębianiem wiedzy nabywaniem nowej wiedzy, będzie to znakomita forma rozwoju.";
			}

			public function get_desc_knowledge_to_inspire_category() {
				return "Knowledge to Inspire to kilkustronicowe wprowadzenie do tematu, które może zachęcić Cię do jego dalszego zgłębiania. Zainspirowanie się zajmie Ci nie więcej czasu niż wypicie jednej kawy. ";
			}

			public function get_name_with_subtype(){
				if($this->get_subtype_name() == '') return $this->get_name();
				return $this->get_name() . ' (' . $this->get_subtype_name() . ')';
			}

			public function get_icon_name() {			
				return $this->get_sub_category_id();
			}

			private function get_pretty_type_name() {
				return $this->get_sub_category_name() ? $this->get_sub_category_name() : '';
			}

			public function is_show_tooltip_on_thumb() {
				return (bool) $this->get_subtype_name(); 
			}

			public function get_subtype_name(){
				$label='';
				if ($this->is_case_study_category()) $label = __( 'Case Study', 'kg' );
				if ($this->is_knowledge_to_inspire_category()) $label =  __( 'Knowledge to Inspire', 'kg' );
				if ($this->is_knowledge_to_share_category()) $label =  __( 'Knowledge to Share', 'kg' );
				if ($this->is_knowledge_to_master_category()) $label =  __( 'Knowledge to Master', 'kg' );
				if ($this->is_knowledge_to_listen_category()) $label =  __( 'Knowledge to Listen', 'kg' );
				return $label;
			}

			public function get_subtype_short_name(){
				if ($this->is_case_study_category()) return __( 'Case Study', 'kg' );
				if ($this->is_knowledge_to_inspire_category()) return __( 'KtI', 'kg' );
				if ($this->is_knowledge_to_share_category()) return __( 'KtS', 'kg' );
				if ($this->is_knowledge_to_master_category()) return __( 'KtM', 'kg' );
				if ($this->is_knowledge_to_listen_category()) return __( 'KtL', 'kg' );
				return '';
			}

			public function get_subtype_type(){
				return $this->get_subtype_name();
			}

			public function get_label(){
				if ($this->is_case_study_category()) return __( 'Case Study', 'kg' );
				if ($this->is_knowledge_to_inspire_category()) return $this->get_subtype_name();
				if ($this->is_knowledge_to_share_category()) return $this->get_subtype_name();
				if ($this->is_knowledge_to_master_category()) return $this->get_subtype_name();
				if ($this->is_knowledge_to_listen_category()) return $this->get_subtype_name();

				return $this->get_pretty_type_name(); 
			}

			public function get_tooltip_icon(){
				$label='';
				if ($this->is_case_study_category()) $label = __( 'Case Study', 'kg' );
				if ($this->is_knowledge_to_inspire_category()) $label =  __( 'Knowledge to Inspire', 'kg' );
				if ($this->is_knowledge_to_share_category()) $label =  __( 'Knowledge to Share', 'kg' );
				if ($this->is_knowledge_to_master_category()) $label =  __( 'Knowledge to Master', 'kg' );
				if ($this->is_knowledge_to_listen_category()) $label =  __( 'Knowledge to Listen', 'kg' );
				$label = $this->get_sub_category_name();
				return ( $this->is_cim_resource() ) ? $label.=' (CIM)' : $label;
			}

			public function get_tooltip() {

				//categories
				if ($this->is_case_study_category()) return __( 'Case Study', 'kg' );
				if ($this->is_knowledge_to_inspire_category()) return $this->get_desc_knowledge_to_inspire_category();
				if ($this->is_knowledge_to_share_category()) return $this->get_desc_knowledge_to_share_category();
				if ($this->is_knowledge_to_master_category()) return $this->get_desc_knowledge_to_master_category();
				if ($this->is_knowledge_to_listen_category()) return $this->get_desc_knowledge_to_listen_category();

				return ''; 

			}
	}