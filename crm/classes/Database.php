<?php
class Database {
	private static $__instance = null;
	private
		$_query,
		$_results,
		$_count = 0,
		$_error = false,
		$_pdo;

	private function __construct() {
		try {
			$this->_pdo = new PDO(
				"mysql:host=" . Config::getDatabaseHost() . ";dbname=" . Config::getDatabaseName(),
				Config::getDatabaseUser(),
				Config::getDatabasePassword()
			);
			$this->_pdo->exec("set names utf8");			
			//echo "connected to database <br />";
		} catch( PDOException $e ) {
			die( $e->getMessage() );
		}
	}

	public static function getInstance() {
		if( !isset( self::$__instance ) ) {
			self::$__instance = new Database();
		}
		return self::$__instance;
	}

	public static function query( $query ) {
		
		trace( "----------" );
		
		$q = self::getInstance(); // query instance
		$q->_error = false;
		if( $q->_query = $q->_pdo->prepare($query) ) {
			trace( "Successful preparation" );
			if( $q->_query->execute() ) {
				itrace( 1, "Successful execution" );
				$q->_results = $q->_query->fetchAll( PDO::FETCH_OBJ );
				$q->_count = $q->_query->rowCount();
			} else {
				itrace( 1, "Unsuccessful execution" );
				itrace( 2, "code: " . $q->_query->errorInfo()[1] );
				itrace( 2, "message: " . $q->_query->errorInfo()[2] );
				$q->_error = true;
			}
		} else {
			trace( "Unsuccessful preparation" );
		}
		
		trace( "----------" );
		//return $q;
		return !$q->_error;
	}

	public static function insert( $table, $columns, $values ) {
		$c = "(";
		$v = "";

		for( $i=0, $L = count($columns), $b = $L-1; $i < $L ; ++$i ) {
			//trace( $columns[$i] );
			$c .= "`" . $columns[$i] . "`";
			if( $i < $b ) {
				$c .= ", ";
			} else {
				$c .= ")";
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

		$query = "INSERT INTO `{$table}` {$c} VALUES {$v};";
		//echo $query . "<br />";
		return self::query( $query );
	}

	public static function getResults() {
		return self::getInstance()->_results;
	}
	public static function getCount() {
		return self::getInstance()->_count;
	}
	public static function getError() {
		return self::getInstance()->_error;
	}

	public static function getFirst() {
		$i = self::getInstance();
		if( !$i->_error && $i->_count > 0 ) {
			return $i->_results[0];
		}
		return null;
	}
	
}