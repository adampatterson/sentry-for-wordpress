<?php

namespace SentryWordPress;

class Actions {

	public function __construct() {
	}

	public static function activationHook() {
//		self::debugFile( 'Enabled' );
	}

	public static function deactivationHook() {
//		self::debugFile( 'Disabled' );
	}

	public static function uninstallHook() {
//		self::debugFile( "Un-installed" );
	}

	public static function debugFile( $value ) {
		$myfile = fopen( "newfile.txt", "w" ) or die( "Unable to open file!" );
		$txt = $value . "\n";
		fwrite( $myfile, $txt );
		fclose( $myfile );
	}
}
