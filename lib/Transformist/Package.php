<?php

/**
 *	Represents a package.
 *
 *	@package Transformist
 *	@author Félix Girault <felix@vtech.fr>
 */

class Transformist_Package {

	/**
	 *	Internal directory representation.
	 *
	 *	@var SplFileInfo
	 */

	protected $_path = null;



	/**
	 *
	 */

	protected $_separator = '_';



	/**
	 *	Constructs a document given its input and output file infos.
	 *
	 *	@param Transformist_FileInfo $Input Input file info.
	 *	@param Transformist_FileInfo $Output Output file info.
	 */

	public function __construct( $path ) {

		$this->_path = is_dir( $path )
			? $path
			: dirname( $path );
	}



	/**
	 *	Returns the absolute path to the directory.
	 *
	 *	@return string Path.
	 */

	public function path( ) {

		return $this->_Info->getRealPath( );
	}



	/**
	 *	Scans the directory and returns the entries it contains.
	 *	Note: This method doesn't deal with symlinks.
	 *
	 *	@param
	 *	@param boolean $recursive Whether or not to search recursively.
	 *	@return array An array of directory and/or file paths.
	 */

	public function classes( $packages = array( ), $recursive = false ) {

		$classes = array( );
		$searchPath = empty( $packages )
			? $this->_path
			: $this->_path . DIRECTORY_SEPARATOR . $this->_makePath( $packages );

		$entries = scandir( $searchPath );

		if ( is_array( $entries )) {
			foreach ( $entries as $entry ) {
				$path = $this->_path . DIRECTORY_SEPARATOR . $entry;
				$parts = $packages;
				$parts[] = $entry;

				if (
					$recursive
					&& is_dir( $path )
					&& ( $entry != '.' ) && ( $entry != '..' )
				) {
					$classes = array_merge( $classes, $this->classes( $parts, $recursive ));
				}

				if ( is_file( $path )) {
					$classes[] = $this->_makePath( $parts, $this->_separator );
				}
			}
		}

		return $classes;
	}



	/**
	 *	Joins the given parts with a separator.
	 *
	 *	@param array $parts An array of strings to join.
	 *	@param string $separator The path separator.
	 *	@return string Path.
	 */

	protected function _makePath( $parts, $separator = DIRECTORY_SEPARATOR ) {

		if ( empty( $parts )) {
			return '';
		}

		return implode( $separator, $parts );
	}
}
