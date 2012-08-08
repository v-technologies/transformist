<?php

/**
 *	An interface to execute commands.
 *
 *	@package Transformist
 *	@author Félix Girault <felix@vtech.fr>
 */

class Transformist_Command {

	/**
	 *	Constructor.
	 *
	 *	@param string $name Command name.
	 *	@param array $arguments Command arguments.
	 */

	public static function execute( $name, $arguments = array( )) {

		$command = $name;

		foreach ( $arguments as $key => $value ) {
			$command .= ' ';

			if ( is_string( $key )) {
				$command .= $key . ' ';
			}

			$command .= $value;
		}

		return exec( $command );
	}
}
