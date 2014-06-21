CREATE TABLE `activities` (
	`activityID` 	INT UNSIGNED NOT NULL
					AUTO_INCREMENT			COMMENT 'primary key',

	`userID` 	INT UNSIGNED NOT NULL	COMMENT 'userID of the activity',
	
	`type`		TINYINT NOT NULL	 	COMMENT 'activity type',
	`date` 		DATETIME NOT NULL		COMMENT 'date of activity',
	
	`baseData`		TEXT NOT NULL		COMMENT 'the source/base data',
	`changedData`	TEXT NOT NULL		COMMENT 'the new/changed data',

	PRIMARY KEY (`activityID`)
)
	ENGINE=MyISAM
	AUTO_INCREMENT=201
	DEFAULT	CHARSET=utf8
	COMMENT='activities table';