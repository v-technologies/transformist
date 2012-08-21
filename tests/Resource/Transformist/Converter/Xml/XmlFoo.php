<?php

/**
 *	@author Félix Girault <felix@vtech.fr>
 */

class Transformist_Converter_Xml_XmlFoo
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
