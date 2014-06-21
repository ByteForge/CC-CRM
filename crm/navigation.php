<?php
$navigation = <<<HTML

      <!-- Sidebar -->
      <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
      	<button class="btn btn-danger dev-btn"></button>
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
         	<a class="navbar-brand" href="projects.php"><img class="brand-logo" src="img/crm_logo_sm.png" alt="logo">
        		<span class="brand-style">Construct Council CRM</span>        		
        	</a>          
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse navbar-ex1-collapse" id="nav-collapse">
          <ul class="nav navbar-nav side-nav" id="sideNavbar">
            
          </ul>

          <ul class="nav navbar-nav navbar-right">
          	
                      
            <li class="dropdown">
				<a href="#" class="dropdown-toggle" data-toggle="dropdown"><span id="userNameDefault">User Name</span> <b class="caret"></b></a>
              	<ul class="dropdown-menu">
              		<li id="userType" class="dropdown-header text-center">User Type</li>	                
              		<li class="divider"></li>
              		<!-- <li class="text-center"><span class="avatar"><img src="http://placehold.it/128x128"></span></li> -->
              		<li class="text-center"><span class="avatar"><img id="userAvatar" src="img/avatars/none.jpg"></span></li>
              		<li class="divider"></li>
	                <li><a href="profile.php"><span class="glyphicon glyphicon-user icon-spacing"></span>Profile</a></li>
	                <li class="divider"></li>
	                <li><a href="sign_out.php"><span class="glyphicon glyphicon-off icon-spacing"></span>Sign Out</a></li>
              	</ul>
            </li>
          </ul>
        </div><!-- /.navbar-collapse -->
      </nav>
HTML;
echo $navigation;
?>