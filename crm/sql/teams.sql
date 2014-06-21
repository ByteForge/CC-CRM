CREATE TABLE `teams` (
	`teamsPK` 	INT UNSIGNED NOT NULL
				AUTO_INCREMENT			COMMENT 'primary key',

	`teamID` 	INT UNSIGNED NOT NULL	COMMENT 'ID of the team',
	`userID` 	INT UNSIGNED NOT NULL	COMMENT 'userID',
	`type`		BIT(1) NOT NULL			COMMENT 'type of the user',
	
	PRIMARY KEY (`teamsPK`)
)
	ENGINE=MyISAM
	AUTO_INCREMENT=220
	DEFAULT	CHARSET=utf8
	COMMENT='teams table';