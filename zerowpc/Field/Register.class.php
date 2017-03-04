<?php
namespace ZeroWPC\Field;

class Register{
	public $type;
	public $class;

	public function __construct( $mode, $type_name, $class_name = false ){
		$this->type = $type_name;
		$this->class = $class_name;

		add_filter( 'zerowpc_controls', array( $this, $mode ) );
	}

	public function add( $controls_array ){
		if( !array_key_exists($this->type, $controls_array) && !empty($this->class) ){
			$controls_array[ $this->type ] = $this->class;
		}
		return $controls_array;
	}

	public function remove( $controls_array ){
		if( isset($this->type) ){
			unset( $controls_array[ $this->type ] );
		}
		return $controls_array;
	}
}