<?php

/**
 *	The base class for a Converter.
 *
 *	@package Transformist
 *	@author Félix Girault <felix@vtech.fr>
 */

abstract class Transformist_Converter {

	/**
	 *	Checks if the Converter can convert the given document.
	 *
	 *	@param Transformist_Document $Document Document to convert.
	 *	@return boolean Whether or not the Converter can convert the document.
	 */

	public static function canConvert( $Document ) {

		return false;
	}



	/**
	 *	Tests different things before and after actually converting the file.
	 *
	 *	@param Transformist_Document $Document Document to convert.
	 *	@throws Transformist_Exception
	 */

	public final function convert( $Document ) {

		if ( !static::canConvert( $Document )) {
			return;
		}

		if ( !$Document->input( )->isReadable( )) {
			throw new Transformist_Exception(
				'The file `%s` is not readable.',
				$Document->input( )->getRealPath( )
			);
		}

		$OutputDir = $Document->output( )->getPathInfo( );

		if ( !$OutputDir->isWritable( )) {
			throw new Transformist_Exception(
				'The directory `%s` is not writable.',
				$OutputDir->getRealPath( )
			);
		}

		$this->_convert( $Document );
	}



	/**
	 *	Converts the given document.
	 *
	 *	@param Transformist_Document $Document Document to convert.
	 */

	abstract public function _convert( $Document );

}
