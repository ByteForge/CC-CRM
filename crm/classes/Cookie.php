<?php
class Cookie {

	public static function exists( $name ) {
		return ( isset( $_COOKIE[ $name ] ) ) ? true : false;
	}

	public static function get( $name ) {
		if( self::exists( $name ) ) {
			return $_COOKIE[ $name ];
		}
		return "";
	}

	public static function set( $name, $value, $expiration ) {
		if( setcookie( $name, $value, time() + $expiration, '/' ) ) {
			return true;
		}
		return false;
	}

	public static function delete( $name ) {
		self::set( $name, '', time()-1 );
	}
}