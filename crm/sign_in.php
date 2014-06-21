<?php
require_once "classes/initialize.php";
itrace( 1, "sign_in.php" );
Session::start();

if( Session::exists() ) {
	itrace( 2, "session exists" );
	
	if( Session::userExists() ) {

		itrace( 3, "user exists - user is signed in" );
		// user signed in
		//Session::regenerate();
		//Redirect::to( "overview.php" );
		Redirect::to( "projects.php" );
	} else {
		if( Post::exists() && Post::itemExists("userid") && Post::itemExists("password") ) {

			itrace( 3, "POST exist" );

			$uid = Post::getItem("userid"); // !!!!! validate input
			$password = Post::getItem("password"); // !!!!! validate input
			$remember = ( Post::getItem("remember") === "on" ) ? true : false;
			
			itrace( 4, "sign in with - {$uid} - {$password}" );			

			Activity::commit(array(
				"type" => Activity::SIGN_IN_WITH_INPUT,
				"data" => "\"{ \"uid\": \"{$uid}\" }\""
			));

			//Session::setItem( Config::getSessionUser(), $uid );				
			$userID = User::signIn( $uid, $password, $remember );
			
			if( $userID > 0 ) { // success
				itrace( 5, "sign in - success" );
				Activity::commit(array(
					"userID" => $userID,
					"type" => Activity::SIGNED_IN_SUCCESSFULLY					
				));
			
				if( $remember ) {				
					Database::query( "SELECT `userID`,`hash` FROM `user_sessions` WHERE `userID` = {$userID};" );
					$result = Database::getFirst(); 
					
					itrace( 5, "count: ". Database::getCount() );
									
					if( Database::getCount() === 0 ) { // no user in user_sessions						
						$hash = Hash::generateUID();
						Database::query( "INSERT INTO `user_sessions` (`userID`,`hash`) VALUES ( {$userID}, '{$hash}' );" );						
					} else { // found user in user_sessions						
						$hash = $result->hash;
						itrace( 6, "found hash: ". $hash );
					}
					
					Cookie::set(Config::getCookieName(), $hash, Config::getCookieExpiration());
				}

				Session::setUser( $userID );
				Session::regenerate();
				Redirect::to( "overview.php" );
			} else { // failure
				itrace( 5, "sign in - failure" );
				Activity::commit(array(
					"type" => Activity::SIGNED_IN_UNSUCCESSFULLY					
				));
			}
		} else if( Cookie::exists(Config::getCookieName()) ) {
			itrace( 3, "remember me exist" );
			
			$hash = Cookie::get(Config::getCookieName());
			
			Activity::commit(array(
				"userID" => $userID,
				"type" => Activity::SIGN_IN_WITH_REMEMBER_HASH,
				"data" => "\"{ \"hash\": \'{$hash}\' }\""				
			));
						
			Database::query( "SELECT `userID`,`hash` FROM `user_sessions` WHERE `hash` = '{$hash}';" );
			if( Database::getCount() !== 0 ) { // successfully found `hash` in `user_sessions`
				$userID = Database::getFirst()->userID;
				Activity::commit(array(
					"userID" => $userID,
					"type" => Activity::SIGNED_IN_SUCCESSFULLY					
				));
				
				Session::setUser( $userID );
				Session::regenerate();
				Redirect::to( "overview.php" );
			} else { // `hash` not found in `user_sessions`, delete "suspicious" cookie
				Activity::commit(array(
					"type" => Activity::SIGNED_IN_UNSUCCESSFULLY					
				));
				Cookie::delete(Config::getCookieName());				
			}
		}
	}
} else {
	itrace( 2, "session doesn't exist" );
} 

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Construct Council CRM</title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.css" rel="stylesheet">

    <!-- Add custom CSS here -->
    <link href="css/sb-admin.css" rel="stylesheet">
    <!-- <link rel="stylesheet" href="font-awesome/css/font-awesome.min.css"> -->
    <link rel="stylesheet" href="css/sign_in.css">
  </head>
<body class="sign-in-body">

	<div class="sign-in-navbar">
		<img class="brand-logo hidden-xs" src="img/crm_logo_lg.png" alt="logo">
		<span class="brand-style hidden-xs"><span class="brand-style-lg">Construct Council CRM</span></span>

		<img class="brand-logo visible-xs" src="img/crm_logo_md.png" alt="logo">		
		<span class="brand-style visible-xs">Construct Council CRM</span>
	</div>

	<div class="container">
		<div class="row">			
				<div class="col-sm-10 col-sm-offset-1 col-md-6 col-md-offset-3">
					<div class="input-group input-group-lg sign-in-userid">
						<span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
						<input type="text" id="userid" class="form-control" placeholder="User ID">
					</div>
				</div>
				<div class="col-sm-10 col-sm-offset-1 col-md-6 col-md-offset-3">
					<div class="input-group input-group-lg sign-in-password">
						<span class="input-group-addon"><span class="glyphicon glyphicon-asterisk"></span></span>
						<input type="password" id="password" class="form-control" placeholder="Password">
					</div>
				</div>	
				<div class="col-xs-8 col-sm-6 col-sm-offset-1 col-md-4 col-md-offset-3">
					<button type="button" id="sign_in" class="btn btn-primary btn-lg btn-block sign-in-btns sign-in-btn-submit">Sign In</button>
				</div>
				<div class="col-xs-4 col-md-2">
					<button type="button" id="remember" class="btn btn-danger btn-lg btn-block sign-in-btns sign-in-btn-remember-off">Remember Me</button>
				</div>			
		</div>
	</div>
    

    <!-- JavaScript -->
    <script src="js/jquery-1.10.2.js"></script>
    <script src="js/bootstrap.js"></script>
	<script>
		$( document ).ready(function() {
			
			var remember = "off";
			
			$("#userid, #password").keyup( function( e ){
				var code = e.keyCode || e.which;
 				if(code === 13) { // Enter
					submitForm();
 				}				
			});
						
			$("#sign_in").click( function(){
				submitForm();									
			});
			
			$("#remember").click( function(){
				var btn = $(this);
				if( btn.hasClass( "sign-in-btn-remember-off" ) ) {
					btn.removeClass( "sign-in-btn-remember-off" );	
					btn.addClass( "sign-in-btn-remember-on" );
					remember = "on";	
				} else {
					btn.removeClass( "sign-in-btn-remember-on" );	
					btn.addClass( "sign-in-btn-remember-off" );
					remember = "off";
				}				
				btn.blur();				
			});
			
			var submitForm = function() {								
				var userid = $("#userid").val();
				var password = $("#password").val();
								
				$.ajax({
					url: "",
					type: "POST",
					data: { "userid": userid, "password": password, "remember": remember } ,					
					async: true,
					success: function (msg){
						location.reload(true);
					},
        			error: function (err){
        				//alert(err.responseText)
        			}
				});	
			}
		});
	</script>
  </body>
</html>