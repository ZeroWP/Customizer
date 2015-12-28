<?php
namespace ZeroWP\Customizer;

class Create{

	public $customize;
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
	public function __construct( $wp_customize ){
		$this->customize = $wp_customize;
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
		$title = !empty($title) && trim($title) !== false ? $title : $id;
		$defaults = array( 'title' => $title, 'capability' => 'edit_theme_options', );
		$settings = wp_parse_args( $settings, $defaults );
		$this->customize->add_panel( $id, $settings );
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
		$this->customize->remove_panel( $id );
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
		if( !empty($title) && trim($title) !== false ){
			$defaults = array( 'title' => $title, 'panel' => $this->panel );
			$settings = wp_parse_args( $settings, $defaults );
			$this->customize->add_section( $id, $settings );
		}
		
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
		$this->customize->remove_section( $id );
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
		$defaults = array( 'default' => '' );
		$settings = wp_parse_args( $settings, $defaults );

		// Create the settings
		$this->customize->add_setting( $id, $settings );


		$control_settings = $settings;

		// Add control to this setting
		$control_settings['section'] = $this->section;
		$control_settings['type']    = $type;
		$control_settings['transport_type'] = !empty($settings['type']) ? $settings['type'] : 'theme_mod';

		// If this field has been registered for this plugin.
		$all_custom_controls = zerowp_customizer_custom_controls();
		if( array_key_exists($type, $all_custom_controls) ){
			$class_name = $all_custom_controls[ $type ];
			if( class_exists($class_name) ){
				$class_instance = new $class_name( $this->customize, $id, $control_settings );
				$this->customize->add_control( $class_instance );
				if( method_exists($class_name, 'child_fields') ){
					$class_instance->child_fields( $this->customize );
				}
			}
		}

		// If the classname is passed instead of field type.
		elseif( class_exists($type)  ){
			$this->customize->add_control( new $type( $this->customize, $id, $control_settings ) );
		}

		// Let the wordpress to decide what to display. Default behavoir.
		else{
			$this->customize->add_control( $id, $control_settings );
		}

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
		$this->customize->remove_control( $id );
	}

}