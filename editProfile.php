<?php
include("connect.php");
session_start();

if (isset($_SESSION['id'])) {
	$id=$_SESSION['id'];
	$res = mysql_query("SELECT is_approved FROM student WHERE student_id='$id'");
	$arr = mysql_fetch_array($res);
	$is_approved = $arr[0];
	if(!$is_approved) {
	
		include 'privileges.php';
		$sql="SELECT * FROM student where student_id='$id'";
		$result=mysql_query($sql,$con);
		$row = mysql_fetch_array($result, MYSQL_ASSOC);
		$name = $row['f_name']." ".$row['l_name'];
		$gender = $row['gender'];
		$studentid = $id;
		$dob = $row['DOB'];
		$batch= $row['prog_start_year'];
		
		$prid = $row['prog_id'];
		$prog = "SELECT prog_name FROM program where prog_id = '$prid'";
		$res = mysql_query($prog,$con);
		$program = mysql_fetch_array($res,MYSQL_ASSOC);
		$prog = $program['prog_name'];

		$stdx = $row['10th_per'];
		$stdxii = $row['12th_per'];

		if (isset($_POST['submit'])){
			$error = array();//Declare An Array to store any error message  
		
			if (empty($_POST['cpi'])) {//if no cpi has been supplied 
				$error[] = 'Please enter CPI ';//add to array "error"
			} else {
				if(!is_numeric($_POST['cpi'])) {
					$error[] = 'CPI must be a number';
				} else {
					if($_POST['cpi']<0 || $_POST['cpi']>10) {
						$error[] = 'CPI must be between 0 to 10';
					} else {
						$cpi = $_POST['cpi'];//else assign it a variable
					}	
				}
			}
			
			if (empty($_POST['curr_sem'])){ // if no current semester is provided
				$error[] = 'Please enter your current semester ';//add to array "error"
			} else {
				if(!is_numeric($_POST['curr_sem'])) {
					$error[] = 'Current Semester must be a number';
				} else {
					if($_POST['curr_sem']<0 || $_POST['curr_sem']>12) {
						$error[] = 'current semester must be between 0 to 12';
					} else {
						$curr_sem = $_POST['curr_sem'];//else assign it a variable
					}
				}
			}
			
			/*$query_edit_profile= "UPDATE student SET cpi='$cpi', curr_sem='$curr_sem' WHERE student_id='$id'";
			$result_edit_profile= mysql_query($query_edit_profile, $con);*/
			
		
			if (empty($_POST['electives'])){ // if no electives is provided
				$error[] = 'Please enter your new electives ';//add to array "error"
				} else {
					$electives= array();
					$electives=$_POST['electives'];//else assign it a variable
					
			}
					
			/*for($i=0;$i<count($electives);$i++) {
				$query_select_courseid="SELECT course_id from course where course_name='$electives[$i]'";
				$result_select_courseid=mysql_query($query_select_courseid, $con);
				$courseid=mysql_fetch_row($result_select_courseid);
				$query_check_electives="SELECT * from electives WHERE student_id='$id' AND course_id='$courseid[0]'";
				echo $query_check_electives;
				$result_check_electives=mysql_query($query_check_electives, $con);
			
				if(mysql_num_rows($result_check_electives)==0) {
					$query_insert_electives="INSERT INTO electives (`course_id`, `student_id`) VALUES ('$courseid[0]', '$id')";
					$result_insert_electives=mysql_query($query_insert_electives, $con );
					}
					
			}*/
			//resume upload	
			if (($_FILES["resume"]["type"] == "application/pdf") && ($_FILES["resume"]["size"] < 1000000) || $_FILES["resume"]["error"]==4){
				if ($_FILES["resume"]["error"] > 0 && $_FILES["resume"]["error"] != 4){
					echo "Return Code: " . $_FILES["resume"]["error"] . "<br>";
				} else{	
					$filenameR = $id.".pdf";
					chmod("assets/data/", 777);
					/*move_uploaded_file($_FILES["resume"]["tmp_name"], "assets/data/".$filenameR);*/
				}
			} else {
				$error = "Invalid file";
			}
			
			if (empty($error)) {
				$backlog = $_POST['backlog'];
			
				$query_edit_profile= "UPDATE student SET cpi='$cpi', curr_sem='$curr_sem', backlog='$backlog' WHERE student_id='$id'";
				$result_edit_profile= mysql_query($query_edit_profile, $con);
				
				for($i=0;$i<count($electives);$i++) {
					$query_select_courseid="SELECT course_id from course where course_name='$electives[$i]'";
					$result_select_courseid=mysql_query($query_select_courseid, $con);
					$courseid=mysql_fetch_row($result_select_courseid);
					$query_check_electives="SELECT * from electives WHERE student_id='$id' AND course_id='$courseid[0]'";
					echo $query_check_electives;
					$result_check_electives=mysql_query($query_check_electives, $con);
				
					if(mysql_num_rows($result_check_electives)==0) {
						$query_insert_electives="INSERT INTO electives (`course_id`, `student_id`) VALUES ('$courseid[0]', '$id')";
						$result_insert_electives=mysql_query($query_insert_electives, $con );
					}
					
				}
				
				move_uploaded_file($_FILES["resume"]["tmp_name"], "assets/data/".$filenameR);
				
				header('Location: profile.php');
			} else {
				foreach($error as $key => $values) {
					$error_message.= "$values";
				}
				echo $error_message;
			}
		
		}////////////////////////

	} else {
		header('Location: profile.php');
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
	<title>Edit Profile</title>
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
	<style>
		label.filebutton {
		    width:100px;
		    height:120px;
		    overflow:hidden;
		    background-color:#ccc;
		}

		label span input {
		    
		    line-height: 0;
		    font-size: 50px;
		    top: -2px;
		    left: -700px;
		    opacity: 0;
		    filter: alpha(opacity = 0);
		    -ms-filter: "alpha(opacity=0)";
		    cursor: pointer;
		    _cursor: hand;
		    margin: 0;
		    padding:0;
		}
	</style>
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
	            <div class="brand">DA-IICT</div>
				
	          	<div class="nav-collapse collapse">
	              	<ul class="nav">
	                  	<li class="divider-vertical"></li>
	                	<li><a href="index.php"><i class="icon-home icon-white"></i> Home</a></li>
	              	</ul>
               	
	              	<div class="pull-right">
	                	<ul class="nav pull-right">
	                    	<li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown">Welcome, <?php echo $name?> <b class="caret"></b></a>
	                        	<ul class="dropdown-menu">
	                            	<li><a href="editProfile.php"><i class=" icon-cog"></i> Edit Profile</a></li>
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
				<h2 class="header-gap">Edit Profile</h2>
    			<div class="row-fluid" style="margin-bottom:20px; margin-top:30px;">
    				<div class="span2">
		    			<!--<label class="filebutton">-->
						<label>
							<img src="assets/data/img/<?php echo $id ?>.png" style="float:right; height:100%; width:100%;">
						</label>
					</div>
					<div class="span9">
						<h3><?php echo $name; ?></h3>
					</div>
    			</div>

				<div id="editp">
    				<form method="POST" action="editProfile.php" enctype="multipart/form-data">
						<table style="width:100%;" class="table">
							<tr>
								<td>Gender</td>
								<td><?php echo $gender; ?></td>
							</tr>

							<tr>
								<td>Student Id</td>
								<td><?php echo $studentid; ?></td>
							</tr>

							<tr>
								<td>CPI</td>
								<td>
									<input required type="number" name="cpi" placeholder="CPI" id="cpi" pattern="[-+]?[0-9]*[.,]?[0-9]+" min="0" max="10" value="" step="0.01">
								</td>
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
								<td>Current Semester</td>
								<td colspan="6">
									<select name="curr_sem">
										<option value="1" selected> 1 </option>
										<option value="2"> 2 </option>
										<option value="3"> 3 </option>
										<option value="4"> 4 </option>
										<option value="5"> 5 </option>
										<option value="6"> 6 </option>
										<option value="7"> 7 </option>
										<option value="8"> 8 </option>
										<option value="9"> 9 </option>
										<option value="10"> 10 </option>
										<option value="11"> 11 </option>
										<option value="12"> 12 </option>
									</select>
								</td>
							</tr>

							<tr>
								<td>Electives Chosen</td>
								<td>
								
									<select name="electives[]" multiple="multiple">";
									<?php
										$sql1 = mysql_query("SELECT distinct course_name FROM course where course_type='Group Elective' or course_type='Humanity Elective' or course_type='Technical Elective' or course_type='Science Elective' ",$con);
										if(mysql_num_rows($sql1)){
										while($row = mysql_fetch_assoc($sql1)){
											echo "<option value=\"".$row['course_name']."\">".$row['course_name']."</option>";
											}
										}
									?>
									</select>
									
								</td>
							</tr>
							
							<tr>
								<td> Backlog </td>
								<td colspan="2"> 
									<input type="radio" value="1" name="backlog"> Yes 
									<input type="radio" value="0" name="backlog" checked> No
								</td>
							</tr>

							<tr>
								<td>Std X</td>
								<td><?php echo $stdx; ?></td>
							</tr>

							<tr>
								<td>Std XII
								<td><?php echo $stdxii; ?></td>
							</tr>
							
							<tr>
								<td>Your cuurent Resume</td>
								<td>
									<input type="button"  value="View Resume" onClick="location.href='assets/data/<?php echo $id.".pdf" ?>'">
								</td>
							</tr>    

							<tr>
								<td>Upload New Resume <BR> (Upload pdf file of size no more than 1MB)</td>
								<td colspan="1"><input type="file" name="resume" size="10"></td>
							</tr>
						</table>
						<input name="submit" type="submit" value="Done" class="btn btn-success" >
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
</body>
</html>
            