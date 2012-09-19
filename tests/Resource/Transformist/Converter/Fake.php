<?php

/**
 *	@author Félix Girault <felix@vtech.fr>
 */

abstract class Transformist_Converter_Fake extends Transformist_Converter {

	/**
	 *
	 */

	public function convert( Transformist_Document $Document ) {

		file_put_contents(
			$Document->output( )->path( ),
			file_get_contents( $Document->input( )->path( ))
		);
	}
}
