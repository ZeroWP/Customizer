<?php
function zerowp_customizer_do_the_css(){
	$less = new ZeroWP\Customizer\Css;

	ob_start();
	do_action('zerowp_customizer_css', $less);
	$out = ob_get_contents();
	ob_end_clean();

	if( is_customize_preview() ){
		echo '<style>'. $out .'</style>';
	}
	else{
		$required_compilation = get_option('zerowp_customizer_compilation_required');
		if( !empty($required_compilation) ){
			if( $less->compileCssToFile( $out ) !== false ) {
				delete_option('zerowp_customizer_compilation_required');
			}
		}
		wp_enqueue_style( 'qwc-main', $less->stylesheetUrl() );
	}
}
if( is_customize_preview() ){
	add_action( 'wp_head', 'zerowp_customizer_do_the_css' );
}
else{
	add_action( 'wp_enqueue_scripts', 'zerowp_customizer_do_the_css', 99 );
}


function zerowp_customizer_request_compile_css(){
	update_option('zerowp_customizer_compilation_required', time());
}
add_action('customize_save', 'zerowp_customizer_request_compile_css');