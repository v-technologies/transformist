<?php

/**
 *	A simplistic interface to execute commands.
 *
 *	@package Transformist
 *	@author Félix Girault <felix@vtech.fr>
 */

class Transformist_Command {

	/**
	 *	Constructor.
	 *
	 *	@param string $name Command name.
	 *	@param array $options Command options.
	 *	@param string $assignment An assignment character that will be used to
	 *		associate long options and their values. It is generally a space
	 *		or an equals sign.
	 *	@param array $output If $output is provided, it will be filled with
	 *		 the generated command, and every line of output from the command.
	 *	@return integer Return status of the executed command
	 */

	public static function execute(
		$name,
		$options = array( ),
		$assignment = ' ',
		&$output = array( )
	) {

		$command = $name;

		foreach ( $options as $key => $value ) {
			$command .= ' ';

			if ( is_string( $key )) {
				$command .= $key . $assignment;
				$value = escapeshellarg( $value );
			}

			$command .= $value;
		}

		$output[] = $command;

		exec( $command, $output, $status );
		return $status;
	}
}
