function trace() {
    var r = "";
    for( var i=0, L=arguments.length, b=L-1; i < L; ++i ) {
        r += arguments[i];
        if( i < b ) {
            r += ", ";
        } 
    }
    console.log( r );
}
function itrace( indentation ) {
    if( indentation ) {
        if( indentation < 0 ) {
            indentation = 0;
        }
    } else {
        indentation = 0;
    }
    
    var r = "";
    while( indentation-- ) {
        r += "\t";
    }
    
    for( var i=1, L=arguments.length, b=L-1; i < L; ++i ) {
        r += arguments[i];
        if( i < b ) {
            r += ", ";
        } 
    }
    console.log( r );
}


// STATUSES
var STATUS_ONGOING = 1;
var STATUS_CANCELED = 2;
var STATUS_COMPLETED = 3;
var STATUS_ARCHIVED = 4;

// PRIORITIES
var PRIORITY_ZERO = 1;
var PRIORITY_LOW = 2;
var PRIORITY_NORMAL = 3;
var PRIORITY_HIGH = 4;
var PRIORITY_SUPER = 5;

// USER TYPES
var USER_NONE = 0;
var USER_ADMINISTRATOR = 1;
var USER_PROJECT_OWNER = 2;
var USER_TASK_OWNER = 3;
var USER_CUSTOMER = 4;

// MESSAGE TYPES
var MESSAGE_NORMAL = 1;
var MESSAGE_ISSUE = 2;

// PROJECT CACHE
PROJECT_CACHE = null;

OWNERS_CACHE = null;
CLIENTS_CACHE = null;

PROJECTS = null;

function biasProgressBar( value, bias ) {
    bias = ( bias ) ? bias : 1;
    value = value * bias;
    if( value > 100 ) {
        value = 100;
    }
    return Math.round(value);
}
function getUID() {
    var min = 0;
    var max = 999999;    
    return Math.floor(Math.random() * (max - min + 1)) + min;
}
function rand( min, max ) {
    return Math.floor(Math.random() * (max - min + 1)) + min;
}

function getRandomPriority() {
    return rand( 1, 5 );
}
function getRandomStatus() {
    return rand( 1, 6 );
}
function getRandomPercent() {
    var value = rand(0,101);
    return value < 100 ? value : 100;
}
function getPriorityByLabel( label ) {
    switch( label ) {
        case "Zero":return PRIORITY_ZERO;
        case "Low":return PRIORITY_LOW;
        case "High":return PRIORITY_HIGH;
        case "Super":return PRIORITY_SUPER;
        default: return PRIORITY_NORMAL;
    }
};
function getStatusByLabel( label ) {
    switch( label ) {
        case "Completed":return STATUS_COMPLETED;
        case "Canceled":return STATUS_CANCELED;
        case "Archived":return STATUS_ARCHIVED;
        default: return STATUS_ONGOING;
    }
};
function getProrityName( id ) {
    id = parseInt(id);
    switch(id) {
        case PRIORITY_ZERO: return "Zero"; break;
        case PRIORITY_LOW: return "Low"; break;
        case PRIORITY_HIGH: return "High"; break;
        case PRIORITY_SUPER: return "Super"; break;
        default: return "Normal"; break;
    }
}
function getStatusName( id ) {
    id = parseInt(id);
    switch(id) {
        case STATUS_COMPLETED: return "Completed"; break;
        case STATUS_CANCELED: return "Canceled"; break;
        case STATUS_ARCHIVED: return "Archived"; break;
        default: return "Ongoing"; break;
    }
}

function getProjectPriorityClass( priority ) {
    var cssClass = "project-entry-priority-";            
    priority = parseInt(priority);
    //trace("priority:", priority);
    switch( priority ) {
        case PRIORITY_ZERO:
            cssClass += "zero";
            break;
        case PRIORITY_LOW:
            cssClass += "low";
            break;
        case PRIORITY_HIGH:
            cssClass += "high";
            break;
        case PRIORITY_SUPER:
            cssClass += "super";
            break;
        default:
            cssClass += "normal";
            break;
    }
    return cssClass;
}
function getProjectStatusClass( status ) {
    var cssClass = "project-entry-status-";            
    status = parseInt(status);
    switch( status ) {
        case STATUS_COMPLETED:        
            cssClass += "completed";
            break;
        case STATUS_CANCELED:        
            cssClass += "canceled";
            break;
        case STATUS_ARCHIVED:        
            cssClass += "archived";
            break;
        default:
            cssClass += "ongoing";
            break;
    }
    return cssClass;
}

function getTaskPriorityClass( priority ) {
    var cssClass = "task-entry-priority-";            
    priority = parseInt(priority);
    switch( priority ) {
        case PRIORITY_ZERO:
            cssClass += "zero";
            break;
        case PRIORITY_LOW:
            cssClass += "low";
            break;
        case PRIORITY_HIGH:
            cssClass += "high";
            break;
        case PRIORITY_SUPER:
            cssClass += "super";
            break;
        default:
            cssClass += "normal";
            break;
    }
    return cssClass;
}
function getTaskStatusClass( status ) {
    var cssClass = "progress-bar-";            
    status = parseInt(status);
    switch( status ) {
        case STATUS_COMPLETED:        
            cssClass += "info";
            break;
        case STATUS_CANCELED:        
            cssClass += "danger";
            break;
        case STATUS_ARCHIVED:        
            cssClass += "warning";
            break;
        default:
            cssClass += "primary";
            break;
    }
    return cssClass;
}



// NAVBAR
function Navbar( object ) {
	if( object ) {
    	this["-"] = object;
    }
};
	Navbar.displayNavbar = function( user ) {
		var divider = '<li class="sidebar-divider"></li>';		
		var overview = '<li><a href="overview.php"><span class="glyphicon glyphicon-th-large icon-spacing"></span>Overview</a></li>';
		var activities = '<li><a href="activities.php"><span class="glyphicon glyphicon-transfer icon-spacing"></span>Activities</a></li>';
		var projects = '<li><a href="projects.php"><span class="glyphicon glyphicon-folder-open icon-spacing"></span>Projects</a></li>';
		var tasks = '<li><a href="tasks.php"><span class="glyphicon glyphicon-list icon-spacing"></span>Tasks</a></li>';
		var messages = '<li><a href="messages.php"><span class="glyphicon glyphicon-envelope icon-spacing"></span>Messages</a></li>';
		var calendar = '<li><a href="calendar.php"><span class="glyphicon glyphicon-calendar icon-spacing"></span>Calendar</a></li>';
		var project_templates = '<li><a href="project_templates.php"><span class="glyphicon glyphicon-list icon-spacing"></span>Project templates</a></li>';
		var task_templates = '<li><a href="task_templates.php"><span class="glyphicon glyphicon-folder-open icon-spacing"></span>Tasks Templates</a></li>';
		var profile = '<li><a href="profile.php"><span class="glyphicon glyphicon-user icon-spacing"></span>Profile</a></li>';
		
		var users = '<li><a href="users.php"><span class="glyphicon glyphicon-list-alt icon-spacing"></span>Users</a></li>';
		var teams = '<li><a href="teams.php"><span class="glyphicon glyphicon-asterisk icon-spacing"></span>Teams</a></li>';
		var system = '<li><a href="system.php"><span class="glyphicon glyphicon-transfer icon-spacing"></span>System</a></li>';
		
		var nb = $("#sideNavbar");
								
		switch( user.getType() ) {
    		case 1: // Administrator
    				nb.html(
    					divider +
    					projects +
    					divider +
    					messages +
    					divider +
    					profile
    					/*
    					divider +
    					users + teams + system
    					*/
    				);
    			break;
    		case 2: // Project Owner
    				nb.html(
    					divider +
    					divider +
    					projects +
    					divider +
    					messages +
    					divider +
    					profile    					
    				);
    			break;
    		case 3: // Task Owner"
    				nb.html(
    					divider +
    					projects +
    					divider +
    					messages +
    					divider +
    					profile    					
    				);
    			break;
    		case 4: // Customer"
    				nb.html(
    					divider +
    					projects +
    					divider +
    					messages +
    					divider +
    					profile    					
    				);
    			break;
    		default: return "Unknown Type";
    	}
    	
    	var pathname = window.location.pathname.toString().split("/");
    	pathname = pathname[ pathname.length-1 ];
    	
    	$('#sideNavbar li a').each(function(){
    		if( $(this).attr('href') === pathname ) {
    			var li = $(this).parent();
    			li.addClass( "active" );
    			
    		}
		});    	
	};

// USER
function User( json ) {
    var obj = jQuery.parseJSON( json );    
    if( obj ) {
    	this["-"] = obj;
    }
    /*
    this["-"] = {
        "firstName" : firstName,
        "lastName" : lastName                                  
    };
    */
    //this._firstName = firstName;
    //this._lastName = lastName;                
};
	User.getUsers = function( json ) {
		//alert( json );
		var users = jQuery.parseJSON( json );
		//alert( users );
		return users;
	};
	User.prototype.getID = function() {
	    return this["-"].userID;
	};
	User.prototype.getAvatar = function() {
	    return this["-"].avatar;
	};
	User.prototype.getFirstName = function() {
	    return this["-"].firstName;
	};
	User.prototype.getLastName = function() {
	    return this["-"].lastName;
	};            
	User.prototype.getFullName = function() {
	    return this["-"].firstName +" "+ this["-"].lastName;
	};
	User.prototype.getType = function() {
	    return this["-"].type;
	};
	User.prototype.getTypeName = function() {
	    switch( this["-"].type ) {
	    	case 1: return "Administrator";
	    	case 2: return "Project Owner";
	    	case 3: return "Task Owner";
	    	case 4: return "Customer";
	    	default: return "Unknown Type";
	    }
	};
	User.prototype.displayName = function() {
	    $("#userNameDefault").html( this.getFullName() );
	};
	User.prototype.displayType = function() {
	    $("#userType").html( this.getTypeName() );
	};
	User.prototype.displayAvatar = function() {
	    
	    var avatar = this["-"].avatar;
	    var src = "img/avatars/";
	    
	    if( avatar !== "-" ) {
	    	src += avatar;
	    } else {
	    	src += "none.jpg";
	    }
	    
	    $("#userAvatar").attr( "src", src );
	};

// OVERVIEW
function Overview( projects, tasks ) {
    this["-"] = {};
    var t = this["-"];
    var obj = null;
    
    if( projects ) {
        var obj = jQuery.parseJSON( projects );
        if( obj ) {
            t["projects"] = obj;
        }                
        obj = null;
    }
    
    if( tasks ) {
        var obj = jQuery.parseJSON( tasks );
        if( obj ) {
            t["tasks"] = obj;
        }                
        obj = null;    
    }    
};
Overview.prototype.displayProjects = function() {
    var t = this["-"];
    
    var all = t["projects"].all;
    var ongoing = t["projects"].ongoing;
    var completed = t["projects"].completed;
    var canceled = t["projects"].canceled;
    var archived = t["projects"].archived;
    
    var pOngoing = Math.round((ongoing/all)*100);    
    var pCompleted = Math.round((completed/all)*100);
    var pCanceled = Math.round((canceled/all)*100);
    var pArchived = Math.round((archived/all)*100);
    
    var bias = 1.25;
    pOngoing = biasProgressBar( pOngoing, bias );
    pCompleted = biasProgressBar( pCompleted, bias );
    pCanceled = biasProgressBar( pCanceled, bias );
    pArchived = biasProgressBar( pArchived, bias );
    
    $("#projectsAll").html( all );
    $("#projectsOngoing").html( ongoing );    
    $("#projectsOngoingProgress").css("width",pOngoing+"%");
    $("#projectsCompleted").html( completed );    
    $("#projectsCompletedProgress").css("width",pCompleted+"%");
    $("#projectsCanceled").html( canceled );    
    $("#projectsCanceledProgress").css("width",pCanceled+"%");
    $("#projectsArchived").html( archived );    
    $("#projectsArchivedProgress").css("width",pArchived+"%");    
};

Overview.prototype.displayTasks = function() {
    var t = this["-"];
    
    var all = t["tasks"].all;
    var ongoing = t["tasks"].ongoing;
    var completed = t["tasks"].completed;
    var canceled = t["tasks"].canceled;
    var archived = t["tasks"].archived;
    
    var pOngoing = Math.round((ongoing/all)*100);    
    var pCompleted = Math.round((completed/all)*100);
    var pCanceled = Math.round((canceled/all)*100);
    var pArchived = Math.round((archived/all)*100);
    
    var bias = 1.25;
    pOngoing = biasProgressBar( pOngoing, bias );
    pCompleted = biasProgressBar( pCompleted, bias );
    pCanceled = biasProgressBar( pCanceled, bias );
    pArchived = biasProgressBar( pArchived, bias );
    
    $("#tasksAll").html( all );
    $("#tasksOngoing").html( ongoing );    
    $("#tasksOngoingProgress").css("width",pOngoing+"%");
    $("#tasksCompleted").html( completed );    
    $("#tasksCompletedProgress").css("width",pCompleted+"%");
    $("#tasksCanceled").html( canceled );    
    $("#tasksCanceledProgress").css("width",pCanceled+"%");
    $("#tasksArchived").html( archived );    
    $("#tasksArchivedProgress").css("width",pArchived+"%");    
};

// PROFILE
function Profile( json ) {
    if( json ) {
        var obj = jQuery.parseJSON( json );    
        if( obj ) {
            this["-"] = obj;
        }   
    }                    
};
	Profile.prototype.displayProfile = function() {
	    var self = this["-"];
	    
	    //alert( self.firstName );
	    
	    function getTypeName( type ) {
	        type = parseInt(type);
	        switch(type) {
	            case USER_ADMINISTRATOR: return "Administrator";
                case USER_PROJECT_OWNER: return "Project Owner";
                case USER_TASK_OWNER: return "Task Owner";
                case USER_CUSTOMER: return "Customer";
	        }
	        return "";
	    }
	    
	    var userID = self.userID;
	    var firstName = self.firstName;
	    var lastName = self.lastName;
	    var type = self.type;
	    var registered = self.registered;
	    var country = self.country;
	    var line1 = self.line1;
	    var line2 = self.line2;
	    var city = self.city;
	    var zip = self.zip;
	    var phone = self.phone;
	    var email = self.email;
	    var avatar = self.avatar;
	    
	    if( avatar == "-" ) {
	        avatar = "img/avatars/none.jpg";
	    } else {
	        avatar = "img/avatars/"+avatar;
	    }
	    type = getTypeName(type);
	    
	    $("#pAvatar").attr("src",avatar);
	    $("#pUserID").html(userID);
	    $("#pFirstName").html(firstName);
	    $("#pLastName").html(lastName);
	    $("#pType").html(type);
	    $("#pRegistered").html(registered);
	    
	    $("#pCountry").html(country);
	    $("#pLine1").html(line1);
	    $("#pLine2").html(line2);
	    $("#pCity").html(city);
	    $("#pZip").html(zip);
	    $("#pPhone").html(phone);
	    $("#pEmail").html(email);	    
	};

// PROJECTS
function Project( obj, JSON ) {    
        
    if( JSON !== false ) {
        //alert( "parse as JSON" );        
        if( obj ) {
            obj = jQuery.parseJSON( obj );
            if( obj ) {
                this["-"] = obj;            
            }
        }   
    } else {
        //alert( "use as Object" );
        if( obj ) {
            this["-"] = obj;
            this["-"]["tasks"] = [];
        }
        //trace( "new Project", obj, obj.name );
        //trace( "new Project", this["-"], this["-"].projectID );
    }
    /*
    if( obj ) {
        obj = jQuery.parseJSON( obj );
        if( obj ) {
            this["-"] = obj;            
        }
    } 
    */                 
};
    Project.parseProjects = function( json ) {
        
        var r = [];
        
        if( json ) {
            var obj = jQuery.parseJSON( json );
            if( obj ) {
                var array = obj;                
                //trace( array.length );
                for( var i=0,L=array.length; i<L; ++i ) {
                    
                    var project = new Project( array[i]["project"], false );
                    var taskList = array[i]["tasks"];
                    
                    //itrace( 1, i, "project:", project.getName() );
                    //trace( i, "tasks:", tasks.length );
                    
                    for( var j=0,JL=taskList.length; j<JL; ++j ) {
                        var task = new Task( taskList[j], false );
                        project.joinTask( task );
                        
                        //itrace( 2, j, "task:", task.getName() );
                    }
                    
                    //itrace( 3, i, "numTasks:", project.numTasks() );
                    
                    r.push( project );
                }            
            }
        }
        return r;
    };

        Project.prototype.getID = function() { return this["-"].projectID; };
        Project.prototype.getType = function() { return this["-"].type; };
        Project.prototype.getName = function() { return this["-"].name; };
        Project.prototype.getDescription = function() { return this["-"].description; };
        Project.prototype.getAddedDate = function() { return this["-"].addedDate; };
        Project.prototype.getStartDate = function() { return this["-"].startDate; };
        Project.prototype.getEndDate = function() { return this["-"].endDate; };
        Project.prototype.getStatus = function() { return this["-"].status; };
        Project.prototype.getCanceledDate = function() { return this["-"].canceledDate; };
        Project.prototype.getCompletedDate = function() { return this["-"].completedDate; };
        Project.prototype.getColor = function() { return this["-"].color; };
        Project.prototype.getPriority = function() { return this["-"].priority; };
        Project.prototype.hasOwner = function() { return this["-"].hasOwner; };
        Project.prototype.getOwnerID = function() { return this["-"].ownerID; };
        Project.prototype.hasClient = function() { return this["-"].hasClient; };
        Project.prototype.getClientID = function() { return this["-"].clientID; };
        Project.prototype.getOwnerName = function() { return this["-"].ownerName; };
        Project.prototype.getClientName = function() { return this["-"].clientName; };
        
        Project.prototype.joinTask = function( task ) {
            this["-"]["tasks"].push( task );
        };
        Project.prototype.hasTasks = function() { return this.numTasks() > 0 ? true: false; };
        Project.prototype.numTasks = function() { return this["-"]["tasks"].length; };
        Project.prototype.getTasks = function() { return this["-"]["tasks"]; };

// TASKS
function Task( obj, JSON ) {
    if( JSON !== false ) {
        //alert( "parse as JSON" );        
        if( obj ) {
            obj = jQuery.parseJSON( obj );
            if( obj ) {
                this["-"] = obj;            
            }
        }   
    } else {
        //alert( "use as Object" );
        if( obj ) {
            this["-"] = obj;
            
            //itrace(3, this["-"].priority,this["-"].status );
        }
    }                
};
    Task.parseTasks = function() {
        var array = [];
        for( var i=0, L=arguments.length; i<L; ++i ) {
            var json = arguments[i];
            var obj = jQuery.parseJSON( json );
            array[i] = obj;
        }
        //alert( "projects: " + array.length );
        return array;
    };
        Task.prototype.getID = function() { return this["-"].taskID; };
        Task.prototype.getProjectID = function() { return this["-"].projectID; };
        Task.prototype.getType = function() { return this["-"].type; };
        Task.prototype.getPosition = function() { return this["-"].position; };
        Task.prototype.getName = function() { return this["-"].name; };
        Task.prototype.getDescription = function() { return this["-"].description; };
        Task.prototype.getAddedDate = function() { return this["-"].addedDate; };
        Task.prototype.getStartDate = function() { return this["-"].startDate; };
        Task.prototype.getEndDate = function() { return this["-"].endDate; };
        Task.prototype.getStatus = function() { return this["-"].status; };
        Task.prototype.getCanceledDate = function() { return this["-"].canceledDate; };
        Task.prototype.getCompletedDate = function() { return this["-"].completedDate; };
        Task.prototype.getPercent = function() { return this["-"].percent; };
        Task.prototype.getColor = function() { return this["-"].color; };
        Task.prototype.getPriority = function() { return this["-"].priority; };
        Task.prototype.hasOwner = function() { return this["-"].hasOwner; };
        Task.prototype.getOwnerID = function() { return this["-"].ownerID; };
        Task.prototype.hasClient = function() { return this["-"].hasClient; };
        Task.prototype.getClientID = function() { return this["-"].clientID; };
        Task.prototype.getOwnerName = function() { return this["-"].ownerName; };
        Task.prototype.getClientName = function() { return this["-"].clientName; };

// projects.php page
function ProjectsPage( obj ){
    if( obj ) {
        this["-"] = {};
        
        if( obj.user ) {
            this["-"].user = obj.user;
        }
        if( obj.projects ) {
            this["-"].projects = obj.projects;
        }
    }
}
    ProjectsPage.fillEditProjectModal = function( projectID ) {
        var projects = ProjectsPage.projects;
        //alert( projects );
        for( var i=0,L=projects.length; i<L; ++i ) {
            var project = projects[i];
            if( project.getID() == projectID ) {
                
                var modal = $("#editProjectModal");
                var projectName = project.getName();
                var projectDescription = project.getDescription();
                var projectStartDate = project.getStartDate();
                    projectStartDate = projectStartDate.split(" ")[0];
                    projectStartDate = ( projectStartDate == "" ) ? "" : projectStartDate;
                var projectEndDate = project.getEndDate();
                    projectEndDate = projectEndDate.split(" ")[0];
                    projectEndDate = ( projectEndDate == "" ) ? "" : projectEndDate;
                
                var projectPriority = project.getPriority();
                var projectStatus = project.getStatus();
                
                $("#editProjectName", modal).val( projectName );
                $("#editProjectDescription", modal).text( projectDescription );
                $("#editStartDate", modal).val( projectStartDate );
                $("#editEndDate", modal).val( projectEndDate );
                
                $("#editPriorityLabel", modal ).text( getProrityName(projectPriority) );
                $("#editStatusLabel", modal ).text( getStatusName(projectStatus) );
                
                $("#editPriorityList li", modal ).click(function(){
                    var priority = $(this).text();
                    $("#editPriorityLabel", modal ).html( priority );
                });
                $("#editStatusList li", modal ).click(function(){
                    var status = $(this).text();
                    $("#editStatusLabel", modal ).html( status );
                });
                
                var projectClientID = project.getClientID();
                var projectOwnerID = project.getOwnerID();
                
                //alert( projectClientID );
                //alert( projectOwnerID );
                
                $("#editClientID").html( Member.getSelectHTML( CLIENTS_CACHE ) );
                $("#editOwnerID").html( Member.getSelectHTML( OWNERS_CACHE ) );                
                $("#editClientID").val("id_"+projectClientID);
                $("#editOwnerID").val("id_"+projectOwnerID);
                
                $("#saveEditProjectBtn").click(function(){
                    //alert("edited");
                    modal.modal("hide");
                    
                    var projectName = $("#editProjectName").val();
                    var projectDescription = $("#editProjectDescription").val();
                    var startDate = $("#editStartDate").val();
                    var endDate = $("#editEndDate").val();
                    var priority = getPriorityByLabel( $("#editPriorityLabel").html() );
                    var status = getStatusByLabel( $("#editStatusLabel").html() );
                    
                    var clientID = $("#editClientID").val();
                        clientID = clientID.split("_"); clientID = parseInt( clientID[clientID.length-1] );
                    
                    var ownerID = $("#editOwnerID").val();
                        ownerID = ownerID.split("_"); ownerID = parseInt( ownerID[ownerID.length-1] );
                        
                    $.ajax({
                        url: "ajax.php",
                        type: "POST",
                        data: { "ajax": 1,
                            "edit-project": {
                                "projectID": projectID,
                                "name": projectName,
                                "description": projectDescription,
                                "startDate": startDate,
                                "endDate": endDate,
                                "priority": priority,
                                "status": status,
                                "ownerID": ownerID,
                                "clientID": clientID                               
                            }
                        } ,                 
                        async: true,
                        success: function (msg){
                            //alert("success");
                            location.reload(true);                          
                        },
                        error: function (err){
                            //alert("error");
                        }
                    }); 
                });
                                
                return;
            }
        }
    };
    ProjectsPage.fillEditTaskModal = function( taskID ) {
        var projects = ProjectsPage.projects;
        //alert( projects );
        for( var i=0,L=projects.length; i<L; ++i ) {
            var project = projects[i];            
            var taskList = project.getTasks();
            for( var j=0,JL=taskList.length; j<JL; ++j ) {
                var task = taskList[j];
                if( task.getID() == taskID ) {
                    //alert("found and filled");
                    
                    var modal = $("#editTaskModal");
                    var taskName = task.getName();
                    var taskDescription = task.getDescription();
                    var taskPriority = task.getPriority();
                    var taskStatus = task.getStatus();
                    var taskPercent = task.getPercent();
                    
                    $("#taskName", modal).val( taskName );
                    $("#taskDescription", modal).text( taskDescription );
                    
                    $("#taskPriorityLabel", modal ).text( getProrityName(taskPriority) );
                    $("#taskStatusLabel", modal ).text( getStatusName(taskStatus) );
                    
                    $("#taskPriorityList li", modal ).click(function(){
                        var priority = $(this).text();
                        $("#taskPriorityLabel", modal ).html( priority );
                    });
                    $("#taskStatusList li", modal ).click(function(){
                        var status = $(this).text();
                        $("#taskStatusLabel", modal ).html( status );
                    });
                    
                    $("#taskSlider", modal).slider("value",taskPercent);
                    
                    var taskOwnerID = task.getOwnerID();
                
                    //alert( projectClientID );
                    //alert( projectOwnerID );
                    
                    $("#taskOwnerID").html( Member.getSelectHTML( OWNERS_CACHE ) );                
                    $("#taskOwnerID").val("id_"+taskOwnerID);
                    
                    //deleteTaskBtn
                    $("#deleteTaskBtn").click(function(){
                        //alert("edited");
                        modal.modal("hide");
                        $.ajax({
                            url: "ajax.php",
                            type: "POST",
                            data: { "ajax": 1,
                                "delete-task": {
                                    "taskID": taskID                                                                                                     
                                }
                            } ,                 
                            async: true,
                            success: function (msg){
                                //alert("success");
                                location.reload(true);                          
                            },
                            error: function (err){
                                //alert("error");
                            }
                        }); 
                    });
                    
                    //editTaskBtn
                    $("#editTaskBtn").click(function(){
                        //alert("edited");
                        modal.modal("hide");
                        
                        var taskName = $("#taskName", modal).val();
                        var taskDescription = $("#taskDescription", modal).val();
                        var priority = getPriorityByLabel( $("#taskPriorityLabel", modal).html() );
                        var status = getStatusByLabel( $("#taskStatusLabel", modal).html() );
                        var ownerID = $("#taskOwnerID", modal).val();
                            ownerID = ownerID.split("_"); ownerID = parseInt( ownerID[ownerID.length-1] );
                        var percent = $("#taskSlider", modal).slider("option", "value");
                            percent = ( percent ) ? parseInt( percent ) : 0;
                            
                        $.ajax({
                            url: "ajax.php",
                            type: "POST",
                            data: { "ajax": 1,
                                "edit-task": {
                                    "taskID": taskID,
                                    "name": taskName,
                                    "description": taskDescription,
                                    "percent": percent,
                                    "priority": priority,
                                    "status": status,
                                    "ownerID": ownerID                                                                   
                                }
                            } ,                 
                            async: true,
                            success: function (msg){
                                //alert("success");
                                location.reload(true);                          
                            },
                            error: function (err){
                                //alert("error");
                            }
                        }); 
                    });
                    
                    return;
                }
            }
        }
    };
    ProjectsPage.fillMessageTaskModal = function( projectID ) {
        var projects = ProjectsPage.projects;
        //alert( projects );
        for( var i=0,L=projects.length; i<L; ++i ) {
            var project = projects[i];
            if( project.getID() == projectID ) {
                
                var modal = $("#messageModal");
                
                var projectName = project.getName();
                var projectOwnerID = project.getOwnerID();
                var userID = ProjectsPage.user.getID();
                
                var clients = Member.getSelectHTML( CLIENTS_CACHE );
                var owners = Member.getSelectHTML( OWNERS_CACHE );
                
                $("#recipientID", modal).html( owners + clients );
                $("#recipientID").val("id_"+projectOwnerID);
                
                $("#messageSubject", modal).val( projectName );
                
                $("#messageTypeLabel", modal ).text( "Normal" );
                $("#messageTypeList li", modal ).click(function(){
                    var type = $(this).text();
                    $("#messageTypeLabel", modal ).html( type );
                });
                
                $("#sendMessageBtn").click(function(){
                    //alert("edited");
                    modal.modal("hide");
                    
                    var sender = userID;
                    var recipient = $("#recipientID").val();
                        recipient = recipient.split("_"); recipient = parseInt( recipient[recipient.length-1] );
                    var type = $("#messageTypeLabel").html();
                        type = ( type == "Normal" ) ? MESSAGE_NORMAL : MESSAGE_ISSUE;
                    
                    var subject = $("#messageSubject").val();
                    var text = $("#messageText").val();
                    
                    $.ajax({
                        url: "ajax.php",
                        type: "POST",
                        data: { "ajax": 1,
                            "create-message": {
                                "senderID": sender,                                                                   
                                "recipientID": recipient,                                                                   
                                "type": type,                                                                   
                                "subject": subject,                                                                   
                                "text": text                                                                   
                            }
                        } ,                 
                        async: true,
                        success: function (msg){
                            //alert("success");
                            location.reload(true);                          
                        },
                        error: function (err){
                            //alert("error");
                        }
                    });
                });
                
                return;
            }
        } 
    };
    ProjectsPage.prototype.getProjects = function() {
        return this["-"].projects;
    };
    ProjectsPage.prototype.getProjectName = function( projectID ) {
        var projects = this.getProjects();
        for( var i=0,L=projects.length; i<L; ++i ) {
            var p = projects[i];
            if( p.getID() == projectID ) {
                return p.getName();
            }
        }
        return "unknown";
    };
    ProjectsPage.prototype.getTaskName = function( taskID ) {
        var projects = this.getProjects();
        for( var i=0,L=projects.length; i<L; ++i ) {
            var p = projects[i];            
            var taskList = p.getTasks();
            //itrace(1, taskList.length );
            for( var j=0,JL=taskList.length; j<JL; ++j ) {
                var task = taskList[j];
                //itrace(2, task.getID() );
                if( task.getID() == taskID ) {
                    //itrace(3, "match", task.getID() );
                    return task.getName();
                }
            }
        }
        return "unknown";
    };
    ProjectsPage.prototype.numProjects = function( status ) {
        if( status ) {
           var a = this["-"].projects;
            var result = 0;
            for( var i=0, L=a.length; i<L; ++i ) {
                var project = a[i];
                var s = project.getStatus();
                if( s == status ) {
                    ++result;
                }
            }
            return result; 
        }
        return this["-"].projects.length;                
    };
    ProjectsPage.prototype.numAllProjects = function() {
        return this.numProjects();        
    };
    ProjectsPage.prototype.numOngoingProjects = function() {
        return this.numProjects( STATUS_ONGOING ); 
    };
    ProjectsPage.prototype.numCompletedProjects = function() {
        return this.numProjects( STATUS_COMPLETED ); 
    };
    ProjectsPage.prototype.numCanceledProjects = function() {
        return this.numProjects( STATUS_CANCELED ); 
    };
    ProjectsPage.prototype.numArchivedProjects = function() {
        return this.numProjects( STATUS_ARCHIVED ); 
    };
    ProjectsPage.prototype.initializeEditor = function() {        
        // prepare template
        var taskContainer = $("#newTaskContainer");
        var taskEntry = $("#newTaskEntry").clone();
            $("#newTaskEntry").remove();
        
        // New Project Button
        $( "#newStartDate" ).datepicker({ "dateFormat": "yy-mm-dd" });             
        $( "#newEndDate" ).datepicker({ "dateFormat": "yy-mm-dd" });
        
        $("#newProjectBtn").click(function(){
            // reset modal
            taskContainer.empty();
            $("#newProjectModal").modal("show");
            $("#priorityList li").click(function(){
                var priority = $(this).text();
                $("#priorityLabel").html( priority );
            });
            $("#statusList li").click(function(){
                var status = $(this).text();
                $("#statusLabel").html( status );
            });
            $("#newClientID").html( Member.getSelectHTML( CLIENTS_CACHE ) );
            $("#newOwnerID").html( Member.getSelectHTML( OWNERS_CACHE ) );
            
        });

        // ADD PROJECT MODAL                
        $("#addTask").click(function(){
            var entry = taskEntry.clone();
            var name = "task_" + getUID(); 
            
            entry.attr( "name", name );
            $( "#deleteTask", entry ).click(function(){
                //alert( "delete: " + name );
                $("div[name="+name+"]").remove();
            });
            $( "#taskSlider", entry ).slider();
            
            $("#taskPriorityList li", entry ).click(function(){
                var priority = $(this).text();
                $("#taskPriorityLabel", entry ).html( priority );
            });
            $("#taskStatusList li", entry ).click(function(){
                var status = $(this).text();
                $("#taskStatusLabel", entry ).html( status );
            });
            
            $("#taskOwnerID", entry ).html( Member.getSelectHTML( OWNERS_CACHE ) );
            
            //$( ".start-date", entry ).datepicker({ "dateFormat": "yy-mm-dd" });             
            //$( ".end-date", entry ).datepicker({ "dateFormat": "yy-mm-dd" });
                                
            taskContainer.append( entry );
        });
        
        // Save Project Button
        $("#saveProjectBtn").click(function(){
            //alert("save project");
            $("#newProjectModal").modal("hide");
            
            var projectName = $("#newProjectName").val();
            var projectDescription = $("#newProjectDescription").val();
            var startDate = $("#newStartDate").val();
            var endDate = $("#newEndDate").val();
            var priority = getPriorityByLabel( $("#priorityLabel").html() );
            var status = getStatusByLabel( $("#statusLabel").html() );
            
            var clientID = $("#newClientID").val();
                clientID = clientID.split("_"); clientID = parseInt( clientID[clientID.length-1] );
            
            var ownerID = $("#newOwnerID").val();
                ownerID = ownerID.split("_"); ownerID = parseInt( ownerID[ownerID.length-1] );
            
            //itrace( 1, clientID, ownerID );
            
            var tasks = [];
            
            var list = $("#newProjectModal #newTaskEntry").each(function(index){
                var taskEntry = $(this);
                var taskName = $("#taskName", taskEntry).val();                
                var taskDescription = $("#taskDescription", taskEntry).val();
                var taskPriority = getPriorityByLabel( $("#taskPriorityLabel", taskEntry).html() );
                var taskStatus = getStatusByLabel( $("#taskStatusLabel", taskEntry).html() );
                var taskPercent = $("#taskSlider", taskEntry).slider("option", "value");
                    taskPercent = ( taskPercent ) ? parseInt( taskPercent ) : 0;
                
                var taskOwnerID = $("#taskOwnerID").val();
                    taskOwnerID = taskOwnerID.split("_"); taskOwnerID = parseInt( taskOwnerID[taskOwnerID.length-1] );
                    
                //itrace(1, taskName, taskDescription, taskPriority, taskStatus, taskPercent, taskOwnerID);
                tasks.push({
                    "name": taskName,
                    "description": taskDescription,
                    "priority": taskPriority,
                    "status": taskStatus,
                    "percent": taskPercent,
                    "ownerID": taskOwnerID
                });                
            });
            
            $.ajax({
                url: "ajax.php",
                type: "POST",
                data: { "ajax": 1,
                    "new-project": {
                        "name": projectName,
                        "description": projectDescription,
                        "startDate": startDate,
                        "endDate": endDate,
                        "priority": priority,
                        "status": status,
                        "ownerID": ownerID,
                        "clientID": clientID,
                        "tasks": tasks
                    }
                } ,                 
                async: true,
                success: function (msg){
                    //alert("success");
                    location.reload(true);                          
                },
                error: function (err){
                    //alert("error");
                }
            }); 
        }); 
                
    };
    ProjectsPage.prototype.displayProjects = function() {
        //alert( "display projects" );
        var globalSelf = this;
        
        // display header data
        var allProjects = this.numAllProjects(); 
        var ongoingProjects = this.numOngoingProjects();        
        var completedProjects = this.numCompletedProjects();        
        var canceledProjects = this.numCanceledProjects();        
        var archivedProjects = this.numArchivedProjects();        
        
        $("#allProjectsValue").html( allProjects );
        $("#ongoingProjectsValue").html( ongoingProjects );
        $("#completedProjectsValue").html( completedProjects );
        $("#canceledProjectsValue").html( canceledProjects );
        $("#archivedProjectsValue").html( archivedProjects );
        
        // display projects and tasks
        var projectContainer = $("#projectsContainer");
        var projectTemplate = $("#projectsTemplate").clone();
            $("#projectsTemplate").remove();
        
        var projectList = this.getProjects();
            
        for( var i=0,L=this.numAllProjects(); i<L; ++i ) {
            //itrace( 1, i );
            var projectEntry = projectTemplate.clone();
            
            var project = projectList[i];            
            var projectPriority = project.getPriority();
            var projectStatus = project.getStatus();
            //itrace( 1, projectPriority, projectStatus );
            //var projectStatus = getRandomStatus();
            //var projectPriority = getRandomPriority();
            var projectName = project.getName();
            var projectID = project.getID();
            var projectClientName = project.getClientName();
            var projectDescription = project.getDescription();
            var projectStartDate =  project.getStartDate();
                projectStartDate = projectStartDate.split(" ")[0];
                projectStartDate = ( projectStartDate == "0000-00-00" ) ? "-" :projectStartDate;                 
            var projectEndDate =  project.getEndDate();
                projectEndDate = projectEndDate.split(" ")[0];
                projectEndDate = ( projectEndDate == "0000-00-00" ) ? "-" :projectEndDate;
                    
            //itrace( 1, i, projectName, projectPriority );
            //itrace( 1, i, getRandomPriority(), getRandomStatus() );
            
            $( projectEntry ).attr("name","project_"+projectID);
            $( projectEntry ).addClass( getProjectStatusClass( projectStatus ) );
            $("#projectPriority", projectEntry ).addClass( getProjectPriorityClass( projectPriority ) );
            $("#projectName", projectEntry ).html(projectName);
            $("#projectID", projectEntry ).html(projectID);
            $("#projectClientName", projectEntry ).html(projectClientName);
            $("#projectDescription", projectEntry ).html(projectDescription);
            $("#projectStartDate", projectEntry ).html(projectStartDate);
            $("#projectEndDate", projectEntry ).html(projectEndDate);
            
            // BUTTONS
                // DELETE PROJECT           
                $("#projectRemoveBtn", projectEntry ).attr("name","remove_"+projectID); 
                $("#projectRemoveBtn", projectEntry ).click(function(){
                    var pID = $(this).attr("name").split("_");
                    pID = parseInt(pID[pID.length-1]);
                    
                    var name = globalSelf.getProjectName(pID);
                    
                    $("#deleteProjectModal").modal("show");
                    $("#deleteModalName").html( name );
                    $("#deleteModalValue").html( "ID: " + pID );
                    
                    PROJECT_CACHE = pID;
                    
                    //itrace( 1, name ); 
                    //alert( pID );
                });            
                $("#deleteProjectModalBtn").click(function(){
                    $("#deleteProjectModal").modal("hide");
                    $.ajax({
                        url: "ajax.php",
                        type: "POST",
                        data: { "ajax": 1,
                            "delete-project": {
                                projectID: PROJECT_CACHE
                            }
                        } ,                 
                        async: true,
                        success: function (msg){
                            //alert("success");
                            location.reload(true);                          
                        },
                        error: function (err){
                            //alert("error");
                        }
                    });
                });
                // EDIT PROJECT
                $("#projectEditBtn", projectEntry ).attr("name","edit_"+projectID); 
                $("#projectEditBtn", projectEntry ).click(function(){
                    var pID = $(this).attr("name").split("_");
                    pID = parseInt(pID[pID.length-1]);
                    
                    var name = globalSelf.getProjectName(pID);
                    
                    $("#editProjectModal").modal("show");
                    
                    PROJECT_CACHE = pID;
                    
                    //itrace( 1, name ); 
                    //alert( pID );
                    
                    ProjectsPage.fillEditProjectModal( pID );
                });
                // PROJECT MESSAGE
                $("#projectMessageBtn", projectEntry ).attr("name","message_"+projectID); 
                $("#projectMessageBtn", projectEntry ).click(function(){
                    var pID = $(this).attr("name").split("_");
                    pID = parseInt(pID[pID.length-1]);
                    
                    var name = globalSelf.getProjectName(pID);
                    
                    var modal = $("#messageModal").modal("show");
                    
                    //itrace( 1, name ); 
                    //alert( pID );
                    
                    ProjectsPage.fillMessageTaskModal(pID);                 
                });             
            
            
            // TASKS FOR THE CURRENT PROJECT
            var taskContainer = $("#tasksContainer", projectEntry );
            var taskTemplate = $("#tasksTemplate", projectEntry ).clone();
                $("#tasksTemplate", projectEntry ).remove();
            
            var taskList = project.getTasks();            
            for( var j=0,JL=taskList.length; j<JL; ++j ) {
                var taskEntry = taskTemplate.clone();
                var task = taskList[j];
                var taskID = task.getID();
                //itrace(1 , task.getName());
                var taskStatus = parseInt( task.getStatus() );                    
                //var taskStatus = getRandomStatus();                    
                var taskPriority = parseInt( task.getPriority() );
                //itrace( 1, taskStatus, taskPriority );
                //var taskPriority = getRandomPriority();
                var taskName = task.getName();
                var taskPercent = parseInt( task.getPercent() );
                //var taskPercent = getRandomPercent();
                if( taskStatus == STATUS_CANCELED || taskStatus == STATUS_ARCHIVED ) {
                        taskPercent = 100;
                }
                var taskOwner = task.getOwnerName();
                
                $( "#taskProgressBar", taskEntry ).css("width", taskPercent + "%" );
                $( "#taskProgressBar", taskEntry ).addClass( getTaskStatusClass( taskStatus ) );
                $( "#taskPriority", taskEntry ).addClass( getTaskPriorityClass( taskPriority ) );
                $( "#taskName", taskEntry ).html( taskName );
                $( "#taskOwnerName", taskEntry ).html( taskOwner );
                
                //itrace( 2, j, task, task.getName() );
                
                // EDIT TASK
                $("#taskEditBtn", taskEntry ).attr("name","edit_"+taskID);
                $("#taskEditBtn", taskEntry ).click(function(){
                    var tID = $(this).attr("name").split("_");
                    tID = parseInt(tID[tID.length-1]);
                    
                    var name = globalSelf.getTaskName(tID);
                    
                    var modal = $("#editTaskModal");
                        modal.modal("show");
                    $( "#taskSlider", modal ).slider();
                    
                    ProjectsPage.fillEditTaskModal( tID );
                    
                    //$("#deleteModalName").html( name );
                    //$("#deleteModalValue").html( "ID: " + pID );
                    
                });                
                
                taskContainer.append( taskEntry );
            }
            
            projectContainer.append( projectEntry );            
        }
        
        //projectContainer.append( projectTemplate );               
    };

// OWNERS (Project Owners/Task Owners)
// CLIENTS (Customers)
function Member( obj, JSON ) {    
        
    if( JSON !== false ) {
        if( obj ) {
            obj = jQuery.parseJSON( obj );
            if( obj ) {
                this["-"] = obj;            
            }
        }   
    } else {
        if( obj ) {
            this["-"] = obj;            
        }
        
    }                 
};
    Member.parseMembers = function( json ) {
        var r = [];
        
        if( json ) {
            var obj = jQuery.parseJSON( json );
            if( obj ) {
                var array = obj;
                //itrace( 1, "members", array );
                for( var i=0,L=array.length; i<L; ++i ) {
                    //itrace(1, i);
                    r.push( new Member( array[i], false ) );
                }
            }
        }        
        return r;
    };
    Member.getSelectHTML = function( members ) {
        //'<option value="">1</option>'
        
        var options = "";
        
        for( var i=0,L=members.length; i<L; ++i ) {
            var member = members[i];
            var id = member.getID();
            var name = member.getFormattedName();
            options += '<option value="id_' +id+ '">' +name+ '</option>';
        }
        
        return options;
    };
    Member.prototype.getID = function() {
        return this["-"].userID;
    };
    Member.prototype.getName = function() {
        return this["-"].name;
    };
    Member.prototype.getType = function() {
        return parseInt( this["-"].type );
    };
    Member.prototype.getFormattedName = function() {
        
        var title = "";        
        switch( this.getType() ) {
            case USER_ADMINISTRATOR: title = "ADMIN"; break;
            case USER_PROJECT_OWNER: title = "PO"; break;
            case USER_TASK_OWNER: title = "TO"; break;
            case USER_CUSTOMER: title = "C"; break;
        }
        
        return this["-"].name +" - "+ title;
    };

// MESSAGE
function Message( obj ) {
    if( obj ) {
        this["-"] = obj;
    }
};
    Message.inbox = [];
    Message.sent = [];
    Message.parseMessages = function( json ) {
        if( json ) {
            var obj = jQuery.parseJSON( json );
            if( obj ) {
                var inbox = obj["inbox"];
                var sent = obj["sent"];
                for( var i=0,L=inbox.length; i<L; ++i ) {
                    var message = new Message(inbox[i]);
                    //itrace(1, message.getID(), message.getSubject());
                    Message.inbox.push( message );
                }
                for( var i=0,L=sent.length; i<L; ++i ) {
                    var message = new Message(sent[i]);
                    //itrace(1, message.getID(), message.getSubject());
                    Message.sent.push( message );
                }
            }
        }
    };
    Message.getMessageByID = function( messageID ) {
        var inbox = Message.inbox;
        for( var i=0, L=inbox.length; i<L; ++i ) {
            if( inbox[i].getID() == messageID ) {
                return inbox[i]; 
            }
        }
        var sent = Message.sent;
        for( var i=0, L=sent.length; i<L; ++i ) {
            if( sent[i].getID() == messageID ) {
                return sent[i]; 
            }
        }
        return null;   
    };
    Message.getEntryStyle = function( type, read ) {
        type = parseInt(type);
        read = parseInt(read);        
        
        if( type == MESSAGE_NORMAL && read == 0 ) { // unread-normal
            return "message-unread-normal";
        } else if( type == MESSAGE_NORMAL && read == 1 ) { // read-normal
            return "message-read-normal";
        } else if( type == MESSAGE_ISSUE && read == 0 ) { // unread-issue
            return "message-unread-issue";
        } else if( type == MESSAGE_ISSUE && read == 1 ) { // read-issue
            return "message-read-issue";
        }
    };
    Message.deleteMessageListener = function(e){
        var mID = $(this).attr("name").split("_");
            mID = parseInt(mID[mID.length-1]);                
        var msg = Message.getMessageByID(mID);
        
        //alert("delete message: "+m.getID() +" - "+m.getSubject());
        
        var modal = $("#deleteMessageModal");
        modal.modal("show");
        
        $("#deleteModalSubject").html( msg.getSubject() );
        $("#deleteModalSenderName").html( msg.getSenderName() );
        $("#deleteMessageModalBtn").click(function(){
            $.ajax({
                url: "ajax.php",
                type: "POST",
                data: { "ajax": 1,
                    "delete-message": {
                        "messageID": mID
                    }
                } ,                 
                async: true,
                success: function (msg){
                    //alert("success");
                    location.reload(true);                          
                },
                error: function (err){
                    //alert("error");
                }
            });
        });
        e.stopPropagation();       
    };
    Message.viewMessageListener = function(e) {
        var pID = $(this).attr("name").split("_");
            pID = parseInt(pID[pID.length-1]);
        
        var modal = $("#viewMessageModal");
        modal.modal("show");
        
        var message = Message.getMessageByID(pID); 
        var sender = message.getSenderName();
        var subject = message.getSubject();
        var type = message.getType();
        var text = message.getText();
        
        type = ( type == 0 ) ? "Normal" : "Issue";
        
        $("#viewMessageRecipient").val(sender);
        $("#viewMessageSubject").val(subject);
        $("#viewMessageType").val(type);
        $("#viewMessageText").text(text);
        
        //alert(pID); 
    };
    Message.toggleMessageListener = function(e) {
        var mID = $(this).attr("name").split("_");
            mID = parseInt(mID[mID.length-1]);                
        var m = Message.getMessageByID(mID);
        
        //alert("mark message: "+m.getID() +" - "+m.getSubject());
        
        $.ajax({
            url: "ajax.php",
            type: "POST",
            data: { "ajax": 1,
                "toggle-message": {
                    "messageID": mID
                }
            } ,                 
            async: true,
            success: function (msg){
                //alert("success");
                location.reload(true);                          
            },
            error: function (err){
                //alert("error");
            }
        });
        
        e.stopPropagation();
    };
    Message.displayMessages = function() {
        //alert("display");
        var inbox = Message.inbox;
        var sent = Message.sent;
                
        var numMessages = inbox.length + sent.length;
        $("#allMessages").html( numMessages );
        
        var numUnreadMessages = 0;
        for( var i=0, L=inbox.length; i<L; ++i ) {
            if( inbox[i].getRead() == 0 ) {
                ++numUnreadMessages;
                //trace( "found" );
            }
        }
        $("#unreadValue").html( numUnreadMessages );  
        
        var numIssuesMessages = 0;
        for( var i=0, L=inbox.length; i<L; ++i ) {
            if( inbox[i].getType() == MESSAGE_ISSUE ) {
                ++numIssuesMessages;
                //trace( "found" );
            }
        }
        $("#issueValue").html( numIssuesMessages );  
        
        // NEW MESSAGE
        $("#newMessageBtn").click(function(){
            var modal = $("#newMessageModal");
            modal.modal("show");
            
            var recipients = Member.getSelectHTML( OWNERS_CACHE ) + Member.getSelectHTML( CLIENTS_CACHE );
            $("#recipientID", modal).html(recipients);
            
            $("#messageTypeLabel", modal ).text( "Normal" );
            $("#messageTypeList li", modal ).click(function(){
                var type = $(this).text();
                $("#messageTypeLabel", modal ).html( type );
            });
            
            $("#sendMessageBtn").click(function(){
                
                modal.modal("hide");
                
                var sender = Message.user.getID();
                var recipient = $("#recipientID").val();
                    recipient = recipient.split("_"); recipient = parseInt( recipient[recipient.length-1] );
                var type = $("#messageTypeLabel").html();
                    type = ( type == "Normal" ) ? MESSAGE_NORMAL : MESSAGE_ISSUE;
                
                var subject = $("#messageSubject").val();
                var text = $("#messageText").val();
                
                $.ajax({
                    url: "ajax.php",
                    type: "POST",
                    data: { "ajax": 1,
                        "create-message": {
                            "senderID": sender,                                                                   
                            "recipientID": recipient,                                                                   
                            "type": type,                                                                   
                            "subject": subject,                                                                   
                            "text": text                                                                   
                        }
                    } ,                 
                    async: true,
                    success: function (msg){
                        //alert("success");
                        location.reload(true);                          
                    },
                    error: function (err){
                        //alert("error");
                    }
                });
            });
        });
        
        var inboxContainer = $("#inbox");
        var sentContainer = $("#sent");
        var template = $("#messageTemplate").clone();
        
        inboxContainer.empty();
        sentContainer.empty();
        
        // INBOX
        for( var i=0, L=inbox.length; i<L; ++i ) {
            var entry = template.clone();
            var message = inbox[i];
            
            var messageID = message.getID();
            var type = message.getType();
            var read = message.getRead();
            var senderName = message.getSenderName();
            var subject = message.getSubject();
            var date = message.getDate();
            
            if( type == MESSAGE_NORMAL ) {
                $("#messageType", entry).addClass("glyphicon-stop");
            } else {
                $("#messageType", entry).addClass("glyphicon-warning-sign");
            }
            
            $("#senderName", entry).html(senderName);
            $("#subject", entry).html(subject);
            $("#date", entry).html(date);
            
            var entryStyle = Message.getEntryStyle(type,read);
            entry.addClass( entryStyle );
            
            // VIEW MESSAGE "BAR"
            $(entry).attr("name","view_"+messageID);
            $(entry).click(Message.viewMessageListener);
            
            // DELETE MESSAGE BUTTON
            $("#deleteMessage", entry).attr("name","delete_"+messageID);
            $("#deleteMessage", entry).click(Message.deleteMessageListener);
            
            // TOGGLE/READ-UNREAD MESSAGE BUTTON
            $("#markMessage", entry).attr("name","mark_"+messageID);
            $("#markMessage", entry).click(Message.toggleMessageListener);
            
            inboxContainer.append( entry );
        }
        
        // SENT
        for( var i=0, L=sent.length; i<L; ++i ) {
            var entry = template.clone();
            var message = sent[i];
            
            var messageID = message.getID();
            var type = message.getType();
            var read = message.getRead();
            var senderName = message.getSenderName();
            var subject = message.getSubject();
            var date = message.getDate();
            
            if( type == MESSAGE_NORMAL ) {
                $("#messageType", entry).addClass("glyphicon-stop");
            } else {
                $("#messageType", entry).addClass("glyphicon-warning-sign");
            }
            
            $("#senderName", entry).html(senderName);
            $("#subject", entry).html(subject);
            $("#date", entry).html(date);
            
            var entryStyle = Message.getEntryStyle(type,read);
            entry.addClass( entryStyle );
            
            // VIEW MESSAGE "BAR"
            $(entry).attr("name","view_"+messageID);
            $(entry).click(Message.viewMessageListener);
            
            // DELETE MESSAGE BUTTON
            $("#deleteMessage", entry).addClass("pull-right");
            $("#deleteMessage", entry).attr("name","delete_"+messageID);
            $("#deleteMessage", entry).click(Message.deleteMessageListener);
            
            // TOGGLE/READ-UNREAD MESSAGE BUTTON
            $("#markMessage", entry).remove();;
            
            sentContainer.append( entry );
        }
    };
        Message.prototype.getID = function() {
            return parseInt( this["-"].messageID );
        };
        Message.prototype.getRecipientID = function() {
            return parseInt( this["-"].recipientID );
        };
        Message.prototype.getRecipientName = function() {
            return this["-"].recipientName;
        };
        Message.prototype.getSenderID = function() {
            return parseInt( this["-"].senderID );
        };
        Message.prototype.getSenderName = function() {
            return this["-"].senderName;
        };
        Message.prototype.getRead = function() {
            return parseInt( this["-"].read );
        };
        Message.prototype.getType = function() {
            return parseInt( this["-"].type );
        };
        Message.prototype.getSubject = function() {
            return this["-"].subject;
        };
        Message.prototype.getText = function() {
            return this["-"].text;
        };
        Message.prototype.getDate = function() {
            return this["-"].date;
        };
        
// USERS TABLE
function UsersTable( object ) {
    if( object ) {
    	this["-"] = object;
    }                
};
	UsersTable.displayUsers = function( obj ) {
		var table = $("#usersTable");
		var tbody = $("#usersTable tbody");
		
		//alert( tbody.children() );
	};








