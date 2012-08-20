<?php

/**
 *	Converts files to PNGs.
 *
 *	@package Transformist.Converter.Office
 *	@author Félix Girault <felix@vtech.fr>
 */

class Transformist_Converter_Office_Png extends Transformist_Converter_Office {

	/**
	 *	Accepted input types.
	 *
	 *	@var array
	 */

	protected $_inputTypes = array( 'image/gif', 'image/jpeg' );



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
