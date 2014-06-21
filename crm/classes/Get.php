<?php
class Get {
	private static $__exists = false;

	public static function __static_initializer() {
		self::$__exists = !empty( $_GET ) ? true : false;		
	}
	public static function exists() {
		return self::$__exists;
	}

	public static function itemExists( $item ) {
		if( self::$__exists && isset( $_GET[$item] ) ) {
			return true;
		}
		return false;
	}
	public static function getItem( $item ) {
		if( self::$__exists ) {
			return $_GET[$item];
		}
		return "";
	}
}
Get::__static_initializer();