<?php
class Task {

	const NORMAL = 1; // "normal" task (a task within a project)
	const ISOLATED = 2; // a task without project
	const DEFAULT_POSITION = 99999;
	
	public static function getUniqueName() {
		return "Task ".rand(151, 999999);
	}
	public static function getNextPosition( $projectID ) {
		Database::query("SELECT `position` FROM `tasks` WHERE `projectID` = {$projectID} ORDER BY `position` DESC LIMIT 1");		
		if( !Database::getError() && Database::getCount() ) {
			$position = Database::getFirst()->position;
			return $position+100;
		}
		return self::DEFAULT_POSITION;
	}
	public static function getTaskByID( $taskID ) {
		Database::query( "SELECT * FROM `tasks` WHERE `taskID` = '{$taskID}' LIMIT 1;" );
		if( !Database::getError() ) {				
			$r = Database::getFirst();
			$task = new Task( $r );			
			return $task;			
		}
		return false;
	}
	public static function createTask( $values ) {
		if( is_array($values) ) {			
			$projectID = ( array_key_exists("projectID", $values) ) ? $values["projectID"] : Project::NONE;
			$type = ( array_key_exists("type", $values) ) ? $values["type"] : self::NORMAL;
			$position = ( array_key_exists("position", $values) ) ? $values["position"] : self::DEFAULT_POSITION;
			$name = ( array_key_exists("name", $values) ) ? $values["name"] : self::getUniqueName();
			$description = ( array_key_exists("description", $values) ) ? $values["description"] : ""; 
			
			$addedDate = ( array_key_exists("addedDate", $values) ) ? $values["addedDate"] : date("Y-m-d H:i:s");
			$startDate = ( array_key_exists("startDate", $values) ) ? $values["startDate"] : "0"; 
			$endDate = ( array_key_exists("endDate", $values) ) ? $values["endDate"] : "0"; 
			$status = ( array_key_exists("status", $values) ) ? $values["status"] : Status::ONGOING;
			$canceledDate = ( array_key_exists("canceledDate", $values) ) ? $values["canceledDate"] : "0"; 
			$completedDate = ( array_key_exists("completedDate", $values) ) ? $values["completedDate"] : "0"; 
			
			$percent = ( array_key_exists("percent", $values) ) ? $values["percent"] : 0;
			$color = ( array_key_exists("color", $values) ) ? $values["color"] : "#999999"; 
			$priority = ( array_key_exists("priority", $values) ) ? $values["priority"] : Priority::NORMAL;
			
			$ownerID = ( array_key_exists("ownerID", $values) ) ? $values["ownerID"] : User::NONE;
			$hasOwner = ( $ownerID !== User::NONE ) ? 1 : 0;
			
			$clientID = ( array_key_exists("clientID", $values) ) ? $values["clientID"] : User::NONE;
			$hasClient = ( $clientID !== User::NONE ) ? 1 : 0;			
		
			Database::query("INSERT INTO `tasks`
			(`projectID`, `type`, `position`, `name`, `description`, `addedDate`, `startDate`, `endDate`, `status`, `canceledDate`, `completedDate`, `percent`, `color`, `priority`, `hasOwner`, `ownerID`, `hasClient`, `clientID`)
			VALUES({$projectID}, {$type}, {$position}, '{$name}', '{$description}', '{$addedDate}', '{$startDate}', '{$endDate}', {$status}, '{$canceledDate}', '{$completedDate}', {$percent}, '{$color}', {$priority}, {$hasOwner}, {$ownerID}, {$hasClient}, {$clientID});
			;");
			
			if( !Database::getError() ) {
				return true;
			}			 
		}
		return false;		
	}
	
	public static function deleteTask( $taskID ) {
		Database::query("DELETE FROM `tasks` WHERE `taskID` = {$taskID};");
	}
	public static function changeTask( $taskID, $values ) {
		$name = $values["name"];
		$description = $values["description"];
		$priority = $values["priority"];
		$status = $values["status"];
		$percent = $values["percent"];
		$ownerID = $values["ownerID"];
		Database::query("UPDATE `tasks` 
			SET `name` = '{$name}',
			`description` = '{$description}',
			`priority` = {$priority},
			`percent` = {$percent},
			`status` = {$status},
			`ownerID` = '{$ownerID}'
		WHERE `taskID` = {$taskID};");
	}
	
	public static function numTasks( $userID = null, $status = 0 ) {
		$count = 0;
		if( $userID ) { // get by userID and userType
			$userType = User::getUserByID($userID)->getType();
			switch ($userType) {
				case User::ADMINISTRATOR:
					if( $status ) { // count projects with specified status
						Database::query( "SELECT COUNT(*) AS `count` FROM `tasks` WHERE `status` = {$status};" );
					} else { // count every projects
						Database::query( "SELECT COUNT(*) AS `count` FROM `tasks`;" );
					}
					if( Database::getCount() ) {				
						$count = Database::getFirst()->count;						
					}				
					break;				
				case User::PROJECT_OWNER:
					break;
				case User::TASK_OWNER:
					break;
				case User::CUSTOMER:
					break;
				default: break;
			}
		} else { // get all projects
			Database::query( "SELECT COUNT(*) AS `count` FROM `tasks`;" );
			if( Database::getCount() ) {				
				$count = Database::getFirst()->count;						
			}
		}
		return $count;
	}
	
	protected
		$_taskID,
		$_projectID,
		$_type,
		$_position,
		$_name,
		$_description,		
		$_addedDate,
		$_startDate,
		$_endDate,
		$_status,
		$_canceledDate,
		$_completedDate,
		$_percent,
		$_color,
		$_priority,
		$_hasOwner,
		$_ownerID,
		$_hasClient,
		$_clientID;

	public function __construct( $values = null ) {
		if( is_object($values) ) {
			$values = get_object_vars($values);
		}
		if( is_array($values) ) {			
			$this->_taskID = $values["taskID"];
			$this->_projectID = ( array_key_exists("projectID", $values) ) ? $values["projectID"] : self::NONE;
			$this->_type = ( array_key_exists("type", $values) ) ? $values["type"] : self::NORMAL;
			$this->_position = ( array_key_exists("position", $values) ) ? $values["position"] : self::DEFAULT_POSITION;
			$this->_name = ( array_key_exists("name", $values) ) ? $values["name"] : self::getUniqueName();
			$this->_description = ( array_key_exists("description", $values) ) ? $values["description"] : ""; 
			
			$this->_addedDate = ( array_key_exists("addedDate", $values) ) ? $values["addedDate"] : date("Y-m-d H:i:s"); 
			$this->_startDate = ( array_key_exists("startDate", $values) ) ? $values["startDate"] : "0"; 
			$this->_endDate = ( array_key_exists("endDate", $values) ) ? $values["endDate"] : "0"; 
			$this->_status = ( array_key_exists("status", $values) ) ? $values["status"] : Status::NOT_SPECIFIED;
			$this->_canceledDate = ( array_key_exists("canceledDate", $values) ) ? $values["canceledDate"] : "0"; 
			$this->_completedDate = ( array_key_exists("completedDate", $values) ) ? $values["completedDate"] : "0"; 
			
			$this->_percent = ( array_key_exists("percent", $values) ) ? $values["percent"] : 0; 
			$this->_color = ( array_key_exists("color", $values) ) ? $values["color"] : "#FFFFFF"; 
			$this->_priority = ( array_key_exists("priority", $values) ) ? $values["priority"] : Priority::NORMAL;
			
			$admin = User::getUserByName("Main", "Administrator")->getID();
			
			$this->_ownerID = ( array_key_exists("ownerID", $values) ) ? $values["ownerID"] : $admin;
			//$this->_hasOwner = ( $this->_ownerID !== User::NONE ) ? 1 : 0;
			$this->_hasOwner = 1;
			
			$this->_clientID = ( array_key_exists("clientID", $values) ) ? $values["clientID"] : $admin;
			//$this->_hasClient = ( $this->_clientID !== User::NONE ) ? 1 : 0;			
			$this->_hasClient = 1;			
		}
		//itrace( 1, "projectID:" . $this->_projectID );
	}

	public function getID() {
		return $this->_taskID;
	}
	public function getProjectID() {
		return $this->_projectID;
	}
	public function getType() {
		return $this->_type;
	}
	public function getPosition() {
		return $this->_position;
	}
	public function getName() {
		return $this->_name;
	}
	public function getDescription() {
		return $this->_description;
	}
	public function getAddedDate() {
		return $this->_addedDate;
	}
	public function getStartDate() {
		return $this->_startDate;
	}
	public function getEndDate() {
		return $this->_endDate;
	}
	public function getStatus() {
		return $this->_status;
	}
	public function getCanceledDate() {
		return $this->_canceledDate;
	}
	public function getCompletedDate() {
		return $this->_completedDate;
	}
	public function getPercent() {
		return $this->_percent;
	}
	public function getColor() {
		return $this->_color;
	}
	public function getPriority() {
		return $this->_priority;
	}
	public function hasOwner() {
		return $this->_hasOwner;
	}
	public function getOwner() {
		return $this->_ownerID;
	}
	public function hasClient() {
		return $this->_hasClient;
	}
	public function getClient() {
		return $this->_clientID;
	}
	
	public function echoData() {
		echo "'{"
			.'"taskID":'.$this->_taskID.','
			.'"projectID":'.$this->_projectID.','
			.'"type":'.$this->_type.','
			.'"position":'.$this->_position.','
			.'"name":"'.$this->_name.'",'
			.'"description":"'.$this->_description.'",'
			.'"addedDate":"'.$this->_addedDate.'",'
			.'"startDate":"'.$this->_startDate.'",'
			.'"endDate":"'.$this->_endDate.'",'
			.'"status":'.$this->_status.','
			.'"canceledDate":"'.$this->_canceledDate.'",'
			.'"completedDate":"'.$this->_completedDate.'",'
			.'"percent":'.$this->_percent.','
			.'"color":"'.$this->_color.'",'
			.'"priority":'.$this->_priority.','
			.'"hasOwner":'.$this->_hasOwner.','
			.'"ownerID":'.$this->_ownerID.','
			.'"hasClient":'.$this->_hasClient.','
			.'"clientID":'.$this->_clientID		
		."}'";
	}
	public function getAsArray() {
		$owner = User::getUserByID($this->_ownerID);
		$ownerName = ( $owner ) ? $owner->getName() : "";
		
		$client = User::getUserByID($this->_clientID);
		$clientName = ( $client ) ? $client->getName() : "";
		
		$data = array(
			"taskID" => $this->_taskID,
			"projectID" => $this->_projectID,
			"type" => $this->_type,
			"name" => $this->_name,
			"description" => $this->_description,
			"addedDate" => $this->_addedDate,
			"startDate" => $this->_startDate,
			"endDate" => $this->_endDate,
			"status" => $this->_status,
			"canceledDate" => $this->_canceledDate,
			"completedDate" => $this->_completedDate,
			"percent" => $this->_percent,
			"color" => $this->_color,
			"priority" => $this->_priority,
			"hasOwner" => $this->_hasOwner,
			"ownerID" => $this->_ownerID,
			"hasClient" => $this->_hasClient,
			"clientID" => $this->_clientID,		
				
			"ownerName" => $ownerName,
			"clientName" => $clientName
		);
		
		return $data;
	}
	
	public function getJSON( $withQuotes = true ) {
		
		$ownerName = ( $this->_ownerID !== User::NONE ) ? User::getUserByID($this->_ownerID)->getName() : "";
		$clientName = ( $this->_clientID !== User::NONE ) ? User::getUserByID($this->_clientID)->getName() : "";
		
		$echo = "";
		
		if( $withQuotes ) {
			$echo .= "'{";
		} else {
			$echo .= "{";
		}
			$echo .= '"taskID":'.$this->_taskID.','
				.'"projectID":'.$this->_projectID.','
				.'"type":'.$this->_type.','
				.'"position":'.$this->_position.','
				.'"name":"'.$this->_name.'",'
				.'"description":"'.$this->_description.'",'
				.'"addedDate":"'.$this->_addedDate.'",'
				.'"startDate":"'.$this->_startDate.'",'
				.'"endDate":"'.$this->_endDate.'",'
				.'"status":'.$this->_status.','
				.'"canceledDate":"'.$this->_canceledDate.'",'
				.'"completedDate":"'.$this->_completedDate.'",'
				.'"percent":'.$this->_percent.','
				.'"color":"'.$this->_color.'",'
				.'"priority":'.$this->_priority.','
				.'"hasOwner":'.$this->_hasOwner.','
				.'"ownerID":'.$this->_ownerID.','
				.'"hasClient":'.$this->_hasClient.','
				.'"clientID":'.$this->_clientID.','			
				
				.'"ownerName":"'.$ownerName.'",'
				.'"clientName":"'.$clientName.'"';
		
		if( $withQuotes ) {
			$echo .= "}'";
		} else {
			$echo .= "}";
		}
		
		return $echo;
	}
}