<?php

/**
 *	Converts documents using ImageMagick.
 *
 *	@package Transformist.Converter
 *	@author Félix Girault <felix@vtech.fr>
 */

abstract class Transformist_Converter_ImageMagick extends Transformist_Converter {

	/**
	 *
	 */

	protected $_typesMap = array(
		'image/gif' => 'gif',
		'image/jpeg' => 'jpg',
		'image/png' => 'png',
		'image/svg+xml' => 'svg',
		'image/tiff' => 'tif'
	);



	/**
	 *	Tests if the imagick extension is loaded.
	 *
	 *	@return boolean True if the extension is loaded, otherwise false.
	 */

	public static function isRunnable( ) {

		$result = Transformist_Command::execute( 'command', array( '-v', 'convert' ));

		return ( $result['status'] == 0 )
			? true
			: 'The convert command (from imagemagick) is not available.';
	}



	/**
	 *	Converts the given document.
	 *
	 *	@param Transformist_Document $Document Document to convert.
	 */

	public function convert( Transformist_Document $Document ) {

		$Input =& $Document->input( );
		$input = isset( $this->_typesMap[ $Input->type( )])
			? $this->_typesMap[ $Input->type( )] . ':'
			: '';
		$input = $Input->path( );

		$Output =& $Document->output( );
		$output = isset( $this->_typesMap[ $Output->type( )])
			? $this->_typesMap[ $Output->type( )] . ':'
			: '';
		$output = $Output->path( );

		Transformist_Command::execute( 'convert', array( $input, $output ));
	}
}
