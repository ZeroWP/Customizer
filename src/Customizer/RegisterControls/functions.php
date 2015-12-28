<?php
function zerowp_customizer_custom_controls(){
	return apply_filters( 'zerowp_customizer_custom_controls', array() );
}
function zerowp_customizer_register_control( $type_name, $class_name ){
	$log_control = new ZeroWP\Customizer\Register( $type_name, $class_name );
	$log_control->register();
}

function zerowp_customizer_deregister_control( $type_name ){
	$log_control = new ZeroWP\Customizer\Register( $type_name );
	$log_control->deregister();
}

/*
-------------------------------------------------------------------------------
Register built-in controls
-------------------------------------------------------------------------------
*/
zerowp_customizer_register_control( 'color', 'WP_Customize_Color_Control' );
zerowp_customizer_register_control( 'upload', 'WP_Customize_Upload_Control' );
zerowp_customizer_register_control( 'image', 'WP_Customize_Image_Control' );
zerowp_customizer_register_control( 'background', 'WP_Customize_Background_Image_Control' );