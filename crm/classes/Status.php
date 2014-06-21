<?php
class Status {

	const ONGOING			= 1;
	const CANCELED			= 2;
	const COMPLETED			= 3;
	const ARCHIVED			= 4;

	public static function getStatusName( $status ) {
		switch( $status ) {
			//case self::NOT_SPECIFIED: return "Not Specified"; break;
			case self::ONGOING: return "Ongoing"; break;
			case self::CANCELED: return "Canceled"; break;
			//case self::IN_PROGRESS: return "In Progress"; break;
			//case self::NEEDS_ATTENTION: return "Needs Attention"; break;
			case self::COMPLETED: return "Completed"; break;
			case self::ARCHIVED: return "Archived"; break;
			
			default: return "Unknown Status"; break;
		}
	}
}