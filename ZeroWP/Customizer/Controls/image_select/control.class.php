<?php
namespace ZeroWP\Customizer;

zerowp_customizer_register_control( 'image_select', __NAMESPACE__ . '\\ImageSelect' );
add_action( 'customize_register', __NAMESPACE__ . '\\zerowp_customizer_register_control_image_select' );

function zerowp_customizer_register_control_image_select( $wp_customize ){
	class ImageSelect extends \WP_Customize_Control {
		public $type = 'image_select';
		public $args = array();

		public function __construct( $manager, $id, $args = array() ) {
			$this->args = $args;
			parent::__construct( $manager, $id, $args);
		}

		public function enqueue() {
			wp_register_style( 'zerowp-customizer-image-select-styles', plugin_dir_url( __FILE__ ) .'assets/styles.css');
			wp_enqueue_style('zerowp-customizer-image-select-styles');

			wp_register_script( 'zerowp-customizer-image-select-scripts', plugin_dir_url( __FILE__ ) .'assets/scripts.js', 'jquery', false, true);
			wp_enqueue_script('zerowp-customizer-image-select-scripts');

			parent::enqueue();
		}

		public function render_content() {
			?>
				<div class="<?php echo $this->id; ?>_image_select">
					<label>
						<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
						<?php if ( ! empty( $this->description ) ) : ?>
							<span class="description customize-control-description"><?php echo $this->description ; ?></span>
						<?php endif; ?>
					</label>
						
					<?php 
						$styles = $this->args['choices'];

						echo '<div class="zerowp-customizer-image-select-control-block"'. $this->getLinkWith() .'>';
							foreach ($styles as $style) {
								if( is_array($style) ){
									echo '<img'. $this->getValueAttributes( $style ) . $this->getStyleClass( $style ) . $this->getOptionAttributes( $style ) . $this->getParentOption( $style ) .' />';
								}
								else{
									echo '<div class="zerowp-customizer-image-select-section-label">'. esc_attr($style) .'</div>';
								}
							}
							$this->getValueInput();
						echo '</div>';
					?>
				</div>
			<?php
		}

		public function getLinkWith(){
			return ( !empty($this->args['link_with']) ) ? ' data-link-with="'. $this->args['link_with'] .'"' : '';
		}

		public function getValueAttributes( $style ){
			return ' src="'. $style['img'] .'" data-value="'. $style['value'] .'" alt="'. $style['value'] .'"';
		}

		public function getOptionAttributes( $args ){
			$attributes = '';
			foreach ($args as $data => $key) {
				if( strrpos( $data, 'data-') !== false ){
					$attributes .= ' '. $data . '="'. esc_attr( $key ) .'"';
				}
			}
			return $attributes;
		}

		public function getParentOption( $style ){
			return ( !empty($style['parent_option']) ) ? ' data-parent-option="' . esc_attr($style['parent_option']) . '"' : '';
		}

		public function getStyleClass( $style ){
			$active = ( $this->value() == $style['value'] ) ? ' active' : '';
			return  ' class="zerowp-customizer-image-select-control-element'. $active .'"';
		}

		public function getValueInput(){
			echo '<input class="zerowp-customizer-image-select-control-value" type="hidden" value="'. $this->value() .'" '. $this->get_link() .' />';	
		}

	}
}