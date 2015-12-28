<?php
/* 
 * Plugin Name: ZeroWP Customizer Test
 * Plugin URI:  http://zerowp.com/
 * Author URI:  http://zerowp.com/
 * Description: This is a test plugin for "ZeroWP Customizer Mod"
 * Author:      ZeroWP Team
 */

/*
-------------------------------------------------------------------------------
Include Customizer Mod
-------------------------------------------------------------------------------
*/
require_once plugin_dir_path( __FILE__ ) . "src/Customizer/mod.php";


/*
-------------------------------------------------------------------------------
Test fields
-------------------------------------------------------------------------------
*/
add_action( 'customize_register', 'zerowp_customizer_demo_fields' );
function zerowp_customizer_demo_fields( $wp_customize ) {
	if( ! class_exists('ZeroWP\Customizer\Create') ) 
		return;
	$ctz = new ZeroWP\Customizer\Create( $wp_customize );

	$ctz->addSection( 'smk_theme_test_builtin', __('Test built-in', 'smk_theme') );

	$ctz->addField( 'image_select_test', 'image_select', array(
		'label' => __('Image select test', 'smk_theme'),
		'choices' => array(
			array(
				'img' => plugin_dir_url(__FILE__) . '1.png',
				'value' => 'my_option_1',
			),
			array(
				'img' => plugin_dir_url(__FILE__) . '2.png',
				'value' => 'my_option_2',
			),
			array(
				'img' => plugin_dir_url(__FILE__) . '3.png',
				'value' => 'my_option_3',
			),
		),
	));

	$ctz->addField( 'ui_slider_test', 'ui_slider', array(
		'label' => __('UI Slider test', 'smk_theme'),
	));

	$ctz->addField( 'color_test', 'color', array(
		'label' => __('Color test', 'smk_theme'),
	));

	$ctz->addField( 'upload_test', 'upload', array(
		'label' => __('upload test', 'smk_theme'),
	));

	$ctz->addField( 'image_test', 'image', array(
		'label' => __('image test', 'smk_theme'),
	));

	$ctz->addSection( 'smk_theme_fonts', __('Theme fonts', 'smk_theme') );

	$ctz->addField( 'demo_field', 'button', array(
		'label' => __('Body text font family button', 'smk_theme'),
		'button_id' => 'mybtnid',
		'button_value' => 'My button',
	));

	$ctz->addField( 'headings_font', 'font', array(
		'label' => __('Headings Font', 'smk_theme'),
	));

	$ctz->addField( 'content_font', 'font', array(
		'label' => __('Content Font', 'smk_theme'),
	));

	$ctz->addField( 'demo_field_font', 'font', array(
		'label' => __('Font', 'smk_theme'),
	));

	$ctz->addField( 'demo_field_font2', 'font', array(
		'label' => __('Font', 'smk_theme'),
	));
	$ctz->addField( 'demo_field_font3', 'font', array(
		'label' => __('Font', 'smk_theme'),
	));

	$ctz->addPanel( 'mypn', 'My pn' );
	$ctz->addSection( 'mypn_section', __('My pn section', 'smk_theme') );

	$ctz->addField( 'mypn_demo_field', 'text', array(
		'label' => __('My pn field', 'smk_theme'),
	));

	$ctz->addField( 'mypn_demo_field_range', 'range', array(
		'label' => __('My pn field range', 'smk_theme'),
	));

	for ($i=0; $i <= 30; $i++) { 
		$ctz->addSection( 'test_sect_'. $i, __('Test section '. $i, 'smk_theme') );

		$ctz->addField( 'test_field'. $i, 'text', array(
			'label' => __('Test field '. $i, 'smk_theme'),
		));
		$ctz->addField( 'test_field'. $i .'_1', 'text', array(
			'label' => __('Test field '. $i .'.1', 'smk_theme'),
		));
	}
	$ctz->closePanel();

	$ctz->addField( 'mypn_demo_field2', 'text', array(
		'label' => __('My pn field 2', 'smk_theme'),
	));

}