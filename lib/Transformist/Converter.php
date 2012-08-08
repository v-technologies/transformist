<?php

/**
 *	The base class for a Converter.
 *
 *	@package Transformist
 *	@author Félix Girault <felix@vtech.fr>
 */

abstract class Transformist_Converter {

	/**
	 *	@var array
	 */

	protected $_conversions = array( );



	/**
	 *	Checks if the Converter can convert the given document.
	 *
	 *	@param Transformist_Document $Document Document to convert.
	 *	@return boolean Whether or not the Converter can convert the document.
	 */

	public function canConvert( $Document ) {

		$inputType = $Document->input( )->type( );

		if ( !isset( $this->_conversions[ $inputType ])) {
			return false;
		}

		return in_array(
			$Document->output( )->type( ),
			$this->_conversions[ $inputType ]
		);
	}



	/**
	 *	Returns every conversion that can be done by the converter.
	 *
	 *	@return array MIME types.
	 */

	public function availableConversions( ) {

		return $this->_conversions;
	}



	/**
	 *	Tests different things before and after actually converting the file.
	 *
	 *	@param Transformist_Document $Document Document to convert.
	 *	@throws Transformist_Exception
	 */

	public final function convert( $Document ) {
		/*
		if ( !static::canConvert( $Document )) {
			return;
		}
		*/
		if ( !$Document->input( )->isReadable( )) {
			throw new Transformist_Exception(
				'The file `%s` is not readable.',
				$Document->input( )->path( )
			);
		}

		if ( !$Document->output( )->isDirWritable( )) {
			throw new Transformist_Exception(
				'The directory `%s` is not writable.',
				$Document->output( )->dirPath( )
			);
		}

		$this->_convert( $Document );
	}



	/**
	 *	Converts the given document.
	 *
	 *	@param Transformist_Document $Document Document to convert.
	 */

	abstract protected function _convert( $Document );

}
