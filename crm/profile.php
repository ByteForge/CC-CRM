<?php
require_once "classes/initialize.php";
Session::start();
$user;

if( Session::exists() ) {	
	if( Session::userExists() ) {
		$userID = Session::getUser();		
		$user = User::getUserByID( $userID );		
	} else {
		Redirect::to( "sign_in.php" );
	}
} else {
	Redirect::to( "sign_in.php" );
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
		<link rel="stylesheet" href="css/overview.css">

	</head>
  
	<body class="body">

    <div id="wrapper">
		<?php include 'navigation.php'; ?>

      <div id="page-wrapper">        
			<div class="row">
          	<div class="col-xs-12">			
				<div class="panel panel-success">
  					<div class="panel-heading">
  						<div class="row">
  							<div class="col-xs-12">
  								<span class="glyphicon glyphicon-user overview-icon-size"></span>
  								<span class="overview-title">Profile</span>
  								<span class="pull-right">
  									<span class="profile-header-userid-name">User ID:</span>
  									<span id="pUserID" class="profile-header-userid-value">210</span>
  								</span>
  							</div>  							
  						</div>
  					</div>
  					<div class="panel-body">
  						<div class="row">
  							<div class="col-xs-4">
  								<img id="pAvatar" src="http://placehold.it/128x128" alt="Avatar" class="img-thumbnail">
  							</div>
  							<div class="col-xs-4 text-left">
  								<span class="profile-username-title">First Name:</span><span id="pFirstName" class="profile-username-first clearfix">FirstName</span>
  								<span class="profile-username-title">Last Name:</span><span id="pLastName" class="profile-username-last clearfix">LastName</span>
  							</div>
  							<div class="col-xs-4">
  								<span class="profile-type-title">Type:</span><span id="pType" class="profile-type-value clearfix">Administrator</span>
  								<span class="profile-registered-title">Registered:</span><span id="pRegistered" class="profile-registered-value clearfix">2014-12-01</span>
  							</div>
  						</div>
  						<div class="row" style="padding-top: 25px;">
  							<div class="col-xs-4">
  								<span class="profile-location-title">Country:</span><span id="pCountry" class="profile-country-value">UserCountry</span>
  								<span class="clearfix"></span>
  								<span class="profile-location-title">Line 1:</span><span id="pLine1" class="profile-line1-value">Line One</span>
  								<span class="clearfix"></span>
  								<span class="profile-location-title">Line 2:</span><span id="pLine2" class="profile-line2-value">Line Two</span>
  							</div>
  							<div class="col-xs-4">
  								<span class="profile-location-title">City:</span><span id="pCity" class="profile-city-value">UserCity</span>
  								<span class="clearfix"></span>
  								<span class="profile-location-title">ZIP Code:</span><span id="pZip" class="profile-zip-value">3435234</span>
  								<span class="clearfix"></span>
  								<span class="profile-location-title">Phone:</span><span id="pPhone" class="profile-phone-value">+34 097 8734 8</span>
  							</div>
  							<div class="col-xs-4">
  								<span class="profile-email-title">E-mail:</span>
  								<span class="clearfix"></span>
  								<span id="pEmail" class="profile-email-value">User@Mail.com</span>  								
  							</div>
  						</div>
  					</div>
				</div>		
          	</div>       
        </div><!-- /.row -->
      </div><!-- /#page-wrapper -->

    </div><!-- /#wrapper -->

		<!-- JavaScript -->
		<script src="js/jquery-1.10.2.js"></script>		
		<script src="js/bootstrap.js"></script>
		<script src="js/defaults.js"></script>
		<script>			
			var user = new User(<?php $user->echoData(); ?>);
			var profile = new Profile(<?php User::echoProfile($userID); ?>);
			Navbar.displayNavbar( user );					
		
			$( document ).ready(function() {
				user.displayName();				
				user.displayType();				
				user.displayAvatar();
				
				profile.displayProfile();
			});
		</script>

	</body>
</html>