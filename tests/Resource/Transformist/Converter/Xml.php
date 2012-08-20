<?php

/**
 *	@author Félix Girault <felix@vtech.fr>
 */

abstract class Transformist_Converter_Xml extends Transformist_Converter {

	/**
	 *
	 */

	protected $_inputTypes = array( 'image/svg+xml', 'text/html' );



	/**
	 *
	 */

	protected $_outputType = 'application/xml';

}
