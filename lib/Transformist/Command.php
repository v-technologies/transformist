<?php

/**
 *	A simplistic interface to execute commands.
 *
 *	@package Transformist
 *	@author Félix Girault <felix@vtech.fr>
 */

class Transformist_Command {

	/**
	 *	Command name.
	 *
	 *	@var string
	 */

	protected $_name = '';



	/**
	 *	Assignment operator.
	 *
	 *	@var string
	 */

	protected $_assignment = '';



	/**
	 *	Constructs a command with the given name.
	 *
	 *	@param string $name Command name.
	 *	@param string $assignment An assignment character that will be used to
	 *		associate long options and their values. It is generally a space
	 *		or an equals sign.
	 */

	public function __construct( $name, $assignment = ' ' ) {

		$this->_name = $name;
		$this->_assignment = $assignment;
	}



	/**
	 *	Returns if the command is available on the system, relying on the
	 *	'command' utility, which should be installed on most systems.
	 *
	 *	@return boolean True if it is available, otherwise false.
	 */

	public function exists( ) {

		$Command = new Transformist_Command( 'command' );
		$Result = $Command->execute( array( '-v', $this->_name ));

		return $Result->isSuccess( );
	}



	/**
	 *	Executes the command with the given options.
	 *
	 *	@param array $options Command options.
	 *	@return Transformist_CommandResult Informations about the executed command.
	 */

	public function execute( array $options = array( )) {

		$command = $this->_name;

		foreach ( $options as $key => $value ) {
			$command .= ' ';

			if ( is_string( $key )) {
				$command .= $key . $this->_assignment;
			}

			$command .= $value;
		}

		@exec( $command . ' 2>&1', $output, $status );

		return new Transformist_CommandResult( $command, $output, $status );
	}
}
