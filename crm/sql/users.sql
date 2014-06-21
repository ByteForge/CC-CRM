CREATE TABLE `users` (
	`userID` 	INT UNSIGNED NOT NULL
				AUTO_INCREMENT			COMMENT 'primary key',
	`uid`		VARCHAR(32) NOT NULL	COMMENT 'user id',
	`hash`		VARCHAR(128) NOT NULL 	COMMENT 'password hash',
	`salt`		VARCHAR(88) NOT NULL 	COMMENT 'password salt',

	`type`		TINYINT NOT NULL	 	COMMENT 'user type',

	`firstName` VARCHAR(32) NOT NULL 	COMMENT 'first name',
	`lastName`	VARCHAR(32) NOT NULL 	COMMENT 'last name',
	
	`registered` DATETIME NOT NULL		COMMENT 'date of registration',
	`updated` 	DATETIME NOT NULL		COMMENT 'date of last update',
	`active`	BIT(1) NOT NULL DEFAULT 0	COMMENT 'active (can sign in or not)',

	`country` 	VARCHAR(128) NOT NULL	COMMENT 'country of the user',
	`line_1`	VARCHAR(128) NOT NULL	COMMENT '1st address line',
	`line_2`	VARCHAR(128) NOT NULL	COMMENT '2nd address line (optional)',
	`city`		VARCHAR(128) NOT NULL 	COMMENT 'city',
	`zip`		INT NOT NULL DEFAULT 0	COMMENT 'zip code',
	`phone`		VARCHAR(64) NOT NULL	COMMENT 'phone number',
	
	`email`		VARCHAR(128) NOT NULL	COMMENT 'e-mail address',
	
	`avatar`	VARCHAR(64) NOT NULL	COMMENT 'avatar/portrait',

	PRIMARY KEY (`userID`),
	KEY `idx_uid` (`uid`)
)
	ENGINE=MyISAM
	AUTO_INCREMENT=201
	DEFAULT	CHARSET=utf8
	COMMENT='users table';