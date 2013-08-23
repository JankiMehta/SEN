<?php

include 'connect.php' ;
session_start();
if (isset($_SESSION['id'])) {
	$id=$_SESSION['id'];
	include 'privileges.php';
	if(strcmp($privilege,"student")==0) {
		$sql="SELECT * FROM student where student_id='$id'";
	}else if(strcmp($privilege,"admin")==0) {
		$sql="SELECT * FROM admin where admin_no='$id'";
	}else if(strcmp($privilege,"faculty")==0) {
		$sql="SELECT * FROM faculty where faculty_id='$id'";
	} else if(strcmp($privilege,"spc")==0) {
		$sql="SELECT * FROM spc where SPCmember_no='$id'";
	}
	
	$result=mysql_query($sql,$con);
	$row = mysql_fetch_array($result, MYSQL_ASSOC);
	$name = $row['f_name']." ".$row['l_name'];
} else {
	header('Location: login.php');
	}
 include "change_pw.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Events</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<!-- Le styles -->
	<link href="assets/css/bootstrap.min.css" rel="stylesheet">
	<link href="assets/css/common.css" rel="stylesheet">
	<link href="assets/css/bootstrap-responsive.min.css" rel="stylesheet">
	<!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
	<!--[if lt IE 9]>
	<script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->
	<!-- Le fav and touch icons -->
</head>

<body>
	<!-- NAVIGATION BAR -->
	<div class="navbar navbar-inverse nav">
	    <div class="navbar-inner">
	        <div class="container">
	            <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
	                <span class="icon-bar"></span>
	                <span class="icon-bar"></span>
	                <span class="icon-bar"></span>
	            </a>
	            <div class="brand" href="#">DA-IICT</div>
				
	          	<div class="nav-collapse collapse">
	              	<ul class="nav">
	                  	<li class="divider-vertical"></li>
	                	<li><a href="index.php"><i class="icon-home icon-white"></i> Home</a></li>
	              	</ul>
		     <?php if(strcmp($privilege,"admin")==0 or strcmp($privilege,"faculty")==0 or strcmp($privilege,"spc")==0) {
			 echo	"<div class=\"pull-right\">
	                	<ul class=\"nav pull-right\">
                            <li class=\"dropdown\"><a href=\"#\" class=\"dropdown-toggle\" data-toggle=\"dropdown\">Administration<b class=\"caret\"></b></a>
                                <ul class=\"dropdown-menu\">
									<li><a href=\"eventgeneration.php\"><i class=\"icon-plus-sign\"></i> Add Event</a></li>"; 
							
									if(strcmp($privilege,"admin")==0) {
                                    echo "<li><a href=\"filtration.php\"><i class=\"icon-search\"></i> Filtration</a></li>    
                                    <li><a href=\"eventcompletion.php\"><i class=\"icon-bullhorn\"></i> Complete Event</a></li>
                                    <li class=\"divider\"></li>
									<li class=\"dropdown-submenu pull-left\"><a tabindex=\"-1\" href=\"#\"><i class=\"icon-briefcase\"></i> Manage Database</a>
									<ul class=\"dropdown-menu\">
									</li>
                                          <li><a href=\"admin.php\"><i class=\"icon-plus-sign\"></i> Insert Admin</a></li>  
                                          <li><a href=\"spc.php\"><i class=\"icon-plus-sign\"></i> Insert SPC Member</a></li>
                                          <li><a href=\"faculty.php\"><i class=\"icon-plus-sign\"></i> Insert Faculty Member</a></li>
										  <li><a href=\"courses.php\"><i class=\"icon-plus-sign\"></i> Insert Courses</a></li>
										  <li><a href=\"organisation.php\"><i class=\"icon-plus-sign\"></i> Insert Organisation</a></li>
                                          <li><a href=\"delete.php\"><i class=\"icon-minus-sign\"></i> Delete Users</a></li>	
									</li> 
									</ul> "; 
									} 
									
                               echo "</ul>
                            </li>
                        </ul>
	                </div>";} ?>
	                	
	              	<div class="pull-right">
	                	<ul class="nav pull-right">
	                    	<li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown">Welcome, <?php echo $name?> <b class="caret"></b></a>
								<ul class="dropdown-menu">
								<?php
								if(strcmp($privilege,"student")==0){
										$query_approved="select is_approved from student where student_id='$id'";
										$result=mysql_query($query_approved, $con);
										$row=mysql_fetch_array($result);
										if($row['is_approved']==0) {
										
											echo "<li><a href=\"editProfile.php\"><i class=\" icon-cog\"></i> Edit Profile</a></li> "; }} ?>
	                            	<li><a data-toggle="modal" href="#change_password"><i class="icon-pencil"></i> Change Password</a></li>
	                            	<li class="divider"></li>
	                            	<li><a href="logout.php"><i class="icon-off"></i> Logout</a></li>
	                        	</ul>	                    	</li>
	                	</ul>
	              	</div>
	            </div>
	        </div>
	    </div>
	</div>

	<!-- BODY CONTAINER -->
	<div class="container">
  		<div class="row-fluid">
    		<!--Sidebar content-->
    		<div id="sidebar_box" class="span3 sidebar-box">
    			<div class="well sidebar-nav custom-well">
    				<img src="assets/img/daiict.png" class="img-rounded sidebar-img" >

    			    <ul class="nav nav-list">  
                        <li ><a href="index.php">Home</a></li>
                        <li class="active"><a href="listevents.php">Events</a></li>  
						<?php if(strcmp($privilege,"student")==0){
                        echo "<li><a href=\"profile.php\">Profile</a></li> ";}?> 
                        <li><a href="http://webmail.daiict.ac.in">Webmail</a></li>
                    </ul>
    			</div>	
    		</div>

    		<!--Body content-->
    		<div class="span9 panel-box">
  			    <h2 class="header-gap">Events</h2> 

                <hr class="custom-hr" style="margin-top:25px; margin-bottom:10px;">
				
             <!--   <h4>3 Events</h4> -->
                <br>
				<?php
					
					if(strcmp($privilege,"admin")==0 or strcmp($privilege,"spc")==0){
					
						$sql="SELECT distinct event_id, org_name,ctc,event_details,last_edited_on_timestamp FROM event 
								WHERE is_completed=0 ORDER BY last_edited_on_timestamp DESC";
						$result=mysql_query($sql,$con);
						while($row=mysql_fetch_array($result,MYSQL_ASSOC)){
							$event_id = $row['event_id'];
							$org = $row['org_name'];
							$pak = $row['ctc'];
							$det = $row['event_details'];
							$timestamp = strtotime($row['last_edited_on_timestamp']);
							$date = date('d-m-Y',$timestamp);
							
							echo "<div id=\"event--1\" class=\"row-fluid question-panel-box\">
								<div class=\"span10 question-panel-inner-rbox\" style='margin: 10px'>
									<h4> ".$org."</h4>
									<p> Description: ".$det." <br>CTC: ".$pak."</p>
									<a href=\"event.php?eventid=".$event_id."\" class=\"btn btn-success btn-small\" style=\"float:left\">View Event</a>
									<p class=\"posted-info\" >".$date."</p>
								</div>    
							</div>"; 
						}
					}
					else if(strcmp($privilege,"faculty")==0){
						$sql="SELECT distinct event_id, org_name,ctc,event_details,last_edited_on_timestamp FROM event 
								WHERE is_completed=0 and generator_id='$id'
								ORDER BY last_edited_on_timestamp DESC";
						$result=mysql_query($sql,$con);
						while($row=mysql_fetch_array($result,MYSQL_ASSOC)){

							$event_id = $row['event_id'];
							$org = $row['org_name'];
							$pak = $row['ctc'];
							$det = $row['event_details'];
							$timestamp = strtotime($row['last_edited_on_timestamp']);
							$date = date('d-m-Y',$timestamp);
							
							echo "<div id=\"event--1\" class=\"row-fluid question-panel-box\">
								<div class=\"span10 question-panel-inner-rbox\" style='margin: 10px'>
									<h4> ".$org."</h4>
									<p> Description: ".$det." <br>CTC: ".$pak."</p>
									<a href=\"event.php?eventid=".$event_id."\" class=\"btn btn-success btn-small\" style=\"float:left\">View Event</a>
									<p class=\"posted-info\" >".$date."</p>
								</div>    
							</div>"; 
						}
					}
					else{
						$sql1="SELECT prog_start_year, prog_id from student
									where student_id='$id'";
						$res=mysql_query($sql1,$con);
						$row1=mysql_fetch_array($res);
						$batch = $row1['prog_start_year'];
						$progid = $row1['prog_id'];
						
						$sql="SELECT distinct event_id, org_name,ctc,event_details,last_edited_on_timestamp FROM event 
								WHERE is_completed=0 and batch = '$batch' and prog_id='$progid' 
								ORDER BY last_edited_on_timestamp DESC";
						
						$result=mysql_query($sql,$con);
						
						while($row=mysql_fetch_array($result,MYSQL_ASSOC)){
							
							$event_id = $row['event_id'];
							$org = $row['org_name'];
							$pak = $row['ctc'];
							$det = $row['event_details'];
							$timestamp = strtotime($row['last_edited_on_timestamp']);
							$date = date('d-m-Y',$timestamp);
							
							echo "<div id=\"event--1\" class=\"row-fluid question-panel-box\">
								<div class=\"span10 question-panel-inner-rbox\" style='margin: 10px'>
									<h4> ".$org."</h4>
									<p> Description: ".$det." <br>CTC: ".$pak."</p>
									<a href=\"event.php?eventid=".$event_id."\" class=\"btn btn-success btn-small\" style=\"float:left\">View Event</a>
									<p class=\"posted-info\" >".$date."</p>
								</div>    
							</div>"; 
						}
					}
				?>			

    		</div>
  		</div>
	</div>

	<div id="change_password" class="modal hide fade in" style="display: none; ">  
        <div class="modal-header">  
            <a class="close custom-close" data-dismiss="modal">x</a>  
            <h4>Change Password</h4>  
        </div>  
        <div class="modal-body">  
            <form class="well" method="POST" >
            	<table>          	
                	<tr>
                		<td >Old Password</td>
                		<td><input type="password" name="old_pw" pattern=".{4,}"td>
                	</tr>
                	<tr>
                		<td >New Password</td>
                		<td><input type="password" name="new_pw" pattern=".{4,}"></td>
                	</tr>
                	<tr>
                		<td >Confirm New Password</td>
                		<td><input type="password"name="confirm_pw" pattern=".{4,}"></td>
                	</tr>
                <table>  
                <button type="submit" class="btn btn-success" name="change_pw" >Change Password</button>
            </form>              
        </div>    
    </div> 
    

<!-- Le javascript
================================================== -->
<script src="assets/js/jquery.js"></script>
<script src="assets/js/bootstrap.min.js"></script>
<script type="text/javascript">
    var delete_id=0, delete_obj;
    $(document).ready(function(){
        $('#ask_question').click(function() {
            $('#question_box').toggle();
        });

        $('.reply-link').click(function() {
            var link_id = $(this).attr('id');
            var reply_panel_id = "#replies-panel--" + link_id.split("--")[1];
            $(reply_panel_id).toggle();
        });

        $('.custom-close').click(function() {
            console.log($(this).attr('id'));
            delete_obj = $(this).attr('id').split("__")[1];
            delete_id = $(this).attr('id').split("__")[2];
            console.log(delete_id);
        });

        $('.confirm-delete').click(function() {
            $("#"+delete_id).remove();
            delete_id = 0;
            if(delete_obj==="event") {
                $(".row-fluid").append("<div class=\'span9 panel-box\'><p><br>Event deleted.<br>Redirecting you to homepage.</p></div>");
                setTimeout(function(){window.location.replace("index.html");}, 3000);
            }
        });

    });
</script>
</body>
</html>
            