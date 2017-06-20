<?php
/* 
 * Plugin Name: ZeroWP Customizer
 * Plugin URI:  http://zerowp.com/customizer
 * Description: Create customizer elements quick and easy with as minimum code as possible.
 * Author:      ZeroWP Team
 * Author URI:  http://zerowp.com/
 * License:     GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain: zerowp-customizer
 * Domain Path: /languages
 *
 * Version:     0.2-beta
 * 
 */

/* No direct access allowed!
---------------------------------*/
if ( ! defined( 'ABSPATH' ) ) exit;

/* Plugin configuration
----------------------------*/
function zwpc_config( $key = false ){
	$settings = apply_filters( 'zwpc:config_args', array(
		
		// Plugin data
		'version'          => '0.2-beta',
		'min_php_version'  => '5.3',
		
		// The list of required plugins. 'slug' => array 'name and uri'
		'required_plugins' => array(),

		// The priority in plugins loaded. Only if has required plugins
		'priority'         => 10,

		// Main action. You may need to change it if is an extension for another plugin.
		'action_name'      => 'init',

		// Plugin branding
		'plugin_name'      => __( 'ZeroWP Customizer', 'zerowp-customizer' ),
		'id'               => 'zerowp-customizer',
		'namespace'        => 'ZeroWPCustomizer',
		'uppercase_prefix' => 'ZWPC',
		'lowercase_prefix' => 'zwpc',
		
		// Access to plugin directory
		'file'             => __FILE__,
		'lang_path'        => plugin_dir_path( __FILE__ ) . 'languages',
		'basename'         => plugin_basename( __FILE__ ),
		'path'             => plugin_dir_path( __FILE__ ),
		'url'              => plugin_dir_url( __FILE__ ),
		'uri'              => plugin_dir_url( __FILE__ ),//Alias

	));

	// Make sure that PHP version is set to 5.3+
	if( version_compare( $settings[ 'min_php_version' ], '5.3', '<' ) ){
		$settings[ 'min_php_version' ] = '5.3';
	}

	// Get the value by key
	if( !empty($key) ){
		if( array_key_exists($key, $settings) ){
			return $settings[ $key ];
		}
		else{
			return false;
		}
	}

	// Get settings
	else{
		return $settings;
	}
}

/* Define the current version of this plugin.
-----------------------------------------------------------------------------*/
define( 'ZWPC_VERSION',         zwpc_config( 'version' ) );
 
/* Plugin constants
------------------------*/
define( 'ZWPC_PLUGIN_FILE',     zwpc_config( 'file' ) );
define( 'ZWPC_PLUGIN_BASENAME', zwpc_config( 'basename' ) );

define( 'ZWPC_PATH',            zwpc_config( 'path' ) );
define( 'ZWPC_URL',             zwpc_config( 'url' ) );
define( 'ZWPC_URI',             zwpc_config( 'url' ) ); // Alias

/* Minimum PHP version required
------------------------------------*/
define( 'ZWPC_MIN_PHP_VERSION', zwpc_config( 'min_php_version' ) );

/* Plugin Init
----------------------*/
final class ZWPC_Plugin_Init{

	public function __construct(){
		
		$required_plugins = zwpc_config( 'required_plugins' );
		$missed_plugins   = $this->missedPlugins();

		/* The installed PHP version is lower than required.
		---------------------------------------------------------*/
		if ( version_compare( PHP_VERSION, ZWPC_MIN_PHP_VERSION, '<' ) ) {

			require_once ZWPC_PATH . 'warnings/php-warning.php';
			new ZWPC_PHP_Warning;

		}

		/* Required plugins are not installed/activated
		----------------------------------------------------*/
		elseif( !empty( $required_plugins ) && !empty( $missed_plugins ) ){

			require_once ZWPC_PATH . 'warnings/noplugin-warning.php';
			new ZWPC_NoPlugin_Warning( $missed_plugins );

		}

		/* We require some plugins and all of them are activated
		-------------------------------------------------------------*/
		elseif( !empty( $required_plugins ) && empty( $missed_plugins ) ){
			
			add_action( 
				'plugins_loaded', 
				array( $this, 'getSource' ), 
				zwpc_config( 'priority' ) 
			);

		}

		/* We don't require any plugins. Include the source directly
		----------------------------------------------------------------*/
		else{

			$this->getSource();

		}

	}

	//------------------------------------//--------------------------------------//
	
	/**
	 * Get plugin source
	 *
	 * @return void 
	 */
	public function getSource(){
		require_once ZWPC_PATH . 'plugin.php';
		
		$components = glob( ZWPC_PATH .'components/*', GLOB_ONLYDIR );
		foreach ($components as $component_path) {
			require_once trailingslashit( $component_path ) .'component.php';
		}
	
	}

	//------------------------------------//--------------------------------------//
	
	/**
	 * Missed plugins
	 *
	 * Get an array of missed plugins
	 *
	 * @return array 
	 */
	public function missedPlugins(){
		$required = zwpc_config( 'required_plugins' );
		$active   = $this->activePlugins();
		$diff     = array_diff_key( $required, $active );

		return $diff;
	}

	//------------------------------------//--------------------------------------//
	
	/**
	 * Active plugins
	 *
	 * Get an array of active plugins
	 *
	 * @return array 
	 */
	public function activePlugins(){
		$active = get_option('active_plugins');
		$slugs  = array();

		if( !empty($active) ){
			$slugs = array_flip( array_map( array( $this, '_filterPlugins' ), (array) $active ) );
		}

		return $slugs;
	}

	//------------------------------------//--------------------------------------//
	
	/**
	 * Filter plugins callback
	 *
	 * @return string 
	 */
	protected function _filterPlugins( $value ){
		$plugin = explode( '/', $value );
		return $plugin[0];
	}

}

new ZWPC_Plugin_Init;