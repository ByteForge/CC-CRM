<?php
//session_start();
function registerClass( $class ) {
	require_once "classes/" . $class . ".php";	
};
spl_autoload_register( "registerClass" );

/*
	usage: SELECT * from table WHERE id = {integer}

	integer:	{int} / {integer}
	string:		{str} / {string}
*/
function Query( $SQL ) {
	
	$q = Database::getInstance();
	
};

$logDate = date("Y-m-d_H-i-s");
//$logfile = new LogFile( "logs/log.txt" );
$logfile = new LogFile( "logs/log-". $logDate .".txt" );

function trace( $string ) {
	/*
	if( Config::getShowTraces() ) { 
		//echo $string . "<br />";
		echo "<pre>". $string . "\n" . "</pre>";
	}
	*/
	global $logfile;
	$logfile->append( $string . "\n" );
}

function itrace( $indentation, $string ) {
	/*
	if( Config::getShowTraces() ) { 
		//echo $string . "<br />";
		echo "<pre>". $string . "\n" . "</pre>";
	}
	*/
	$i = "";
	if( is_int( $indentation ) && $indentation > 0 ) {
		while( $indentation-- ) {
			$i .= "\t";
		}
	}
	global $logfile;
	$logfile->append( $i . $string . "\n" );
}

function escape( $string ) {
	return htmlentities( $string, ENT_QUOTES, 'UTF-8' );
};

itrace( 0, "initialize.php" );

if( Config::getDevelopment() === true ) { // development phase
	trace( "development config" );
	ini_set('display_errors', 'On');
	error_reporting(-1);
} else { // production phase
	trace( "production config" );
	ini_set('display_errors', 'Off');
	error_reporting(0);
}