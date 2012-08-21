<?php

/**
 *	Converts files to PNGs.
 *
 *	@package Transformist.Converter.Office
 *	@author Félix Girault <felix@vtech.fr>
 */

class Transformist_Converter_Office_Png extends Transformist_Converter_Office {

	/**
	 *	Name of the printer to be used for conversion.
	 *
	 *	@var string
	 */

	protected $_printer = 'draw_png_Export';



	/**
	 *	Returns the type of files that the converter accepts.
	 *
	 *	@return array Types.
	 */

	public static function inputTypes( ) {

		return array( 'image/gif', 'image/jpeg' );
	}



	/**
	 *	Returns the type of files that the converter produces.
	 *
	 *	@return string Type.
	 */

	public static function outputType( ) {

		return 'image/png';
	}
}
