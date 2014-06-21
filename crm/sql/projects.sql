CREATE TABLE `projects` (
	`projectID` 	INT UNSIGNED NOT NULL
					AUTO_INCREMENT						COMMENT 'primary key',
	`type`			TINYINT UNSIGNED NOT NULL  			COMMENT 'type of the project',

	`name` 			VARCHAR(64) NOT NULL			 	COMMENT 'project name',
	`description`	TEXT NOT NULL			 			COMMENT 'project description',
	
	`addedDate`		DATETIME NOT NULL 	 				COMMENT 'date of the project added',
	`startDate`		DATETIME NOT NULL 	 				COMMENT 'start date of the project',
	`endDate`		DATETIME NOT NULL		 	 		COMMENT 'end/due date of the project',
	
	`status`		TINYINT(1) UNSIGNED NOT NULL		COMMENT 'status of the project',
	`canceledDate`	DATETIME NOT NULL		 	 		COMMENT 'date of the project cancelation (if canceled)',
	`completedDate`	DATETIME NOT NULL		 	 		COMMENT 'date of the project completion (if completed)',

	`color`			VARCHAR(16) NOT NULL 				COMMENT 'color of the project',
	`priority`		TINYINT(1) UNSIGNED NOT NULL  		COMMENT 'priority of the project',	

	`hasOwner`		BIT(1) NOT NULL DEFAULT 0			COMMENT 'whether the project has a project owner',
	`ownerID`		INT UNSIGNED NOT NULL	 			COMMENT 'user id for the project owner',
	
	`hasClient`		BIT(1) NOT NULL DEFAULT 0			COMMENT 'whether the project has a client',
	`clientID`		INT UNSIGNED NOT NULL 				COMMENT 'userID of the client',

	PRIMARY KEY (`projectID`)
)
	ENGINE=MyISAM
	AUTO_INCREMENT=601
	DEFAULT	CHARSET=utf8
	COMMENT='projects table';