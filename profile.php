<?php
include("connect.php");
session_start();
if(isset($_SESSION['id'])) {
	$id=$_SESSION['id'];
	include 'privileges.php';
	$sql="SELECT * FROM student where student_id='$id'";
	$result=mysql_query($sql,$con);
	$row = mysql_fetch_array($result, MYSQL_ASSOC);
	$name = $row['f_name']." ".$row['m_name']." ".$row['l_name'];
	if($row['gender']=='M'){
		$gender = "Male";
	} else {
		$gender = "Female";
	}
	$studentid = $id;
	$sem = $row['curr_sem'];
	$cpi = $row['CPI'];
	$dob = $row['DOB'];
	$batch= $row['prog_start_year'];
	$prid = $row['prog_id'];
	if($row['backlog']){
		$backlog = "Yes";
	} else {
		$backlog = "No";
	}
	$prog = "SELECT prog_name FROM program where prog_id = '$prid'";
	$res = mysql_query($prog,$con);

	$program = mysql_fetch_array($res,MYSQL_ASSOC);
	$prog = $program['prog_name'];

	$sql1 = "SELECT c.course_name FROM course as c,electives as e 
				where c.course_id = e.course_id
				and e.student_id=$id";
	$res1 = mysql_query($sql1,$con);
	$course = array();
	while($elec = mysql_fetch_array($res1,MYSQL_ASSOC)){
		$course[] = $elec['course_name'];
	}
	$electives = $elec['course_name'];
	$stdx = $row['10th_per'];
	$stdxii = $row['12th_per'];
} else {
	header('Location: login.php');
}
include "change_pw.php";

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Profile</title>
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
											echo "<li><a href=\"editProfile.php\"><i class=\" icon-cog\"></i> Edit Profile</a></li> "; }} 
									?>
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
                        <li class="active"><a href="profile.php">Profile</a></li>  
                        <li><a href="http://webmail.daiict.ac.in">Webmail</a></li>
                    </ul>
                    
                </div>  
            </div>

    		<!--Body content-->
    		<div class="span9 panel-box">
        		
                <h2>Profile</h2>
                <div class="row-fluid" style="margin-bottom:20px; margin-top:30px;">
                    <div class="span2">
                        <img src="assets/data/img/<?php echo $id.".png";?>" style="width:100%; height=100%"> 
                    </div>
                    <div class="span9">
                        <h3><?php echo $name; ?></h3>
                    </div>
                </div>               

                <table class="table" style="width:100%;">

                    <tr>
                        <td>Student Id</td>
                        <td><?php echo $studentid; ?></td>
                    </tr>
					
					<tr>
                        <td>Gender</td>
                        <td><?php echo $gender; ?></td>
                    </tr>

                    <tr>
                        <td>CPI</td>
                        <td><?php echo $cpi; ?></td>
                    </tr>

                    <tr>
                        <td>Date of Birth</td>
                        <td><?php echo $dob; ?></td>
                    </tr>

                    <tr>
                        <td>Program</td>
                        <td colspan="1"><?php echo $prog; ?></td>
                    </tr>

                    <tr>
                        <td>Batch</td>
                        <td colspan="6"><?php echo $batch; ?></td>
                    </tr>

                    <tr>
                        <td>Electives Chosen</td>
                        <td colspan="6"><?php foreach ($course as $key => $values) { 
											echo ''.$values.'</br>';
										}; ?></td>
                    </tr>
					
					<tr>
                        <td>Backlog</td>
                        <td><?php echo $backlog; ?></td>
                    </tr>

                    <tr>
                        <td>Std X</td>
                        <td><?php echo $stdx; ?></td>
                    </tr>

                    <tr>
                        <td>Std XII
                        <td><?php echo $stdxii; ?></td>
                    </tr>
                </table>

                <div class="row-fluid">
				<?php
					if(strcmp($privilege,"student")==0){
					$query_approved="select is_approved from student where student_id='$id'";
					$result=mysql_query($query_approved, $con);
					$row=mysql_fetch_array($result);
					if($row['is_approved']==0) {
                     echo '<a href="editProfile.php" class="btn btn-primary">Edit Profile</a>'; }} 
				?>
                    <a class="btn btn-success" href="assets/data/<?php echo $id.".pdf"?>" >View Resume</a>
                </div>				
    		</div>
  		</div>
	</div>

    <div id="change_password" class="modal hide fade in" style="display: none; ">  
        <div class="modal-header">  
            <a class="close custom-close" data-dismiss="modal">×</a>  
            <h4>Change Password</h4>  
        </div>  
        <div class="modal-body">  
            <form class="well" method="POST" >
            	<table>          	
                	<tr>
                		<td >Old Password</td>
                		<td><input type="password" name="old_pw" pattern=".{4,}"></td>
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
</body>
</html>
            