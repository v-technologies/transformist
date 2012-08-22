<?php

/**
 *	Converts images to GIFs.
 *
 *	@package Transformist.Converter.ImageMagick
 *	@author Félix Girault <felix@vtech.fr>
 */

class Transformist_Converter_ImageMagick_Gif extends Transformist_Converter_ImageMagick {

	/**
	 *	Returns the type of files that the converter accepts.
	 *
	 *	@return array Types.
	 */

	public static function inputTypes( ) {

		return array(
			'image/jpeg',
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

		return 'image/gif';
	}
}
