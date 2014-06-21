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

//User::echoOwners($userID);
//User::echoClients($userID);

//$u = User::getUserByName("James", "Donovan")->getID();
//$u = User::getUserByName("Main", "Administrator")->getID();

//Project::echoProjects($u);

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
		<link rel="stylesheet" href="http://cdn.oesmith.co.uk/morris-0.4.3.min.css">
		<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css">
		<link rel="stylesheet" href="css/spectrum.css">
		
		<!-- <link rel="stylesheet" href="font-awesome/css/font-awesome.min.css"> -->
		<link rel="stylesheet" href="css/overview.css">

	</head>
  
	<body class="body">

    <div id="wrapper">
		<?php include 'navigation.php'; ?>

      <div id="page-wrapper">
        <div class="row">
          	<div class="col-xs-12">			
				<div class="panel panel-primary">
  					<div class="panel-heading">
  						<div class="row">
  							<div class="col-xs-12">
  								<span class="glyphicon glyphicon-folder-open overview-icon-size"></span>
  								<span class="projects-title">Projects</span>
  								<span class="projects-all-projects">
  									All projects:<span id="allProjectsValue" class="projects-all-projects-value">0</span>
  								</span>
  							</div>  							
  						</div>
  					</div>
  					<div class="panel-body">
  						<div class="row">
  							<div class="col-md-8">
  								<table class="table table-bordered">
		  							<tbody><tr><td>
		  								<div class="row">
		  									<div class="col-xs-3 text-center text-info">
		  										<span id="ongoingProjectsLabel" class="label label-info">Ongoing</span>
		  										<span id="ongoingProjectsValue" class="projects-header-value clearfix">0</span>
		  									</div>
		  									<div class="col-xs-3 text-center text-success">
		  										<span id="completedProjectsLabel" class="label label-success">Completed</span>
		  										<span id="completedProjectsValue" class="projects-header-value clearfix">0</span>
		  									</div>
		  									<div class="col-xs-3 text-center text-danger">
		  										<span id="canceledProjectsLabel" class="label label-danger">Canceled</span>
		  										<span id="canceledProjectsValue" class="projects-header-value clearfix">0</span>
		  									</div>
		  									<div class="col-xs-3 text-center text-warning">
		  										<span id="archivedProjectsLabel" class="label label-warning">Archived</span>
		  										<span id="archivedProjectsValue" class="projects-header-value clearfix">0</span>
		  									</div>
		  								</div>
		  							</td></tr></tbody>
		  						</table>
  							</div>
  							<div class="col-md-4">
  								<button id="newProjectBtn" type="button" class="btn btn-primary btn-lg btn-block">
  									<span class="glyphicon glyphicon-plus projects-add-project-icon"></span> New Project
  								</button>
  							</div>
  						</div>  						
  						<div class="row" style="padding-top: 10px;">
  							<div id="projectsContainer" class="col-xs-12">
  								
  								<table id="projectsTemplate" class="table table-bordered"><tr><td>  									  										
  									<div id="projectPriority" class="col-xs-1 project-entry-priority"></div>
  									<div class="col-xs-3"><span id="projectName" class="project-entry-project-name">Project Name</span></div>
  									<div class="col-xs-2 text-right"><span id="projectID" class="project-entry-project-id">ProjectID</span></div>
  									<div class="col-xs-3 text-right"><span id="projectClientName" class="project-entry-project-client-name">Client Name</span></div>
  									<div class="col-xs-3">
  										<div class="pull-right">
  											<button id="projectRemoveBtn" type="button" class="btn btn-danger"><span class="glyphicon glyphicon-remove"></span></button>
  											<button id="projectMessageBtn" type="button" class="btn btn-warning"><span class="glyphicon glyphicon-envelope"></span></button>
  											<button id="projectEditBtn" type="button" class="btn btn-primary"><span class="glyphicon glyphicon-pencil"></span></button>
  										</div>
  									</div>  									
  									<div class="row">  										
  										<div class="col-xs-8 col-xs-offset-2">
  											<span id="projectDescription" class="project-entry-project-description">Description</span>
  										</div>  										
  									</div>
  									<div class="row">
  										<div class="col-xs-6 text-center">
  											<span class="label label-success">Start Date</span>
  											<span id="projectStartDate" class="project-entry-project-start-date clearfix">2014-05-11</span>
  										</div>
  										<div class="col-xs-6 text-center">
  											<span class="label label-danger">End Date</span>
  											<span id="projectEndDate" class="project-entry-project-end-date clearfix">2014-12-11</span>
  										</div>
  									</div>
  									<div id="tasksContainer" class="row" style="padding-top: 15px;">
  										<div id="tasksTemplate" class="row">  											
	  										<div id="taskPriority" class="col-xs-1 col-xs-offset-1 task-entry-task-priority"></div>
	  										<div class="col-xs-3"><span id="taskName" class="task-entry-task-name">Task Name</span></div>
	  										<div class="col-xs-3">
	  											<div class="progress progress-striped"><div id="taskProgressBar" class="progress-bar" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width: 100%;"></div></div>
	  										</div>
	  										<div class="col-xs-2 text-right"><span id="taskOwnerName" class="task-entry-task-owner">Owner</span></div>
	  										<div class="col-xs-1 text-right">
	  											<button id="taskEditBtn" type="button" class="btn btn-primary btn-sm"><span class="glyphicon glyphicon-pencil"></span></button>
	  										</div>
  										</div>
  									</div>
  								</td></tr></table>
  								
	  						</div>
  						</div>  						
  					</div>
				</div>			
          	</div>       
        </div><!-- /.row -->

      </div><!-- /#page-wrapper -->
      
		<!-- Modal -->
		<div class="modal fade" id="editProjectModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		  <div class="modal-dialog">
		    <div class="modal-content">
		      <div class="modal-header">
		        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		        <h4 class="modal-title" id="myModalLabel"><span class="glyphicon glyphicon-pencil" style="padding-right: 35px;"></span>Edit Project</h4>
		      </div>
		      <div class="modal-body">
		      		<div class="row">
		      			<div class="col-xs-12">
		      				<div class="input-group modal-spacing">
  								<span class="input-group-addon">Name</span>
  								<input id="editProjectName" type="text" class="form-control" placeholder="Project name">
							</div>	
		      			</div>
		      			<div class="col-xs-12">		
		      				<div class="input-group modal-spacing">
  								<span class="input-group-addon">Description</span>
  								<textarea id="editProjectDescription" class="form-control" placeholder="Project description" rows="3"></textarea>
							</div>
						</div>
						<div class="col-xs-6">
							<div class="input-group modal-spacing">
		  						<span class="input-group-addon">Start Date</span>
		  						<input id="editStartDate" type="text" class="form-control" placeholder="Pick a start date">
							</div><!-- /input-group -->
						</div>	      			
						<div class="col-xs-6">
							<div class="input-group modal-spacing">
		  						<span class="input-group-addon">End Date</span>
		  						<input id="editEndDate" type="text" class="form-control" placeholder="Pick an end date">
							</div><!-- /input-group -->
						</div>
						<div class="col-xs-6">
							<div class="btn-group">
								<span class="label label-info">Priority</span>
							  <button id="editPriorityBtn" type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
							    <span id="editPriorityLabel">Normal</span><span class="caret"></span>
							  </button>
							  <ul id="editPriorityList" class="dropdown-menu" role="menu">
							    <li><a href="#">Zero</a></li>
							    <li><a href="#">Low</a></li>
							    <li><a href="#">Normal</a></li>
							    <li><a href="#">High</a></li>
							    <li><a href="#">Super</a></li>
							  </ul>
							</div>
						</div>
						<div class="col-xs-6">
							<div class="btn-group">
								<span class="label label-primary">Status</span>
							  <button id="editStatusBtn" type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
							    <span id="editStatusLabel">Ongoing</span><span class="caret"></span>
							  </button>
							  <ul id="editStatusList" class="dropdown-menu" role="menu">
							    <li><a href="#">Ongoing</a></li>
							    <li><a href="#">Canceled</a></li>
							    <li><a href="#">Completed</a></li>
							    <li><a href="#">Archived</a></li>							    
							  </ul>
							</div>
						</div>
						<div class="col-xs-6">
							<span class="label label-success">Client</span>
							<select id="editClientID" class="form-control">								
							</select>
						</div>
						<div class="col-xs-6">
							<span class="label label-danger">Owner</span>
							<select id="editOwnerID" class="form-control">								
							</select>
						</div>
		      		</div>		      					
		      </div>
		      <div class="modal-footer">
		        <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">Close</button>
		        <button id="saveEditProjectBtn" type="button" class="btn btn-primary">Save Project</button>
		      </div>
		    </div><!-- /.modal-content -->
		  </div><!-- /.modal-dialog -->
		</div><!-- /.modal -->
		
		<!-- Modal -->
		<div class="modal fade" id="deleteProjectModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		  <div class="modal-dialog">
		    <div class="modal-content">
		      <div class="modal-header">
		        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		        <h4 class="modal-title" id="myModalLabel"><span class="glyphicon glyphicon-remove" style="padding-right: 35px;"></span>Delete Project</h4>
		      </div>
		      <div class="modal-body text-center">
		      	<span id="deleteModalText" class="project-modal-delete-text">Do you really want to delete project?</span>
		      	<span id="deleteModalName" class="project-modal-delete-name clearfix">Name: Project Name</span>
		      	<span id="deleteModalValue" class="project-modal-delete-value clearfix">ID: 600</span>
		      </div>
		      <div class="modal-footer">
		        <button type="button" class="btn btn-primary pull-left" data-dismiss="modal">No</button>
		        <button id="deleteProjectModalBtn" type="button" class="btn btn-danger">Yes, delete the project</button>
		      </div>
		    </div><!-- /.modal-content -->
		  </div><!-- /.modal-dialog -->
		</div><!-- /.modal -->

	<div class="modal fade" id="newProjectModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		  <div class="modal-dialog">
		    <div class="modal-content">
		      <div class="modal-header">
		        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		        <h4 class="modal-title" id="myModalLabel"><span class="glyphicon glyphicon-folder-open" style="padding-right: 35px;"></span>New Project</h4>
		      </div>
		      <div class="modal-body">
		      		<div class="row">
		      			<div class="col-xs-12">
		      				<div class="input-group modal-spacing">
  								<span class="input-group-addon">Name</span>
  								<input id="newProjectName" type="text" class="form-control" placeholder="Project name">
							</div>	
		      			</div>
		      			<div class="col-xs-12">		
		      				<div class="input-group modal-spacing">
  								<span class="input-group-addon">Description</span>
  								<textarea id="newProjectDescription" class="form-control" placeholder="Project description" rows="3"></textarea>
							</div>
						</div>
						<div class="col-xs-6">
							<div class="input-group modal-spacing">
		  						<span class="input-group-addon">Start Date</span>
		  						<input id="newStartDate" type="text" class="form-control" placeholder="Pick a start date">
							</div><!-- /input-group -->
						</div>	      			
						<div class="col-xs-6">
							<div class="input-group modal-spacing">
		  						<span class="input-group-addon">End Date</span>
		  						<input id="newEndDate" type="text" class="form-control" placeholder="Pick an end date">
							</div><!-- /input-group -->
						</div>
						<div class="col-xs-6">
							<div class="btn-group">
								<span class="label label-info">Priority</span>
							  <button id="priorityBtn" type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
							    <span id="priorityLabel">Normal</span><span class="caret"></span>
							  </button>
							  <ul id="priorityList" class="dropdown-menu" role="menu">
							    <li><a href="#">Zero</a></li>
							    <li><a href="#">Low</a></li>
							    <li><a href="#">Normal</a></li>
							    <li><a href="#">High</a></li>
							    <li><a href="#">Super</a></li>
							  </ul>
							</div>
						</div>
						<div class="col-xs-6">
							<div class="btn-group">
								<span class="label label-primary">Status</span>
							  <button id="statusBtn" type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
							    <span id="statusLabel">Ongoing</span><span class="caret"></span>
							  </button>
							  <ul id="statusList" class="dropdown-menu" role="menu">
							    <li><a href="#">Ongoing</a></li>
							    <li><a href="#">Canceled</a></li>
							    <li><a href="#">Completed</a></li>
							    <li><a href="#">Archived</a></li>							    
							  </ul>
							</div>
						</div>
						<div class="col-xs-6">
							<span class="label label-success">Client</span>
							<select id="newClientID" class="form-control">								
							</select>
						</div>
						<div class="col-xs-6">
							<span class="label label-danger">Owner</span>
							<select id="newOwnerID" class="form-control">								
							</select>
						</div>
		      		</div>
		      		<div class="row">
		      			<hr />
		      			<div class="col-xs-12">
		      				<button id="addTask" type="button" class="btn btn-primary btn-block">Add Task</button>
		      			</div>		      			
		      			<div id="newTaskContainer" class="row">
		      				<div id="newTaskEntry">		      					
		      					<div class="col-xs-10 col-xs-offset-1">
		      						<hr />
		      					</div>
		      					<div class="col-xs-8 col-xs-offset-1">
			      					<div class="input-group modal-spacing">
	  									<span class="input-group-addon">Name</span>
	  									<input id="taskName" type="text" class="form-control" placeholder="Task name">
									</div>									
			      				</div>
			      				<div class="col-xs-2">
			      					<button id="deleteTask" type="button" class="btn btn-danger">Delete</button>
		      					</div>
		      					<div class="col-xs-10 col-xs-offset-1">
			      					<div class="input-group modal-spacing">
  										<span class="input-group-addon">Description</span>
  										<textarea id="taskDescription" class="form-control" placeholder="Task description" rows="3"></textarea>
									</div>									
			      				</div>
								<div class="col-xs-5 col-xs-offset-1">
									<div class="btn-group">
										<span class="label label-info">Priority</span>
									  <button id="taskPriorityBtn" type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
											<span id="taskPriorityLabel">Normal</span><span class="caret"></span>
									  </button>
									  <ul id="taskPriorityList" class="dropdown-menu" role="menu">
									    <li><a href="#">Zero</a></li>
									    <li><a href="#">Low</a></li>
									    <li><a href="#">Normal</a></li>
									    <li><a href="#">High</a></li>
									    <li><a href="#">Super</a></li>
									  </ul>
									</div>
								</div>
								<div class="col-xs-5">
									<div class="btn-group">
										<span class="label label-primary">Status</span>
									  <button id="taskStatusBtn" type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
									    <span id="taskStatusLabel">Ongoing</span><span class="caret"></span>
									  </button>
									  <ul id="taskStatusList" class="dropdown-menu" role="menu">
									    <li><a href="#">Ongoing</a></li>
									    <li><a href="#">Canceled</a></li>
									    <li><a href="#">Completed</a></li>
									    <li><a href="#">Archived</a></li>							    
									  </ul>
									</div>	
								</div>		      								
								<div class="col-xs-8 col-xs-offset-2">
									<h4><span class="label label-success">Progress</span></h4>									
									<div id="taskSlider"></div>
									<div style="margin: 20px;"></div>
								</div>
								<div class="col-xs-5 col-xs-offset-3">
									<span class="label label-danger">Owner</span>
									<select id="taskOwnerID" class="form-control">										
									</select>
								</div>		      								
		      				</div>		      								
		      			</div>				
		      		</div>				
		      </div>
		      <div class="modal-footer">
		        <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">Close</button>
		        <button id="saveProjectBtn" type="button" class="btn btn-primary">Save New Project</button>
		      </div>
		    </div><!-- /.modal-content -->
		  </div><!-- /.modal-dialog -->
		</div><!-- /.modal -->
		
		<div class="modal fade" id="editTaskModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		  <div class="modal-dialog">
		    <div class="modal-content">
		      <div class="modal-header">
		        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		        <h4 class="modal-title" id="myModalLabel"><span class="glyphicon glyphicon-folder-open" style="padding-right: 35px;"></span>Edit Task</h4>
		      </div>
		      <div class="modal-body">		      		
		      		<div class="row">
		      			<div id="newTaskContainer" class="row">
		      				<div id="newTaskEntry">		      					
		      					<div class="col-xs-10 col-xs-offset-1">
			      					<div class="input-group modal-spacing">
	  									<span class="input-group-addon">Name</span>
	  									<input id="taskName" type="text" class="form-control" placeholder="Task name">
									</div>									
			      				</div>
			      				<div class="col-xs-10 col-xs-offset-1">
			      					<div class="input-group modal-spacing">
  										<span class="input-group-addon">Description</span>
  										<textarea id="taskDescription" class="form-control" placeholder="Task description" rows="3"></textarea>
									</div>									
			      				</div>
								<div class="col-xs-5 col-xs-offset-1">
									<div class="btn-group">
										<span class="label label-info">Priority</span>
									  <button id="taskPriorityBtn" type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
											<span id="taskPriorityLabel">Normal</span><span class="caret"></span>
									  </button>
									  <ul id="taskPriorityList" class="dropdown-menu" role="menu">
									    <li><a href="#">Zero</a></li>
									    <li><a href="#">Low</a></li>
									    <li><a href="#">Normal</a></li>
									    <li><a href="#">High</a></li>
									    <li><a href="#">Super</a></li>
									  </ul>
									</div>
								</div>
								<div class="col-xs-5">
									<div class="btn-group">
										<span class="label label-primary">Status</span>
									  <button id="taskStatusBtn" type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
									    <span id="taskStatusLabel">Ongoing</span><span class="caret"></span>
									  </button>
									  <ul id="taskStatusList" class="dropdown-menu" role="menu">
									    <li><a href="#">Ongoing</a></li>
									    <li><a href="#">Canceled</a></li>
									    <li><a href="#">Completed</a></li>
									    <li><a href="#">Archived</a></li>							    
									  </ul>
									</div>	
								</div>		      								
								<div class="col-xs-8 col-xs-offset-2">
									<h4><span class="label label-success">Progress</span></h4>									
									<div id="taskSlider"></div>
									<div style="margin: 20px;"></div>
								</div>
								<div class="col-xs-5 col-xs-offset-3">
									<span class="label label-danger">Owner</span>
									<select id="taskOwnerID" class="form-control">										
									</select>
								</div>		      								
		      				</div>		      								
		      			</div>				
		      		</div>				
		      </div>
		      <div class="modal-footer">
		        <button type="button" class="btn btn-primary pull-left" data-dismiss="modal">Close</button>
		        <button id="deleteTaskBtn" type="button" class="btn btn-danger">Delete Task</button>
		        <button id="editTaskBtn" type="button" class="btn btn-primary">Save Task</button>
		      </div>
		    </div><!-- /.modal-content -->
		  </div><!-- /.modal-dialog -->
		</div><!-- /.modal -->
		
		<div class="modal fade" id="messageModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
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

    </div><!-- /#wrapper -->

		<!-- JavaScript -->
		<script src="js/jquery-1.10.2.js"></script>
		<script src="http://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>		
		<script src="js/bootstrap.js"></script>
		
		<script src="js/defaults.js"></script>
		<script>			
			var user = new User(<?php $user->echoData(); ?>);
			var clients = Member.parseMembers(<?php User::echoClients($userID) ?>);
			var owners = Member.parseMembers(<?php User::echoOwners($userID) ?>);
			var projects = Project.parseProjects(<?php Project::echoProjects($userID) ?>);
			var projectsPage = new ProjectsPage({
				"user": user,
				"projects": projects
			});
			ProjectsPage.user = user;
			ProjectsPage.projects = projects;
			
			CLIENTS_CACHE = clients;							
			OWNERS_CACHE = owners;
			PROJECTS - projects;
			Navbar.displayNavbar( user );					
					
			$( document ).ready(function() {
				user.displayName();				
				user.displayType();				
				user.displayAvatar();
								
				projectsPage.displayProjects();
				projectsPage.initializeEditor();										
			});
		</script>

	</body>
</html>