<?php

/**
 *	An interface to execute commands.
 *
 *	@package Transformist
 *	@author Félix Girault <felix@vtech.fr>
 */

class Transformist_Command {

	/**
	 *	An array of all command that are executed.
	 *
	 *	@var array
	 */

	protected static $_commands = array( );



	/**
	 *	Constructor.
	 *
	 *	@param string $name Command name.
	 *	@param array $options Command options.
	 *	@param string $assignment An assignment character that will be used to
	 *		associate long options and their values. It is generally a space
	 *		or an equals sign.
	 */

	public static function execute( $name, $options = array( ), $assignment = ' ' ) {

		$command = $name;

		foreach ( $options as $key => $value ) {
			$command .= ' ';

			if ( is_string( $key )) {
				$command .= $key . $assignment;
				$value = escapeshellarg( $value );
			}

			$command .= $value;
		}

		self::$_commands[] = $command;
		return @exec( $command );
	}



	/**
	 *	Returns all the executed commands.
	 *
	 *	@return array
	 */

	public static function executed( ) {

		return self::$_commands;
	}



	/**
	 *	Returns the last executed command.
	 *
	 *	@return string|false The last command, or false if none were already
	 *		executed.
	 */

	public static function last( ) {

		if ( empty( self::$_commands )) {
			return false;
		}

		$last = count( self::$_commands ) - 1;
		return self::$_commands[ $last ];
	}
}
