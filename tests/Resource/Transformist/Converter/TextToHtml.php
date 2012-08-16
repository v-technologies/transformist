<?php

/**
 *	@author Félix Girault <felix@vtech.fr>
 */

class Transformist_Converter_TextToHtml extends Transformist_Converter {

	/**
	 *
	 */

	protected $_inputType = 'text/plain';



	/**
	 *
	 */

	protected $_outputType = 'text/html';



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
