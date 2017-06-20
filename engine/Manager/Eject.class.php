<?php
/**
 * Eject
 *
 * Eject content from manager.
 *
 * @since 1.0
 */
namespace ZeroWPCustomizer\Manager;

class Eject{

	public $id;

	public function __construct( $filter, $id, $priority ){
		$this->id = $id;

		add_filter( $filter, array($this, 'manage'), absint($priority) );
	}

	public function manage( $elements ){
		if( array_key_exists($this->id, (array) $elements) ){
			unset( $elements[ $this->id ] );
		}
		return $elements;
	}

}