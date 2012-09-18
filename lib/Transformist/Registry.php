<?php

/**
 *	Regitry of files formats.
 *
 *	@package Transformist
 *	@author Félix Girault <felix@vtech.fr>
 */

class Transformist_Registry {

	/**
	 *	Maps MIME types to extensions.
	 *
	 *	@var array
	 */

	protected static $_map = array( );



	/**
	 *	Returns the common extensions associated to a MIME type.
	 *
	 *	@param string $type MIME type.
	 *	@return string The associated extension if it is set, otherwise an
	 *		empty string.
	 */

	public static function extension( $type ) {

		return isset( self::$_map[ $type ])
			? self::$_map[ $type ]
			: '';
	}



	/**
	 *	Associates an extension to one ore more MIME types.
	 *
	 *	@param string|array $extension Extension, or an array of extension => types.
	 *	@param string $type MIME type.
	 */

	public static function register( $extension, $type = null ) {

		$associations = is_array( $extension )
			? $extension
			: array( $extension => $type );

		foreach ( $associations as $extension => $type ) {
			self::$_map[ $type ] = $extension;
		}
	}
}
