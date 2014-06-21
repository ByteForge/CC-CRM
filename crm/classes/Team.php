<?php
class Team {
		
	const MEMBER = 0;
	const LEADER = 1;
	
	public static function getAvailableTeamID() {
		Database::query( "SELECT `teamID` FROM `teams` ORDER BY `teamID` DESC LIMIT 1;" );
		$result = Database::getFirst();
		if( $result ) {
			return $result->teamID+1;
		}
		return 1;
	}	
	public static function createTeam( $leader, $members = null ) {
		
		$teamID = self::getAvailableTeamID();
		$values = "({$teamID}, {$leader}, ".self::LEADER.")";
				
		if( is_array($members) ) {
			$L=count($members);
			if( $L > 0 ) {
				$values .= ",";
			}
						
			for( $i=0, $B=$L-1; $i<$L; ++$i ) {
				$member = $members[$i];
				$values .= "({$teamID}, {$member}, ".self::MEMBER.")";
				if( $i<$B ) {
					$values .= ",";
				}				
			}
		}		
		itrace( 3, $values );		
		Database::query( "INSERT INTO `teams` (`teamID`, `userID`, `type`) VALUES {$values};" );
	}	
	public static function changeTeam() {}
	
	public static function deleteTeam( $teamID ) {
		// delete team and delete every projects, tasks, messages related to the team
	}
		
	public static function addMember( $teamID, $userID ) {
		
	}
	
	public static function numMembers( $teamID ) {
		
		Database::query( "SELECT COUNT(*) AS `count` FROM `teams` WHERE `teamID` = {$teamID};" );
		if( !Database::getError() ) {				
			$r = Database::getFirst();
			return $r->count;
		}				
		return 0;
	}
}