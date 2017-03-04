<?php
namespace ZeroWPC\Manage;

class Section{

	public $id;
	public $title;
	public $settings;
	public $panel;

	public function __construct( $mode, $id, $title = false, $settings = array(), $panel = '' ){
		$this->id       = $id;
		$this->title    = $title;
		$this->settings = $settings;
		$this->panel    = $panel;

		add_action( 'customize_register', array( $this, $mode ) );
	}

	public function add( $wp_customize ){
		if( !empty($this->title) && trim($this->title) !== false ){
			$defaults = array( 
				'title' => $this->title, 
				'panel' => $this->panel 
			);

			$settings = wp_parse_args( $this->settings, $defaults );
			
			$wp_customize->add_section( $this->id, $settings );
		}
		
	}

	public function remove( $wp_customize ){
		$wp_customize->remove_section( $this->id );
	}

}