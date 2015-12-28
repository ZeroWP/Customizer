<?php
namespace ZeroWP\Customizer;

zerowp_customizer_register_control( 'info_text', __NAMESPACE__ . '\\InfoText' );
add_action( 'customize_register', __NAMESPACE__ . '\\zerowp_customizer_register_control_info_text' );

function zerowp_customizer_register_control_info_text( $wp_customize ){
	class InfoText extends \WP_Customize_Control {
		public $type = 'info_text';
		public $args = array();

		public function __construct( $manager, $id, $args = array() ) {
			$this->args = $args;
			parent::__construct( $manager, $id, $args);
		}

		public function render_content() {
			$output = '';
			$output .= '<div class="info-text-customizer-control">';
				if( !empty($this->label) ){
					$output .= '<h2>' . $this->label . '</h2>';
				}
				if( !empty($this->description) ){
					$output .= '<div>' . $this->description . '</div><p></p>';
				}
			$output .= '</div>';
			echo $output;
		}

	}
}