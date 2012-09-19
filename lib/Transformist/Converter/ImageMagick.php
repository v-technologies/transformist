<?php

/**
 *	Converts documents using ImageMagick.
 *
 *	@package Transformist.Converter
 *	@author Félix Girault <felix@vtech.fr>
 */

class Transformist_Converter_ImageMagick extends Transformist_Converter {

	/**
	 *	Tests if the imagick extension is loaded.
	 *
	 *	@return boolean True if the extension is loaded, otherwise false.
	 */

	public static function isRunnable( ) {

		$Convert = new Transformist_Command( 'convert' );

		return $Convert->exists( )
			? true
			: 'The convert command (from imagemagick) is not available.';
	}



	/**
	 *
	 */

	public static function conversions( ) {

		return array(
			'image/gif' => array(
				'image/jpeg',
				'image/png',
				'image/svg+xml',
				'image/tiff'
			),
			'image/jpeg' => array(
				'image/gif',
				'image/png',
				'image/svg+xml',
				'image/tiff'
			),
			'image/png' => array(
				'image/gif',
				'image/jpeg',
				'image/svg+xml',
				'image/tiff'
			),
			'image/svg+xml' => array(
				'image/gif',
				'image/jpeg',
				'image/png',
				'image/tiff'
			),
			'image/tiff' => array(
				'image/gif',
				'image/jpeg',
				'image/png',
				'image/svg+xml'
			)
		);
	}



	/**
	 *	Converts the given document.
	 *
	 *	@param Transformist_Document $Document Document to convert.
	 */

	public function convert( Transformist_Document $Document ) {

		$Input =& $Document->input( );
		$input = Transformist_Registry::extension( $Input->type( ));

		if ( !empty( $input )) {
			$input .= ':';
		}

		$input .= $Input->path( );

		$Output =& $Document->output( );
		$output = Transformist_Registry::extension( $Output->type( ));

		if ( !empty( $output )) {
			$output .= ':';
		}

		$output .= $Output->path( );

		$Convert = new Transformist_Command( 'convert' );
		$Convert->execute( array( $input, $output ));
	}
}
