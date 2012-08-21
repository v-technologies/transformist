<?php

/**
 *	@author Félix Girault <felix@vtech.fr>
 */

class Transformist_Converter_Html extends Transformist_Converter {

	/**
	 *	Returns the type of files that the converter accepts.
	 *
	 *	@return array Types.
	 */

	public static function inputTypes( ) {

		return array( 'text/plain' );
	}



	/**
	 *	Returns the type of files that the converter produces.
	 *
	 *	@return string Type.
	 */

	public static function outputType( ) {

		return 'text/html';
	}



	/**
	 *
	 */

	public function convert( Transformist_Document $Document ) {

		file_put_contents(
			$Document->output( )->path( ),
			file_get_contents( $Document->input( )->path( ))
		);
	}
}
