<?php

/**
 *	The base Exception class for SaeTransformist.
 *
 *	@package Transformist
 *	@author Félix Girault <felix@vtech.fr>
 */

class Transformist_Exception extends Exception {

	/**
	 *	An html version of the Exception message.
	 *
	 *	@var string
	 */

	protected $_html = '';



	/**
	 *	Constructs an Exception, and automatically adds the calling class and
	 *	function to the message.
	 *	This method behaves like sprintf, so it accepts a string as first
	 *	parameter, and many arguments to be inserted in the string.
	 *
	 *	@param string $message Exception message.
	 *	@param mixed $arguments Multiple arguments.
	 */

	public function __construct( $message, $arguments = null ) {

		// formatting

		if ( func_num_args( ) > 1 ) {
			$message = vsprintf( $message, array_slice( func_get_args( ), 1 ));
		}

		// call

		$trace = array_shift( $this->getTrace( ));
		$call = '';

		if ( $trace ) {
			if ( isset( $trace['class'])) {
				$call .= $trace['class'] . '::';
			}

			if ( isset( $trace['function'])) {
				$call .= $trace['function'] . '( )';
			}
		}

		if ( $call ) {
			$this->_html = "<pre><strong>$call</strong> $message</pre>";
			$message = "$call : $message";
		} else {
			$this->_html = "<pre>$message</pre>";
		}

		parent::__construct( $message );
	}



	/**
	 *	Returns an html version of the message.
	 *
	 *	@return string Html code.
	 */

	public function getMessageAsHtml( ) {

		return $this->_html;
	}
}
