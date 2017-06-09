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
	protected $_defaulSection = 'title_tagline';

	/**
	 * Keep the current section ID. Modified in time
	 *
	 * @return string 
	 */
	protected $_currentSection = 'title_tagline';

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

	//------------------------------------//--------------------------------------//

	/**
	 * Construct manager
	 *
	 * @return void
	 */
	public function __construct(){
		$this->_defaulSection = apply_filters( 'zwpc:default_section_name', $this->_defaulSection );
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
		));
		
		$settings['panel'] = $this->_currentPanel;

		new Inject( $this->_filterSections, $id, $settings, $priority );

		$this->_currentSection = $id;

		return $this;
	}

	public function removeSection( $id, $priority = 30 ){
		new Eject( $this->_filterSections, $id, $priority );
		$this->_currentSection = $this->_defaulSection;

		return $this;
	}

	public function openSection( $id ){
		$this->_currentSection = $id;

		return $this;
	}

	public function closeSection( $id ){
		$this->_currentSection = $this->_defaulSection;

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

}