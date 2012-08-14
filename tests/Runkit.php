<?php

/**
 *	A wrapper for runkit extension.
 *
 *	@author Félix Girault <felix@vtech.fr>
 */

class Runkit {

	/**
	 *	Returns if the runkit extension is loaded.
	 */

	public static function isEnabled( ) {

		return extension_loaded( 'runkit' );
	}



	/**
	 *	Reimplements the given function.
	 */

	public static function reimplement( $function, $arguments, $code ) {

		runkit_function_rename( $function, "__original_$function" );
		runkit_function_add( $function, $arguments, $code );
	}



	/**
	 *	Reset original implementation of the given function.
	 */

	public static function reset( $function ) {

		$originalFunction = "__original_$function";

		if ( function_exists( $originalFunction )) {
			runkit_function_remove( $function );
			runkit_function_rename( $originalFunction, $function );
		}
	}
}
