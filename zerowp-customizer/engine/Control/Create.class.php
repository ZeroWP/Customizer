<?php
namespace ZeroWPCustomizer\Control;

class Create{

	public function __construct(){
		add_action( 'customize_register', array( __CLASS__, 'registerBuiltInControls' ) );
		add_action( 'customize_register', array( __CLASS__, 'registerBuiltInCustomControls' ) );
	}
	
	//------------------------------------//--------------------------------------//

	/**
	 * String convertor
	 *
	 * Convert strings from camelCase to snake_case
	 *
	 * @param string $string String to be converted
	 * @return string Converted string
	 */
	public static function camelToSnake( $string){
		return strtolower(preg_replace(['/([a-z\d])([A-Z])/', '/([^_])([A-Z][a-z])/'], '$1_$2', $string));
	}

	//------------------------------------//--------------------------------------//

	/**
	 * Access to all custom customizer controls.
	 *
	 * @return array 
	 */
	public static function controls(){
		return apply_filters( 'zwpc:controls', array() );
	}
	
	//------------------------------------//--------------------------------------//
	
	/**
	 * Register custom control
	 *
	 * Register custom control
	 *
	 * @param string $type_name Control type ID
	 * @param string $class_name The PHP class used by this control type
	 * @return void
	 */
	public static function registerControl( $type_name, $class_name ){
		new Register( 'add', $type_name, $class_name );
	}

	//------------------------------------//--------------------------------------//
	
	/**
	 * DeRegister custom control
	 *
	 * DeRegister custom control
	 *
	 * @param string $type_name Control type ID
	 * @return void
	 */
	public static function deregisterControl( $type_name ){
		new Register( 'remove', $type_name );
	}

	//------------------------------------//--------------------------------------//
	
	/**
	 * Register WP built-in controls
	 *
	 * Register WP built-in controls
	 *
	 * @return void 
	 */
	public static function registerBuiltInControls(){
		self::registerControl( 'color', 'WP_Customize_Color_Control' );
		self::registerControl( 'image', 'WP_Customize_Image_Control' );
		self::registerControl( 'media', 'WP_Customize_Media_Control' );
		self::registerControl( 'upload', 'WP_Customize_Upload_Control' );
		self::registerControl( 'cropped_image', 'WP_Customize_Cropped_Image_Control' );
		
		// The following controls are not working!

		// self::registerControl( 'background', 'WP_Customize_Background_Image_Control' );
		// self::registerControl( 'background_position', 'WP_Customize_Background_Position_Control' );
	}

	//------------------------------------//--------------------------------------//
	
	/**
	 * Register built-in custom controls
	 *
	 * Register custom controls that are included in this framework.
	 *
	 * @return void 
	 */
	public static function registerBuiltInCustomControls(){
		$controls = glob(ZWPC_PATH .'engine/Control/*', GLOB_ONLYDIR);
		foreach ($controls as $control) {
			$controlname  = basename($control);
			$control_type = self::camelToSnake( $controlname );
			
			self::registerControl( $control_type, 'ZeroWPCustomizer\\Control\\'. $controlname .'\\Field' );
		}
	}

}