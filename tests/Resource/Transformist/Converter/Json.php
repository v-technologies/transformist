<?php

/**
 *	@author Félix Girault <felix@vtech.fr>
 */

class Transformist_Converter_Json extends Transformist_Converter {

	/**
	 *
	 */

	protected $_inputTypes = array( 'application/xml' );



	/**
	 *
	 */

	protected $_outputType = 'application/json';



	/**
	 *
	 */

	public function convert( $Document ) {

		file_put_contents(
			$Document->output( )->path( ),
			file_get_contents( $Document->input( )->path( ))
		);
	}
}
