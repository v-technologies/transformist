<?php

/**
 *	@author Félix Girault <felix@vtech.fr>
 */

class Transformist_Converter_Fake_Xml extends Transformist_Converter_Fake {

	/**
	 *
	 */

	public static function conversions( ) {

		return array( 'text/html' => 'application/xml' );
	}
}
