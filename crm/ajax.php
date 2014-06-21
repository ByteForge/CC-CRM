<?php
require_once "classes/initialize.php";
itrace( 1, "ajax.php" );
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

if( Post::itemExists("ajax") ) {
	itrace( 3 , "ajax was sent" );
	// PROJECTS
	if( Post::itemExists("new-project") ) {
		//itrace( 4 , "new project" . print_r(Post::getItem("new-project"), true) );
		itrace( 4 , "new project" );
		$post = Post::getItem("new-project");
		
		itrace( 5, print_r($post, true) );
		
		$projectID = Project::createProject($post);
		
		//itrace( 1, "projectID {$projectID}" );
		
		foreach ($post["tasks"] as $values) {
			$values["projectID"] = $projectID;
			itrace( 6, print_r( $task, true ) );
			
			Task::createTask($values);								
		}
		
	} else if( Post::itemExists("edit-project") ) {
			
		itrace( 4 , "edit project" );
		
		$post = Post::getItem("edit-project");
		
		itrace( 5, "edit-project". print_r($post, true) );
		
		Project::changeProject($post["projectID"], $post);
		
	} else if( Post::itemExists("delete-project") ) {
		itrace( 4 , "delete project" );
		
		$post = Post::getItem("delete-project");
		
		itrace( 5, print_r($post, true) );
		
		Project::deleteProject( $post["projectID"] );
	}
	// TASKS
		if( Post::itemExists("edit-task") ) {
			
			//itrace( 4 , "edit task" );
			
			$post = Post::getItem("edit-task");
			itrace( 5, "edit-task". print_r($post, true) );
			Task::changeTask($post["taskID"], $post);
			
		} else if( Post::itemExists("delete-task") ) {
				
			$post = Post::getItem("delete-task");
			itrace( 5, "delete-task". print_r($post, true) );
			Task::deleteTask($post["taskID"]);
		}
	// MESSAGES
		if( Post::itemExists("create-message") ) {
			
			//itrace( 4 , "edit task" );
			
			$post = Post::getItem("create-message");
			itrace( 5, "create-message". print_r($post, true) );
			Message::createMessage($post);			
			
		} else if( Post::itemExists("delete-message") ) {
				
			$post = Post::getItem("delete-message");
			itrace( 5, "delete-task". print_r($post, true) );
			Message::deleteMessage($post);
		} else if( Post::itemExists("toggle-message") ) {
				
			$post = Post::getItem("toggle-message");
			itrace( 5, "toggle-message". print_r($post, true) );
			Message::toggleMessage($post);
		}
		
	// USERS
		// new-user
		// edit-user		
		// delete-user		
} else {
	itrace( 3 , "ajax was not sent" );
}

?>