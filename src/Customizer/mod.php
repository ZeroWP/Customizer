<?php
/* 
 * Mod Name:    ZeroWP Customizer
 * Mod URI:     http://zerowp.com/
 * Description: Create customizer controls quick and easy with as minimum code as possible.
 * Author:      ZeroWP Team
 * Version:     1.0
 * Author URI:  http://zerowp.com/
 * Licence:     GPLv2
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 * Copyright:   (c) 2015 ZeroWP. All rights reserved
 */

//Do not allow direct access to this file.
if( ! function_exists('add_action') ) 
	die();

/*
-------------------------------------------------------------------------------
Get the root url of this mod
-------------------------------------------------------------------------------
*/
function zerowp_customizer_root_url(){
	return plugin_dir_url(__FILE__);
}

/*
-------------------------------------------------------------------------------
Get the root path of this mod
-------------------------------------------------------------------------------
*/
function zerowp_customizer_root_path(){
	return plugin_dir_path(__FILE__);
}

/*
-------------------------------------------------------------------------------
Define PATH and URI constants
-------------------------------------------------------------------------------
*/
define('ZEROWP_CUSTOMIZER_PATH', zerowp_customizer_root_path() );
define('ZEROWP_CUSTOMIZER_URI', zerowp_customizer_root_url() );
define('ZEROWP_CUSTOMIZER_URL', ZEROWP_CUSTOMIZER_URI );//alternative for 'ZEROWP_CUSTOMIZER_URI'

/*
-------------------------------------------------------------------------------
Include 'Create' class
-------------------------------------------------------------------------------
*/
require_once( ZEROWP_CUSTOMIZER_PATH . 'Create/create.class.php' );

/*
-------------------------------------------------------------------------------
Include controls registration
-------------------------------------------------------------------------------
*/
require_once( ZEROWP_CUSTOMIZER_PATH . 'RegisterControls/register.class.php' );
require_once( ZEROWP_CUSTOMIZER_PATH . 'RegisterControls/functions.php' );

/*
-------------------------------------------------------------------------------
Include CSS Compiler
-------------------------------------------------------------------------------
*/
require_once( ZEROWP_CUSTOMIZER_PATH . 'CssCompiler/lessc.class.php' );
require_once( ZEROWP_CUSTOMIZER_PATH . 'CssCompiler/css.class.php' );
require_once( ZEROWP_CUSTOMIZER_PATH . 'CssCompiler/functions.php' );

/*
-------------------------------------------------------------------------------
Include custom controls
-------------------------------------------------------------------------------
*/
$custom_fields = glob(ZEROWP_CUSTOMIZER_PATH .'Controls/*/control.class.php');
foreach ($custom_fields as $field) {
	require_once( $field );
}

/*
-------------------------------------------------------------------------------
Include functions for custom controls
-------------------------------------------------------------------------------
*/
$custom_fields_functions = glob(ZEROWP_CUSTOMIZER_PATH .'Controls/*/functions.php');
foreach ($custom_fields_functions as $field_functions) {
	require_once( $field_functions );
}