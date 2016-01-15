<?php
namespace ZeroWP\Customizer;

zerowp_customizer_register_control( 'ui_slider', __NAMESPACE__ . '\\UiSlider' );
add_action( 'customize_register', __NAMESPACE__ . '\\zerowp_customizer_register_control_ui_slider' );

function zerowp_customizer_register_control_ui_slider( $wp_customize ){
	class UiSlider extends \WP_Customize_Control {
		public $id;
		public $type = 'ui_slider';
		public $args = array();

		public function __construct( $manager, $id, $args = array() ) {
			$this->id = $id;
			$this->args = $args;
			parent::__construct( $manager, $id, $args);
		}

		public function enqueue() {
			wp_register_style( 'zerowp-customizer-ui-slider-styles', plugin_dir_url( __FILE__ ) .'assets/styles.css');
			wp_enqueue_style('zerowp-customizer-ui-slider-styles');

			wp_register_script( 'zerowp-customizer-ui-slider-scripts', plugin_dir_url( __FILE__ ) .'assets/scripts.js', array( 'jquery', 'jquery-ui-core' ), false, true);
			wp_enqueue_script('zerowp-customizer-ui-slider-scripts');

			parent::enqueue();
		}

		public function render_content() {
			?>
				<div class="<?php echo $this->id; ?>_ui_slider">
					<label>
						<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
						<?php if ( ! empty( $this->description ) ) : ?>
							<span class="description customize-control-description"><?php echo $this->description ; ?></span>
						<?php endif; ?>
					</label>
						
					<?php 
						$output = '';
		
						$min  = ( !empty($this->args['min']) ) ? absint($this->args['min']) : 0;
						$max  = ( !empty($this->args['max']) ) ? absint($this->args['max']) : absint($min) + 100;
						$step = ( !empty($this->args['step']) ) ? absint($this->args['step']) : 1;
						$value = $this->value();
						$val  = ( !empty($value) ) ? absint($value) : $min+1;
						$data = ' data-val="'. $val .'" data-min="'. $min .'" data-max="'. $max .'" data-step="'. $step .'"';
						
						//html output

						$output .= '<div class="zerowp-customizer-ui-slider-block">';
							$output .= '<input type="text" '. $this->get_link() .' value="'. $val .'" min="'. $min .'" max="'. $max .'" step="'. $step .'" class="zerowp-customizer-ui-slider-input" />';
							$output .= '<div id="'.esc_attr($this->id).'-slider" class="zerowp-customizer-ui-slider"'. $data .'></div>';
						$output .= '</div>';		

						echo $output;
					?>

				</div>
			<?php
		}

	}
}