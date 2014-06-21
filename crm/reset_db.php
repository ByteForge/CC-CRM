<?php
require_once "classes/initialize.php";

DatabaseData::resetUsers();
trace( "database: `users` resetted" );

DatabaseData::resetUserSessions();
trace( "database: `user_sessions` resetted" );

DatabaseData::resetActivities();
trace( "database: `activities` resetted" );

DatabaseData::resetTeams();
trace( "database: `teams` resetted" );

DatabaseData::resetProjects();
trace( "database: `projects` resetted" );

DatabaseData::resetTasks();
trace( "database: `tasks` resetted" );

DatabaseData::resetMessages();
trace( "database: `messages` resetted" );


?>