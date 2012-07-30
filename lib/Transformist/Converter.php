<?php

/**
 *	A high level API to handle file conversions.
 *
 *	@package Transformist
 *	@author Félix Girault <felix@vtech.fr>
 */

class Transformist_Converter {

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
	 *	Constructs a Converter given a source document and its mime type.
	 *	If no mime type is provided, the Converter will try to determine it by
	 *	itself.
	 *
	 *	@param string $document Contents of the source document.
	 *	@param string $mimeType Mime type of the source document.
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
	 */

	protected function _detectMimeType( ) {

		$FileInfo = new finfo( FILEINFO_MIME );
		$mimeType = $FileInfo->buffer( $this->_document );

		if ( $mimeType !== false ) {
			$this->_sourceMimeType = $mimeType;
		}
	}



	/**
	 *	Converts the document to a format matching the given mime type.
	 *
	 *	@param string $mimeType The mime type the document will match.
	 *	@return mixed The content of the converted document, or false if the
	 *		document could not be converted.
	 */

	public function to( $mimeType ) {

		$Strategy = Transformist_StrategyFactory::load( $this->_sourceMimeType, $mimeType );

		if ( $Strategy === null ) {
			return false;
		}

		return $Strategy->convert( $this->_document );
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

		$_this = new Transformist_Converter( $document, $sourceMimeType );

		return $_this->to( $targetMimeType );
	}
}
