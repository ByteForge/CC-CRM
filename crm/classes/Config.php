<?php
class Config {
	private static		
		// DATABASE
		$__databaseHost		= "wi-projectdb.technikum-wien.at",
		$__databaseUser  	= "ws13-bdl1-fst-3",
		$__databasePassword	= "DbPass4BDL1-3",
		$__databaseName		= "ws13-bdl1-fst-3",

		// SESSION
		$__sessionName 		= "___UID", // change the default PHPSESSID
		$__sessionUser		= "ID", // in $_SESSION["ID"] - user ID
		$__sessionToken 	= "token", // in $_SESSION["token"]

		// COOKIE
		$__cookieName		= "___hash",
		$__cookieExpiration	= 604800, // 1 week

		// DEVELOPMENT
		$__development = true,
		$__showTraces = true;

	// DATABASE
	public static function getDatabaseHost() {
		return self::$__databaseHost;
	}
	public static function getDatabaseUser() {
		return self::$__databaseUser;
	}
	public static function getDatabasePassword() {
		return self::$__databasePassword;
	}
	public static function getDatabaseName() {
		return self::$__databaseName;
	}

	// SESSION
	public static function getSessionName() {
		return self::$__sessionName;
	}
	public static function getSessionUser() {
		return self::$__sessionUser;
	}
	public static function getSessionToken() {
		return self::$__sessionToken;
	}

	// COOKIE
	public static function getCookieName() {
		return self::$__cookieName;
	}
	public static function getCookieExpiration() {
		return self::$__cookieExpiration;
	}

	// DEVELOPMENT
	public static function getDevelopment() {
		return self::$__development;
	}
	public static function getShowTraces() {
		return self::$__showTraces;
	}
}
