<?php

/**
 *	Converts files to PDF/As.
 *
 *	@package Transformist.Converter.Office
 *	@author Félix Girault <felix@vtech.fr>
 */

class Transformist_Converter_Office_Pdfa extends Transformist_Converter_Office {

	/**
	 *	Output format.
	 *
	 *	@var string
	 */

	protected $_format = 'pdf';



	/**
	 *	Command arguments to be merged with the default ones.
	 *
	 *	@var array
	 */

	protected $_arguments = array( '-e' => 'SelectPdfVersion=1' );



	/**
	 *	Returns the type of files that the converter accepts.
	 *
	 *	@return array Types.
	 */

	public static function inputTypes( ) {

		return array(
			'application/msword',
			'application/pdf'
		);
	}



	/**
	 *	Returns the type of files that the converter produces.
	 *
	 *	@return string Type.
	 */

	public static function outputType( ) {

		return 'application/pdfa';
	}
}
