CREATE TABLE `tasks` (
	`taskID`		INT UNSIGNED NOT NULL
					AUTO_INCREMENT						COMMENT 'primary key',

	`projectID` 	INT UNSIGNED NOT NULL				COMMENT 'ID of the parent project',
	`type`			TINYINT UNSIGNED NOT NULL	  		COMMENT 'type of the task',

	`position`		INT UNSIGNED NOT NULL				COMMENT 'position of the task (when listing multiple tasks)',

	`name` 			VARCHAR(64) NOT NULL			 	COMMENT 'task name',
	`description`	TEXT NOT NULL			 			COMMENT 'description of the task',

	`addedDate`		DATETIME NOT NULL 	 				COMMENT 'date of the task added',
	`startDate`		DATETIME NOT NULL		 	 		COMMENT 'preferred start date',
	`endDate`		DATETIME NOT NULL 		 	 		COMMENT 'preferred end date',

	`status`		TINYINT(1) UNSIGNED NOT NULL		COMMENT 'status of the task',
	`canceledDate`	DATETIME NOT NULL		 	 		COMMENT 'date of the task cancelation (if canceled)',
	`completedDate`	DATETIME NOT NULL		 	 		COMMENT 'date of the task completion (if completed)',
	`percent`		TINYINT(3) UNSIGNED NOT NULL  		COMMENT 'percent of the task (integers from 0 to 100)',

	`color`			VARCHAR(16) NOT NULL 				COMMENT 'color of the task',
	`priority`		TINYINT(1) UNSIGNED NOT NULL  		COMMENT 'priority of the task',	

	`hasOwner`		BIT(1) NOT NULL DEFAULT 0			COMMENT 'whether the task has a task owner',
	`ownerID`		INT UNSIGNED NOT NULL		 		COMMENT 'userID for the task owner',
	
	`hasClient`		BIT(1) NOT NULL DEFAULT 0			COMMENT 'whether the task has a client',
	`clientID`		INT UNSIGNED NOT NULL 				COMMENT 'userID of the client',

	PRIMARY KEY (`taskID`)
)
	ENGINE=MyISAM
	AUTO_INCREMENT=1001
	DEFAULT	CHARSET=utf8
	COMMENT='tasks table';