<?php
namespace ZeroWPCustomizer\Control\Font;

use ZeroWPCustomizer\ControlBase;

class Field extends ControlBase {

	public function enqueue() {
		wp_enqueue_style('zwpc-font-field');
		wp_enqueue_script('zwpc-font-field');

		parent::enqueue();
	}

	public function fieldContent() {
		echo '<div class="zerowpc-fonts-block">
			<div class="zerowpc-show-selected-font"><div class="zerowpc-font-item"></div></div>
			<input type="hidden" class="zerowpc-fonts-value" '. $this->get_link() .' '. $this->value() .' />
		</div>';
	}

	// public function child_fields( $ctz ){
		// $setting_args = $this->args;
		// $setting_args['type'] = $this->args['transport_type'];

		// // Font weight
		// $setting_args['default'] = !empty($this->args['font_weight']) ? $this->args['font_weight'] : '400';
		// $ctz->add_setting( $this->id .'_weight', $setting_args );

		// $weight_args = $this->args;
		// $weight_args['label'] = _x('Weight', 'The font weight', 'zerowp-customizer');
		// $weight_args['type'] = 'select';
		// $weight_args['choices'] = array(
		// 	'100' => '100',
		// 	'200' => '200',
		// 	'300' => '300',
		// 	'400' => _x('Normal - 400', 'Font weight', 'zerowp-customizer'),
		// 	'500' => '500',
		// 	'600' => '600',
		// 	'700' => _x('Bold - 700', 'Font weight', 'zerowp-customizer'),
		// 	'800' => '800',
		// 	'900' => '900',
		// );
		// $ctz->add_control( $this->id .'_weight', $weight_args );

		// // Font style
		// $setting_args['default'] = !empty($this->args['font_style']) && in_array( $this->args['font_style'], array('normal', 'italic') ) ? $this->args['font_style'] : 'normal';
		// $ctz->add_setting( $this->id .'_style', $setting_args );

		// $style_args = $this->args;
		// $style_args['label'] = _x('Style', 'The font style',  'zerowp-customizer');
		// $style_args['type'] = 'radio';
		// $style_args['choices'] = array(
		// 	'normal' => _x('normal', 'font style normal', 'zerowp-customizer'),
		// 	'italic' => _x('italic', 'font style italic', 'zerowp-customizer'),
		// );
		// $ctz->add_control( $this->id .'_style', $style_args );

		// // Font family
		// $setting_args['default'] = !empty($this->args['font_family']) ? $this->args['font_family'] : 'sans-serif';
		// $ctz->add_setting( $this->id .'_family', $setting_args );

		// $family_args = $this->args;
		// $family_args['label'] = _x('Family', 'The font family', 'zerowp-customizer');
		// $family_args['type'] = 'select';
		// $family_args['choices'] = array(
		// 	'sans-serif' => _x('sans-serif', 'Font family', 'zerowp-customizer'),
		// 	'serif' => _x('serif', 'Font family', 'zerowp-customizer'),
		// 	'monospace' => _x('monospace', 'Font family', 'zerowp-customizer'),
		// 	'fantasy' => _x('fantasy', 'Font family', 'zerowp-customizer'),
		// 	'cursive' => _x('cursive', 'Font family', 'zerowp-customizer'),
		// );
		// $ctz->add_control( $this->id .'_family', $family_args );

	// }

}