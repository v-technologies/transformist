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
	 *	@todo Find a better way to set an output filename, because the current
	 *		workaround is freaking ugly.
	 *	@param Transformist_Document $Document Document to convert.
	 */

	public function _convert( $Document ) {

		$workaround = ( $Document->input( )->getName( ) !== $Document->output( )->getName( ));
		$originalInputFile = $Document->input( )->getRealPath( );
		$inputFile = $originalInputFile;

		if ( $workaround ) {
			$tmpInputFile = $Document->input( )->getPath( ) . DIRECTORY_SEPARATOR
				. $Document->output( )->getName( ) . '.workaround';

			if ( rename( $inputFile, $tmpInputFile )) {
				$inputFile = $tmpInputFile;
			}
		}

		$outputType = $Document->output( )->getMimeType( );
		$filter = self::$_formats[ $outputType ];

		$command = sprintf(
			'soffice --headless --nodefault --outdir %s/test --convert-to %s:%s %s',
			$Document->output( )->getPath( ),
			$Document->output( )->getExtension( ),
			$filter,
			$inputFile
		);

		exec( $command );

		if ( $workaround ) {
			rename( $inputFile, $originalInputFile );
		}
	}
}
