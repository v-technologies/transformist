<?php

/**
 *	Converts documents through the OpenOffice/LibreOffice conversion system.
 *	This converter relies on the OpenOffice/LibreOffice suite, which must be
 *	installed on the system for the conversion to be done.
 *
 *	@package Transformist.Converter
 *	@author Félix Girault <felix@vtech.fr>
 */

class Transformist_Converter_Office extends Transformist_Converter {

	/**
	 *	Tests if the soffice command is available on the system.
	 *
	 *	@return boolean|sting True if the command exists, otherwise an error message.
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
	 *	Returns an array of conversions the converter can handle.
	 *
	 *	array( 'input/type' => 'output/type' )
	 *	array( 'input/type' => array( 'output/type1', 'output/type2' ))
	 *
	 *	@return array Array of supported types.
	 */

	public static function conversions( ) {

		return array(
			'application/msword' => array(
				'application/pdf',
				'application/pdfa'
			),
			'application/pdf' => 'application/pdfa'
		);
	}



	/**
	 *	Converts the given document.
	 *
	 *	@param Transformist_Document $Document Document to convert.
	 */

	public function convert( Transformist_Document $Document ) {

		$Input =& $Document->input( );
		$Output =& $Document->output( );

		// The office command doesn't allow us to specify an output file name.
		// So here's the trick: we're creating a link to the input file, named
		// as the desired output file name, with a unique extension to ensure
		// that the link file name doesn't exists.
		// The we will pass the symlink to the office command, which will use
		// the link name as output file name.

		$inputPath = $Input->path( );
		$workaround = ( $Input->baseName( ) !== $Output->baseName( ));

		if ( $workaround ) {
			$linkPath = $Output->dirPath( )
				. DIRECTORY_SEPARATOR
				. $Output->baseName( )
				. uniqid( '.workaround-' );

			if ( symlink( $inputPath, $linkPath )) {
				$inputPath = $linkPath;
			} else {
				return;
			}
		}

		//

		$arguments = array( );

		if ( $Output->type( ) == 'application/pdfa' ) {
			$arguments['-e'] = 'SelectPdfVersion=1';
		}

		$format = Transformist_Registry::extension( $Output->type( ));

		if ( $format ) {
			$arguments['-f'] = $format;
		}

		$arguments += array(
			'--output' => $Output->dirPath( ),
			$inputPath
		);

		$Unoconv = new Transformist_Command( 'unoconv' );
		$R = $Unoconv->execute( $arguments );

		// We don't need the symlink anymore.

		if ( $workaround ) {
			unlink( $inputPath );
		}
	}
}
