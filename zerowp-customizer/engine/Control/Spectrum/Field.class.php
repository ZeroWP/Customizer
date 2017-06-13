<?php
namespace ZeroWPCustomizer\Control\Spectrum;

class Field extends \WP_Customize_Control {
	public $id;
	public $type = 'spectrum';
	public $args = array();

	public function __construct( $manager, $id, $args = array() ) {
		$this->id = $id;
		$this->args = $args;
		parent::__construct( $manager, $id, $args);
	}

	public function enqueue() {
		wp_enqueue_style('zwpc-spectrum');
		wp_enqueue_script('zwpc-spectrum');

		parent::enqueue();
	}

	public function render_content() {
		?>
			<div class="<?php echo sanitize_html_class( $this->id ); ?>_spectrum">
				<label>
					<?php 
						$output = '';
						$output .= '<div class="zerowpc-spectrum-block">';
							$output .= '<div class="zerowpc-spectrum-title">'. esc_html( $this->label ) .'</div>';
							$output .= '<input type="text" '. $this->get_link() .' value="'. $this->value() .'" class="zerowpc-spectrum-input" />';
						$output .= '</div>';

						echo $output;
					?>
					<?php if ( ! empty( $this->description ) ) : ?>
						<span class="description customize-control-description"><?php echo $this->description ; ?></span>
					<?php endif; ?>
					
				</label>
			</div>
		<?php
	}

}