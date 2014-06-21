<?php
class DatabaseData {

	private static function getFile( $file ) {
		$data = file_get_contents( $file );
		if( $data === FALSE ) {
			trace( "couldn't open file: \"". $file ."\"" );
		} 
		return $data;
	}

	private static function insertFormat( $sqlScript, $fields, $values ) {		
		$f = "(";
		$v = "";
		
		for( $i=0, $L = count($fields), $b = $L-1; $i < $L ; ++$i ) {
			$f .= "`" . $fields[$i] . "`";
			if( $i < $b ) {
				$f .= ", ";
			} else {
				$f .= ")";
			}
		}	

		for( $i=0, $iL = count($values), $ib = $iL-1; $i < $iL; ++$i ) {
			$v .= "(";
			for( $j=0, $jL = count($values[$i]), $jb = $jL-1; $j < $jL; ++$j ) {
				$v .= "'" . $values[$i][$j] . "'";
				if( $j < $jb ) {
					$v .= ", ";
				}	
			}
			if( $i < $ib ) {
				$v .= "),";
			} else {
				$v .= ")";
			}
		}
		return str_replace( array('{$fields}','{$values}'), array($f,$v), $sqlScript);
	}
	
	public static function resetAll() { // drop, create and insert/fill/populate the database		
	}

	public static function dropUsers() {
		//$query = file_get_contents('sql/drop_users.sql');
		$query = "DROP TABLE IF EXISTS `users`;";
		Database::query( $query );
	}
	public static function createUsers() {
		$query = file_get_contents('sql/users.sql');
		Database::query( $query );
	}
	public static function insertUsers() {

		// ADMINISTRATORS
		User::registerUser( "admin", "admin", User::ADMINISTRATOR, "Main", "Administrator" );		
		User::registerUser( "richard", "richard", User::ADMINISTRATOR, "Richard", "Szakacs", "-", "-", "-", "-", 0, "-", "-", "f1.jpg" );
		User::registerUser( "laura", "laura", User::ADMINISTRATOR, "Laura", "Nagyova", "-", "-", "-", "-", 0, "-", "-", "f2.jpg" );
		User::registerUser( "michael", "michael", User::ADMINISTRATOR, "Michael", "Oyibo", "-", "-", "-", "-", 0, "-", "-", "f3.jpg" );
		User::registerUser( "anton", "anton", User::ADMINISTRATOR, "Anton", "Nankov", "-", "-", "-", "-", 0, "-", "-", "f4.jpg" );
		// PROJECT OWNERS
		User::registerUser( "james", "donovan", User::PROJECT_OWNER, "James", "Donovan", "UK", "Highwall", "St. 504", "Bath", 35743, "+44 5324 3212", "jdons@stvo.com", "a01.jpg" );
		User::registerUser( "carl", "johanson", User::PROJECT_OWNER, "Carl", "Johanson", "-", "-", "-", "-", 0, "-", "-", "a02.jpg" );
		User::registerUser( "jake", "kirk", User::PROJECT_OWNER, "Jake", "Kirk", "Austria", "Hoechwessel", "G. 24", "Graz", 8010, "+43 660 492 8678", "jakkrk@devtools.org", "a03.jpg" );
		User::registerUser( "amit", "tarun", User::PROJECT_OWNER, "Amit", "Tarun", "-", "-", "-", "-", 0, "-", "-", "a04.jpg" );
		// TASK OWNERS
		User::registerUser( "evan", "smith", User::TASK_OWNER, "Evan", "Smith", "USA", "Highroad", "Drv. 35", "Las Vegas", 46343, "+49 324 2342", "evansmt@trasv.com", "a12.jpg" );
		User::registerUser( "susan", "oreo", User::TASK_OWNER, "Susan", "Oreo", "-", "-", "-", "-", 0, "-", "-", "a06.jpg" );
		User::registerUser( "robert", "taylor", User::TASK_OWNER, "Robert", "Taylor", "USA", "Longhill", "Blvd. 35", "Los Angeles", 46343, "+49 324 2342", "robtaylor@trasv.com", "a13.jpg" );
		User::registerUser( "daniela", "spring", User::TASK_OWNER, "Daniela", "Spring", "-", "-", "-", "-", 0, "-", "-", "a08.jpg" );
		User::registerUser( "elena", "longway", User::TASK_OWNER, "Elena", "Longway", "-", "-", "-", "-", 0, "-", "-", "a09.jpg" );
		
		User::registerUser( "michael", "etherton", User::TASK_OWNER, "Michael", "Etherton", "-", "-", "-", "-", 0, "-", "-", "a05.jpg" );
		User::registerUser( "andrew", "garrison", User::TASK_OWNER, "Andrew", "Garrison", "-", "-", "-", "-", 0, "-", "-", "a07.jpg" );
		User::registerUser( "christina", "highfield", User::TASK_OWNER, "Christina", "Highfield", "-", "-", "-", "-", 0, "-", "-", "a10.jpg" );
		User::registerUser( "grace", "elliston", User::TASK_OWNER, "Grace", "Elliston", "-", "-", "-", "-", 0, "-", "-", "a11.jpg" );
		
		// CUSTOMERS
		User::registerUser( "mary", "hill", User::CUSTOMER, "Mary", "Hill", "USA", "Greenslate", "56/2", "New Shore", 35232, "+48 334 3423", "maryh@greensa.com", "a17.jpg" );
		User::registerUser( "eric", "ward", User::CUSTOMER, "Eric", "Ward", "Germany", "Friedrich", "str. 16", "Sulzbach", 71976, "+41 3422 5241", "ericward@ewsol.com", "a24.jpg" );
		User::registerUser( "gillian", "clark", User::CUSTOMER, "Gillian", "Clark", "-", "-", "-", "-", 0, "-", "-", "a14.jpg" );
		User::registerUser( "matthew", "walker", User::CUSTOMER, "Matthew", "Walker", "-", "-", "-", "-", 0, "-", "-", "a15.jpg" );
		User::registerUser( "thomas", "jackson", User::CUSTOMER, "Thomas", "Jackson", "-", "-", "-", "-", 0, "-", "-", "a16.jpg" );
		User::registerUser( "thomas", "jackson", User::CUSTOMER, "Thomas", "Jackson", "-", "-", "-", "-", 0, "-", "-", "a16.jpg" );
		User::registerUser( "john", "allen", User::CUSTOMER, "John", "Allen", "-", "-", "-", "-", 0, "-", "-", "a18.jpg" );
		User::registerUser( "jessica", "scott", User::CUSTOMER, "Jessica", "Scott", "-", "-", "-", "-", 0, "-", "-", "a19.jpg" );
		User::registerUser( "linda", "baker", User::CUSTOMER, "Linda", "Baker", "-", "-", "-", "-", 0, "-", "-", "a20.jpg" );
		User::registerUser( "william", "hall", User::CUSTOMER, "William", "Hall", "-", "-", "-", "-", 0, "-", "-", "a21.jpg" );
		User::registerUser( "donald", "mitchell", User::CUSTOMER, "Donald", "Mitchell", "-", "-", "-", "-", 0, "-", "-", "a22.jpg" );
		User::registerUser( "nancy", "carter", User::CUSTOMER, "Nancy", "Carter", "-", "-", "-", "-", 0, "-", "-", "a23.jpg" );
		User::registerUser( "amanda", "bailey", User::CUSTOMER, "Amanda", "Bailey", "-", "-", "-", "-", 0, "-", "-", "a25.jpg" );
		User::registerUser( "edward", "rover", User::CUSTOMER, "Edward", "Rover", "-", "-", "-", "-", 0, "-", "-", "a26.jpg" );
		User::registerUser( "nicholas", "cooper", User::CUSTOMER, "Nicholas", "Cooper", "-", "-", "-", "-", 0, "-", "-", "a27.jpg" );
		User::registerUser( "jacob", "miller", User::CUSTOMER, "Jacob", "Miller", "-", "-", "-", "-", 0, "-", "-", "a28.jpg" );
		User::registerUser( "stephen", "parker", User::CUSTOMER, "Stephen", "Parker", "-", "-", "-", "-", 0, "-", "-", "a29.jpg" );
		User::registerUser( "frank", "morris", User::CUSTOMER, "Frank", "Morris", "-", "-", "-", "-", 0, "-", "-", "a30.jpg" );
		User::registerUser( "raymond", "phillips", User::CUSTOMER, "Raymond", "Phillips", "-", "-", "-", "-", 0, "-", "-", "a31.jpg" );
		User::registerUser( "omar", "ayala", User::CUSTOMER, "Omar", "Ayala", "-", "-", "-", "-", 0, "-", "-", "a32.jpg" );
		User::registerUser( "gregory", "rogers", User::CUSTOMER, "Gregory", "Rogers", "-", "-", "-", "-", 0, "-", "-", "a33.jpg" );
		User::registerUser( "anna", "gray", User::CUSTOMER, "Anna", "Gray", "-", "-", "-", "-", 0, "-", "-", "a34.jpg" );
		User::registerUser( "angela", "kelly", User::CUSTOMER, "Angela", "Kelly", "-", "-", "-", "-", 0, "-", "-", "a35.jpg" );
		User::registerUser( "benjamin", "barnes", User::CUSTOMER, "Benjamin", "Barnes", "-", "-", "-", "-", 0, "-", "-", "a36.jpg" );

		/*
		$query = file_get_contents('sql/insert_users.sql');
		//Database::query( $query );
		//echo $query . "<br />";

		//$salt;
		$salt = Hash::generateSalt();

		$query = self::insertFormat( $query,
			array(
				"firstName", "lastName",
				"uid",
				"hash",
				"salt",
				
				"registered",
				"groupID"
			),
			array(
				array( "Common", "Administrator",
					"admin",
					//Hash::generateHash( "admin", ( $salt = Hash::generateSalt() ) ),
					Hash::generateHash( "admin", $salt ),
					base64_encode( $salt ),

					date("Y-m-d H:i:s"),
					Group::ADMINISTRATOR
				),
				
			)
		);
		Database::query( $query );
		*/
	}
	public static function resetUsers() {
		self::dropUsers();
		self::createUsers();
		self::insertUsers();
	}

	// USER SESSIONS
	public static function dropUserSessions() {
		$query = "DROP TABLE IF EXISTS `user_sessions`;";
		Database::query( $query );
	}
	public static function createUserSessions() {
		$query = file_get_contents('sql/user_sessions.sql');
		Database::query( $query );
	}
	public static function insertUserSessions() {}
	public static function resetUserSessions() {
		self::dropUserSessions();
		self::createUserSessions();
		self::insertUserSessions();
	}

	// TEAMS
	public static function dropTeams() {
		$query = "DROP TABLE IF EXISTS `teams`;";
		Database::query( $query );
	}
	public static function createTeams() {
		$query = file_get_contents('sql/teams.sql');
		Database::query( $query );		
	}
	public static function insertTeams() {
		Team::createTeam(
			User::getUserByName("James", "Donovan")->getID(),
				array(				
					User::getUserByName("Susan", "Oreo")->getID(),
					User::getUserByName("Andrew", "Garrison")->getID(),
					User::getUserByName("Daniela", "Spring")->getID(),
					User::getUserByName("Elena", "Longway")->getID(),
					User::getUserByName("Robert", "Taylor")->getID(),
					User::getUserByName("Grace", "Elliston")->getID()
				)
		);
		Team::createTeam(
			User::getUserByName("Carl", "Johanson")->getID(),
				array(					
					User::getUserByName("Daniela", "Spring")->getID(),
					User::getUserByName("Elena", "Longway")->getID(),
					User::getUserByName("Christina", "Highfield")->getID(),
					User::getUserByName("Grace", "Elliston")->getID()
				)
		);
		Team::createTeam(
			User::getUserByName("Jake", "Kirk")->getID(),
				array(					
					User::getUserByName("Elena", "Longway")->getID(),
					User::getUserByName("Christina", "Highfield")->getID(),
					User::getUserByName("Grace", "Elliston")->getID(),
					User::getUserByName("Evan", "Smith")->getID(),
					User::getUserByName("Robert", "Taylor")->getID()
				)
		);
		Team::createTeam(
			User::getUserByName("Amit", "Tarun")->getID(),
				array(					
					User::getUserByName("Andrew", "Garrison")->getID(),
					User::getUserByName("Daniela", "Spring")->getID(),
					User::getUserByName("Elena", "Longway")->getID(),
					User::getUserByName("Christina", "Highfield")->getID(),
					User::getUserByName("Grace", "Elliston")->getID()
				)
		);
		Team::createTeam(
			User::getUserByName("Michael", "Etherton")->getID(),
				array(					
					User::getUserByName("Daniela", "Spring")->getID(),
					User::getUserByName("Grace", "Elliston")->getID(),
					User::getUserByName("Evan", "Smith")->getID(),
					User::getUserByName("Robert", "Taylor")->getID()
				)
		);
	}
	public static function resetTeams() {
		self::dropTeams();
		self::createTeams();
		self::insertTeams();
	}

	// PROJECTS
	public static function dropProjects() {
		$query = "DROP TABLE IF EXISTS `projects`;";
		Database::query( $query );
	}
	public static function createProjects() {
		$query = file_get_contents('sql/projects.sql');
		Database::query( $query );		
	}
	public static function insertProjects() {
		// PROJECT OWNERS
		$jamesDonovan = User::getUserByName("James", "Donovan")->getID();
		$jakeKirk = User::getUserByName("Jake", "Kirk")->getID();
		// TASK OWNERS
		$robertTaylor = User::getUserByName("Robert", "Taylor")->getID();
		$evanSmith = User::getUserByName("Evan", "Smith")->getID();
		// CUSTOMERS
		$maryHill = User::getUserByName("Mary", "Hill")->getID();
		$ericWard = User::getUserByName("Eric", "Ward")->getID();
		
		Project::createProject(array(
			"name" => "Cisco Administration",
			"description" => "A server administrator, or admin has the overall control of a server. This can be in the context of a business organization, where often a server administrator oversees the performance and condition of multiple servers in the business",
			"status" => Status::ONGOING, "priority" => Priority::HIGH,			
			"startDate" => "2014-01-07", "endDate" => "2014-01-26",
			"clientID" => $maryHill,		
			"ownerID" => $jamesDonovan		
		));
		Project::createProject(array(
			"name" => "Server For Quick Journal",
			"description" => "Repair servers for the Quick Journal",
			"status" => Status::ONGOING, "priority" => Priority::LOW,			
			"startDate" => "2014-02-14", "endDate" => "2014-03-26",
			"clientID" => $maryHill,		
			"ownerID" => $jamesDonovan		
		));
		Project::createProject(array(
			"name" => "Server For Daily News",
			"status" => Status::COMPLETED,
			"clientID" => User::getUserByName("Matthew", "Walker")->getID(),		
			"ownerID" => $jamesDonovan		
		));
		Project::createProject(array(
			"name" => "Repair Servers Of FastCO",
			"status" => Status::ONGOING,
			"clientID" => User::getUserByName("Thomas", "Jackson")->getID(),		
			"ownerID" => User::getUserByName("Carl", "Johanson")->getID()		
		));
		Project::createProject(array(
			"name" => "Repair Servers Of AmazeMe",
			"status" => Status::CANCELED,
			"clientID" => User::getUserByName("Thomas", "Jackson")->getID(),		
			"ownerID" => User::getUserByName("Carl", "Johanson")->getID()		
		));
		Project::createProject(array(
			"name" => "CES Presentation",
			"status" => Status::ONGOING,
			"clientID" => User::getUserByName("Mary", "Hill")->getID(),		
			"ownerID" => $jakeKirk		
		));
		Project::createProject(array(
			"name" => "CSHAA Presentation",
			"status" => Status::CANCELED,
			"clientID" => User::getUserByName("Mary", "Hill")->getID(),		
			"ownerID" => User::getUserByName("Jake", "Kirk")->getID()		
		));
		Project::createProject(array(
			"name" => "Product AERO Presentation",
			"status" => Status::ONGOING,
			"clientID" => User::getUserByName("John", "Allen")->getID(),		
			"ownerID" => User::getUserByName("Amit", "Tarun")->getID()		
		));
		Project::createProject(array(
			"name" => "Product SIGMA Presentation",
			"status" => Status::ARCHIVED,
			"clientID" => User::getUserByName("John", "Allen")->getID(),		
			"ownerID" => User::getUserByName("Amit", "Tarun")->getID()		
		));
		Project::createProject(array(
			"name" => "Software For OETI Standards",
			"status" => Status::ONGOING,
			"clientID" => User::getUserByName("Jessica", "Scott")->getID(),		
			"ownerID" => User::getUserByName("Michael", "Etherton")->getID()		
		));
		Project::createProject(array(
			"name" => "Software For CS Utilities",
			"status" => Status::COMPLETED,
			"clientID" => User::getUserByName("Jessica", "Scott")->getID(),		
			"ownerID" => User::getUserByName("Michael", "Etherton")->getID()		
		));
		Project::createProject(array(
			"name" => "Software For CSS Archives",
			"status" => Status::COMPLETED,
			"clientID" => User::getUserByName("Jessica", "Scott")->getID(),		
			"ownerID" => User::getUserByName("Michael", "Etherton")->getID()		
		));
	}
	public static function resetProjects() {
		self::dropProjects();
		self::createProjects();
		self::insertProjects();
	}

	// TASKS
	public static function dropTasks() {
		$query = "DROP TABLE IF EXISTS `tasks`;";
		Database::query( $query );
	}
	public static function createTasks() {
		$query = file_get_contents('sql/tasks.sql');
		Database::query( $query );		
	}
	public static function insertTasks() {
		// PROJECT OWNERS
		$jamesDonovan = User::getUserByName("James", "Donovan")->getID();
		$jakeKirk = User::getUserByName("Jake", "Kirk")->getID();
		// TASK OWNERS
		$robertTaylor = User::getUserByName("Robert", "Taylor")->getID();
		$evanSmith = User::getUserByName("Evan", "Smith")->getID();
		// CUSTOMERS
		$maryHill = User::getUserByName("Mary", "Hill")->getID();
		$ericWard = User::getUserByName("Eric", "Ward")->getID();
		
		$projectID = Project::getProjectByName("Cisco Administration")->getID();
				Task::createTask(array(
					"projectID" => $projectID,
					"name" => "Gather Information",
					"description" => "Gather information from the IT Staff",
					"percent" => 75,
					"status" => Status::ONGOING, "priority" => Priority::HIGH,
					"clientID" => User::getUserByName("Linda", "Baker")->getID(),
					"ownerID" => $robertTaylor
				));			
				Task::createTask(array(
					"projectID" => $projectID,
					"name" => "Contact IT Staff",
					"percent" => 100,
					"status" => Status::ARCHIVED, "priority" => Priority::ZERO,
					"clientID" => User::getUserByName("William", "Hall")->getID(),		
					"ownerID" => $robertTaylor
				));			
				Task::createTask(array(
					"projectID" => $projectID,
					"name" => "Solve Router Problems",
					"percent" => 50,
					"status" => Status::ONGOING, "priority" => Priority::HIGH,
					"clientID" => User::getUserByName("Donald", "Mitchell")->getID(),		
					"ownerID" => User::getUserByName("Daniela", "Spring")->getID()
				));			
				Task::createTask(array(
					"projectID" => $projectID,
					"name" => "Check Switch Functionality",
					"percent" => 100,
					"status" => Status::COMPLETED, "priority" => Priority::HIGH,
					"clientID" => User::getUserByName("Nancy", "Carter")->getID(),		
					"ownerID" => User::getUserByName("Elena", "Longway")->getID()
				));			
				Task::createTask(array(
					"projectID" => $projectID,
					"name" => "Organize The Meeting",
					"percent" => 25,
					"status" => Status::ONGOING, "priority" => Priority::NORMAL,
					"clientID" => User::getUserByName("Eric", "Ward")->getID(),		
					"ownerID" => User::getUserByName("Robert", "Taylor")->getID()
				));
		$projectID = Project::getProjectByName("Server For Quick Journal")->getID();
				Task::createTask(array(
					"projectID" => $projectID,
					"name" => "Gather IT Needs",
					"position" => Task::getNextPosition($projectID),
					"clientID" => User::getUserByName("Eric", "Ward")->getID(),		
					"ownerID" => User::getUserByName("Robert", "Taylor")->getID()
				));
				Task::createTask(array(
					"projectID" => $projectID,
					"name" => "Contact Administrators",
					"position" => Task::getNextPosition($projectID),
					"clientID" => User::getUserByName("Nancy", "Carter")->getID(),		
					"ownerID" => User::getUserByName("Elena", "Longway")->getID()
				));				
				Task::createTask(array(
					"projectID" => $projectID,
					"name" => "Design Infrastructure",
					"position" => Task::getNextPosition($projectID),
					"clientID" => User::getUserByName("Donald", "Mitchell")->getID(),		
					"ownerID" => User::getUserByName("Daniela", "Spring")->getID()
				));				
				Task::createTask(array(
					"projectID" => $projectID,
					"name" => "Organize The Meeting",
					"position" => Task::getNextPosition($projectID),
					"clientID" => User::getUserByName("William", "Hall")->getID(),		
					"ownerID" => User::getUserByName("Andrew", "Garrison")->getID()
				));				
				Task::createTask(array(
					"projectID" => $projectID,
					"name" => "Notify CEO",
					"position" => Task::getNextPosition($projectID),
					"clientID" => User::getUserByName("Linda", "Baker")->getID(),		
					"ownerID" => User::getUserByName("Susan", "Oreo")->getID()
				));				
				Task::createTask(array(
					"projectID" => $projectID,
					"name" => "Start The Server",
					"position" => Task::getNextPosition($projectID),
					"clientID" => User::getUserByName("Linda", "Baker")->getID(),		
					"ownerID" => User::getUserByName("Susan", "Oreo")->getID()
				));
		$projectID = Project::getProjectByName("Repair Servers Of FastCO")->getID();
				Task::createTask(array(
					"projectID" => $projectID,
					"name" => "Get Servers From DHL",
					"position" => Task::getNextPosition($projectID),
					"clientID" => User::getUserByName("Amanda", "Bailey")->getID(),		
					"ownerID" => User::getUserByName("Daniela", "Spring")->getID()
				));				
				Task::createTask(array(
					"projectID" => $projectID,
					"name" => "Contact Server Repairs Department",
					"position" => Task::getNextPosition($projectID),
					"clientID" => User::getUserByName("Edward", "Rover")->getID(),		
					"ownerID" => User::getUserByName("Daniela", "Spring")->getID()
				));				
				Task::createTask(array(
					"projectID" => $projectID,
					"name" => "Create Repairment Sheet",
					"position" => Task::getNextPosition($projectID),
					"clientID" => User::getUserByName("Nicholas", "Cooper")->getID(),		
					"ownerID" => User::getUserByName("Elena", "Longway")->getID()
				));				
				Task::createTask(array(
					"projectID" => $projectID,
					"name" => "Consult With Client",
					"position" => Task::getNextPosition($projectID),
					"clientID" => User::getUserByName("Jacob", "Miller")->getID(),		
					"ownerID" => User::getUserByName("Christina", "Highfield")->getID()
				));				
				Task::createTask(array(
					"projectID" => $projectID,
					"name" => "Deliver Repaired Servers",
					"position" => Task::getNextPosition($projectID),
					"clientID" => User::getUserByName("Jacob", "Miller")->getID(),		
					"ownerID" => User::getUserByName("Grace", "Elliston")->getID()
				));
		$projectID = Project::getProjectByName("CES Presentation")->getID();
				Task::createTask(array(
					"projectID" => $projectID,
					"name" => "Collect Information",
					"position" => Task::getNextPosition($projectID),
					"clientID" => User::getUserByName("Stephen", "Parker")->getID(),		
					"ownerID" => User::getUserByName("Elena", "Longway")->getID()
				));				
				Task::createTask(array(
					"projectID" => $projectID,
					"name" => "Arrange Tickets",
					"position" => Task::getNextPosition($projectID),
					"clientID" => User::getUserByName("Frank", "Morris")->getID(),		
					"ownerID" => User::getUserByName("Christina", "Highfield")->getID()
				));				
				Task::createTask(array(
					"projectID" => $projectID,
					"name" => "Organize Presentation Area",
					"position" => Task::getNextPosition($projectID),
					"clientID" => User::getUserByName("Raymond", "Phillips")->getID(),		
					"ownerID" => User::getUserByName("Grace", "Elliston")->getID()
				));				
				Task::createTask(array(
					"projectID" => $projectID,
					"name" => "Buy Stand Tables",
					"position" => Task::getNextPosition($projectID),
					"clientID" => User::getUserByName("Omar", "Ayala")->getID(),		
					"ownerID" => User::getUserByName("Evan", "Smith")->getID()
				));				
				Task::createTask(array(
					"projectID" => $projectID,
					"name" => "Print Leaflets",
					"position" => Task::getNextPosition($projectID),
					"clientID" => User::getUserByName("Omar", "Ayala")->getID(),		
					"ownerID" => User::getUserByName("Robert", "Taylor")->getID()
				));
		$projectID = Project::getProjectByName("Product AERO Presentation")->getID();
				Task::createTask(array(
					"projectID" => $projectID,
					"name" => "Gather Information",
					"position" => Task::getNextPosition($projectID),
					"clientID" => User::getUserByName("Edward", "Rover")->getID(),		
					"ownerID" => User::getUserByName("Andrew", "Garrison")->getID()
				));				
				Task::createTask(array(
					"projectID" => $projectID,
					"name" => "Organize Area",
					"position" => Task::getNextPosition($projectID),
					"clientID" => User::getUserByName("Nicholas", "Cooper")->getID(),		
					"ownerID" => User::getUserByName("Daniela", "Spring")->getID()
				));				
				Task::createTask(array(
					"projectID" => $projectID,
					"name" => "Send Notifications",
					"position" => Task::getNextPosition($projectID),
					"clientID" => User::getUserByName("Stephen", "Parker")->getID(),		
					"ownerID" => User::getUserByName("Elena", "Longway")->getID()
				));				
				Task::createTask(array(
					"projectID" => $projectID,
					"name" => "Print Leaflets",
					"position" => Task::getNextPosition($projectID),
					"clientID" => User::getUserByName("Raymond", "Phillips")->getID(),		
					"ownerID" => User::getUserByName("Christina", "Highfield")->getID()
				));				
				Task::createTask(array(
					"projectID" => $projectID,
					"name" => "Send Finals",
					"position" => Task::getNextPosition($projectID),
					"clientID" => User::getUserByName("Omar", "Ayala")->getID(),		
					"ownerID" => User::getUserByName("Grace", "Elliston")->getID()
				));
		$projectID = Project::getProjectByName("Software For OETI Standards")->getID();
				Task::createTask(array(
					"projectID" => $projectID,
					"name" => "Organize First Meeting",
					"position" => Task::getNextPosition($projectID),
					"clientID" => User::getUserByName("Gregory", "Rogers")->getID(),		
					"ownerID" => User::getUserByName("Daniela", "Spring")->getID()
				));				
				Task::createTask(array(
					"projectID" => $projectID,
					"name" => "Create Fundamentals",
					"position" => Task::getNextPosition($projectID),
					"clientID" => User::getUserByName("Anna", "Gray")->getID(),		
					"ownerID" => User::getUserByName("Grace", "Elliston")->getID()
				));				
				Task::createTask(array(
					"projectID" => $projectID,
					"name" => "Design Software",
					"position" => Task::getNextPosition($projectID),
					"clientID" => User::getUserByName("Angela", "Kelly")->getID(),		
					"ownerID" => User::getUserByName("Evan", "Smith")->getID()
				));				
				Task::createTask(array(
					"projectID" => $projectID,
					"name" => "Development Phase",
					"position" => Task::getNextPosition($projectID),
					"clientID" => User::getUserByName("Benjamin", "Barnes")->getID(),		
					"ownerID" => User::getUserByName("Robert", "Taylor")->getID()
				));				
				Task::createTask(array(
					"projectID" => $projectID,
					"name" => "Testing Phase",
					"position" => Task::getNextPosition($projectID),
					"clientID" => User::getUserByName("Angela", "Kelly")->getID(),		
					"ownerID" => User::getUserByName("Daniela", "Spring")->getID()
				));				
				Task::createTask(array(
					"projectID" => $projectID,
					"name" => "Final Tests",
					"position" => Task::getNextPosition($projectID),
					"clientID" => User::getUserByName("Gregory", "Rogers")->getID(),		
					"ownerID" => User::getUserByName("Evan", "Smith")->getID()
				));				
				Task::createTask(array(
					"projectID" => $projectID,
					"name" => "Deploy Software",
					"position" => Task::getNextPosition($projectID),
					"clientID" => User::getUserByName("Raymond", "Phillips")->getID(),		
					"ownerID" => User::getUserByName("Robert", "Taylor")->getID()
				));				
	}
	public static function resetTasks() {
		self::dropTasks();
		self::createTasks();
		self::insertTasks();
	}
	
	// MESSAGES
	public static function dropMessages() {
		$query = "DROP TABLE IF EXISTS `messages`;";
		Database::query( $query );
	}
	public static function createMessages() {
		$query = file_get_contents('sql/messages.sql');
		Database::query( $query );		
	}
	public static function insertMessages() {
		Message::createMessage(array(
			"senderID" => User::getUserByName("James", "Donovan")->getID(),
			"recipientID" => User::getUserByName("Robert", "Taylor")->getID(),
			"type" => Message::NORMAL,
			"subject" => "Cisco Documents",
			"text" => "Please deliver the Cisco CLS12 documents ASAP. Thank you!"
		));	
		Message::createMessage(array(
			"senderID" => User::getUserByName("James", "Donovan")->getID(),
			"recipientID" => User::getUserByName("Mary", "Hill")->getID(),
			"type" => Message::NORMAL,
			"subject" => "Greetings by the CRM Staff",
			"text" => "Welcome to our team!"
		));	
		Message::createMessage(array(
			"senderID" => User::getUserByName("James", "Donovan")->getID(),
			"recipientID" => User::getUserByName("Mary", "Hill")->getID(),
			"type" => Message::ISSUE,
			"subject" => "Cisco Project Problem",
			"text" => "Please consult the router access data with our IT Staff. Thank You!",
			"date" => "2014-01-19"
		));	
		Message::createMessage(array(
			"senderID" => User::getUserByName("Mary", "Hill")->getID(),
			"recipientID" => User::getUserByName("James", "Donovan")->getID(),
			"type" => Message::ISSUE,
			"subject" => "Test Message 3",
			"text" => "Test Text 3"
		));	
		Message::createMessage(array(
			"senderID" => User::getUserByName("Mary", "Hill")->getID(),
			"recipientID" => User::getUserByName("James", "Donovan")->getID(),
			"type" => Message::NORMAL,
			"subject" => "Test Message 4",
			"text" => "Test Text 4"
		));	
	}
	public static function resetMessages() {
		self::dropMessages();
		self::createMessages();
		self::insertMessages();
	}
	
	// ACTIVITIES
	public static function dropActivities() {
		$query = "DROP TABLE IF EXISTS `activities`;";
		Database::query( $query );
	}
	public static function createActivities() {
		$query = file_get_contents('sql/activities.sql');
		Database::query( $query );		
	}
	public static function insertActivities() {	
	}
	public static function resetActivities() {
		self::dropActivities();
		self::createActivities();
		self::insertActivities();
	}
}