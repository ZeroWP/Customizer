<?php 
/* No direct access allowed!
---------------------------------*/
if ( ! defined( 'ABSPATH' ) ) exit;

/* Inject the component
----------------------------*/
add_action( 'zwpc:create', function( $ctz ){
	
	// Built-in WP control types
	$ctz->addControlType( 'color', 'WP_Customize_Color_Control' );
	$ctz->addControlType( 'image', 'WP_Customize_Image_Control' );
	$ctz->addControlType( 'media', 'WP_Customize_Media_Control' );
	$ctz->addControlType( 'upload', 'WP_Customize_Upload_Control' );
	$ctz->addControlType( 'cropped_image', 'WP_Customize_Cropped_Image_Control' );

	// Built-in custom control types 
	$controls = glob(ZWPC_PATH .'engine/Control/*', GLOB_ONLYDIR);
	foreach ($controls as $control) {
		$controlname  = basename($control);
		$ctz->addControlType( $controlname, 'ZeroWPCustomizer\\Control\\'. $controlname .'\\Field' );
	}
});