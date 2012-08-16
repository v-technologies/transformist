<?php

/**
 *	@author Félix Girault <felix@vtech.fr>
 */

class Transformist_Converter_HtmlToXml_HtmlToXmlFoo
	extends Transformist_Converter_HtmlToXml {

	/**
	 *
	 */

	protected function _convert( $Document ) {

		file_put_contents(
			$Document->output( )->path( ),
			file_get_contents( $Document->input( )->path( ))
		);
	}
}
