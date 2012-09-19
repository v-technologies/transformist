<?php

/**
 *	@author Félix Girault <felix@vtech.fr>
 */

class Transformist_Converter_Fake_Json extends Transformist_Converter_Fake {

	/**
	 *
	 */

	public static function conversions( ) {

		return array( 'application/xml' => 'application/json' );
	}
}
