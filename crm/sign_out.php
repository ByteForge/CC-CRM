<?php
require_once "classes/initialize.php";
itrace( 1, "sign_out.php" );	
Session::start();

if( Session::userExists() ) {
	$userID = Session::getUser();
	Activity::commit(array(
		"userID" => $userID,
		"type" => Activity::SIGNED_OUT					
	));
}

User::signOut();
Redirect::to( "sign_in.php" );
?>