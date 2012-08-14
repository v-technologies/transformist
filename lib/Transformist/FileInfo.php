<?php

/**
 *	Wraps some functionnalities of SplFileInfo, and adds some pretty useful stuff.
 *
 *	@package Transformist
 *	@author Félix Girault <felix@vtech.fr>
 */

class Transformist_FileInfo {

	/**
	 *	Internal file representation.
	 *
	 *	@var SplFileInfo
	 */

	protected $_Info = null;



	/**
	 *	MIME type of the file.
	 *
	 *	@var string
	 */

	protected $_type = '';



	/**
	 *	Constructs a new FileInfo object.
	 *
	 *	@param string $fileName Path to the file.
	 *	@param string $type MIME type of the file to avoid auto detection.
	 */

	public function __construct( $fileName, $type = '' ) {

		$this->_Info = new SplFileInfo( $fileName );
		$this->_type = $type;
	}



	/**
	 *	Returns if the file exists.
	 *
	 *	@return boolean True if the file exists, otherwise false.
	 */

	public function exists( ) {

		return $this->_Info->isFile( );
	}



	/**
	 *	Returns the base name of the file, directory, or link without path
	 *	info or extension.
	 *
	 *	@return string File name.
	 */

	public function baseName( ) {

		return $this->_Info->getBasename( '.' . $this->extension( ));
	}



	/**
	 *	Returns the file extension.
	 *
	 *	@return string Extension.
	 */

	public function extension( ) {

		return $this->_Info->getExtension( );
	}



	/**
	 *	Returns if the file is readable.
	 *
	 *	@return boolean True if the file is readable, otherwise false.
	 */

	public function isReadable( ) {

		return $this->_Info->isReadable( );
	}



	/**
	 *	Returns if the file is writable.
	 *
	 *	@return boolean True if the file is writable, otherwise false.
	 */

	public function isWritable( ) {

		return $this->_Info->isWritable( );
	}



	/**
	 *	Returns if the directory containing the file is readable.
	 *
	 *	@return boolean True if the directory is readable, otherwise false.
	 */

	public function isDirReadable( ) {

		return $this->_Info->getPathInfo( )->isReadable( );
	}



	/**
	 *	Returns if the directory containing the file is writable.
	 *
	 *	@return boolean True if the directory is writable, otherwise false.
	 */

	public function isDirWritable( ) {

		return $this->_Info->getPathInfo( )->isWritable( );
	}



	/**
	 *	Returns the absolute path to the file.
	 *
	 *	@return string Path.
	 */

	public function path( ) {

		return $this->_Info->getPath( )
			. DIRECTORY_SEPARATOR . $this->_Info->getFilename( );
	}



	/**
	 *	Returns the absolute path to the directory containing the file.
	 *
	 *	@return string Path.
	 */

	public function dirPath( ) {

		$PathInfo = $this->_Info->getPathInfo( );

		return $PathInfo->getPath( )
			. DIRECTORY_SEPARATOR . $PathInfo->getBasename( );
	}



	/**
	 *	Returns the internal SplFileInfo object.
	 *
	 *	@return SplFileInfo Internal file info.
	 */

	public function splFileInfo( ) {

		return $this->_Info;
	}



	/**
	 *	Returns the MIME type of the file.
	 *
	 *	@return string MIME type.
	 *	@throws Transformist_Exception
	 */

	public function type( ) {

		if ( $this->_type === '' ) {
			$this->_detectType( );
		}

		return $this->_type;
	}



	/**
	 *	Attempts to detect the MIME type of the file.
	 *
	 *	@throws Transformist_Exception
	 */

	protected function _detectType( ) {

		if ( !class_exists( 'finfo' )) {
			throw new Transformist_Exception(
				'Unable to detect MIME type. Auto detection requires the FileInfo extension.'
			);
		}

		$info = new finfo( FILEINFO_MIME );
		$type = @$info->file( $this->path( ));

		if ( $type === false ) {
			throw new Transformist_Exception( 'Unable to detect MIME type.' );
		}

		// finfo can return MIME types in the form 'application/msword; charset=binary'.
		// In this case, we keep the only part that matters to us: 'application/msword'.

		$semicolon = strpos( $type, ';' );

		if ( $semicolon !== false ) {
			$type = array_shift( explode( ';', $type ));
		}

		$this->_type = $type;
	}
}
