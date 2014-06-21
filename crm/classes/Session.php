<?php
class Session {

	public static function start( $name = null ) {		
		if( $name === null ) {
			$name = Config::getSessionName();
		}
		ini_set( 'session.cookie_httponly', 1 );
		session_name( $name );
		session_start( $name );		
	}
	public static function regenerate() {
		session_regenerate_id( true );
	}
	
	public static function exists() {
		return isset( $_SESSION );
	}
	public static function delete() {
		session_unset();
		session_destroy();
	}

	public static function itemExists( $item ) {
		return ( self::exists() && isset( $_SESSION[$item] ) );
	}
	public static function getItem( $item ) {
		if( self::itemExists( $item ) ) {
			return $_SESSION[$item];
		}
		return "";
	}
	public static function setItem( $item, $value ) {
		if( self::exists() ) {
			$_SESSION[$item] = $value;
		}
	}
	public static function deleteItem( $item ) {
		if( self::exists() ) {
			unset( $_SESSION[$item] );
		}
	}

	public static function userExists() {
		return self::exists() && self::itemExists( Config::getSessionUser() ) ? true : false;
	}

	public static function getUser() {
		if( self::userExists() ) {
			return self::getItem( Config::getSessionUser() );
		}
		return "";
	}
	public static function setUser( $value ) {
		self::setItem( Config::getSessionUser(), $value );
	}
}