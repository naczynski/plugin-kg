<?php

	abstract class KG_Stat_Box {

		protected $widget_id;
		private $path;

		private $bar_colors = array(
			'220,220,220',
			'151,187,205',
			'0,187,205',
			'151,187,0'
		);


		public function __construct($widget_id, $widget_name, $path){
			$this->widget_id = $widget_id;
			$this->path = $path;
			
			add_action( 'wp_dashboard_setup', function() use($widget_id, $widget_name){
				wp_add_dashboard_widget($widget_id, $widget_name, array($this, 'render') );
			});
			
			add_action('admin_enqueue_scripts', array($this, 'add_scripts') );
		}

		public function add_scripts() {
			 if(get_current_screen()->id == 'dashboard') {
				 wp_register_script( 
				 	$this->widget_id, 
				 	plugins_url( 'assets/' . $this->widget_id . '.js', $this->path ),
				 	array('kg_stats_utils')
				 );	
				 wp_enqueue_script($this->widget_id);
			}
		}

		private function get_data_for_config_obj($data, $type){

			$out = array();
			foreach ((array) $data as $key => $data_obj) {
				$out[] = array(
		            'label' =>  $data_obj['label'],
		            'fillColor' => "rgba(" . $this->bar_colors[$key] . ",0.5)",
		            'strokeColor' => "rgba(" . $this->bar_colors[$key] . ",0.8)",
		            'highlightFill' => "rgba(" . $this->bar_colors[$key] . ",0.75)",
		            'highlightStroke' => "rgba(" . $this->bar_colors[$key] . ",1)",
		            'data' => $data_obj['data']
				);	
			}
			return $out;
		}

		public function chart_config_obj($data_names, $values, $type, $label_type='', $extra = array()) {
			return array_merge(array(
				'labels' => $data_names,
				'labelType' => $label_type,
  				'datasets' => $this->get_data_for_config_obj($values, $type)
			), $extra);
		}

		abstract public function render();

	}