<?php

/**
 *	@author Félix Girault <felix@vtech.fr>
 */

class Transformist_Converter_Fake_Html extends Transformist_Converter_Fake {

	/**
	 *
	 */

	public static function conversions( ) {

		return array( 'text/plain' => 'text/html' );
	}
}
