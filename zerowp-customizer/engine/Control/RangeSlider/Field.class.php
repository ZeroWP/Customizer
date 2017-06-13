<?php
namespace ZeroWPCustomizer\Control\RangeSlider;

class Field extends \WP_Customize_Control {
	public $id;
	public $type = 'range_slider';
	public $args = array();

	public function __construct( $manager, $id, $args = array() ) {
		$this->id = $id;
		$this->args = $args;
		parent::__construct( $manager, $id, $args);
	}

	public function enqueue() {
		wp_enqueue_style('zwpc-range-slider');
		wp_enqueue_script('zwpc-range-slider');

		parent::enqueue();
	}

	public function render_content() {
		?>
			<div class="<?php echo $this->id; ?>_range_slider">
				<label>
					<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
					<?php if ( ! empty( $this->description ) ) : ?>
						<span class="description customize-control-description"><?php echo $this->description ; ?></span>
					<?php endif; ?>
				</label>
					
				<?php 
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
				?>

			</div>
		<?php
	}

}