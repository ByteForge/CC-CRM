<?php
class Activity {
	
	// SIGNIN IN/OUT
	const SIGN_IN_WITH_INPUT = 			1;
	const SIGN_IN_WITH_REMEMBER_HASH = 	2;
	const SIGNED_IN_SUCCESSFULLY = 		3;
	const SIGNED_IN_UNSUCCESSFULLY = 	4;
	const SIGNED_OUT = 					5;
	
	// TEAMS
	// PROJECTS
	// TASKS
	// MESSAGES
	
	public static function commit( $values ) {
		//Database::query( "INSERT INTO `activities` (`userID`,`type`,`date`,`baseData`,`changedData`);" );
		
		if( is_array($values) ) {
			$userID = User::NONE;
			if( array_key_exists("userID", $values) ) {
				$userID = $values["userID"];
			}
			$type = $values["type"];			
			$date = date("Y-m-d H:i:s");
			$baseData = "";
			$changedData = "";			
			if( array_key_exists("data", $values) ) {
				$baseData = $values["data"];
			}
			
			Database::query( "INSERT INTO `activities` (`userID`,`type`,`date`,`baseData`,`changedData`) VALUES ({$userID}, {$type}, '{$date}', '{$baseData}', '{$changedData}');" );
		}
	}
}