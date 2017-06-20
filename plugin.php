<?php 
final class ZWPC_Plugin{

	/**
	 * Plugin version.
	 *
	 * @var string
	 */
	public $version;

	/**
	 * Manager. User to manage fields, sections, panels and control types.
	 *
	 * @var string
	 */
	public $manager;

	/**
	 * This is the only instance of this class.
	 *
	 * @var string
	 */
	protected static $_instance = null;
	
	//------------------------------------//--------------------------------------//
	
	/**
	 * Plugin instance
	 *
	 * Makes sure that just one instance is allowed.
	 *
	 * @return object 
	 */
	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}

	//------------------------------------//--------------------------------------//
	
	/**
	 * Cloning is forbidden.
	 *
	 * @return void 
	 */
	public function __clone() {
		_doing_it_wrong( __FUNCTION__, __( 'Cheatin&#8217; huh?', 'zerowp-customizer' ), '1.0' );
	}

	//------------------------------------//--------------------------------------//
	
	/**
	 * Unserializing instances of this class is forbidden.
	 *
	 * @return void 
	 */
	public function __wakeup() {
		_doing_it_wrong( __FUNCTION__, __( 'Cheatin&#8217; huh?', 'zerowp-customizer' ), '1.0' );
	}

	//------------------------------------//--------------------------------------//
	
	/**
	 * Plugin configuration
	 *
	 * @param string $key Optional. Get the config value by key.
	 * @return mixed 
	 */
	public function config( $key = false ){
		return zwpc_config( $key );
	}

	//------------------------------------//--------------------------------------//
	
	/**
	 * Build it!
	 */
	public function __construct() {
		$this->version = ZWPC_VERSION;
		
		/* Include core
		--------------------*/
		include_once $this->rootPath() . "autoloader.php";
		include_once $this->rootPath() . "functions.php";

		$this->manager = new ZeroWPCustomizer\Manager\Manage;
		
		/* Activation and deactivation hooks
		-----------------------------------------*/
		register_activation_hook( ZWPC_PLUGIN_FILE, array( $this, 'onActivation' ) );
		register_deactivation_hook( ZWPC_PLUGIN_FILE, array( $this, 'onDeactivation' ) );

		/* Init core
		-----------------*/
		add_action( $this->config( 'action_name' ), array( $this, 'init' ), 0 );
		add_action( 'widgets_init', array( $this, 'initWidgets' ), 0 );

		/* Register and enqueue scripts and styles
		-----------------------------------------------*/
		add_action( 'wp_enqueue_scripts', array( $this, 'frontendScriptsAndStyles' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'backendScriptsAndStyles' ) );

		/* Load components, if any...
		----------------------------------*/
		$this->loadComponents();

		/* Plugin fully loaded and executed
		----------------------------------------*/
		do_action( 'zwpc:loaded' );
	}

	//------------------------------------//--------------------------------------//
	
	/**
	 * Init the plugin.
	 * 
	 * Attached to `init` action hook. Init functions and classes here.
	 *
	 * @return void 
	 */
	public function init() {
		do_action( 'zwpc:before_init' );

		$this->loadTextDomain();

		// Create customizer elements
		do_action( 'zwpc:create', $this->manager );

		new ZeroWPCustomizer\Build;

		// Call plugin classes/functions here.
		do_action( 'zwpc:init' );

	}

	//------------------------------------//--------------------------------------//
	
	/**
	 * Init the widgets of this plugin
	 *
	 * @return void 
	 */
	public function initWidgets() {
		do_action( 'zwpc:widgets_init' );
	}

	//------------------------------------//--------------------------------------//
	
	/**
	 * Localize
	 *
	 * @return void 
	 */
	public function loadTextDomain(){
		load_plugin_textdomain( 
			'zerowp-customizer', 
			false, 
			$this->config( 'lang_path' ) 
		);
	}

	//------------------------------------//--------------------------------------//
	
	/**
	 * Load components
	 *
	 * @return void 
	 */
	public function loadComponents(){
		$components = glob( ZWPC_PATH .'components/*', GLOB_ONLYDIR );
		foreach ($components as $component_path) {
			require_once trailingslashit( $component_path ) .'component.php';
		}
	}

	//------------------------------------//--------------------------------------//
	
	/**
	 * Front-end scripts & styles
	 *
	 * @return void 
	 */
	public function frontendScriptsAndStyles(){
		
		$id = $this->config( 'id' );

		$this->addStyles(array(
			$id . '-styles' => array(
				'src'     => $this->assetsURL( 'css/styles.css' ),
				'enqueue' => false,
			),
		));

		$this->addScripts(array(
			$id . '-config' => array(
				'src'     => $this->assetsURL( 'js/config.js' ),
				'deps'    => array( 'jquery' ),
				'enqueue' => false,
				// 'enqueue_callback' => 'is_home',
			),
		));

	}

	//------------------------------------//--------------------------------------//
	
	/**
	 * Back-end scripts & styles
	 *
	 * @return void 
	 */
	public function backendScriptsAndStyles(){
		
		$id = $this->config( 'id' );

		$this->addStyles(array(
			
			'zwpc-range-slider' => array(
				'src'     => $this->assetsURL( 'js-plugins/range-slider/rangeslider.css' ),
				'ver'     => '2.1.1',
				'enqueue' => false,
				'enqueue_callback' => array( $this, 'isCustomizerScreen' ),
			),
			
			'zwpc-spectrum' => array(
				'src'     => $this->assetsURL( 'js-plugins/spectrum/spectrum.css' ),
				'ver'     => '1.8.0',
				'enqueue' => false,
				'enqueue_callback' => array( $this, 'isCustomizerScreen' ),
			),
			
			'zwpc-font-field' => array(
				'src'     => $this->assetsURL( 'js-plugins/font/font.css' ),
				'enqueue' => false,
				'enqueue_callback' => array( $this, 'isCustomizerScreen' ),
			),
			
			$id . '-styles-admin' => array(
				'src'     => $this->assetsURL( 'css/styles-admin.css' ),
				'enqueue' => false,
			),
	
		));

		$this->addScripts(array(
	
			'zwpc-range-slider' => array(
				'src'     => $this->assetsURL( 'js-plugins/range-slider/rangeslider.min.js' ),
				'ver'     => '2.1.1',
				'deps'    => array( 'jquery' ),
				'enqueue' => false,
				'enqueue_callback' => array( $this, 'isCustomizerScreen' ),
			),
	
			'zwpc-spectrum' => array(
				'src'     => $this->assetsURL( 'js-plugins/spectrum/spectrum.js' ),
				'ver'     => '1.8.0',
				'deps'    => array( 'jquery' ),
				'enqueue' => false,
				'enqueue_callback' => array( $this, 'isCustomizerScreen' ),
			),
	
			'zwpc-randomcolor' => array(
				'src'     => $this->assetsURL( 'js-plugins/randomcolor/randomColor.js' ),
				'deps'    => array( 'jquery' ),
				'enqueue' => false,
				'enqueue_callback' => array( $this, 'isCustomizerScreen' ),
			),
			
			'zwpc-font-field' => array(
				'src'     => $this->assetsURL( 'js-plugins/font/font.js' ),
				'deps'    => array( 'jquery' ),
				'enqueue' => false,
				'enqueue_callback' => array( $this, 'isCustomizerScreen' ),
			),
	
			$id . '-config-admin' => array(
				'src'     => $this->assetsURL( 'js/config-admin.js' ),
				'deps'    => array( 'jquery' ),
				'enqueue' => true,
				'enqueue_callback' => array( $this, 'isCustomizerScreen' ),
			),
	
		));

	}

	public function isCustomizerScreen(){
		$screen = get_current_screen();
		return is_admin() && 'customize' == $screen->base;
	}
	
	/*
	-------------------------------------------------------------------------------
	Styles
	-------------------------------------------------------------------------------
	*/
	public function addStyles( $styles ){
		if( !empty( $styles ) ){

			foreach ($styles as $handle => $s) {
				
				/* If just calling an already registered style
				------------------------------------------------------*/
				if( is_numeric( $handle ) && !empty($s) ){
					wp_enqueue_style( $s );
					continue;
				}

				/* Merge with defaults
				------------------------------*/
				$s = wp_parse_args( $s, array(
					'deps'    => array(),
					'ver'     => $this->version,
					'media'   => 'all',
					'enqueue' => true,
					'enqueue_callback' => false,
				));
				
				/* Register style
				-------------------------*/
				wp_register_style( $handle, $s['src'], $s['deps'], $s['ver'], $s['media'] );
				
				/* Enqueue style
				------------------------*/
				$this->_enqueue( 'style', $s, $handle );
			}

		}
	}

	/*
	-------------------------------------------------------------------------------
	Scripts
	-------------------------------------------------------------------------------
	*/
	public function addScripts( $scripts ){
		if( !empty( $scripts ) ){

			foreach ($scripts as $handle => $s) {
				
				/* If just calling an already registered script
				----------------------------------------------------*/
				if( is_numeric( $handle ) && !empty($s) ){
					wp_enqueue_script( $s );
					continue;
				}

				/* Register
				----------------*/
				// Merge with defaults
				$s = wp_parse_args( $s, array(
					'deps'      => array( 'jquery' ),
					'ver'       => $this->version,
					'in_footer' => true,
					'enqueue'   => true,
					'enqueue_callback' => false,
				));
				
				wp_register_script( $handle, $s['src'], $s['deps'], $s['ver'], $s['in_footer'] );
				
				/* Enqueue
				---------------*/
				$this->_enqueue( 'script', $s, $handle );

				/* Localize 
				-----------------*/
				// Remove known keys 
				unset( $s['src'], $s['deps'], $s['ver'], $s['in_footer'], $s['enqueue'], $s['enqueue_callback'] );

				// Probably we have localization strings
				if( !empty( $s ) ){

					// Get first key from array. This may contain the strings for wp_localize_script
					$localize_key = key( $s );

					// Get strings
					$localization_strings = $s[ $localize_key ];

					// Localize strings
					if( !empty( $localization_strings ) && is_array( $localization_strings ) ){
						wp_localize_script( $handle, $localize_key, $localization_strings );
					}

				}
			}

		}
	}

	//------------------------------------//--------------------------------------//
	
	/**
	 * Enqueue
	 *
	 * Try to enqueue, but first check the callback
	 *
	 * @param string $type 'script' or 'style'
	 * @param array $s Parameters
	 * @param string $handle Asset handle
	 * @return void 
	 */
	protected function _enqueue( $type, $s, $handle ){
		if( $s['enqueue'] ){
			if( empty( $s['enqueue_callback'] ) || ( 
				! empty( $s['enqueue_callback'] ) 
				&& is_callable( $s['enqueue_callback'] ) 
				&& call_user_func( $s['enqueue_callback'] )
			) ){
				
				if( 'style' == $type ){
					wp_enqueue_style( $handle );
				}
				elseif( 'script' == $type ){
					wp_enqueue_script( $handle );
				}

			}
		}
	}

	//------------------------------------//--------------------------------------//

	/**
	 * Actions when the plugin is activated
	 *
	 * @return void
	 */
	public function onActivation() {
		// Code to be executed on plugin activation
		do_action( 'zwpc:on_activation' );
	}

	//------------------------------------//--------------------------------------//

	/**
	 * Actions when the plugin is deactivated
	 *
	 * @return void
	 */
	public function onDeactivation() {
		// Code to be executed on plugin deactivation
		do_action( 'zwpc:on_deactivation' );
	}

	//------------------------------------//--------------------------------------//

	/**
	 * Get Root URL
	 *
	 * @return string
	 */
	public function rootURL(){
		return ZWPC_URL;
	}

	//------------------------------------//--------------------------------------//

	/**
	 * Get Root PATH
	 *
	 * @return string
	 */
	public function rootPath(){
		return ZWPC_PATH;
	}

	//------------------------------------//--------------------------------------//

	/**
	 * Get assets url.
	 * 
	 * @param string $file Optionally specify a file name
	 *
	 * @return string
	 */
	public function assetsURL( $file = false ){
		$path = ZWPC_URL . 'assets/';
		
		if( $file ){
			$path = $path . $file;
		}

		return $path;
	}

}


/*
-------------------------------------------------------------------------------
Main plugin instance
-------------------------------------------------------------------------------
*/
function ZeroWPC() {
	return ZWPC_Plugin::instance();
}

/*
-------------------------------------------------------------------------------
Rock it!
-------------------------------------------------------------------------------
*/
ZeroWPC();