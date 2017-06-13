<?php 
namespace ZeroWPCustomizer;

use ZeroWPCustomizer\Manager\Manage;

class Build{

	public function __construct(){
		add_action( 'customize_register', array( $this, 'release' ) );
	}

	public function release( $wp_customize ){
		$manager = new Manage;

		$this->parsePanels( $manager, $wp_customize );
		$this->parseSections( $manager, $wp_customize );
		$this->parseFields( $manager, $wp_customize );
	}

	public function parsePanels( $manager, $wp_customize ){
		$panels = $manager->getPanels();

		if( !empty( $panels ) ){
			foreach ($panels as $panel_id => $panel) {
				$title = !empty($panel['title']) ? esc_html($panel['title']) : $panel_id;
				$settings = wp_parse_args( $panel, array( 
					'capability' => 'edit_theme_options',
				));
				$settings[ 'title' ] = $title;

				$wp_customize->add_panel( $panel_id, $settings );
			}
		}
	}

	public function parseSections( $manager, $wp_customize ){
		$sections = $manager->getSections();

		if( !empty( $sections ) ){
			foreach ($sections as $section_id => $section) {
				$title = !empty($section['title']) ? esc_html($section['title']) : $section_id;
				$settings = wp_parse_args( $section, array() );
				$settings[ 'title' ] = $title;

				$wp_customize->add_section( $section_id, $settings );
			}
		}
	}

	public function parseFields( $manager, $wp_customize ){
		$fields = $manager->getFields();
		
		if( !empty( $fields ) ){
			foreach ( $fields as $field_id => $field ) {
				$field_settings = !empty( $field['settings'] ) ? $field['settings'] : array();
				$field_type     = $field['type'];

				$setting_args = wp_parse_args( $field_settings, array(
					'type'                 => 'theme_mod', // or 'option'
					'capability'           => 'edit_theme_options',
					'theme_supports'       => '', // Rarely needed.
					'default'              => '',
					'transport'            => 'refresh', // or postMessage
					'sanitize_callback'    => '',
					'sanitize_js_callback' => '', // Basically to_json.
				));
				$setting_args['default'] = $field['value'];

				$control_args = wp_parse_args( $field_settings, array(
					'type'            => $field_type,
					'priority'        => 10, // Within the section.
					'section'         => '', // Required, core or custom.
					'label'           => '',
					'description'     => '',
					'choices'         => array(),
					'input_attrs'     => array(),
					'active_callback' => '',
				));
				$control_args['section'] = $field['section'];

				$wp_customize->add_setting( $field_id, $setting_args );


				$all_custom_controls = $manager->getControlTypes();
				
				try {
					// If this field has been registered for this plugin.
					if( array_key_exists($field_type, $all_custom_controls) ){

						$class_name = $all_custom_controls[ $field_type ];

						if( ! class_exists($class_name) )
							throw new DoException( "The `{$class_name}` registered for `{$field_type}` does not exists!" );
							
						$class_instance = new $class_name( $wp_customize, $field_id, $control_args );
						
						$wp_customize->add_control( $class_instance );
						
						if( method_exists($class_name, 'child_fields') ){
							$class_instance->child_fields( $wp_customize );
						}

					}

					// Let WordPress decide what to display.
					else{
						$wp_customize->add_control( $field_id, $control_args );
					}
				} catch (DoException $e) {
					error_log( __CLASS__ .' error: '. $e->getMessage() );
				}

			}
		}
	}

}