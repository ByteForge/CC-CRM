<?php
class User {

	const NONE = 0; // no user (useful in activities)

	// USER TYPES
	const ADMINISTRATOR = 1;
	const PROJECT_OWNER = 2;
	const TASK_OWNER = 3;
	const CUSTOMER = 4;

	public static function registerUser( $uid, $password, $type, $firstName = "-", $lastName = "-", $country = "-", $line_1 = "-", $line_2 = "-", $city = "-", $zip = 0, $phone = "-", $email = "-", $avatar = "-" ) {

		//$siid		
		$salt = Hash::generateSalt();
		$hash = Hash::generateHash( $password, $salt );

		$salt = base64_encode( $salt );
		//$firstName;
		//$lastName;
		
		$registered = date("Y-m-d H:i:s");
		$updated = date("Y-m-d H:i:s");
		$active = 1;
		
		Database::query(
			"INSERT INTO `users` (`uid`, `hash`, `salt`, `type`, `firstName`, `lastName`, `registered`, `updated`, `active`, `country`, `line_1`, `line_2`, `city`, `zip`, `phone`, `email`, `avatar`) 
			VALUES ('{$uid}','{$hash}','{$salt}','{$type}','{$firstName}','{$lastName}','{$registered}','{$updated}','{$active}','{$country}','{$line_1}','{$line_2}','{$city}',{$zip},'{$phone}','{$email}','{$avatar}');"
		);
	}

	public static function signIn( $uid, $password ) {

		trace( "----------" );
		trace( $uid ." - ". $password );

		Database::query( "SELECT `userID`,`uid`,`hash`,`salt`,`active` FROM `users` WHERE `uid` = '{$uid}'" );
		if( Database::getCount() === 1 ) { // $uid found
			$r = Database::getFirst();

			trace( "uid is correct" );

			if( $r->hash === Hash::generateHash( $password, base64_decode( $r->salt ) ) ) { // validate password
				//Session::setItem( $sessionUser, $r->ID ); // set user ID
				//Session::regenerate();
				//Redirect::to( "overview.php" );
				trace( "password is correct" );
				return $r->userID;
			} else {
				// $password is incorrect
				trace( "password is incorrect" );
			}
		} else { //
			// $uid is incorrect
			trace( "uid is incorrect" );
		}
		trace( "----------" );

		return -1;
	}
	public static function signOut() {
		$userID = Session::getUser();
		
		Session::delete();
		Cookie::delete(Config::getCookieName());
		Database::query( "DELETE FROM `user_sessions` WHERE `userID` = {$userID};" );		
	}

	public static function echoProfile( $userID ) {
		Database::query("SELECT * FROM `users` WHERE `userID` = {$userID} LIMIT 1;");
		if( Database::getCount() ) {
			$result = Database::getFirst();
			
			$userID = $result->userID;
			$type = $result->type;
			$firstName = $result->firstName;
			$lastName = $result->lastName;
			$registered = $result->registered;
			$country = $result->country;
			$line1 = $result->line_1;
			$line2 = $result->line_2;
			$city = $result->city;
			$zip = $result->zip;
			$phone = $result->phone;
			$email = $result->email;
			$avatar = $result->avatar;
			
			$data = array(
				"userID" => $userID,
				"type" => $type,
				"firstName" => $firstName,
				"lastName" => $lastName,
				"registered" => $registered,
				"country" => $country,
				"line1" => $line1,
				"line2" => $line2,
				"city" => $city,
				"zip" => $zip,
				"phone" => $phone,
				"email" => $email,
				"avatar" => $avatar,
			);
			
			echo "'".json_encode($data)."'";
		}
	}

	public static function getUserByID( $userID ) {
		
		if( $userID == User::NONE ) {
			return false;
		}
			
		trace( "----------" );				
		Database::query( "SELECT * FROM `users` WHERE `userID` = {$userID} LIMIT 1;" );
		if( !Database::getError() ) {
			itrace( 3, "query success" );
			
			$r = Database::getFirst();
			
			$user = new User();
			$user->_userID = $userID;
			$user->_firstName = $r->firstName;
			$user->_lastName = $r->lastName;
			$user->_type = $r->type;
			$user->_avatar = $r->avatar;
						
			return $user;
			
		} else {
			itrace( 3, "query unsuccess" );
		}
		trace( "----------" );
				
		return false;
	}
	public static function getUserByName( $firstName, $lastName ) {
		Database::query( "SELECT `userID`, `firstName`, `lastName`, `type`, `avatar` FROM `users` WHERE `firstName` = '{$firstName}' AND `lastName` = '{$lastName}' LIMIT 1;" );
		if( !Database::getError() ) {
				
			$r = Database::getFirst();
			
			/*
			$user = new User();
			$user->_userID = $r->userID;
			$user->_firstName = $r->firstName;
			$user->_lastName = $r->lastName;
			$user->_type = $r->type;
			$user->_avatar = $r->avatar;
			return $user;
			*/
			
			return new User($r);			
		}
		return false;
	}
	public static function getProjectsIDs( $userID ) {
		Database::query( "SELECT `projectID` FROM `projects` WHERE `ownerID` = {$userID};" );
		if( Database::getCount() ) {
				
			$count = Database::getCount();
			itrace( 5, "project count: {$count}" );
			
			$results = Database::getResults();
			$r = array();
			foreach ( $results as $result ) {
				$r[] = $result->projectID;
			}
			
			itrace( 5, "project IDs: " . implode(", ", $r) );
			
			return $r;
		}
		return array();
	}	
	public static function getTaskIDsOfProject( $projectID ) {
		Database::query( "SELECT `taskID` FROM `tasks` WHERE `projectID` = {$projectID};" );
		if( Database::getCount() ) {
			
			$count = Database::getCount();
			itrace( 5, "task count: {$count} for projectID: {$projectID}" );
			
			$results = Database::getResults();
			$r = array();
			foreach ( $results as $result ) {
				$r[] = $result->taskID;
			}
			
			itrace( 5, "task IDs: " . implode(", ", $r) );
			
			return $r;
		}
		return array();
	}
	public static function echoProjectsByIDs( $projectIDs ) {
		if( is_array($projectIDs) ) {
			for( $i=0, $L=count($projectIDs), $B=$L-1; $i<$L; ++$i ) {
				$project = Project::getProjectByID($projectIDs[$i]);
				$project->echoData();	
				if( $i<$B ) {
					echo ", ";
				}	
			}			
		}		
	}	
	public static function echoTasks( $userID ) {
		
		$projectIDs = User::getProjectsIDs($userID);
		itrace( 5 , "echoTasks: ". count($projectIDs) );
		for( $i=0, $L=count($projectIDs), $B=$L-1; $i<$L; ++$i ) {
			$task = Task::getTaskByID($projectIDs[$i]);
			itrace( 6 , "tasks: ". $task->getName() );
			$task->echoData();	
			if( $i<$B ) {
				echo ", ";
			}	
		}	
	}	
	public static function getUsers() {
		Database::query( "SELECT * FROM `users`;" );
		if( !Database::getError() ) {				
			return Database::getResults();			
		}
		return array();
	}
	public static function getCustomers() {
		$a = array();
		$customerType = self::CUSTOMER;
		Database::query( "SELECT * FROM `users` WHERE `type` = {$customerType};" );
		if( Database::getCount() ) {
			$results = Database::getResults();				
			foreach ( $results as $result ) {
				$a[] = new User( $result );
			}		
		}
		return $a;		
	}
	
	public static function getOwners( $userID ) {
		$projectOwner = User::PROJECT_OWNER;
		$taskOwner = User::TASK_OWNER;		
		$userType = self::getUserByID($userID)->getType();
		
		$a = array();
		
		Database::query( "SELECT * FROM `users` WHERE `type` = {$projectOwner} OR `type`= {$taskOwner};" );
		if( Database::getCount() ) {
			$results = Database::getResults();				
			foreach ( $results as $result ) {
				$user = new User( $result );
				$a[] = $user->getAsArray();
			}		
		}
		
		switch ($userType) {
			case User::ADMINISTRATOR:
				break;
			
			default:				
				break;
		}
		return $a;
	}
	public static function getClients( $userID ) {
		$customer = User::CUSTOMER;
		$projectOwner = User::PROJECT_OWNER;
		$taskOwner = User::TASK_OWNER;		
		$userType = self::getUserByID($userID)->getType();
		
		$a = array();
		
		Database::query( "SELECT * FROM `users` WHERE `type`= {$customer};" );
		if( Database::getCount() ) {
			$results = Database::getResults();				
			foreach ( $results as $result ) {
				$user = new User( $result );
				$a[] = $user->getAsArray();
			}		
		}
		
		switch ($userType) {
			case User::ADMINISTRATOR:								
				break;
			
			default:				
				break;
		}
		return $a;
	}
	
	public static function echoOwners( $userID ) {
		$json = json_encode( self::getOwners($userID) );
		itrace( 1, "JSON" . print_r( $json, true ) );
		echo "'".$json."'"; 
	}
	
	public static function echoClients( $userID ) {
		$json = json_encode( self::getClients($userID) );
		itrace( 1, "JSON" . print_r( $json, true ) );
		echo "'".$json."'";
	}
	
	public static function echoUsers( $users ) {
		$r = "'[";		
		for( $i = 0, $L = count($users), $B = $L-1; $i < $L; ++$i ) {
			$user = $users[$i];
			
			$r .= "{";
			$r .= "\"userID\":{$user->userID}";
			//$r .= "\"type\":{$user->type},";
			//$r .= "\"firstName\":\"{$user->firstName}\",";
			//$r .= "\"lastName\":\"{$user->lastName}\",";
			//$r .= "\"avatar\":\"{$user->avatar}\"";
			$r .= "}";
			
			if( $i < $B ) {
				$r .= ",";
			}
		}
		$r .= "]'";
		
		itrace( 5 , $r );
		echo $r;
	}	

	// CLASS INSTANCE	
	protected
		$_userID,	
		$_uid,	
		$_hash,	
		$_salt,		
		$_type,	
		$_firstName,
		$_lastName,
		$_registered,
		$_updated,
		$_active,
		$_country,
		$_line_1,
		$_line_2,
		$_city,
		$_zip,
		$_phone,
		$_email,		
		$_avatar;

	private function __construct( $values = null ) {
		if( is_object($values) ) {
			$values = get_object_vars($values);
		}
		if( is_array($values) ) {
			$this->_userID = ( array_key_exists("userID", $values) ) ? $values["userID"] : self::NONE;
			$this->_firstName = ( array_key_exists("firstName", $values) ) ? $values["firstName"] : "";
			$this->_lastName = ( array_key_exists("lastName", $values) ) ? $values["lastName"] : "";
			$this->_type = $values["type"];
			$this->_avatar = ( array_key_exists("avatar", $values) ) ? $values["avatar"] : "none";
		}
	}	

	public function getID() {
		return $this->_userID;
	}	
	public function getFirstName() {
		return $this->_firstName;
	}
	public function getLastName() {
		return $this->_lastName;
	}
	public function getName() {
		return $this->getFirstName() ." ". $this->getLastName();
	}
	public function getType() {
		return $this->_type;
	}
	public function getAvatar() {
		return $this->_avatar;
	}
	public function getAsArray() {
		$data = array(
			"userID" => $this->_userID,
			"firstName" => $this->_firstName,
			"lastName" => $this->_lastName,
			"name" => $this->_firstName ." ". $this->_lastName,
			"type" => $this->_type,
			"avatar" => $this->_avatar
		);
		
		return $data;
	}
	
	public function echoData() {		
		echo "'{"
			.'"userID":"'.$this->_userID.'",'
			.'"firstName":"'.$this->_firstName.'",'
			.'"lastName":"'.$this->_lastName.'",'
			.'"type":'.$this->_type.','
			.'"avatar":"'.$this->_avatar.'"'.
		"}'";
	}
}