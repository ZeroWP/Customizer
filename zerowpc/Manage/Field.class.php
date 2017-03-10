<?php
namespace ZeroWPC\Manage;

class Field{

	/**
	 * Field ID
	 *
	 * @return string 
	 */
	public $id;

	/**
	 * Field type
	 *
	 * This field type may or may not be registered or may be a classname
	 *
	 * @return string 
	 */
	public $type;

	/**
	 * Field settings
	 *
	 * An array of settings for this field
	 *
	 * @return array 
	 */
	public $settings;

	/**
	 * The section ID where this field will be included to.
	 *
	 * @return string 
	 */
	public $section;

	public function __construct( $mode, $id, $type = 'text', $settings = array(), $section = false ){
		$this->id       = $id;
		$this->type     = $type;
		$this->settings = $settings;
		$this->section  = $section;
		
		add_action( 'customize_register', array( $this, $mode ) );
	}

	public function add( $wp_customize ){
		$type = $this->type;

		$defaults = array( 
			'default' => '',
			'section' => $this->section, 
		);

		$settings = wp_parse_args( $this->settings, $defaults );

		// Create the settings
		$wp_customize->add_setting( $this->id, $settings );

		$control_settings = $settings;

		// Add control to this setting
		$control_settings['type']    = $type;
		$control_settings['transport_type'] = !empty($settings['type']) ? $settings['type'] : 'theme_mod';

		$all_custom_controls = \ZeroWPC::controls();

		// If this field has been registered for this plugin.
		if( array_key_exists($type, $all_custom_controls) ){

			$class_name = $all_custom_controls[ $type ];

			if( class_exists($class_name) ){
				
				$class_instance = new $class_name( $wp_customize, $this->id, $control_settings );
				
				$wp_customize->add_control( $class_instance );
				
				if( method_exists($class_name, 'child_fields') ){
					$class_instance->child_fields( $wp_customize );
				}
			}

		}

		// If the classname is passed instead of field type.
		elseif( class_exists($type)  ){
			$wp_customize->add_control( new $type( $wp_customize, $this->id, $control_settings ) );
		}

		// Let the wordpress to decide what to display.
		else{
			$wp_customize->add_control( $this->id, $control_settings );
		}

	}

	public function remove( $wp_customize ){
		$wp_customize->remove_control( $this->id );
	}

}