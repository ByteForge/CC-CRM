<?php
class Group {
	const EMPLOYER = 1;
	const EMPLOYEE = 2;
	const CUSTOMER = 3;
	const FOREIGN = 4;

	public static function getGroupName( $group ) {
		switch( $group ) {
			case self::EMPLOYER return "Employer"; break;
			case self::EMPLOYEE return "Employee"; break;
			case self::CUSTOMER return "Customer"; break;
			case self::FOREIGN return "Foreign"; break;
						
			default: return "Unknown Group"; break;
		}
	}
}