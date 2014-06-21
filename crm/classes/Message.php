<?php
class Message {
	
	// MESSAGE TYPES
	const NORMAL = 1; // normal message
	const ISSUE = 2; // some type of error/issue
	
	private static function getArray( $result ) {
			
		$recipientUser = User::getUserByID($result->recipientID);
		$senderUser = User::getUserByID($result->senderID);
			
		$data = array(
			"messageID" => $result->messageID,
			"recipientID" => $result->recipientID,
			"recipientName" => $recipientUser->getName(),
			"senderID" => $result->senderID,
			"senderName" => $senderUser->getName(),
			"read" => $result->read,
			"type" => $result->type,
			"subject" => $result->subject,
			"text" => $result->text,
			"date" => $result->date,
		);		
		return $data;
	}
	
	public static function getMessagesByID( $userID ) {
		$a = array(
			"inbox" => array(),
			"sent" => array()
		);
		
		// INBOX
		Database::query("SELECT * FROM `messages` WHERE `recipientID` = {$userID} ORDER BY `date` DESC;");
		if( Database::getCount() ) {
			$results = Database::getResults();
			foreach ($results as $result) {
				$a["inbox"][] = self::getArray($result);
			}
		}
		// SENT
		Database::query("SELECT * FROM `messages` WHERE `senderID` = {$userID} ORDER BY `date` DESC;");
		if( Database::getCount() ) {
			$results = Database::getResults();
			foreach ($results as $result) {
				$a["sent"][] = self::getArray($result);
			}
		}
		
		return $a;
	}
	
	public static function echoMessages( $userID ) {
		$results = self::getMessagesByID($userID);
		echo "'".json_encode($results)."'";
	}
	
	public static function createMessage( $values ) {
		$message = new Message( $values );
		$recipientID = $message->getRecipientID();
		$senderID = $message->getSenderID();
		$read = $message->getRead();
		$type = $message->getType();
		$subject = $message->getSubject();
		$text = $message->getText();
		$date = $message->getDate();
		
		Database::query("INSERT INTO `messages`
		 (`recipientID`, `senderID`, `read`, `type`, `subject`, `text`, `date`)
		 VALUES ('{$recipientID}','{$senderID}','{$read}','{$type}','{$subject}','{$text}','{$date}');");		
	}
	public static function deleteMessage( $values ) {
		if( array_key_exists("messageID", $values) ) {
			$messageID = $values["messageID"]; 
			Database::query("DELETE FROM `messages` WHERE `messageID` = {$messageID};");	
		}				
	}
	public static function toggleMessage( $values ) {
		if( array_key_exists("messageID", $values) ) {
			$messageID = $values["messageID"]; 
			itrace(1, "* toggleMessage ". $messageID );
			itrace(1, "* toggleMessage ". print_r($values, true) );
			Database::query("SELECT `read` FROM `messages` WHERE `messageID` = {$messageID} LIMIT 1;");
			if( !Database::getError() ) {				
				$result = Database::getFirst();
				$read = $result->read;
				
				itrace(1, "* toggleMessage ". $messageID ." - ". $read );
				itrace(1, "* type of $read ". gettype($read) );
				
				if( $read == "0" ) {
					self::markAsRead( $messageID );
					itrace(2, "* markedAsRead: ". $messageID);
				} else {
					self::markAsUnread( $messageID );
					itrace(2, "* markedAsUnread ". $messageID);
				}
			}
		}
	}
	public static function markAsRead( $messageID ) {
		Database::query("UPDATE `messages` SET `read` = 1 WHERE `messageID` = {$messageID};");		
	}		
	public static function markAsUnread( $messageID ) {
		Database::query("UPDATE `messages` SET `read` = 0 WHERE `messageID` = {$messageID};");				
	}
	
	protected
		$_messageID,
		$_recipientID,
		$_senderID,
		$_read,
		$_type,
		$_subject,
		$_text,
		$_date;
		
	private function __construct( $values = null ) {
		if( is_object($values) ) {
			$values = get_object_vars($values);
		}
		if( is_array($values) ) {
			$this->_messageID = ( array_key_exists("messageID", $values) ) ? $values["messageID"] : 0;
			$this->_recipientID = ( array_key_exists("recipientID", $values) ) ? $values["recipientID"] : 205;
			$this->_senderID = ( array_key_exists("senderID", $values) ) ? $values["senderID"] : 205;
			$this->_read = ( array_key_exists("read", $values) ) ? $values["read"] : 0;
			$this->_type = ( array_key_exists("type", $values) ) ? $values["type"] : self::NORMAL;
			$this->_subject = ( array_key_exists("subject", $values) ) ? $values["subject"] : "";
			$this->_text = ( array_key_exists("text", $values) ) ? $values["text"] : "";
			//$this->_date = date("Y-m-d H:i:s");
			$this->_date = ( array_key_exists("date", $values) ) ? $values["date"] : date("Y-m-d H:i:s");
		}
	}
	
	public function getMessageID() {
		return $this->_messageID;
	}
	public function getRecipientID() {
		return $this->_recipientID;
	}
	public function getSenderID() {
		return $this->_senderID;
	}
	public function getRead() {
		return $this->_read;
	}
	public function getType() {
		return $this->_type;
	}
	public function getSubject() {
		return $this->_subject;
	}
	public function getText() {
		return $this->_text;
	}
	public function getDate() {
		return $this->_date;
	}
	
	public function getAsArray(){
		$data = array(
			"messageID" => $this->getMessageID(),
			"recipientID" => $this->getRecipientID(),
			"senderID" => $this->getSenderID(),
			"read" => $this->getRead(),
			"type" => $this->getType(),
			"subject" => $this->getSubject(),
			"text" => $this->getText(),
			"date" => $this->getDate()
		);
		return $data;
	}
}