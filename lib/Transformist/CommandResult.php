<?php

/**
 *	Holds informations about executed commands.
 *
 *	@package Transformist
 *	@author Félix Girault <felix@vtech.fr>
 */

class Transformist_CommandResult {

	/**
	 *	Executed command.
	 *
	 *	@var string
	 */

	protected $_command = '';



	/**
	 *	Command output lines.
	 *
	 *	@var array
	 */

	protected $_output = array( );



	/**
	 *	Execution status.
	 *
	 *	@var int
	 */

	protected $_status = -1;



	/**
	 *	Constructor.
	 *
	 *	@param string $command Executed command.
	 */

	public function __construct( $command, $output, $status ) {

		$this->_command = $command;
		$this->_output = $output;
		$this->_status = $status;
	}



	/**
	 *	Returns if the execution was succesful.
	 *	This method doesn't guarantee that the execution went fine, but it will
	 *	be right most of the time (with programs that follow standards).
	 *
	 *	@return boolean True if it was, otherwise false.
	 */

	public function isSuccess( ) {

		return ( $this->_status == 0 );
	}



	/**
	 *	Returns the executed command.
	 *
	 *	@var string Command.
	 */

	public function command( ) {

		return $this->_command;
	}



	/**
	 *	Returns the command output lines.
	 *
	 *	@return array Lines.
	 */

	public function output( ) {

		return $this->_output;
	}



	/**
	 *	Returns the execution status.
	 *
	 *	@var int Status.
	 */

	public function status( ) {

		return $this->_status;
	}
}
