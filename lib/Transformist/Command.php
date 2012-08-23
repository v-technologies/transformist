<?php

/**
 *	A simplistic interface to execute commands.
 *
 *	@package Transformist
 *	@author Félix Girault <felix@vtech.fr>
 */

class Transformist_Command {

	/**
	 *	Holds informations about executed commands.
	 *
	 *	```
	 *		array(
	 *			array( ... ),
	 *			array( ... ),
	 *			array(
	 *				'command' => 'ls -l',
	 *				'output' => array( ... ),
	 *				'status' => 0
	 *			)
	 *		)
	 *	```
	 *
	 *	@var array
	 */

	protected static $_executed = array( );



	/**
	 *	Executes a command with the given options.
	 *
	 *	@param string $name Command name.
	 *	@param array $options Command options.
	 *	@param string $assignment An assignment character that will be used to
	 *		associate long options and their values. It is generally a space
	 *		or an equals sign.
	 *	@return array Informations about the executed command.
	 */

	public static function execute( $name, array $options = array( ), $assignment = ' ' ) {

		$command = $name;

		foreach ( $options as $key => $value ) {
			$command .= ' ';

			if ( is_string( $key )) {
				$command .= $key . $assignment;
			}

			$command .= $value;
		}

		// stderr redirection

		$command .= ' 2>&1';

		@exec( $command, $output, $status );

		$informations = compact( 'command', 'output', 'status' );
		self::$_executed[] = $informations;

		return $informations;
	}



	/**
	 *	Returns informations about all executed commands.
	 *
	 *	@return array Informations.
	 */

	public static function executed( ) {

		return self::$_executed;
	}



	/**
	 *	Returns informations about the last executed command.
	 *
	 *	@return array Informations.
	 */

	public function last( ) {

		$last = count( self::$_executed ) - 1;

		return ( $last < 0 )
			? array( )
			: self::$_executed[ $last ];
	}
}
