<?php
class Overview {
	
	public static function getNumAllProjects( $userID ) {
		return Project::numProjects( $userID );
	}
	public static function getNumOngoingProjects( $userID ) {
		return Project::numProjects( $userID, Status::IN_PROGRESS );
	}
	public static function getNumCompletedProjects( $userID ) {
		return Project::numProjects( $userID, Status::COMPLETED );
	}
	public static function getNumCancelledProjects( $userID ) {
		return Project::numProjects( $userID, Status::CANCELED );
	}
	public static function getNumArchivedProjects( $userID ) {
		return Project::numProjects( $userID, Status::ARCHIVED );
	}
	
	public static function echoProjects($userID) {
		
		$all = self::getNumAllProjects($userID);
		$ongoing = self::getNumOngoingProjects($userID);
		$completed = self::getNumCompletedProjects($userID);
		$canceled = self::getNumCancelledProjects($userID);
		$archived = self::getNumArchivedProjects($userID);
		
		echo "'{ \"all\": {$all}, \"ongoing\": {$ongoing}, \"completed\": {$completed}, \"canceled\": {$canceled}, \"archived\": {$archived} }'";
	}
	
	public static function getNumAllTasks( $userID ) {
		return Task::numTasks( $userID );
	}
	public static function getNumOngoingTasks( $userID ) {
		return Task::numTasks( $userID, Status::IN_PROGRESS );
	}
	public static function getNumCompletedTasks( $userID ) {
		return Task::numTasks( $userID, Status::COMPLETED );
	}
	public static function getNumCancelledTasks( $userID ) {
		return Task::numTasks( $userID, Status::CANCELED );
	}
	public static function getNumArchivedTasks( $userID ) {
		return Task::numTasks( $userID, Status::ARCHIVED );
	}	
	public static function echoTasks($userID) {
			
		$all = self::getNumAllTasks($userID);
		$ongoing = self::getNumOngoingTasks($userID);
		$completed = self::getNumCompletedTasks($userID);
		$canceled = self::getNumCancelledTasks($userID);
		$archived = self::getNumArchivedTasks($userID);
		
		echo "'{"
			.'"all":'.$all.','
			.'"ongoing":'.$ongoing.','
			.'"completed":'.$completed.','
			.'"canceled":'.$canceled.','
			.'"archived":'.$archived					
		."}'";
	}
	public static function echoActivities($userID) {
		
	}
	public static function echoMessages($userID) {
		
	}	
	public static function echoAll( $userID ) {
		self::echoProjects($userID);
		echo ", ";
		self::echoTasks($userID);
	}
}