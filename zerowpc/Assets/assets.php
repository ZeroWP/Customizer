<?php
class ZeroWPC_Assets_Register{
	public function __construct(){
		add_action( 'customize_controls_enqueue_scripts', array( $this, 'register' ), 1 );
		add_action( 'customize_controls_enqueue_scripts', array( $this, 'enqueueGlobal' ), 90 );
	}

	public function register(){

		// Spectrum Color Picker
		$spectrum_version = '1.8.0';
		wp_register_style( 'spectrum', ZeroWPC::assetsURL() .'spectrum-color-picker/spectrum.css', false, $spectrum_version);
		wp_register_script( 'spectrum', ZeroWPC::assetsURL() .'spectrum-color-picker/spectrum.js', array( 'jquery' ), $spectrum_version, true);
		
		// range slider
		$range_slider_version = '2.1.1';

		wp_register_style( 'range-slider', ZeroWPC::assetsURL() .'range-slider/rangeslider.css', false, $range_slider_version);
		wp_register_script( 'range-slider', ZeroWPC::assetsURL() .'range-slider/rangeslider.min.js', array( 'jquery' ), $range_slider_version, true);
		
		//Common scripts
		wp_register_script( 'zerowpc-common-scripts', ZeroWPC::assetsURL() .'common.js', array( 'jquery' ), false, true);


	}

	public function enqueueGlobal(){
		wp_enqueue_script('zerowpc-common-scripts');
	}

}
new ZeroWPC_Assets_Register;