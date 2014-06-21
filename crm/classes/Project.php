<?php
class Project {
	
	const NONE = 0; // none (useful for tasks without project)
	//////////////////////////////////////////////////////////	
	const NORMAL = 1; // normal project (has tasks)
	const ISOLATED = 2; // isolated project (has tasks)

	public static function getUniqueName() {
		return "Project ".rand(151, 999999);
	}
	public static function getProjectByName( $name ) {
		Database::query( "SELECT `projectID`, `type`, `name`, `description`, `addedDate`, `startDate`, `endDate`, `status`, `canceledDate`, `completedDate`, `color`, `priority`, `hasOwner`, `ownerID`, `hasClient`, `clientID` FROM `projects` WHERE `name` = '{$name}' LIMIT 1;" );
		if( !Database::getError() ) {				
			$r = Database::getFirst();
			$project = new Project( $r );			
			return $project;			
		}
		return false;
	}
	public static function getProjectByID( $projectID ) {
		Database::query( "SELECT `projectID`, `type`, `name`, `description`, `addedDate`, `startDate`, `endDate`, `status`, `canceledDate`, `completedDate`, `color`, `priority`, `hasOwner`, `ownerID`, `hasClient`, `clientID` FROM `projects` WHERE `projectID` = '{$projectID}' LIMIT 1;" );
		if( !Database::getError() ) {				
			$r = Database::getFirst();
			$project = new Project( $r );			
			return $project;			
		}
		return false;
	}
	public static function echoProjects( $userID ) {
		itrace( 5, "echoProjects:" );
		
		$type = User::getUserByID($userID)->getType();
		
		switch ($type) {
			case User::ADMINISTRATOR:
				Database::query( "SELECT * FROM `projects`;" );
				if( Database::getCount() ) {
					$count = Database::getCount();
					//$count = 1;
					$data = array();					
					$results = Database::getResults();					
					
					for( $i=0,$B=$count-1; $i<$count; ++$i ) {
						$project = new Project($results[$i]);
						$projectID = $project->getID();
						
						$data[$i] = array(
							"project" => $project->getAsArray(),
							"tasks" => array()
						);						
						
							// TASKS
							Database::query( "SELECT * FROM `tasks` WHERE `projectID` = {$projectID};" );
							if( Database::getCount() ) {
								$taskResults = Database::getResults();
								$taskCount = count( $taskResults );
								//$taskCount = 2;
								for( $j=0,$JB=$taskCount-1; $j<$taskCount; ++$j ) {
									$task = new Task( $taskResults[$j] );
									$data[$i]["tasks"][] = $task->getAsArray();									
								}	
							}						
					}
					echo "'".json_encode($data)."'";
					return; 
				}				
				break;
			case User::PROJECT_OWNER:			
				Database::query( "SELECT * FROM `projects` WHERE `ownerID` = {$userID};" );
				if( Database::getCount() ) {
					$count = Database::getCount();
					//$count = 1;
					$data = array();					
					$results = Database::getResults();					
					
					for( $i=0,$B=$count-1; $i<$count; ++$i ) {
						$project = new Project($results[$i]);
						$projectID = $project->getID();
						
						itrace(5, "projectID:" . print_r($results[$i], true));
						
						$data[$i] = array(
							"project" => $project->getAsArray(),
							"tasks" => array()
						);						
						
							// TASKS
							Database::query( "SELECT * FROM `tasks` WHERE `projectID` = {$projectID};" );
							if( Database::getCount() ) {
								$taskResults = Database::getResults();
								$taskCount = count( $taskResults );
								//$taskCount = 2;
								for( $j=0,$JB=$taskCount-1; $j<$taskCount; ++$j ) {
									$task = new Task( $taskResults[$j] );
									$data[$i]["tasks"][] = $task->getAsArray();									
								}	
							}						
					}
					echo "'".json_encode($data)."'";
					return; 
				}				
				break;
				
			case User::TASK_OWNER:
				
				Database::query( "SELECT `projectID` FROM `tasks` WHERE `ownerID` = {$userID} GROUP BY `projectID`;" );
				$IDs = "";
				if( Database::getCount() ) {
					$results = Database::getResults();
					itrace( 1, "projectIDs: " . print_r($results, true) );
					$a = array();
					foreach ($results as $result) {
						$a[] = $result->projectID;
					}
					$IDs = join(',',$a);
					itrace( 1, "joined IDs: " . $IDs );
				}
							
				//Database::query( "SELECT * FROM `projects` WHERE `ownerID` = {$userID};" );
				Database::query( "SELECT * FROM `projects` WHERE `projectID` IN ({$IDs});" );
				if( Database::getCount() ) {
					$count = Database::getCount();
					//$count = 1;
					$data = array();					
					$results = Database::getResults();					
					
					for( $i=0,$B=$count-1; $i<$count; ++$i ) {
						$project = new Project($results[$i]);
						$projectID = $project->getID();
						
						itrace(5, "projectID:" . print_r($results[$i], true));
						
						$data[$i] = array(
							"project" => $project->getAsArray(),
							"tasks" => array()
						);						
						
							// TASKS
							Database::query( "SELECT * FROM `tasks` WHERE `projectID` = {$projectID};" );
							if( Database::getCount() ) {
								$taskResults = Database::getResults();
								$taskCount = count( $taskResults );
								//$taskCount = 2;
								for( $j=0,$JB=$taskCount-1; $j<$taskCount; ++$j ) {
									$task = new Task( $taskResults[$j] );
									$data[$i]["tasks"][] = $task->getAsArray();									
								}	
							}						
					}
					echo "'".json_encode($data)."'";
					return; 
				}				
				break;
				
			case User::CUSTOMER:
				Database::query( "SELECT * FROM `projects` WHERE `clientID` = {$userID} ;" );
				if( Database::getCount() ) {
					$count = Database::getCount();
					//$count = 1;
					$data = array();					
					$results = Database::getResults();					
					
					for( $i=0,$B=$count-1; $i<$count; ++$i ) {
						$project = new Project($results[$i]);
						$projectID = $project->getID();
						
						itrace(5, "projectID:" . print_r($results[$i], true));
						
						$data[$i] = array(
							"project" => $project->getAsArray(),
							"tasks" => array()
						);						
						
							// TASKS
							Database::query( "SELECT * FROM `tasks` WHERE `projectID` = {$projectID};" );
							if( Database::getCount() ) {
								$taskResults = Database::getResults();
								$taskCount = count( $taskResults );
								//$taskCount = 2;
								for( $j=0,$JB=$taskCount-1; $j<$taskCount; ++$j ) {
									$task = new Task( $taskResults[$j] );
									$data[$i]["tasks"][] = $task->getAsArray();									
								}	
							}						
					}
					echo "'".json_encode($data)."'";
					return; 
				}				
				break;
				
			default: break;
		}
			
		echo "";
		return;
	}
	public static function createProject( $values ) {
		if( is_array($values) ) {
			$type = ( array_key_exists("type", $values) ) ? $values["type"] : self::NORMAL;
			$name = ( array_key_exists("name", $values) ) ? $values["name"] : self::getUniqueName();
			$description = ( array_key_exists("description", $values) ) ? $values["description"] : ""; 
			
			$addedDate = ( array_key_exists("addedDate", $values) ) ? $values["addedDate"] : date("Y-m-d H:i:s");
			
			$startDate = ( array_key_exists("startDate", $values) ) ? $values["startDate"] : date("Y-m-d H:i:s", time()-(24 * 60 * 60) ); 
			$endDate = ( array_key_exists("endDate", $values) ) ? $values["endDate"] : date("Y-m-d H:i:s", time()+(72 * 60 * 60) ); 
			
			$status = ( array_key_exists("status", $values) ) ? $values["status"] : Status::NOT_SPECIFIED;
			$canceledDate = ( array_key_exists("canceledDate", $values) ) ? $values["canceledDate"] : "0"; 
			$completedDate = ( array_key_exists("completedDate", $values) ) ? $values["completedDate"] : "0"; 
			
			$color = ( array_key_exists("color", $values) ) ? $values["color"] : "#FFFFFF"; 
			$priority = ( array_key_exists("priority", $values) ) ? $values["priority"] : Priority::NORMAL;
			
			$ownerID = ( array_key_exists("ownerID", $values) ) ? $values["ownerID"] : User::NONE;
			$hasOwner = ( $ownerID !== User::NONE ) ? 1 : 0;
			
			$clientID = ( array_key_exists("clientID", $values) ) ? $values["clientID"] : User::NONE;
			$hasClient = ( $clientID !== User::NONE ) ? 1 : 0;
			
			Database::query("INSERT INTO `projects`
			(`type`, `name`, `description`, `addedDate`, `startDate`, `endDate`, `status`, `canceledDate`, `completedDate`, `color`, `priority`, `hasOwner`, `ownerID`, `hasClient`, `clientID`)
			VALUES({$type}, '{$name}', '{$description}', '{$addedDate}', '{$startDate}', '{$endDate}', {$status}, '{$canceledDate}', '{$completedDate}', '{$color}', {$priority}, {$hasOwner}, {$ownerID}, {$hasClient}, {$clientID});
			;");
			
			if( Database::getError() ) {
				return 0;
			}
			
			Database::query("SELECT `projectID` FROM `projects` ORDER BY `addedDate` DESC LIMIT 1;");
			if( Database::getCount() ) {
				$r = Database::getFirst();
				return $r->projectID;
			}			 
		}
		return 0;		
	}
	public static function deleteProject( $projectID ) {
		Database::query("DELETE FROM `tasks` WHERE `projectID` = {$projectID};");
		Database::query("DELETE FROM `projects` WHERE `projectID` = {$projectID};");
	}
	public static function changeProject( $projectID, $values ) {
		$name = $values["name"];
		$description = $values["description"];
		$startDate = $values["startDate"];
			if( $startDate == "" ) { $startDate = 0; }
		$endDate = $values["endDate"];
			if( $endDate == "" ) { $endDate = 0; }
		$priority = $values["priority"];
		$status = $values["status"];
		$clientID = $values["clientID"];
		$ownerID = $values["ownerID"];
		Database::query("UPDATE `projects` 
			SET `name` = '{$name}',
			`description` = '{$description}',
			`startDate` = '{$startDate}',
			`endDate` = '{$endDate}',
			`priority` = {$priority},
			`status` = {$status},
			`clientID` = '{$clientID}',
			`ownerID` = '{$ownerID}'
		WHERE `projectID` = {$projectID};");
	}	
	public static function assignProjectToOwner( $projectID, $ownerID ) {		
		return false;		
	}
	public static function assignProjectToClient( $projectID, $clientID ) {
		return false;		
	}
	
	public static function numProjects( $userID = null, $status = 0 ) {
		$count = 0;
		if( $userID ) { // get by userID and userType
			$userType = User::getUserByID($userID)->getType();
			switch ($userType) {
				case User::ADMINISTRATOR:
					if( $status ) { // count projects with specified status
						Database::query( "SELECT COUNT(*) AS `count` FROM `projects` WHERE `status` = {$status};" );
					} else { // count every projects
						Database::query( "SELECT COUNT(*) AS `count` FROM `projects`;" );
					}
					if( Database::getCount() ) {				
						$count = Database::getFirst()->count;						
					}				
					break;				
				case User::PROJECT_OWNER:
					if( $status ) { // count projects with specified status of the owner
						Database::query( "SELECT COUNT(*) AS `count` FROM `projects` WHERE `ownerID` = {$userID} AND `status` = {$status};" );
					} else { // count every projects of the owner
						Database::query( "SELECT COUNT(*) AS `count` FROM `projects` WHERE `ownerID` = {$userID};" );
					}
					if( Database::getCount() ) {				
						$count = Database::getFirst()->count;						
					}				
					break;
				case User::TASK_OWNER:
					if( $status ) { // count tasks within projects with specified status of the owner
						Database::query( "SELECT COUNT(`projectID`) FROM `tasks` WHERE `ownerID` = {$userID} AND `status` = {$status} GROUP BY `projectID`;" );
					} else { // count every tasks within projects of the owner						
						Database::query( "SELECT COUNT(`projectID`) FROM `tasks` WHERE `ownerID` = {$userID} GROUP BY `projectID`;" );
					}
					if( Database::getCount() ) {				
						$count = Database::getCount();						
					}									
					break;
				case User::CUSTOMER:
					if( $status ) { // count projects with specified status of the client
						Database::query( "SELECT COUNT(`projectID`) FROM `tasks` WHERE `clientID` = {$userID} AND `status` = {$status} GROUP BY `projectID`;" );
					} else { // count every projects of the client						
						Database::query( "SELECT COUNT(`projectID`) FROM `tasks` WHERE `clientID` = {$userID} GROUP BY `projectID`;" );
					}
					if( Database::getCount() ) {				
						$count = Database::getCount();						
					}									
					break;
				default: break;
			}
		} else { // get all projects
			Database::query( "SELECT COUNT(*) AS `count` FROM `projects`;" );
			if( Database::getCount() ) {				
				$count = Database::getFirst()->count;						
			}
		}
		return $count;
	}
	
	public static function numTasks( $projectID ) {
		return 0;		
	}
	public static function getTaskIDs( $projectID ) {
		$a = array();
		Database::query( "SELECT `taskID` FROM `tasks` WHERE `projectID`= {$projectID};" );
		if( Database::getCount() ) {				
			foreach (Database::getResults() as $result) {
				$a[] = $result->taskID;
			};						
		}
		return $a;	
	}
	public static function addTask( $projectID, $taskID ) {		
	}
	public static function removeTask( $projectID, $taskID ) {		
	}
	
	protected
		$_projectID,
		$_type,
		$_name,
		$_description,		
		$_addedDate,
		$_startDate,
		$_endDate,
		$_status,
		$_canceledDate,
		$_completedDate,
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
			//$this->_projectID = $values["projectID"];
			$this->_projectID = ( array_key_exists("projectID", $values) ) ? $values["projectID"] : 0;
			//$this->_projectID = $values["projectID"];
			$this->_type = ( array_key_exists("type", $values) ) ? $values["type"] : self::NORMAL;
			$this->_name = ( array_key_exists("name", $values) ) ? $values["name"] : self::getUniqueName();
			$this->_description = ( array_key_exists("description", $values) ) ? $values["description"] : ""; 
			
			$this->_addedDate = ( array_key_exists("addedDate", $values) ) ? $values["addedDate"] : date("Y-m-d H:i:s");
			$this->_startDate = ( array_key_exists("startDate", $values) ) ? $values["startDate"] : "0"; 
			$this->_endDate = ( array_key_exists("endDate", $values) ) ? $values["endDate"] : "0"; 
			$this->_status = ( array_key_exists("status", $values) ) ? $values["status"] : Status::ONGOING;
			$this->_canceledDate = ( array_key_exists("canceledDate", $values) ) ? $values["canceledDate"] : "0"; 
			$this->_completedDate = ( array_key_exists("completedDate", $values) ) ? $values["completedDate"] : "0"; 
			
			$this->_color = ( array_key_exists("color", $values) ) ? $values["color"] : "#FFFFFF"; 
			$this->_priority = ( array_key_exists("priority", $values) ) ? $values["priority"] : Priority::NORMAL;
			
			$this->_ownerID = ( array_key_exists("ownerID", $values) ) ? $values["ownerID"] : User::NONE;
			$this->_hasOwner = ( $this->_ownerID !== User::NONE ) ? 1 : 0;
			
			$this->_clientID = ( array_key_exists("clientID", $values) ) ? $values["clientID"] : User::NONE;
			$this->_hasClient = ( $this->_clientID !== User::NONE ) ? 1 : 0;			
		}
		itrace( 1, "projectID:" . $this->_projectID );
	}

	public function getID() {
		return $this->_projectID;
	}
	public function getType() {
		return $this->_type;
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
			.'"projectID":'.$this->_projectID.','
			.'"type":'.$this->_type.','
			.'"name":"'.$this->_name.'",'
			.'"description":"'.$this->_description.'",'
			.'"addedDate":"'.$this->_addedDate.'",'
			.'"startDate":"'.$this->_startDate.'",'
			.'"endDate":"'.$this->_endDate.'",'
			.'"status":'.$this->_status.','
			.'"canceledDate":"'.$this->_canceledDate.'",'
			.'"completedDate":"'.$this->_completedDate.'",'
			.'"color":"'.$this->_color.'",'
			.'"priority":'.$this->_priority.','
			.'"hasOwner":'.$this->_hasOwner.','
			.'"ownerID":'.$this->_ownerID.','
			.'"hasClient":'.$this->_hasClient.','
			.'"clientID":'.$this->_clientID		
		."}'";
	}
	public function getAsArray() {
		$ownerName = ( $this->_ownerID !== User::NONE ) ? User::getUserByID($this->_ownerID)->getName() : "";
		$clientName = ( $this->_clientID !== User::NONE ) ? User::getUserByID($this->_clientID)->getName() : "";
		
		$data = array(
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
		
		$data = array(
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
			"color" => $this->_color,
			"priority" => $this->_priority,
			"hasOwner" => $this->_hasOwner,
			"ownerID" => $this->_ownerID,
			"hasClient" => $this->_hasClient,
			"clientID" => $this->_clientID,		
				
			"ownerName" => $ownerName,
			"clientName" => $clientName
		);
		
		return json_encode($data);
		/*	
		$echo = "";
		
		if( $withQuotes ) {
			$echo .= "'{";
		} else {
			$echo .= "{";
		}
			$echo .= '"projectID":'.$this->_projectID.','
				.'"type":'.$this->_type.','
				.'"name":"'.$this->_name.'",'
				.'"description":"'.$this->_description.'",'
				.'"addedDate":"'.$this->_addedDate.'",'
				.'"startDate":"'.$this->_startDate.'",'
				.'"endDate":"'.$this->_endDate.'",'
				.'"status":'.$this->_status.','
				.'"canceledDate":"'.$this->_canceledDate.'",'
				.'"completedDate":"'.$this->_completedDate.'",'
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
		*/
		
		
	}
	
}