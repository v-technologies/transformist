<?php

/**
 *	The main Exception class for Transformist.
 *
 *	@package Transformist
 *	@author Félix Girault <felix@vtech.fr>
 */

class Transformist_Exception extends Exception {

	/**
	 *	Constructs a Transformist Exception, and automatically adds the calling
	 *	class and function to the message.
	 *
	 *	@param string $message Exception message.
	 *	@param int $code Exception code.
	 */

	public function __construct( $message = '', $code = 0 ) {

		$trace = array_shift( $this->getTrace( ));
		$location = '';

		if ( $trace ) {
			if ( isset( $trace['class'])) {
				$location .= $trace['class'] . '::';
			}

			if ( isset( $trace['function'])) {
				$location .= $trace['function'] . '( )';
			}
		}

		if ( $location !== '' ) {
			$message = "$location : $message";
		}

		parent::__construct( $message, $code );
	}
}
