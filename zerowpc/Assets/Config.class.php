<?php
namespace ZeroWPC\Assets;

class Config{
	
	protected $customizer_styles;
	protected $customizer_scripts;

	public function __construct(){

		$this->customizerStyles(array(
			'spectrum' => array(
				'src' => \ZeroWPC::assetsURL() .'spectrum-color-picker/spectrum.css',
				'ver' => '1.8.0',
				'enqueue' => false,
			),
			'range-slider' => array(
				'src' => \ZeroWPC::assetsURL() .'range-slider/rangeslider.css',
				'ver' => '2.1.1',
				'enqueue' => false,
			),
		));

		$this->customizerScripts(array(
			'jquery',

			'spectrum' => array(
				'src' => \ZeroWPC::assetsURL() .'spectrum-color-picker/spectrum.js',
				'ver' => '1.8.0',
				'enqueue' => false,
			),
			'range-slider' => array(
				'src' => \ZeroWPC::assetsURL() .'range-slider/rangeslider.min.js',
				'ver' => '2.1.1',
				'enqueue' => false,
			),
			'zerowpc-config' => array(
				'src' => \ZeroWPC::assetsURL() .'config.js',
				'ver' => '2.1.1',
			),
		));

	}

	/*
	-------------------------------------------------------------------------------
	Styles
	-------------------------------------------------------------------------------
	*/
	public function customizerStyles( $styles = array(), $priority = 10 ){
		$this->customizer_styles = $styles;
		add_action( 'customize_controls_enqueue_scripts', array( $this, 'addCustomizerStyles' ), $priority );
	}

	public function addCustomizerStyles(){
		if( !empty( $this->customizer_styles ) ){

			foreach ($this->customizer_styles as $handle => $s) {
				// If just calling an already registered style
				if( is_numeric( $handle ) && !empty($s) ){
					wp_enqueue_style( $s );
					continue;
				}

				// Merge with defaults
				$s = wp_parse_args( $s, array(
					'deps'    => array(),
					'ver'     => false,
					'media'   => 'all',
					'enqueue' => true,
				));
				
				// Register style
				wp_register_style( $handle, $s['src'], $s['deps'], $s['ver'], $s['media'] );
				
				// Enqueue style
				if( $s['enqueue'] ){
					wp_enqueue_style( $handle );
				}
			}

		}
	}

	/*
	-------------------------------------------------------------------------------
	Scripts
	-------------------------------------------------------------------------------
	*/
	public function customizerScripts( $scripts = array(), $priority = 10 ){
		$this->customizer_scripts = $scripts;
		add_action( 'customize_controls_enqueue_scripts', array( $this, 'addCustomizerScripts' ), $priority );
	}

	public function addCustomizerScripts(){
		if( !empty( $this->customizer_scripts ) ){

			foreach ($this->customizer_scripts as $handle => $s) {
				// If just calling an already registered script
				if( is_numeric( $handle ) && !empty($s) ){
					wp_enqueue_script( $s );
					continue;
				}

				// Merge with defaults
				$s = wp_parse_args( $s, array(
					'deps'      => array( 'jquery' ),
					'ver'       => false,
					'in_footer' => true,
					'enqueue'   => true,
				));
				
				// Register script
				wp_register_script( $handle, $s['src'], $s['deps'], $s['ver'], $s['in_footer'] );
				
				// Enqueue script
				if( $s['enqueue'] ){
					wp_enqueue_script( $handle );
				}
			}

		}
	}

}