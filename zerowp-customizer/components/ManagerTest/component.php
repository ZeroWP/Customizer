<?php 
/* No direct access allowed!
---------------------------------*/
if ( ! defined( 'ABSPATH' ) ) exit;

/* Inject the component
----------------------------*/
// add_action( 'zwpc:create', function( $ctz ){

// 	$ctz->openCustomizer();

// 	$ctz->addSection( 'test_fields', 'Test fields' );

// 	// xHTML inputs
// 	$ctz->addField( 'x00', 'text', '', array(
// 		'label' => 'Text'
// 	) );

// 	$ctz->addField( 'x01', 'password', '', array(
// 		'label' => 'Password'
// 	) );

// 	$ctz->addField( 'x02', 'checkbox', '', array(
// 		'label' => 'Checkbox'
// 	) );

// 	$ctz->addField( 'x03', 'radio', '', array(
// 		'label' => 'Radio',
// 		'choices' => array(
// 			'no' => 'No',
// 			'yes' => 'Yes',
// 			'x' => 'I don\'t know'
// 		),
// 	) );

// 	// HTML5 inputs
// 	$ctz->addField( 'x04', 'number', '', array(
// 		'label' => 'Number'
// 	) );

// 	$ctz->addField( 'x05', 'email', '', array(
// 		'label' => 'Email'
// 	) );

// 	$ctz->addField( 'x06', 'range', '', array(
// 		'label' => 'Range'
// 	) );

// 	$ctz->addField( 'x07', 'date', '', array(
// 		'label' => 'Date'
// 	) );

// 	$ctz->addField( 'x08', 'datetime-local', '', array(
// 		'label' => 'Date local'
// 	) );

// 	$ctz->addField( 'x09', 'month', '', array(
// 		'label' => 'Month'
// 	) );

// 	$ctz->addField( 'x010', 'search', '', array(
// 		'label' => 'Search'
// 	) );

// 	$ctz->addField( 'x011', 'tel', '', array(
// 		'label' => 'Tel'
// 	) );

// 	$ctz->addField( 'x012', 'time', '', array(
// 		'label' => 'Time'
// 	) );

// 	$ctz->addField( 'x013', 'url', '', array(
// 		'label' => 'Url'
// 	) );

// 	$ctz->addField( 'x014', 'week', '', array(
// 		'label' => 'Week'
// 	) );

// 	// Button inputs
// 	// Just testing, but these types are not working properly. The value is ignored.
// 	// This should be implemented using <button> tag. 
// 	$ctz->addField( 'x10', 'button', '', array(
// 		'label' => 'Button',
// 		'input_attrs' => array( 'value' => 'My Button' ),
// 	) );

// 	$ctz->addField( 'x11', 'submit', '', array(
// 		'label' => 'Submit',
// 		'input_attrs' => array( 'value' => 'My Submit' ),
// 	) );

// 	$ctz->addField( 'x12', 'reset', '', array(
// 		'label' => 'Reset',
// 		'input_attrs' => array( 'value' => 'My Reset' ),
// 	) );

// 	// Other inputs
// 	$ctz->addField( 'x20', 'textarea', '', array(
// 		'label' => 'Textarea'
// 	) );

// 	$ctz->addField( 'x21', 'select', '', array(
// 		'label' => 'Select',
// 		'choices' => array(
// 			'no' => 'No',
// 			'yes' => 'Yes',
// 			'x' => 'I don\'t know'
// 		),
// 	) );

// 	// Custom by WP
// 	$ctz->addField( 'x30', 'dropdown-pages', '', array(
// 		'label' => 'Dropdown pages',
// 		'allow_addition' => true,
// 	) );

// 	$ctz->addField( 'x31', 'color', '', array(
// 		'label' => 'Color',
// 	) );

// 	$ctz->addField( 'x32', 'image', '', array(
// 		'label' => 'Image',
// 	) );

// 	$ctz->addField( 'x33', 'media', '', array(
// 		'label' => 'Media',
// 	) );

// 	$ctz->addField( 'x34', 'upload', '', array(
// 		'label' => 'Upload',
// 	) );

// 	$ctz->addField( 'x35', 'cropped_image', '', array(
// 		'label' => 'Cropped image',
// 	) );

// 	// Custom by ZWPC
// 	$ctz->addField( 'x50', 'font', '', array(
// 		'label' => 'Font',
// 	) );

// });