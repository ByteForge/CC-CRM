CREATE TABLE `user_sessions` (
	`user_sessionID`	INT UNSIGNED NOT NULL
				AUTO_INCREMENT						COMMENT 'primary key',

	`userID` 	INT UNSIGNED NOT NULL				COMMENT 'userID from `users`',
	`hash`		VARCHAR(128) NOT NULL DEFAULT '-' 	COMMENT 'stored session hash',
			
	PRIMARY KEY (`user_sessionID`),	
	KEY `idx_hash` (`hash`)
)
	ENGINE=MyISAM
	DEFAULT	CHARSET=utf8
	COMMENT='user sessions table';