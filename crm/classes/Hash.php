<?php
class Hash {

	public static function generateHash( $string, $salt = "" ) {
		return hash( "sha512", $string . $salt );
	}
	public static function generateSalt( $length = 64 ) {
		return mcrypt_create_iv( $length );
	}
	public static function generateUID() {
		return self::generateHash( uniqid() );
	}
}