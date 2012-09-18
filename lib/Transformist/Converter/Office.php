<?php

/**
 *	Converts documents through the OpenOffice/LibreOffice conversion system.
 *	This converter relies on the OpenOffice/LibreOffice suite, which must be
 *	installed on the system for the conversion to be done.
 *
 *	@package Transformist.Converter
 *	@author Félix Girault <felix@vtech.fr>
 */

abstract class Transformist_Converter_Office extends Transformist_Converter {

	/**
	 *	Output format.
	 *
	 *	@var string
	 */

	protected $_format = '';



	/**
	 *	Command arguments to be merged with the default ones.
	 *
	 *	@var array
	 */

	protected $_arguments = array( );



	/**
	 *	Tests if the soffice command is available on the system.
	 *
	 *	@return boolean True if the command exists, otherwise false.
	 */

	public static function isRunnable( ) {

		$Unoconv = new Transformist_Command( 'unoconv' );

		if ( !$Unoconv->exists( )) {
			return 'The unoconv command is not available.';
		}

		$result = $Unoconv->execute( array( '--version' ));
		$version = 0;

		foreach ( $result->output( ) as $line ) {
			if ( preg_match( '#unoconv\\s+(?P<version>[0-9]\\.[0-9])#i', $line, $matches )) {
				$version = floatval( $matches['version']);
				break;
			}
		}

		if ( $version < 0.6 ) {
			return 'unoconv version must be 0.6 or higher';
		}

		return true;
	}



	/**
	 *	Converts the given document.
	 *
	 *	@param Transformist_Document $Document Document to convert.
	 */

	public function convert( Transformist_Document $Document ) {

		if ( empty( $this->_format )) {
			throw new Transformist_Exception(
				'$_format must be defined.'
			);
		}

		$Input =& $Document->input( );
		$Output =& $Document->output( );

		$inputPath = $Input->path( );

		// The office command doesn't allow us to specify an output file name.
		// So here's the trick: we're creating a link to the input file, named
		// as the desired output file name, with a unique extension to ensure
		// that the link file name doesn't exists.
		// The we will pass the symlink to the office command, which will use
		// the link name as output file name.

		$workaround = ( $Input->baseName( ) !== $Output->baseName( ));

		if ( $workaround ) {
			$linkPath = $Output->dirPath( )
				. DIRECTORY_SEPARATOR
				. $Output->baseName( )
				. uniqid( '.workaround-' );

			if ( @symlink( $inputPath, $linkPath )) {
				$inputPath = $linkPath;
			} else {
				return;
			}
		}

		// We're calling the office suite, without GUI (--headless) and without
		// opening a default document (--nodefault).

		$arguments = array_merge(
			$this->_arguments,
			array(
				'-f' => $this->_format,
				'--output' => $Output->dirPath( ),
				$inputPath
			)
		);

		$Unoconv = new Transformist_Command( 'unoconv' );
		$Unoconv->execute( $arguments );

		// We don't need the symlink anymore.

		if ( $workaround ) {
			unlink( $inputPath );
		}
	}
}
