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
			? rtrim( $path, DS )
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
	 *	@param string $packages Sub packages in which to search for, relatively
	 *		to the base package path.
	 *	@param boolean $recursive Whether or not to search recursively.
	 *	@return array An array of directory and/or file paths.
	 */

	public function classes( $packages = array( ), $recursive = false ) {

		$classes = array( );
		$searchPath = empty( $packages )
			? $this->_path
			: $this->_path . DS . $this->_makePath( $packages, DS );

		$entries = scandir( $searchPath );

		if ( is_array( $entries )) {
			foreach ( $entries as $entry ) {
				$path = $searchPath . DS . $entry;
				$parts = $packages;
				$parts[] = basename( $entry, '.php' );

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

	protected function _makePath( $parts, $separator ) {

		if ( empty( $parts )) {
			return '';
		}

		return implode( $separator, $parts );
	}
}
