CREATE TABLE `messages` (
	`messageID` 	INT UNSIGNED NOT NULL
					AUTO_INCREMENT			COMMENT 'primary key',

	`recipientID` 	INT UNSIGNED NOT NULL	COMMENT 'userID of the recipient (to)',
	`senderID` 		INT UNSIGNED NOT NULL	COMMENT 'userID of the message (from)',
	
	`read`			TINYINT NOT NULL	 	COMMENT 'whether the recipient read the message',
	
	`type`			TINYINT NOT NULL	 	COMMENT 'type of the message',
	`subject` 		VARCHAR(64) NOT NULL	COMMENT 'subject of the message',	
	`text`			TEXT NOT NULL			COMMENT 'message text',
	
	`date`			DATETIME NOT NULL		COMMENT 'sent date',
					
	PRIMARY KEY (`messageID`)
)
	ENGINE=MyISAM
	AUTO_INCREMENT=51
	DEFAULT	CHARSET=utf8
	COMMENT='messages table';