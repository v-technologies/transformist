<?php

/**
 *	Converts DOCs to PDFs.
 *
 *	@package Transformist.Converter.Office
 *	@author Félix Girault <felix@vtech.fr>
 */

class Transformist_Converter_Office_DocToPdf extends Transformist_Converter_Office {

	/**
	 *	Accepted input type.
	 *
	 *	@var string
	 */

	protected $_inputType = 'application/msword';



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
