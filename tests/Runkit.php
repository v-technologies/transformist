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

	public static function redefine( $constant, $value ) {

		$originalConstant = "__original_$constant";

		if ( !defined( $originalConstant )) {
			define( $originalConstant, constant( $constant ));
		}

		runkit_constant_redefine( $constant, $value );
	}



	/**
	 *	Reimplements the given function.
	 */

	public static function reimplement( $function, $arguments, $code ) {

		$originalFunction = "__original_$function";

		if ( !function_exists( $originalFunction )) {
			runkit_function_rename( $function, "__original_$function" );
		}

		runkit_function_add( $function, $arguments, $code );
	}



	/**
	 *	Reset original definition.
	 */

	public static function reset( $definition ) {

		$originalDefinition = "__original_$definition";

		if ( function_exists( $originalDefinition )) {
			runkit_function_remove( $definition );
			runkit_function_rename( $originalDefinition, $definition );
		}

		if ( defined( $originalDefinition )) {
			runkit_constant_redefine( $definition, constant( $originalDefinition ));
			runkit_constant_remove( $originalDefinition );
		}
	}
}
