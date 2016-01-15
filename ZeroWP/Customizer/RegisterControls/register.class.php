<?php
namespace ZeroWP\Customizer;

class Register{
	public $type;
	public $class;

	public function __construct( $type_name, $class_name = false ){
		$this->type = $type_name;
		$this->class = $class_name;
	}

	public function add( $controls_array ){
		if( !array_key_exists($this->type, $controls_array) && !empty($this->class) ){
			$controls_array[ $this->type ] = $this->class;
		}
		return $controls_array;
	}

	public function delete( $controls_array ){
		if( isset($this->type) ){
			unset( $controls_array[ $this->type ] );
		}
		return $controls_array;
	}

	public function register(){
		add_filter( 'zerowp_customizer_custom_controls', array( $this, 'add' ) );
	}

	public function deregister(){
		add_filter( 'zerowp_customizer_custom_controls', array( $this, 'delete' ) );
	}
}