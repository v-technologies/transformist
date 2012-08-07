<?php

/**
 *	An extended version of the SplFileInfo class.
 *
 *	@package Transformist
 *	@author Félix Girault <felix@vtech.fr>
 */

class Transformist_FileInfo extends SplFileInfo {

	/**
	 *	Mime type of the file.
	 *
	 *	@var string
	 */

	protected $_mime = '';



	/**
	 *	Constructs a new FileInfo object.
	 *
	 *	@param string $fileName Path to the file.
	 *	@param string $mimeType Mime type of the file to avoid auto detection.
	 */

	public function __construct( $fileName, $mimeType = '' ) {

		parent::__construct( $fileName );

		$this->_mime = $mimeType;
	}



	/**
	 *	Returns the base name of the file, directory, or link without path
	 *	info or extension.
	 *
	 *	@return string File name.
	 */

	public function getName( ) {

		return $this->getBasename( '.' . $this->getExtension( ));
	}



	/**
	 *	Returns the mime type of the file.
	 *
	 *	@return $mimeType
	 *	@throws Transformist_Exception
	 */

	public function getMimeType( ) {

		if ( $this->_mime === '' ) {
			$this->_detectMimeType( );
		}

		return $this->_mime;
	}



	/**
	 *	Attempts to detect the mime type of the file.
	 *
	 *	@throws Transformist_Exception
	 */

	protected function _detectMimeType( ) {

		if ( !class_exists( 'finfo' )) {
			throw new Transformist_Exception(
				'Unable to detect mime type. Auto detection requires the FileInfo extension.'
			);
		}

		$info = new finfo( FILEINFO_MIME );
		$mime = $info->file( $this->getRealPath( ));

		if ( $mime === false ) {
			throw new Transformist_Exception( 'Unable to detect mime type.' );
		}

		// finfo can return mime types in the form 'application/msword; charset=binary'.
		// In this case, we keep the only part that matters to us: 'application/msword'.

		$semicolon = strpos( $mime, ';' );

		if ( $semicolon !== false ) {
			$mime = array_shift( explode( ';', $mime ));
		}

		$this->_mime = $mime;
	}
}
