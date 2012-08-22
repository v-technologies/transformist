<?php

/**
 *	Converts images to JPGs.
 *
 *	@package Transformist.Converter.ImageMagick
 *	@author Félix Girault <felix@vtech.fr>
 */

class Transformist_Converter_ImageMagick_Jpg extends Transformist_Converter_ImageMagick {

	/**
	 *	Returns the type of files that the converter accepts.
	 *
	 *	@return array Types.
	 */

	public static function inputTypes( ) {

		return array(
			'image/gif',
			'image/png',
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

		return 'image/jpeg';
	}
}
