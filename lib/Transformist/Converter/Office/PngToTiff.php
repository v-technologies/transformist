<?php

/**
 *	Converts PNGs to TIFFs.
 *
 *	@package Transformist.Converter.Office
 *	@author Félix Girault <felix@vtech.fr>
 */

class Transformist_Converter_Office_PngToTiff extends Transformist_Converter_Office {

	/**
	 *	Accepted input type.
	 *
	 *	@var string
	 */

	protected $_inputType = 'image/png';



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

	protected $_printer = 'impress_tif_Export';

}
