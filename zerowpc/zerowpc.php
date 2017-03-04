<?php
/* 
 * Plugin Name: ZeroWP Customizer
 * Plugin URI:  http://zerowp.com/
 * Description: Create customizer controls quick and easy with as minimum code as possible.
 * Author:      ZeroWP Team
 * Version:     1.0
 * Author URI:  http://zerowp.com/customizer/
 * Licence:     GPLv2
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 * Copyright:   (c) 2017 ZeroWP. All rights reserved
 */

//------------------------------------//--------------------------------------//

/**
 * ZeroWP Customizer Plugin Class
 *
 * Root class.
 * 
 */
class ZeroWPC{

	public static function init(){
		add_action( 'customize_register', array( __CLASS__, 'registerBuiltInControls' ) );
		add_action( 'customize_register', array( __CLASS__, 'registerBuiltInCustomControls' ) );
	}

	//------------------------------------//--------------------------------------//

	/**
	 * Access to all custom customizer controls.
	 *
	 * @return array 
	 */
	public static function controls(){
		return apply_filters( 'zerowpc_controls', array() );
	}
	//------------------------------------//--------------------------------------//

	/**
	 * Determine if is loaded in a plugin.
	 *
	 * Returns `true` if this file is included in a plugin or `false` if it is in a theme
	 *
	 * @param string $file Current file
	 * @return string 
	 */
	public static function isPlugin( $file = __FILE__ ){
		return strpos( str_replace("\\", "/", plugin_dir_path( $file ) ) , str_replace("\\", "/", WP_PLUGIN_DIR) ) !== false;
	}

	//------------------------------------//--------------------------------------//

	/**
	 * Get customizer Root URL
	 *
	 * Get customizer Root URL
	 *
	 * @return string 
	 */
	public static function rootURL(){
		if( self::isPlugin() ){
			return plugin_dir_url(__FILE__);
		}
		else{
			return trailingslashit( get_template_directory_uri() .'/'. basename(__DIR__) );
		}
	}

	//------------------------------------//--------------------------------------//

	/**
	 * Get customizer Root PATH
	 *
	 * Get customizer Root PATH
	 *
	 * @return string 
	 */
	public static function rootPath(){
		return plugin_dir_path(__FILE__);
	}

	//------------------------------------//--------------------------------------//

	/**
	 * Customizer controls url
	 *
	 * Get the url to Controls directory or(if $file is specified) to the file
	 *
	 * @param string $file A file to get the basename from
	 * @return string 
	 */
	public static function controlURL( $file = false ){
		$control_name = '';

		if( $file ){
			$control_name = '/'. basename( dirname( $file ) );
		}

		return trailingslashit( self::rootURL() .'Field'. $control_name );
	}

	//------------------------------------//--------------------------------------//

	/**
	 * Customizer controls url
	 *
	 * Get the url to Assets directory or(if $file is specified) to the file
	 *
	 * @param string $file A file to get the basename from
	 * @return string 
	 */
	public static function assetsURL( $file = false ){
		$control_name = '';

		if( $file ){
			$control_name = '/'. basename( dirname( $file ) );
		}

		return trailingslashit( self::rootURL() .'Assets'. $control_name );
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
	 * Register custom control
	 *
	 * Register custom control
	 *
	 * @param string $type_name Control type ID
	 * @param string $class_name The PHP class used by this control type
	 * @return void
	 */
	public static function registerControl( $type_name, $class_name ){
		new ZeroWPC\Field\Register( 'add', $type_name, $class_name );
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
		new ZeroWPC\Field\Register( 'remove', $type_name );
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
		self::registerControl( 'upload', 'WP_Customize_Upload_Control' );
		self::registerControl( 'image', 'WP_Customize_Image_Control' );
		self::registerControl( 'background', 'WP_Customize_Background_Image_Control' );
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
		$controls = glob(self::rootPath() .'Field/*');
		foreach ($controls as $control) {
			$controlname  = basename($control);
			$control_type = self::camelToSnake( $controlname );
			
			self::registerControl( $control_type, 'ZeroWPC\\Field\\'. $controlname .'\\Control' );
		}
	}

	//------------------------------------//--------------------------------------//
	
	/**
	 * Standard fonts
	 *
	 * Return a list of standard fonts
	 *
	 * @return array 
	 */
	public static function standardFonts(){
		return array(
			//sans-serif
			'Arial', 'Arial Black', 'Arial Narrow', 'Arial Rounded MT Bold', 'Calibri', 'Candara', 'Century Gothic', 'Helvetica', 'Helvetica Neue', 'Impact', 'Lucida Grande', 'Optima', 'Segoe UI', 'Tahoma', 'Trebuchet MS', 'Verdana', 
			
			//serif
			'Georgia', 'Calisto MT', 'Cambria', 'Garamond', 'Lucida Bright', 'Baskerville', 'Palatino', 'TimesNewRoman',

			//monospace
			'Consolas', 'Courier New', 'Lucida Console', 'Lucida Sans Typewriter', 'Monaco', 'Andale Mono', 

			//fantasy
			'Copperplate', 'Papyrus',

			//cursive
			'Brush Script MT',
		);
	}

	//------------------------------------//--------------------------------------//
	
	/**
	 * Enqueue font
	 *
	 * Safe method to enqueue a font. Must be hooked to `wp_enqueue_scripts`
	 *
	 * @param string $option Theme mod ID
	 * @return string 
	 */
	public static function enqueueFont( $option ){
		$font_name          = get_theme_mod( $option );
		if(empty($font_name)){
			$font_name = 'Arial';
		}

		if( ! in_array($font_name, self::standardFonts() ) ){
			$font_weight        = get_theme_mod( $option . '_weight', 400 );
			$font_weight        = (! empty( $font_weight ) ? $font_weight : 400);
			$font_weight_in_url = !in_array( absint($font_weight), array(400, 700) ) ? '400,700,'. $font_weight : '400,700';
			$font_name          = trim($font_name);
			$handle             = 'google_font_' . str_ireplace(' ', '_', $font_name );

			if ( ! wp_style_is( $handle, 'enqueued' ) ) {
				wp_register_style( $handle, "//fonts.googleapis.com/css?family=". str_ireplace(' ', '+', $font_name) .":". $font_weight_in_url);
				wp_enqueue_style( $handle );
			}
			else{
				$registered_link = wp_styles()->query( $handle )->src;

				if ( strpos($registered_link, (string) $font_weight) === false ) {
					wp_deregister_style( $handle );
					wp_register_style( $handle, $registered_link . ','. $font_weight );
					wp_enqueue_style( $handle );
				}
			}
		}
	}

	//------------------------------------//--------------------------------------//
	
	/**
	 * Get the CSS for an option
	 *
	 * Get the CSS for an option
	 *
	 * @param string $option The mod ID.
	 * @return string The formated CSS
	 */
	public static function getFontCSS( $option ){
		$font_name   = get_theme_mod( $option );
		$font_weight = get_theme_mod( $option . '_weight', 400 );
		$font_weight = (! empty( $font_weight ) ? $font_weight : 400);
		$font_style  = get_theme_mod( $option . '_style', 'normal');
		$font_family = get_theme_mod( $option . '_family', 'sans-serif' );
		$font_family = (! empty( $font_family ) ? $font_family : 'sans-serif');

		if( !empty($font_name) ){
			return '
				font-family: "'. $font_name .'", '. $font_family .';
				font-weight: '. $font_weight .';
				font-style: '. $font_style .';
			';
		}
	}
	
	//------------------------------------//--------------------------------------//
	
	/**
	 * Apply font CSS
	 *
	 * Apply font CSS. Used in wp_head in preview
	 *
	 * @param string $option The mod ID
	 * @param string $selectors The selector to apply
	 * @param string $style_tag Use <style> tags
	 * @return string
	 */
	public static function applyFontCSS( $option, $selectors, $style_tag = false ){
		$before = ( $style_tag ) ? '<style>' : '';
		$after = ( $style_tag ) ? '</style>' : '';
		return $before . $selectors .'{
			'. self::getFontCSS( $option ) .'
		}' . $after;
	}

	public static function getRegisteredSections() {
		global $wp_customize;
		$result = array();

		if( $wp_customize instanceof WP_Customize_Manager ){
			$sections = $wp_customize->sections();
			$result = array();
			foreach ($sections as $section) {
				if(  $section instanceof WP_Customize_Section ){
					$result[ $section->id ] = array(
						'priority' => $section->priority,
						'capability' => $section->capability,
					);
				}
			}
		}
		
		return $result;
	}

	public static function getRegisteredPanels() {
		global $wp_customize;
		$result = array();

		if( $wp_customize instanceof WP_Customize_Manager ){
			$panels = $wp_customize->panels();
			$result = array();
			foreach ($panels as $panel) {
				if(  $panel instanceof WP_Customize_Panel ){
					$result[ $panel->id ] = array(
						'priority' => $panel->priority,
						'capability' => $panel->capability,
					);
				}
			}
		}
		
		return $result;
	}

	public static function getCustomizerContainers(){
		$s = self::getRegisteredSections();
		$p = self::getRegisteredPanels();
		$arr = array_merge($s, $p);

		return $arr;
	}


	
	public $panel;
	public $section;
	public $defaultSection = 'title_tagline';

	//------------------------------------//--------------------------------------//
	
	/**
	 * Construct Object
	 *
	 * @param object The $wp_customize object available from 'customize_register' action hook. 
	 * @return object 
	 */
	public function __construct(){
		$this->panel = '';
		$this->section = $this->defaultSection;
	}

	//------------------------------------//--------------------------------------//
	
	/**
	 * Add panel
	 *
	 * Add a new panel to the customizer
	 *
	 * @param string $id The panel ID
	 * @param string $title The panel title. Optional. If omited the ID will be used instead
	 * @param string $settings The panel settings. Optional.
	 * @return void 
	 */
	public function addPanel( $id, $title = '', $settings = array() ){	

		new ZeroWPC\Manage\Panel( 'add', $id, $title, $settings );

		//Switch to this panel
		$this->panel = $id;
	}

	//------------------------------------//--------------------------------------//
	
	/**
	 * Open panel
	 *
	 * Switch to an already registered panel. Any section added after this will be appended to this panel.
	 *
	 * @param string $id the panel ID that needs to be open
	 * @return void
	 */
	public function openPanel( $id ){
		$this->panel = $id;
	}

	//------------------------------------//--------------------------------------//
	
	/**
	 * Close panel
	 *
	 * Close a panel that has been already open. Any section added after this will be appended to the customizer itself.
	 *
	 * @return void 
	 */
	public function closePanel(){
		$this->panel = '';
		$this->section = $this->defaultSection;
	}

	//------------------------------------//--------------------------------------//
	
	/**
	 * Remove panel
	 *
	 * Remove a panel that has been already registed.
	 *
	 * @param string $id The panel ID
	 * @return void 
	 */
	public function removePanel( $id ){
		new ZeroWPC\Manage\Panel( 'remove', $id );
	}

	//------------------------------------//--------------------------------------//
	
	/**
	 * Add section
	 *
	 * Add a new section
	 *
	 * @param string $id Section ID.
	 * @param string $title Section title. Optional. The ID will be used instead.
	 * @param string $settings Section settings. Optional.
	 * @return void 
	 */
	public function addSection( $id, $title = false, $settings = array() ){	
		
		new ZeroWPC\Manage\Section( 'add', $id, $title, $settings, $this->panel );
		
		// Switch to this section
		$this->section = $id;
	}

	//------------------------------------//--------------------------------------//
	
	/**
	 * Open section
	 *
	 * Switch to an already registered section. Any field added after this will be appended to this section.
	 *
	 * @param string $id the section ID that needs to be open
	 * @return void
	 */
	public function openSection( $id ){
		$this->section = $id;
	}

	//------------------------------------//--------------------------------------//
	
	/**
	 * Close section
	 *
	 * Close a section that has been already open. Any field added after this will be appended to the default section.
	 *
	 * @return void 
	 */
	public function closeSection(){
		$this->section = $this->defaultSection;
	}

	//------------------------------------//--------------------------------------//
	
	/**
	 * Remove section
	 *
	 * Remove a section that has been already registed.
	 *
	 * @param string $id The section ID
	 * @return void 
	 */
	public function removeSection( $id ){
		new ZeroWPC\Manage\Section( 'remove', $id );
	}
	
	//------------------------------------//--------------------------------------//
	
	/**
	 * Add field
	 *
	 * Add a new field(setting/control).
	 *
	 * @param string $id Field ID.
	 * @param string $type Field type. The field type or 'Control class name' that has been inherited from "WP_Customize_Control" class.
	 * @param string $settings Field settings. Optional.
	 * @return void 
	 */
	public function addField( $id, $type = 'text', $settings = array() ){
		new ZeroWPC\Manage\Field( 'add', $id, $type, $settings, $this->section );
	}
	
	//------------------------------------//--------------------------------------//
	
	/**
	 * Remove field
	 *
	 * Remove a field that has been already registed.
	 *
	 * @param string $id The field ID
	 * @return void 
	 */
	public function removeField( $id ){
		new ZeroWPC\Manage\Field( 'remove', $id );
	}


}


//------------------------------------//--------------------------------------//

/**
 * First time init
 *
 * This first time init prepares the built-in and custom controls
 *
 * @return void 
 */
ZeroWPC::init();

//------------------------------------//--------------------------------------//

/**
 * Include the loader
 *
 * Load customizer base classes
 *
 */
include ZeroWPC::rootPath() . "autoloader.php";

/*
-------------------------------------------------------------------------------
Init customizer assets
-------------------------------------------------------------------------------
*/
include ZeroWPC::rootPath(). 'Assets/assets.php';



/*
-------------------------------------------------------------------------------
Test
-------------------------------------------------------------------------------
*/
$ctz = new ZeroWPC;

$ctz->addField( 'tts2', 'text', array(
	'label' => 'Hola2',
	'default' => 'yes2',
	'priority' => 202,
) );

$ctz->addSection( 'ttre', 'Mysection' );

$ctz->addField( 'tts3', 'font', array(
	'label' => 'Hola3',
	// 'default' => 'yes3',
	'priority' => 201,
) );

for ($i=0; $i < 20; $i++) {
	$ctz->addPanel( 'panel_x_'. $i );

	$ctz->addSection( 'section_x_'. $i, 'Section - x'. $i );

	$ctz->addField( 'field_x_'. $i, 'text', array(
		'label' => 'Field x'. $i,
		'default' => $i,
	) );

}