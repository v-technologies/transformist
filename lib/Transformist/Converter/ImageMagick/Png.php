<?php

/**
 *	Converts images to PNGs.
 *
 *	@package Transformist.Converter.ImageMagick
 *	@author Félix Girault <felix@vtech.fr>
 */

class Transformist_Converter_ImageMagick_Png extends Transformist_Converter_ImageMagick {

	/**
	 *	Returns the type of files that the converter accepts.
	 *
	 *	@return array Types.
	 */

	public static function inputTypes( ) {

		return array(
			'image/gif',
			'image/jpeg',
			'image/svg+xml',
			'image/tiff'
		);
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
