<?php

/**
 *	@author Félix Girault <felix@vtech.fr>
 */

abstract class Transformist_Converter_Xml_XmlBar
	extends Transformist_Converter_Xml {

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
