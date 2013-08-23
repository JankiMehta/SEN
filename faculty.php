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

	if (isset($_POST['submit'])) {	
		if(strcmp($privilege, "admin")==0) {
			$faculty_id=$_POST['faculty_id'];
			$f_name=$_POST['f_name'];
			$m_name=$_POST['m_name'];
			$l_name=$_POST['l_name'];

			$error = array();
			if(strlen($faculty_id)!=9 or is_numeric($faculty_id)==0 or empty($faculty_id))
				$error[] = 'Invalid ID.';
			if(strlen($f_name)>50 or empty($f_name))
				$error[] = 'First Name too Long.Max 50 characters allowed.';
			if(strlen($m_name)>50)
				$error[] = 'Middle Name too Long.Max 50 characters allowed.';
			if(strlen($l_name)>50 or empty($l_name))
				$error[] = 'Last name too Long.Max 50 characters allowed.';


			foreach ($error as $key => $values) { 
						echo '	<li>'.$values.'</li>';
					}
				$pw = md5($faculty_id);
				$insert_query1="insert into user (user_id, password)
							values('$faculty_id', '$pw')";
							
				$insert_query="insert into faculty (faculty_id,f_name,m_name,l_name)
							values('$faculty_id','$f_name','$m_name','$l_name')";
				
				if(sizeof($error)==0){
					if (!mysql_query($insert_query1,$con)){
						echo "EEROR";
						die('Could not be inserted');
					}
			  
					if (!mysql_query($insert_query,$con)){
						echo "ERROR";
						die('Could not be inserted');
					}
					else
					{
						header('Location: faculty.php');;
					}
				}
			mysql_close($con);
		} else {
			echo "You are not privileged to enter Faculty details";
		}
	}
} else {
	header('Location: login.php');
}
include "change_pw.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Faculty Registration</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<!-- We don't need author field -->
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
								<?php if(strcmp($privilege,"student")==0){
	                            	echo "<li><a href=\"editProfile.php\"><i class=\" icon-cog\"></i> Edit Profile</a></li> "; } ?>
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

    		<!--Body content-->
    		<div class="span9 panel-box" style="margin-left:auto; margin-right:auto; float:none">
				<h2>Faculty Registration</h2>
				<div id="regtr">
					<form name="form1"  method ="post" onSubmit="return validateForm()">
						<table style="margin-left:50px; width:100%;">
	
							<tr> 
								<td>Faculty ID:</td>
								<td > <input required type="text" name="faculty_id" pattern="[+]?[0-9]{9,9}" placeholder="Faculty ID" id="faculty_id"></td>
								<tr><td></td><td><div id="faculty_id1"></div></td></tr>
								<td></td> 
								<td></td> 
								<td></td>
								<td></td> 
							</tr>
						
							<tr> 
								<td>First Name</td>
								<td ><input required type="text" name="f_name" pattern="[a-z A-Z]{1,20}" placeholder="First Name" id="f_name"></td>
								<tr><td></td><td><div id="f_name1"></div></td></tr>
								<td></td> 
								<td></td> 
								<td></td>
								<td></td>
							</tr>
							
						   <tr> 
								<td>Middle Name</td>
								<td ><input type="text" name="m_name" pattern="[a-z A-Z]{1,20}" placeholder="Middle Name" id="m_name"></td>
								<tr><td></td><td><div id="m_name1"></div></td></tr>
								<td></td> 
								<td></td> 
								<td></td>
								<td></td>
							</tr>
							
							<tr>
								<td>Last Name</td>
								<td><input required type="text" name="l_name" pattern="[a-z A-Z]{1,20}" placeholder="Last Name" id="l_name"></td>
								<tr><td></td><td><div id="l_name1"></div></td></tr>
								<td></td> 
								<td></td> 
								<td></td>
								<td></td>
							</tr>
						   <tr>
						   </tr>
						</table>
		<input type="submit" class="btn btn-success" name="submit">
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
<script src="assets/js/validate_faculty.js"></script>
  
</body>
</html>            