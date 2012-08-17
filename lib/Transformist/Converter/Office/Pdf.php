<?php

/**
 *	Converts files to PDFs.
 *
 *	@package Transformist.Converter.Office
 *	@author Félix Girault <felix@vtech.fr>
 */

class Transformist_Converter_Office_Pdf extends Transformist_Converter_Office {

	/**
	 *	Accepted input types.
	 *
	 *	@var array
	 */

	protected $_inputTypes = array( 'application/msword' );



	/**
	 *	Supported output type.
	 *
	 *	@var string
	 */

	protected $_outputType = 'application/pdf';



	/**
	 *	Name of the printer to be used for conversion.
	 *
	 *	@var string
	 */

	protected $_printer = 'writer_pdf_Export';

}
