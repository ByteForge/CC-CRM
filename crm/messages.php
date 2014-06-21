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
		<link rel="stylesheet" href="css/bootstrap.css">

		<!-- Add custom CSS here -->
		<link rel="stylesheet" href="css/sb-admin.css">
		<!-- <link rel="stylesheet" href="font-awesome/css/font-awesome.min.css"> -->
		<link rel="stylesheet" href="css/overview.css">

	</head>
  
	<body class="body">

    <div id="wrapper">
		<?php include 'navigation.php'; ?>

      <div id="page-wrapper">
        <div class="row">
          	<div class="col-xs-12">			
				<div class="panel panel-warning">
  					<div class="panel-heading">
  						<div class="row">
  							<div class="col-xs-12">
  								<span class="glyphicon glyphicon-envelope overview-icon-size"></span>
  								<span class="overview-title">Messages</span>
  								<span class="pull-right">
  									<span class="message-all-title">All Messages:</span>
  									<span id="allMessages" class="message-all-value">0</span>
  								</span>
  							</div>  							
  						</div>
  					</div>
  					<div class="panel-body">
    					<div class="row">
    						<div class="col-xs-8 col-sm-6">
    							<ul class="nav nav-tabs">
								  <li class="active"><a href="#inbox" data-toggle="tab" class="message-inbox-title">Inbox</a></li>
								  <li><a href="#sent" data-toggle="tab" class="message-sent-title">Sent</a></li>								  
								</ul>
    						</div>
  							<div class="col-xs-4 col-sm-4">
  								<table class="table table-bordered">
		  							<tbody><tr><td>
		  								<div class="row">
		  									<div class="col-xs-6 text-center text-info">
		  										<span class="label label-warning">Unread</span>
		  										<span id="unreadValue" class="clearfix">0</span>
		  									</div>
		  									<div class="col-xs-6 text-center text-success">
		  										<span class="label label-danger">Issue</span>
		  										<span id="issueValue" class="clearfix">0</span>
		  									</div>		  									
		  								</div>
		  							</td></tr></tbody>
		  						</table>
  							</div>
  							<div class="col-xs-4 col-xs-offset-4 col-sm-2 col-sm-offset-0">  								
  								<button id="newMessageBtn" type="button" class="btn btn-warning btn-lg btn-block">
  									<span class="glyphicon glyphicon-envelope projects-add-project-icon"></span></button>
  							</div>
  						</div>
  						<div class="row" style="padding-top: 40px;">
  							<div class="col-xs-12">
  								<div class="tab-content">
								  <div id="inbox" class="tab-pane active">
								  		<table id="messageTemplate" class="table table-bordered" style="margin-bottom: 10px;">
				  							<tbody><tr><td>
				  								<div class="row">
				  									<div id="col1" class="col-xs-3">
				  										<span id="messageType" class="glyphicon message-entry-icon"></span>
				  										<span id="senderName" class="message-entry-sender">From - sender</span>				  										
				  									</div>
				  									<div id="col2" class="col-xs-4">
				  										<span id="subject" class="message-entry-subject">Subject</span>				  										
				  									</div>
				  									<div id="col3" class="col-xs-3 text-right">
				  										<span id="date" class="message-entry-date">Date</span>				  										
				  									</div>
				  									<div class="col-xs-2">
				  										<button id="deleteMessage" type="button" class="btn btn-danger"><span class="glyphicon glyphicon-remove"></span></button>				  										
				  										<button id="markMessage" type="button" class="btn btn-primary pull-right"><span class="glyphicon glyphicon-tag"></span></button>				  										
				  									</div>
				  								</div>
				  							</td></tr></tbody>
				  						</table>	
								  </div>
								  <div id="sent" class="tab-pane">
								  	
								  </div>								  
								</div>
  							</div>
  						</div>
  					</div>
				</div>		
          	</div>       
        </div><!-- /.row -->

      </div><!-- /#page-wrapper -->
      
      <!-- Modal -->
		<div class="modal fade" id="deleteMessageModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		  <div class="modal-dialog">
		    <div class="modal-content">
		      <div class="modal-header">
		        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		        <h4 class="modal-title" id="myModalLabel"><span class="glyphicon glyphicon-remove" style="padding-right: 35px;"></span>Delete Message</h4>
		      </div>
		      <div class="modal-body text-center">
		      	<span id="deleteModalText" class="project-modal-delete-text">Do you really want to delete message?</span>
		      	<span id="deleteModalSubject" class="project-modal-delete-name clearfix">Subject: Subjext Text</span>
		      	<span class="clearfix" style="font-size: 1.25em;">from</span>
		      	<span id="deleteModalSenderName" class="project-modal-delete-value clearfix">From: User Name</span>
		      </div>
		      <div class="modal-footer">
		        <button type="button" class="btn btn-primary pull-left" data-dismiss="modal">No</button>
		        <button id="deleteMessageModalBtn" type="button" class="btn btn-danger">Yes, delete the message</button>
		      </div>
		    </div><!-- /.modal-content -->
		  </div><!-- /.modal-dialog -->
		</div><!-- /.modal -->
		
	<div class="modal fade" id="newMessageModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		  <div class="modal-dialog">
		    <div class="modal-content">
		      <div class="modal-header">
		        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		        <h4 class="modal-title" id="myModalLabel"><span class="glyphicon glyphicon-envelope" style="padding-right: 35px;"></span>New Message</h4>
		      </div>
		      <div class="modal-body">		      		
		      		<div class="row">		      					      				
	  					<div class="col-xs-10 col-xs-offset-1" style="padding-bottom: 25px;">
							<span class="label label-danger">Recipient</span>
							<select id="recipientID" class="form-control">										
							</select>
						</div>		
		      		</div>
		      		<div class="row">
		      			<div class="col-xs-8 col-xs-offset-1" style="padding-bottom: 50px;">
							<div class="input-group">
  								<span class="input-group-addon">Subject</span>
  								<input id="messageSubject" type="text" class="form-control" placeholder="">
							</div>
						</div>
						<div class="col-xs-3">
							<div class="btn-group">
								<span class="label label-primary">Type</span>
							  <button id="messageTypeBtn" type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
							    <span id="messageTypeLabel">Normal</span><span class="caret"></span>
							  </button>
							  <ul id="messageTypeList" class="dropdown-menu" role="menu">
							    <li><a href="#">Normal</a></li>
							    <li><a href="#">Issue</a></li>							    
							  </ul>
							</div>
						</div>
		      		</div>
		      		<div class="row">
		      			<div class="col-xs-10 col-xs-offset-1">
		      				<textarea id="messageText" class="form-control" rows="10"></textarea>
		      			</div>
		      		</div>				
		      </div>
		      <div class="modal-footer">
		        <button type="button" class="btn btn-primary pull-left" data-dismiss="modal">Close</button>
		        <button id="sendMessageBtn" type="button" class="btn btn-primary">Send</button>
		      </div>
		    </div><!-- /.modal-content -->
		  </div><!-- /.modal-dialog -->
		</div><!-- /.modal -->
		
		<div class="modal fade" id="viewMessageModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		  <div class="modal-dialog">
		    <div class="modal-content">
		      <div class="modal-header">
		        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		        <h4 class="modal-title" id="myModalLabel"><span class="glyphicon glyphicon-envelope" style="padding-right: 35px;"></span>View Message</h4>
		      </div>
		      <div class="modal-body">		      		
		      		<div class="row">		      					      				
	  					<div class="col-xs-10 col-xs-offset-1" style="padding-bottom: 25px;">
							<span class="label label-danger">Sender</span>
							<input id="viewMessageRecipient" type="text" class="form-control" placeholder="">
						</div>		
		      		</div>
		      		<div class="row">
		      			<div class="col-xs-10 col-xs-offset-1" style="padding-bottom: 10px;">
							<div class="input-group">
  								<span class="input-group-addon">Subject</span>
  								<input id="viewMessageSubject" type="text" class="form-control" placeholder="">
							</div>
						</div>
						<div class="col-xs-4 col-xs-offset-7" style="padding-bottom: 10px;">
							<div class="input-group">
  								<span class="label label-primary">Type</span>
  								<input id="viewMessageType" type="text" class="form-control" placeholder="">
							</div>
						</div>						
		      		</div>
		      		<div class="row">
		      			<div class="col-xs-10 col-xs-offset-1">
		      				<textarea id="viewMessageText" class="form-control" rows="10"></textarea>
		      			</div>
		      		</div>				
		      </div>
		      <div class="modal-footer">
		        <button id="viewMessageCloseBtn" type="button" class="btn btn-primary" data-dismiss="modal">Close</button>		        
		      </div>
		    </div><!-- /.modal-content -->
		  </div><!-- /.modal-dialog -->
		</div><!-- /.modal -->

    </div><!-- /#wrapper -->

		<!-- JavaScript -->
		<script src="js/jquery-1.10.2.js"></script>		
		<script src="js/bootstrap.js"></script>
		
		<script src="js/defaults.js"></script>
		<script>			
			var user = new User(<?php $user->echoData(); ?>);
			var clients = Member.parseMembers(<?php User::echoClients($userID) ?>);
			var owners = Member.parseMembers(<?php User::echoOwners($userID) ?>);
			var messages = Message.parseMessages(<?php Message::echoMessages($userID); ?>);
			Message.user = user;
			Navbar.displayNavbar( user );					
		
			CLIENTS_CACHE = clients;							
			OWNERS_CACHE = owners;
		
			//alert(messages);
		
			$( document ).ready(function() {
				user.displayName();				
				user.displayType();				
				user.displayAvatar();
				
				Message.displayMessages(messages);						
			});
		</script>

	</body>
</html>