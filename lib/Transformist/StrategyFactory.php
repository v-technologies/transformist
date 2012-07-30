<?php

/**
 *	A factory that finds the correct strategy to handle documents conversion.
 *
 *	@package Transformist
 *	@author Félix Girault <felix@vtech.fr>
 */

class Transformist_StrategyFactory {

	/**
	 *	A list of strategies class names.
	 *
	 *	@var array
	 */

	protected $_strategies = array( );



	/**
	 *	Constructor.
	 */

	protected function __construct( ) {

		$this->_listStrategies( );
	}



	/**
	 *	Lists and stores every available strategies.
	 */

	protected function _listStrategies( ) {

		$pattern = TRANSFORMIST_ROOT . 'Transformist' . DS . 'Strategy' . DS . '*.php';

		foreach ( glob( $pattern ) as $fileName ) {
			$className = sprintf( 'Transformist_Strategy_%s', basename( $fileName, '.php' ));
			$this->_strategies[] = $className;
		}
	}



	/**
	 *	Returns a singleton instance of the StrategyFactory.
	 *
	 *	@return Transformist_StrategyFactory Instance.
	 */

	protected static function _instance( ) {

		static $instance = null;

		if ( $instance === null ) {
			$instance = new Transformist_StrategyFactory( );
		}

		return $instance;
	}



	/**
	 *	Finds a strategy that can convert a document from $sourceMimeType to
	 *	$targetMimeType.
	 *
	 *	@param string $sourceMimeType Mime type of the source document.
	 *	@param string $targetMimeType	Mime type of the target document.
	 */

	public static function load( $sourceMimeType, $targetMimeType ) {

		$_this = self::_instance( );
		$Strategy = null;

		foreach ( $_this->_strategies as $className ) {
			if (
				$className::convertsFrom( $sourceMimeType ) &&
				$className::convertsTo( $targetMimeType )
			) {
				$Strategy = new $className;
				break;
			}
		}

		return $Strategy;
	}
}
