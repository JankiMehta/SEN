<?php
include 'connect.php' ;
session_start();
if (isset($_SESSION['id'])) {
	$id=$_SESSION['id'];
//	$id="201001093";
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
 
 if($privilege != 'admin'){
	header('Location: index.php');
 }
 include "change_pw.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Event Completion</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="author" content="Sanskriti Jain">
	<!-- Le styles -->
	<link href="assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/css/chosen.css" rel="stylesheet">
	<link href="assets/css/common.css" rel="stylesheet">
	<!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
	<!--[if lt IE 9]>
	<script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->
	<!-- Le fav and touch icons -->
</head>

<body onload='init()'>
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
    		<div class="span3 sidebar-box">
                <div class="well sidebar-nav custom-well">
                    <img src="assets/img/daiict.png" class="img-rounded sidebar-img" >

                    <ul class="nav nav-list">  
                        <li><a href="index.php">Home</a></li>
                        <li><a href="listevents.php">Events</a></li>  
                        <li><a href="profile.php">Profile</a></li>  
                        <li><a href="http://webmail.daiict.ac.in">Webmail</a></li>
                    </ul>
                    
                </div>  
            </div>

    		<!--Body content-->
    		<div class="span9 panel-box">
    			<h2>Event Completion</h2>
		  		<div class="row-fluid">
				<form action='completeEvent.php' method='post'>
				<?php
		  			echo "<div class=\"span5\">
						<select name=\"company\" id=\"company\" size=\"1\" class=\"chosenElement\" >";
							
								$sql1 = mysql_query("SELECT e.event_id,e.org_name,e.event_type,e.batch,p.prog_name
													FROM event as e,program as p
													WHERE is_completed = 0
													and e.prog_id = p.prog_id");
								if(mysql_num_rows($sql1)){
								while($row = mysql_fetch_assoc($sql1)){
									echo "<option id=\"".$row['event_id']."\" value=\"".$row['event_id']."\">".$row['org_name']."-".$row['event_type']."-".$row['batch']."-".$row['prog_name']. "</option>";
									}
								}
							
						echo "</select>
					</div>";
				
		  			echo "<div class=\"span5 student_multiple_selector\">
					<select name=\"selected_students[]\" id=\"students\" multiple=\"multiple\" size=\"1\" class=\"chosenElement\">";
								$sql2 = mysql_query("SELECT event_reg_id,event_id,student_id FROM `eventregister` WHERE event_id = \"abc\"");
								if(mysql_num_rows($sql2)){
								while($row = mysql_fetch_assoc($sql2)){
									echo "<option value=\"".$row['event_id']."\">".$row['org_name']."-- ".$row['event_type']. "</option>";
									}
								}
						echo "</select>
						</div>";
				
				
				?>
				<input type='submit' class='btn btn-success' value='Done'>
				</form>
		  		</div>
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
<script src="assets/js/chosen.jquery.js"></script>

<script type="text/javascript">
var registered_students;
		function init(){
				$(document).ready(function() {
				var select = document.getElementById('company');
				select.onchange = populateOption;
				//
				var choice = select.options[select.selectedIndex].id;
			console.info(choice);
			if (choice != "") {
			console.info("NOT !! "+choice);
			
		$.post("getIdsEvent.php", { event_id : choice },
  function(data, status){
   //alert("Data: " + data + "\nStatus: " + status);
    //console.info(data);
   // console.info(status);
	console.info(data);
	var status = "success";
	if(status == "success"){
	registered_students = data;
	//
	  $html2 = '<select name="selected_students[]" id="students" multiple="multiple" size="1" class="chosenElement">';
			 for(var j=0; j<registered_students.length; j++) {
  			 $html2 += '<option value="'+registered_students[j]['student_id']+'">'+registered_students[j]['student_id']+'</option>';
  		 }
		 $html2 += "</select>";
  		 $('.student_multiple_selector').html($html2);
  		$('#students').chosen();
	
	//
	
	}
  },"json");
		
			}
				
				
				
				//
				});
		}

		function populateOption(){
			var choice = this.options[this.selectedIndex].id;
			console.info(choice);
			if (choice != "") {
			console.info("NOT !! "+choice);
			/**
			registered_students = ['201001093','201001092','201001033','201001044'];
			 $html2 = '<select name="selected_students[]" id="students" multiple="multiple" size="1" class="chosenElement">';
			 for(var j=0; j<registered_students.length; j++) {
  			 $html2 += '<option value="foo">'+registered_students[j]+'</option>';
  		 }
  		 $('.student_multiple_selector').html($html2);
  		$('#students').chosen();
		
		**/
		$.post("getIdsEvent.php", { event_id : choice },
  function(data, status){
   //alert("Data: " + data + "\nStatus: " + status);
    //console.info(data);
   // console.info(status);
	console.info(data);
	var status = "success";
	if(status == "success"){
	registered_students = data;
	//
	  $html2 = '<select name="selected_students[]" id="students" multiple="multiple" size="1" class="chosenElement">';
			 for(var j=0; j<registered_students.length; j++) {
  			 $html2 += '<option value="'+registered_students[j]['student_id']+'">'+registered_students[j]['student_id']+'</option>';
  		 }
		 $html2 += "</select>";
  		 $('.student_multiple_selector').html($html2);
  		$('#students').chosen();
	
	//
	
	}
  },"json");
		
			}
		}
		
	$(document).ready(function() {
  	//	$html = '<select name="company" id="company" size="1" class="chosenElement">';
		//GET ALL COMPANIES INTO THIS ARRAY
  		// var companies = ['Amazon','Deloitte','TCS','Infosys'];
  		// for(var i=0; i<companies.length; i++) {
  			// $html += '<option value="foo">'+companies[i]+'</option>';
  		// }
  		// $('.company_selector').html($html);
  		$('#company').chosen();

		

  		 $html2 = '<select name="selected_students[]" id="students" multiple="multiple" size="1" class="chosenElement">';
		// //GET ALL REGISTERED STUDENTS INTO THIS ARRAY
  		 registered_students = [];
  		
  		 for(var j=0; j<registered_students.length; j++) {
  			 $html2 += '<option value="foo">'+registered_students[j]+'</option>';
  		 }
		 $html2 += "</select>";
  		 $('.student_multiple_selector').html($html2);
  		$('#students').chosen();
		
	});
</script>
</body>
</html>
            
