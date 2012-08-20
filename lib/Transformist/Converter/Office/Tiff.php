<?php

/**
 *	Converts JPGs to TIFFs.
 *
 *	@package Transformist.Converter.Office
 *	@author Félix Girault <felix@vtech.fr>
 */

class Transformist_Converter_Office_Tiff extends Transformist_Converter_Office {

	/**
	 *	Accepted input types.
	 *
	 *	@var array
	 */

	protected $_inputTypes = array( 'image/png', 'image/jpeg' );



	/**
	 *	Supported output type.
	 *
	 *	@var string
	 */

	protected $_outputType = 'image/tiff';



	/**
	 *	Name of the printer to be used for conversion.
	 *
	 *	@var string
	 */

	protected $_printer = 'draw_tif_Export';

}
