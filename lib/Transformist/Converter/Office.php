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
	 *	Maps mime types with their corresponding formats.
	 */

	protected static $_formats = array(
		'application/pdf' => 'writer_pdf_Export'
	);



	/**
	 *	Checks if the Converter can convert the given document.
	 *
	 *	@param Transformist_Document $Document Document to convert.
	 *	@return boolean Whether or not the Converter can convert the document.
	 */

	public static function canConvert( $Document ) {

		$handlesInput = in_array(
			$Document->input( )->getMimeType( ),
			array( 'application/msword' )
		);

		$handlesOutput = in_array(
			$Document->output( )->getMimeType( ),
			array_keys( self::$_formats )
		);

		return ( $handlesInput && $handlesOutput );
	}



	/**
	 *	Converts the given document.
	 *
	 *	@param Transformist_Document $Document Document to convert.
	 */

	public function _convert( $Document ) {

		$workaround = ( $Document->input( )->getName( ) !== $Document->output( )->getName( ));
		$originalInputFilePath = $Document->input( )->getRealPath( );
		$inputFilePath = $originalInputFilePath;

		// The office command doesn't allow us to specify an output file name.
		// So here's the trick: we're renaming the input file to match the
		// desired output file name, with a unique extension to ensure that
		// the file doesn't exists.
		// This seems dirty at first, but the file renaming is actually pretty
		// fast (between 0,02 and 0,03 ms on my old desktop computer), and it
		// becomes reeaally fast compared to the office command execution time.

		// PROBLEM: No one else can access the file while it is beeing converted,
		// as its name changes.
		// POSSIBLE FIX: Use a symlink instead of renaming the file, but what
		// about windows ?

		if ( $workaround ) {
			$tmpInputFilePath = $Document->input( )->getPath( )
				. DIRECTORY_SEPARATOR
				. $Document->output( )->getName( )
				. uniqid( '.workaround-' );

			if ( rename( $inputFilePath, $tmpInputFilePath )) {
				$inputFilePath = $tmpInputFilePath;
			}
		}

		$outputType = $Document->output( )->getMimeType( );
		$filter = self::$_formats[ $outputType ];

		// We're calling the office suite, without GUI (--headless) and without
		// opening a default document (--nodefault).

		$command = sprintf(
			'soffice --headless --nodefault --outdir %s --convert-to %s:%s %s',
			$Document->output( )->getPath( ),		// output directory
			$Document->output( )->getExtension( ),	// output file extension
			$filter,							// filter
			$inputFilePath						// input file
		);

		exec( $command );

		// Resetting the input file name if needed.

		if ( $workaround ) {
			rename( $inputFilePath, $originalInputFilePath );
		}
	}
}
