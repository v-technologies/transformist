<?php

/**
 *	Converts JPGs to TIFFs.
 *
 *	@package Transformist.Converter.Office
 *	@author Félix Girault <felix@vtech.fr>
 */

class Transformist_Converter_Office_Tiff extends Transformist_Converter_Office {

	/**
	 *	Name of the printer to be used for conversion.
	 *
	 *	@var string
	 */

	protected $_printer = 'draw_tif_Export';



	/**
	 *	Returns the type of files that the converter accepts.
	 *
	 *	@return array Types.
	 */

	public static function inputTypes( ) {

		return array( 'image/png', 'image/jpeg' );
	}



	/**
	 *	Returns the type of files that the converter produces.
	 *
	 *	@return string Type.
	 */

	public static function outputType( ) {

		return 'image/tiff';
	}
}
