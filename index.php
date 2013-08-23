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
 include 'change_pw.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Welcome!</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	
	<!-- Le styles -->
	<link href="assets/css/bootstrap.min.css" rel="stylesheet">
	<link href="assets/css/common.css" rel="stylesheet">
	<link href="assets/css/bootstrap-responsive.min.css" rel="stylesheet">
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
                                    <li><a href=\"eventcompletion.php\"><i class=\"icon-bullhorn\"></i>Complete Evemt </a></li>
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
	                        	</ul>
	                    	</li>
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
                        <li class="active"><a href="index.php">Home</a></li>
                        <li><a href="listevents.php">Events</a></li>  
						<?php if(strcmp($privilege,"student")==0){
                        echo "<li><a href=\"profile.php\">Profile</a></li> ";}?> 
                        <li><a href="http://webmail.daiict.ac.in">Webmail</a></li>
                    </ul>
    			</div>	
    		</div>

    		<!--Body content-->
    		<div class="span9">   			
    			<div class="row-fluid" >
    			    <div id="myCarousel" class="carousel slide" >
			      		<ol class="carousel-indicators">
							<li data-target="#myCarousel" data-slide-to="0" class="active"></li>
							<li data-target="#myCarousel" data-slide-to="1"></li>
							<li data-target="#myCarousel" data-slide-to="2"></li>
			      		</ol>
			      		<!-- Carousel items -->
			      		<div class="carousel-inner">
							<div class="active item">
				  				<img class="adjust-height" src="assets/img/da-campus1.jpg" alt="">
				  				<div class="carousel-caption">
                      				<h4>Resource Center</h4>
                    			</div>
							</div>
							<div class="item">
				  				<img class="adjust-height" src="assets/img/da-campus2.jpg" alt="">
				  				<div class="carousel-caption">
                      				<h4>Lotus Pond</h4>
                    			</div>
							</div>
							<div class="item">
				  				<img class="adjust-height" src="assets/img/da-campus3.jpg" alt="">
				  				<div class="carousel-caption">
                      				<h4>Open Air Theater</h4>
                    			</div>
							</div>
			      		</div>
			      		<!-- Carousel nav -->
			      		<a class="carousel-control left" href="#myCarousel" data-slide="prev">&lsaquo;</a>
			      		<a class="carousel-control right" href="#myCarousel" data-slide="next">&rsaquo;</a>
			    	</div>
    			</div>
    		</div>
    	</div>

	    <div class="row-fluid panel-box">	    	
	    	<div class="row-fluid">
	    		<div class="span12">
	    			<h3>Recent events</h3>
	    		</div>
	    	</div>
	    	<div class="row-fluid">  
		    	<?php
					if(strcmp($privilege,"admin")==0 or strcmp($privilege,"spc")==0){
					
						$sql="SELECT event_id, org_name,ctc,domain,eli_cri,last_edited_on_timestamp FROM event
							where is_completed=0
							order by last_edited_on_timestamp DESC
							limit 3";
					
						$result=mysql_query($sql,$con);
						
						while($row=mysql_fetch_array($result,MYSQL_ASSOC)){
							$org = $row['org_name'];
							$pak = $row['ctc'];
							$elc = $row['eli_cri'];
							$domain =$row['domain'];
							$event_id=$row['event_id'];
							echo "<div class=\"span4\"> 
								<h4>".$org."</h4>
								<div class=\"row-fluid\">
									<div class=\"span9\">
										<p>CTC: ".$pak."</br> </p>
										<p>Profile: ".$domain."</br> </p>
										<p>Eligibility criteria: ".$elc."</br> </p>
									</div>				
								</div>  
								<p><a href=\"event.php?eventid=".$event_id."\" class=\"btn btn-success btn-small\" style=\"float:left\">View Event</a></p>  
							</div>";
						}
					}
					else if(strcmp($privilege,"faculty")==0){
						
						$sql="SELECT event_id, org_name,ctc,domain,eli_cri,last_edited_on_timestamp FROM event
							where is_completed=0 and generator_id='$id'
							order by last_edited_on_timestamp DESC
							limit 3";
					
						$result=mysql_query($sql,$con);
						
						while($row=mysql_fetch_array($result,MYSQL_ASSOC)){
							$org = $row['org_name'];
							$pak = $row['ctc'];
							$elc = $row['eli_cri'];
							$domain =$row['domain'];
							$event_id=$row['event_id'];
							echo "<div class=\"span4\"> 
								<h4>".$org."</h4>
								<div class=\"row-fluid\">
									<div class=\"span9\">
										<p>CTC: ".$pak."</br> </p>
										<p>Profile: ".$domain."</br> </p>
										<p>Eligibility criteria: ".$elc."</br> </p>
									</div>				
								</div>  
								<p><a href=\"event.php?eventid=".$event_id."\" class=\"btn btn-success btn-small\" style=\"float:left\">View Event</a></p>  
							</div>";
						}
					}
					else{
						$sql1="SELECT prog_start_year, prog_id from student
									where student_id='$id'";
						$res = mysql_query($sql,$con);
						$row1=mysql_fetch_array($res);
						$batch = $row1['prog_start_year'];
						$progid = $row1['prog_id'];
						
						$sql="SELECT event_id, org_name,ctc,domain,eli_cri,last_edited_on_timestamp FROM event
								where is_completed=0 and batch = '$batch' and prog_id='$progid'
								order by last_edited_on_timestamp DESC
								limit 3";
					
						$result=mysql_query($sql,$con);
						
						while($row=mysql_fetch_array($result,MYSQL_ASSOC)){
							$org = $row['org_name'];
							$pak = $row['ctc'];
							$elc = $row['eli_cri'];
							$domain =$row['domain'];
							$event_id=$row['event_id'];
							
							echo "<div class=\"span4\"> 
								<h4>".$org."</h4>
								<div class=\"row-fluid\">
									<div class=\"span9\">
										<p>CTC: ".$pak."</br> </p>
										<p>Profile: ".$domain."</br> </p>
										<p>Eligibility criteria: ".$elc."</br> </p>
									</div>				
								</div>  
								<p><a href=\"event.php?eventid=".$event_id."\" class=\"btn btn-success btn-small\" style=\"float:left\">View Event</a></p>  
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
	$(document).ready(function(){
		var elem = document.getElementById("sidebar_box");
    	var height = window.getComputedStyle(elem,null).getPropertyValue("height");
    	$(".adjust-height").css("height",height)
    	$(".adjust-height").css("width","auto")
	});
</script>
</body>
</html>
            
