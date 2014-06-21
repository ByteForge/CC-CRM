<?php
class Priority {

	const ZERO = 1;
	const LOW = 2;
	const NORMAL = 3;
	const HIGH = 4;
	const SUPER = 5;

	public static function getPriorityName( $priority ) {
		switch( $priority ) {
			case self::ZERO: return "Zero"; break;
			case self::LOW: return "Low"; break;
			case self::NORMAL: return "Normal"; break;
			case self::HIGH: return "High"; break;
			case self::SUPER: return "Super"; break;
			
			default: return "Unknown Priority"; break;
		}
	}
}