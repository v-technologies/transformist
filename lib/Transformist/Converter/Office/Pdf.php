<?php

/**
 *	Converts files to PDFs.
 *
 *	@package Transformist.Converter.Office
 *	@author Félix Girault <felix@vtech.fr>
 */

class Transformist_Converter_Office_Pdf extends Transformist_Converter_Office {

	/**
	 *	Output format.
	 *
	 *	@var string
	 */

	protected $_format = 'pdf';



	/**
	 *	Returns the type of files that the converter accepts.
	 *
	 *	@return array Types.
	 */

	public static function inputTypes( ) {

		return array( 'application/msword' );
	}



	/**
	 *	Returns the type of files that the converter produces.
	 *
	 *	@return string Type.
	 */

	public static function outputType( ) {

		return 'application/pdf';
	}
}
