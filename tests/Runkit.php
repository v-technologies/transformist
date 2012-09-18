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
	 *
	 */

	public static function requiredBy( PHPUnit_Framework_TestCase $Case ) {

		if ( !Runkit::isEnabled( )) {
			$Case->markTestSkipped( 'Runkit must be enabled' );
		}
	}



	/**
	 *
	 */

	public static function redefineConstant( $constant, $value ) {

		$originalConstant = "__ORIGINAL_$constant";

		if ( !defined( $originalConstant )) {
			define( $originalConstant, constant( $constant ));
		}

		runkit_constant_redefine( $constant, $value );
	}



	/**
	 *	Reset original definition.
	 */

	public static function resetConstant( $constant ) {

		$originalConstant = "__ORIGINAL_$constant";

		if ( defined( $originalConstant )) {
			runkit_constant_redefine( $constant, constant( $originalConstant ));
			runkit_constant_remove( $originalConstant );
		}
	}



	/**
	 *	Reimplements the given function.
	 */

	public static function reimplementFunction( $function, $arguments, $code ) {

		$originalFunction = "__original_$function";

		if ( !function_exists( $originalFunction )) {
			runkit_function_rename( $function, $originalFunction );
		}

		runkit_function_add( $function, $arguments, $code );
	}



	/**
	 *	Reset original function.
	 */

	public static function resetFunction( $function ) {

		$originalFunction = "__original_$function";

		if ( function_exists( $originalFunction )) {
			runkit_function_remove( $function );
			runkit_function_rename( $originalFunction, $function );
		}
	}



	/**
	 *	Reimplements the given function.
	 */

	public static function reimplementMethod( $class, $method, $arguments, $code ) {

		$originalMethod = "__original_$method";

		if ( !method_exists( $class, $originalMethod )) {
			runkit_method_rename( $class, $method, $originalMethod );
		}

		runkit_method_add( $class, $method, $arguments, $code );
	}



	/**
	 *	Reset original definition.
	 */

	public static function resetMethod( $class, $method ) {

		$originalMethod = "__original_$method";

		if ( method_exists( $class, $originalMethod )) {
			runkit_method_remove( $class, $method );
			runkit_method_rename( $class, $originalMethod, $method );
		}
	}
}
