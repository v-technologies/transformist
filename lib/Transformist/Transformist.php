<?php

/**
 *	A high level API to handle file conversions.
 *
 *	@package Transformist
 *	@author Félix Girault <felix@vtech.fr>
 */

class Transformist_Transformist {

	/**
	 *	Contents of the source document.
	 *
	 *	@var string
	 */

	protected $_document = '';



	/**
	 *	Mime type of the source document.
	 *
	 *	@var string
	 */

	protected $_sourceMimeType = '';



	/**
	 *	Constructs a Transformist given a source document and its mime type.
	 *	If no mime type is provided, the Transformist will try to determine it
	 *	by itself. If an error occurs during mime type detection, an exception
	 *	will be raised.
	 *
	 *	@param string $document Contents of the source document.
	 *	@param string $mimeType Mime type of the source document.
	 *	@throws Transformist_Exception
	 */

	public function __construct( $document, $mimeType = '' ) {

		$this->_document = $document;
		$this->_sourceMimeType = $mimeType;

		if ( $this->_sourceMimeType === '' ) {
			$this->_detectMimeType( );
		}
	}



	/**
	 *	Attempts to detect the mime type of the document passed to the constructor.
	 *
	 *	@throws Transformist_Exception
	 */

	protected function _detectMimeType( ) {

		if ( !class_exists( 'finfo' )) {
			throw new Transformist_Exception(
				'Unable to detect mime type. Auto detection requires the FileInfo extension.'
			);
		}

		$FileInfo = new finfo( FILEINFO_MIME );
		$mimeType = $FileInfo->buffer( $this->_document );

		if ( $mimeType === false ) {
			throw new Transformist_Exception( 'Unable to detect mime type.' );
		}

		$this->_sourceMimeType = $mimeType;
	}



	/**
	 *	Converts the document to a format matching the given mime type.
	 *
	 *	@param string $mimeType The mime type the document will match.
	 *	@return mixed The content of the converted document, or false if the
	 *		document could not be converted.
	 */

	public function to( $mimeType ) {

		$Converter = Transformist_ConverterFactory::load( $this->_sourceMimeType, $mimeType );

		if ( $Converter === null ) {
			return false;
		}

		return $Converter->convert( $this->_document );
	}



	/**
	 *	Converts the given document from $sourceMimeType to $targetMimeType.
	 *
	 *	@param string $document Contents of the source document.
	 *	@param string $sourceMimeType Mime type of the source document.
	 *	@param string $targetMimeType The mime type the document will match.
	 *	@return mixed The content of the converted document, or false if the
	 *		document could not be converted.
	 */

	public static function convert( $document, $sourceMimeType, $targetMimeType ) {

		$_this = new Transformist_Transformist( $document, $sourceMimeType );

		return $_this->to( $targetMimeType );
	}
}
