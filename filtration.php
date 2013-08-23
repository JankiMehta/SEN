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
 
 if($privilege != 'admin'){
		header('Location: index.php');
 }
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Filter</title>
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
    		<!--Sidebar content-->
    		<div id="sidebar_box" class="span3 sidebar-box">
    			<div class="well sidebar-nav custom-well">
    				<img src="assets/img/daiict.png" class="img-rounded sidebar-img" >

    			    <ul class="nav nav-list">  
                        <li class="active"><a href="index.php">Home</a></li>
                        <li><a href="listevents.html">Events</a></li>  
						<?php if(strcmp($privilege,"student")==0){
                        echo "<li><a href=\"profile.php\">Profile</a></li> ";}?> 
                        <li><a href="http://webmail.daiict.ac.in">Webmail</a></li>
                    </ul>
    			</div>	
    		</div>

    		

    		<!--Body content-->
    		<div class="span9"> 
    			<div class="row-fluid panel-box">
    				<h3>Filter Students</h3>
                    
                    <div class="form-horizontal" style="max-height:500px;">  
           <form action="filterprocess.php" method="post" onsubmit="return validateForm(this)">
				<table style="width:100%;" class="table">
					<tr>
						<td><input type="checkbox" name="options[]" value="CPI"> CPI</td>
						<td>From:  <input type="text" name="cpiF" style="width:120px"></td>
					 	<td>To:  <input type="text" name="cpiT" style="width:120px"></td>
				 	</tr>

					<tr>
						<td><input type="checkbox" name="options[]" value="elective"> Electives </td>
						<td colspan="4">
							<select name="elective"  size="5">
								<?php
									$sql1 = mysql_query("SELECT distinct course_name , course_id  FROM course where course_type='Group Elective' or course_type='Humanity Elective' or course_type='Technical Elective' or course_type='Science Elective' ",$con);
									if(mysql_num_rows($sql1)){
									while($row = mysql_fetch_assoc($sql1)){
										echo "<option value=\"".$row['course_id']."\">".$row['course_name']."</option>";
										}
									}
								?>
							</select>
						</td>
					</tr>
					
					<tr>
						<td><input type="checkbox" name="options[]" value="program"> Program </td>
						<td colspan="4"><select name="program">
							<option value="B.Tech"> B.Tech </option>
							<option value="M.Tech"> M.Tech </option>
							<option value="MSC-IT"> MSC-IT </option>
							</select>
						</td>
					</tr>

					<tr>
						<td><input type="checkbox" name="options[]" value="batch"> Batch </td>
						<td colspan="4"><select name="batch">
							<option value="2013"> 2013 </option>
							<option value="2012"> 2012 </option>
							<option value="2011"> 2011 </option>
							<option value="2010"> 2010 </option>
							<option value="2009"> 2009 </option>
							<option value="2008"> 2008 </option>
							<option value="2008"> 2007 </option>
							</select>
						</td>
					</tr>


					<tr>
						<td> <input type="checkbox" name="options[]" value="gender"> Gender </td>
						<td><input type="radio" name="gender" value="M" checked> Male </td>
						<td><input type="radio" name="gender" value="F"> Female </td>
					</tr>

					<tr>
						<td> <input type="checkbox" name="options[]" value="status"> Status </td>
						<td> <input type="radio" name="status" value="placed" checked> Placed </td>
						<td> <input type="radio" name="status" value="unplaced"> Unplaced </td>
					</tr>

					<tr>
						<td> <input type="checkbox" name="options[]" value="stdX"> Std X % </td>
						<td>From:  <input type="text" name="xpF" style="width:120px"> </td>
					 	<td>To:  <input type="text" name="xpT" style="width:120px"> </td>
				 	</tr>

					<tr>
						<td><input type="checkbox" name="options[]" value="stdXII"> Std XII % </td>
						<td>From:  <input type="text" name="xiipF" style="width:120px"> </td>
					 	<td>To:  <input type="text" name="xiipT" style="width:120px"> </td>					
					</tr>
				</table>
				<input type="submit" class="btn btn-success btn-small">
			</form>              
        </div>    
    		</div>		
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
<script src="assets/js/filtration.js"></script>
</body>
</html>
            
