<?php
namespace ZeroWPC\Manage;

class Panel{

	public $id;
	public $title;
	public $settings;

	public function __construct( $mode, $id, $title = false, $settings = array() ){
		$this->id       = $id;
		$this->title    = $title;
		$this->settings = $settings;

		add_action( 'customize_register', array( $this, $mode ) );
	}

	public function add( $wp_customize ){
		$title = !empty($this->title) && trim($this->title) !== false ? $this->title : $this->id;
		
		$defaults = array( 
			'title' => $title, 
			'capability' => 'edit_theme_options',
		);

		$settings = wp_parse_args( $this->settings, $defaults );

		$wp_customize->add_panel( $this->id, $settings );
	}

	public function remove( $wp_customize ){
		$wp_customize->remove_panel( $this->id );
	}

}