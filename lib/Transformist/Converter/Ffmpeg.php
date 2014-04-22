<?php

/**
 *	Converts documents using ImageMagick.
 *
 *	@package Transformist.Converter
 *	@author Félix Girault <felix@vtech.fr>
 */

class Transformist_Converter_Ffmpeg extends Transformist_Converter {

	/**
	 *	Tests if the ffmpeg command is available on the system.
	 *
	 *	@return boolean|sting True if the command exists, otherwise an error message.
	 */

	public static function isRunnable( ) {

		$ffmpeg = new Transformist_Command( 'ffmpeg' );

		return $ffmpeg->exists( )
			? true
			: 'The ffmpeg command is not available.';
	}



	/**
	 *	Returns an array of conversions the converter can handle.
	 *
	 *	array( 'input/type' => 'output/type' )
	 *	array( 'input/type' => array( 'output/type1', 'output/type2' ))
	 *
	 *	@return array Array of supported types.
	 */

	public static function conversions( ) {

		return array(
			'video/mp4' => array(
				'video/x-flv',
			),
			'video/x-msvideo' => array(
				'video/x-flv',
			),
			'video/quicktime' => array(
				'video/x-flv',
			),
			'video/x-ms-wmv' => array(
				'video/x-flv',
			)
		);
	}



	/**
	 *	Converts the given document.
	 *
	 *	@param Transformist_Document $Document Document to convert.
	 */

	public function convert( Transformist_Document $Document ) {

		$input = $Document->input()->path();
		$output = $Document->output()->path();

		$ffmpeg = new Transformist_Command( 'ffmpeg' );
		$params = array(
			'-i' => $input,
			'-ar' => 44100,
			'-ab' => '64k',
			'-b' => 25,
			'-s' => '1280x1024',
			$output
		);
		$ffmpeg->execute( $params );
	}
}
