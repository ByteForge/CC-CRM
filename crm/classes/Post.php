<?php
class Post {
	private static $__exists = false;

	public static function __static_initializer() {
		self::$__exists = !empty( $_POST ) ? true : false;		
	}
	public static function exists() {
		return self::$__exists;
	}

	public static function itemExists( $item ) {
		if( self::$__exists && isset( $_POST[$item] ) ) {
			return true;
		}
		return false;
	}
	public static function getItem( $item ) {
		if( self::itemExists($item) ) {
			return $_POST[$item];
		}
		return "";
	}
}
Post::__static_initializer();