<?php
class Role {
	const ADMINISTRATOR = 1;	
	const WORKER = 2;
	const CLIENT = 3;

	public static function getRoleName( $role ) {
		switch( $role ) {
			case self::ADMINISTRATOR: return "Administrator"; break;
			case self::WORKER return "Worker"; break;
			case self::CLIENT return "Client"; break;

			default: return "Unknown Role"; break;
		}
	}
}