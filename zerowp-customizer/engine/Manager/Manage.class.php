<?php
/**
* Manager
*
* Get access to customizer and manage its content(fields, sections, etc).
*
* @since 1.0
*
*/
namespace ZeroWPCustomizer\Manager;

class Manage{

	/**
	 * Keep the default section ID
	 *
	 * @return string 
	 */
	protected $_defaultSection = 'title_tagline';

	/**
	 * Keep the current section ID. Modified in time
	 *
	 * @return string 
	 */
	protected $_currentSection = 'title_tagline';

	/**
	 * Keep the default panel ID
	 *
	 * @return string 
	 */
	protected $_defaultPanel = null;

	/**
	 * Keep the current panel ID
	 *
	 * @return string 
	 */
	protected $_currentPanel = null;

	/**
	 * The filter name used to keep the panels
	 *
	 * @return string 
	 */
	protected $_filterPanels = 'zwpc:panels';

	/**
	 * The filter name used to keep the sections
	 *
	 * @return string 
	 */
	protected $_filterSections = 'zwpc:sections';

	/**
	 * The filter name used to keep the fields
	 *
	 * @return string 
	 */
	protected $_filterFields = 'zwpc:fields';

	/**
	 * The filter name used to keep the control types
	 *
	 * @return string 
	 */
	protected $_controlTypes = 'zwpc:controls';

	//------------------------------------//--------------------------------------//

	/**
	 * Construct manager
	 *
	 * @return void
	 */
	public function __construct(){
		$this->_defaultSection = apply_filters( 'zwpc:default_section_name', $this->_defaultSection );
	}

	/*
	-------------------------------------------------------------------------------
	Open customizer. This must be the first method to call in each action hook, to
	avoid unexpected results.
	-------------------------------------------------------------------------------
	*/
	public function openCustomizer(){
		$this->_currentSection = $this->_defaultSection;
		$this->_currentPanel = $this->_defaultPanel;

		return $this;
	}

	/*
	-------------------------------------------------------------------------------
	Fields
	-------------------------------------------------------------------------------
	*/
	public function addField( $id, $type, $value, $settings = false, $priority = 30 ){
		$args = array(
			'id' => $id,
			'type' => $type,
			'value' => $value,
			'section' => $this->_currentSection,
			'settings' => $settings,
		);

		// Set field priority
		$args['settings']['priority'] = $priority;

		new Inject( $this->_filterFields, $id, $args, $priority );

		return $this;
	}

	public function removeField( $id, $priority = 30 ){
		new Eject( $this->_filterFields, $id, $priority );

		return $this;
	}

	/*
	-------------------------------------------------------------------------------
	Sections
	-------------------------------------------------------------------------------
	*/
	public function addSection( $id, $title = false, $settings = array(), $priority = 30 ){
		$settings = wp_parse_args( $settings, array(
			'title' => $title,
			'priority' => $priority,
		));
		
		$settings['panel'] = $this->_currentPanel;

		new Inject( $this->_filterSections, $id, $settings, $priority );

		$this->_currentSection = $id;

		return $this;
	}

	public function removeSection( $id, $priority = 30 ){
		new Eject( $this->_filterSections, $id, $priority );
		$this->_currentSection = $this->_defaultSection;

		return $this;
	}

	public function openSection( $id ){
		$this->_currentSection = $id;

		return $this;
	}

	public function closeSection( $id ){
		$this->_currentSection = $this->_defaultSection;

		return $this;
	}

	/*
	-------------------------------------------------------------------------------
	Panels
	-------------------------------------------------------------------------------
	*/
	public function addPanel( $id, $title = false, $settings = array(), $priority = 30 ){
		$settings = wp_parse_args( $settings, array(
			'title' => $title,
			'priority' => $priority,
		));
		
		new Inject( $this->_filterPanels, $id, $settings, $priority );

		$this->_currentPanel = $id;

		return $this;
	}

	public function removePanel( $id, $priority = 30 ){
		new Eject( $this->_filterPanels, $id, $priority );
		$this->_currentPanel = null;

		return $this;
	}

	public function openPanel( $id ){
		$this->_currentPanel = $id;

		return $this;
	}

	public function closePanel( $id ){
		$this->_currentPanel = null;

		return $this;
	}

	/*
	-------------------------------------------------------------------------------
	Fields
	-------------------------------------------------------------------------------
	*/
	public function addControlType( $type, $classname, $priority = 30 ){
		new Inject( $this->_controlTypes, $this->camelToSnake( $type ), $classname, $priority );

		return $this;
	}

	public function removeControlType( $type, $priority = 30 ){
		new Eject( $this->_controlTypes, $this->camelToSnake( $type ), $priority );

		return $this;
	}

	/*
	-------------------------------------------------------------------------------
	Helpers
	-------------------------------------------------------------------------------
	*/
	public function getFields(){
		return apply_filters( $this->_filterFields, array() );
	}

	public function getSections(){
		return apply_filters( $this->_filterSections, array() );
	}

	public function getPanels(){
		return apply_filters( $this->_filterPanels, array() );
	}

	public function getControlTypes(){
		return apply_filters( $this->_controlTypes, array() );
	}

	/*
	-------------------------------------------------------------------------------
	Utils
	-------------------------------------------------------------------------------
	*/
	/**
	 * ID
	 *
	 * Prepare ID. Convert strings from camelCase to snake_case
	 *
	 * @param string $id String to be converted
	 * @return string Converted string
	 */
	public function camelToSnake( $id ){
		return strtolower(preg_replace( array('/([a-z\d])([A-Z])/', '/([^_])([A-Z][a-z])/' ), '$1_$2', $id ));
	}

}