<?php

/**
 *	Converts JPGs to PNGs.
 *
 *	@package Transformist.Converter.Office
 *	@author Félix Girault <felix@vtech.fr>
 */

class Transformist_Converter_Office_JpgToPng extends Transformist_Converter_Office {

	/**
	 *	Accepted input type.
	 *
	 *	@var string
	 */

	protected $_inputType = 'image/jpeg';



	/**
	 *	Supported output type.
	 *
	 *	@var string
	 */

	protected $_outputType = 'image/png';



	/**
	 *	Name of the printer to be used for conversion.
	 *
	 *	@var string
	 */

	protected $_printer = 'draw_png_Export';

}
