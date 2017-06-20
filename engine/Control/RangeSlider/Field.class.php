<?php
namespace ZeroWPCustomizer\Control\RangeSlider;

use ZeroWPCustomizer\ControlBase;

class Field extends ControlBase {
	public function enqueue() {
		wp_enqueue_style('zwpc-range-slider');
		wp_enqueue_script('zwpc-range-slider');

		parent::enqueue();
	}

	public function fieldContent() {
		$min = !empty($this->args['min']) && is_numeric($this->args['min']) ? $this->args['min'] : 0;
		$max = !empty($this->args['max']) && is_numeric($this->args['max']) ? $this->args['max'] : $min+100;
		$step = !empty($this->args['step']) && is_numeric($this->args['step']) ? $this->args['step'] : 1;
		$postfix = !empty($this->args['postfix']) ? esc_html($this->args['postfix']) : '';
		
		$attributes = ' min="'. $min .'" max="'. $max .'" step="'. $step .'" data-postfix="'. esc_html($postfix) .'"';

		//html output
		$output = '';
		$output .= '<div class="zerowpc-range-slider-block">';
			$output .= '<input type="text" '. $this->get_link() .' value="'. $this->value() .'"'. $attributes .' class="zerowpc-range-slider-input" />';
		$output .= '</div>';

		echo $output;
	}

}