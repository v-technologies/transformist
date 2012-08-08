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
	 *
	 */

	protected $_conversions = array(
		'application/msword' => 'application/pdf'
	);



	/**
	 *	Maps mime types with their corresponding formats.
	 */

	protected $_formats = array(
		'application/pdf' => 'writer_pdf_Export'
	);



	/**
	 *	Converts the given document.
	 *
	 *	@param Transformist_Document $Document Document to convert.
	 */

	protected function _convert( $Document ) {

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
				. uniqid( '.workaround' );

			if ( symlink( $inputPath, $linkPath )) {
				$inputPath = $linkPath;
			} else {
				// avoids deleting the real file after the conversion if the
				// symlink couldn't be created.
				$workaround = false;
			}
		}

		// We're calling the office suite, without GUI (--headless) and without
		// opening a default document (--nodefault).

		Transformist_Command::execute(
			'soffice',
			array(
				'--headless',
				'--nodefault',
				'--outdir' => $Output->dirPath( ),
				'--convert-to' => $Output->extension( ) . ':' . $filter,
				$this->_formats[ $Output->type( )]
			)
		);

		// We don't need the symlink anymore.

		if ( $workaround ) {
			unlink( $inputPath );
		}
	}
}
