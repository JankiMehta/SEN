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
	$username = $row['f_name']." ".$row['l_name'];
} else {
	header('Location: login.php');
	}
 include 'change_pw.php';
 
 if($privilege != 'admin'){
		header('Location: index.php');
 }
$result = mysql_query("SET NAMES utf8");
$sqle="";
$sqll="";
$sql = "";

//print_r($_POST['options']);

if(isset($_POST['options'])){
	//echo "SET<br>";
  if (is_array($_POST['options'])) {
	//echo "ARRAY<br>";
    foreach($_POST['options'] as $val){
			if($val == "CPI"){
				if($_POST['cpiF'] == ""){
					$_POST['cpiF'] = 0;
				}
				if($_POST['cpiT'] == ""){
					$_POST['cpiT'] = 10;
				}
				$cF = mysql_real_escape_string($_POST['cpiF']);
				$cT = mysql_real_escape_string($_POST['cpiT']);
				if($sql == ""){
				$sql = "SELECT student_id FROM student WHERE ";
				$sql .= " CPI >= '$cF' AND CPI <= '$cT'";
				}else
				$sql .= " AND CPI >= '$cF' AND CPI <= '$cT'";
			}
			else if($val == "elective"){
		if(isset($_POST['elective'])){
		//	$el=$_POST['elective'];
		//	$sqle = "SELECT student_id FROM electives WHERE electives = '$el'";
			if (is_array($_POST['elective'])) {
			//$sqle = "SELECT DISTINCT student_id FROM ( ";
			$sqle = "SELECT * FROM ( ";
		//	echo "<BR>;;1;;".$sqle."<br>";
			$i=1;
			foreach($_POST['elective'] as $val){
				$val = mysql_real_escape_string($val);
				$r = "r".$i;
				$sqle .= "(SELECT student_id FROM electives WHERE course_id = '$val')";
				$i=$i+1;
		//		echo "<BR>;;2;;".$sqle."<br>";
			}
			$sqle = substr($sqle, 0, strlen($sqle) - 6 );
			$sqle .= " ) AS Temp";
			
		//	echo "<BR>;;3;;".$sqle."<br>";
			}
			else{
			$val = mysql_real_escape_string($_POST['elective']);
			$sqle = "SELECT student_id FROM electives WHERE course_id = '$val'";
			}
			
			}
		
		}
		else if($val == "program"){
			  
			$program = mysql_real_escape_string($_POST['program']);
			if($sql == ""){
				$sql = "SELECT student_id FROM student WHERE ";
			$sql .= " prog_id = (SELECT prog_id FROM program WHERE prog_name = '$program' )";
			}else
			$sql .= " AND prog_id = (SELECT prog_id FROM program WHERE prog_name = '$program' )";
		
		}
		else if($val == "batch"){
		 $batch = mysql_real_escape_string($_POST['batch']);
		 if($sql == ""){
				$sql = "SELECT student_id FROM student WHERE ";
		$sql .= " prog_start_year = '$batch'";
		}else
		$sql .= " AND prog_start_year = '$batch'";
		
		}
	/*	else if($val == "domain"){
		if(isset($_POST['domain'])){
		$domain = mysql_real_escape_string($_POST['domain']);
		if($sql == ""){
				$sql = "SELECT student_id FROM student WHERE ";
		$sql .= " domain = '$domain'"; //domain not in db !!!
		}else
		$sql .= " AND domain = '$domain'"; //domain not in db !!!
		}
		}
		*/
		else if($val == "gender"){
		if(isset($_POST['gender'])){
		$gender = mysql_real_escape_string($_POST['gender']);
		if($sql == ""){
				$sql = "SELECT student_id FROM student WHERE ";
		$sql .= " gender = '$gender'";
		}else
		$sql .= " AND gender = '$gender'";
		}
		}		
		else if($val == "status"){
		$status = mysql_real_escape_string($_POST['status']);
		if($status == "placed"){
		$sqll = "SELECT student.student_id FROM student JOIN (SELECT DISTINCT eventregister.student_id FROM eventregister JOIN placement ON eventregister.event_reg_id = placement.event_reg_id ) as r ON student.student_id = r.student_id";
		}else{
		$sqll = "SELECT student_id FROM student WHERE (student_id) NOT IN (SELECT student.student_id AS student_id FROM student JOIN (SELECT DISTINCT eventregister.student_id FROM eventregister JOIN placement ON eventregister.event_reg_id = placement.event_reg_id ) as r ON student.student_id = r.student_id )";
		}
		}
		
		else if($val == "stdX"){
				if($_POST['xpF'] == ""){
					$_POST['xpF'] = 0;
				}
				if($_POST['xpT'] == ""){
					$_POST['xpT'] = 100;
				}
				$cF = mysql_real_escape_string($_POST['xpF']);
				$cT = mysql_real_escape_string($_POST['xpT']);
				if($sql == ""){
				$sql = "SELECT student_id FROM student WHERE ";
				$sql .= " 10th_per >= '$cF' AND 10th_per <= '$cT'";
				}else
				$sql .= " AND 10th_per >= '$cF' AND 10th_per <= '$cT'";
			}
		else if($val == "stdXII"){
				if($_POST['xiipF'] == ""){
					$_POST['xiipF'] = 0;
				}
				if($_POST['xiipT'] == ""){
					$_POST['xiipT'] = 100;
				}
				$cF = mysql_real_escape_string($_POST['xiipF']);
				$cT = mysql_real_escape_string($_POST['xiipT']);
				if($sql == ""){
				$sql = "SELECT student_id FROM student WHERE ";
				$sql .= " 12th_per >= '$cF' AND 12th_per <= '$cT'";
				}else
				$sql .= " AND 12th_per >= '$cF' AND 12th_per <= '$cT'";
			}
  }
}
}
if($sql != ""){
//echo $sql."<br>";
$result = mysql_query($sql);
$to_encode = array();
while($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
  $to_encode[] = $row;
}
//echo json_encode($to_encode);
}else{
$sql = "SELECT student_id FROM student WHERE 1";
}
//echo "<br>";
//echo $sqle."<br>";
if($sqle != ""){
$result = mysql_query($sqle);
$to_encode = array();
while($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
  $to_encode[] = $row;
}
//echo json_encode($to_encode);
}else{
$sqle = "SELECT student_id FROM student WHERE 1";
}
//echo "<br>";
//echo $sqll."<br>";
if($sqll != ""){
$result = mysql_query($sqll);
$to_encode = array();
while($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
  $to_encode[] = $row;
}
//echo json_encode($to_encode)."<BR>";
}else{
$sqll = "SELECT student_id FROM student WHERE 1";
}

$s="( SELECT C.student_id FROM 
( ".$sql." ) A
INNER JOIN 
( ".$sqle." ) B ON A.student_id = B.student_id 
INNER JOIN 
( ".$sqll." ) C ON B.student_id = C.student_id ) D";
//$cl = "student.student_id,student.f_name,student.m_name,student.l_name,student.DOB,student.prog_id,student.prog_start_year,student.CPI,student.curr_sem,student.10th_per,student.12th_per,student.is_activated,student.is_approved,student.resume,student.gender";
$cl = "student.student_id,student.f_name,student.m_name,student.l_name,student.DOB,student.CPI,student.curr_sem,student.10th_per,student.12th_per,student.is_approved,student.resume,student.gender";
$sf = "SELECT ".$cl." FROM student JOIN ( ".$s." ) ON student.student_id = D.student_id";


$result = mysql_query($sf);
//echo $sf."<br>";
$to_encode = array();
//$data = "<table width='100%' class='table table-striped table-bordered'><b><tr><th>Student ID<th>First Name<th>Middle Name<th>Last Name<th>DOB<th>Prog_ID<th>Prog_Start_Year<th>CPI<th>Current Sem<th>10th %<th>12th %<th>IS_Activated<th>IS_Approved<th>Resume<th>Gender</b>";
$data = "<table width='100%' class='table table-striped table-bordered'><b><tr><th>Student ID<th>Name<th>DOB<th>CPI<th>Current Sem<th>10th %<th>12th %<th>Resume<th>Gender<th>Approval</b>";
while($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
	$approve="";
	if($row['is_approved'] == 1)
	$approve = "<a href='deactivate.php?studentid=".$row['student_id']."' target='_blank' >Click To Deactivate</a>";
	else
	$approve = "<a href='approve.php?studentid=".$row['student_id']."' target='_blank' >Click To approve</a>";
	
	$link = "<a href='http://localhost/".$row['resume']."' target='_blank' >Link</a>";
	//$data .= "<tr><td>".$row['student_id']."<td>".$row['f_name']."<td>".$row['m_name']."<td>".$row['l_name']."<td>".$row['DOB']."<td>".$row['prog_id']."<td>".$row['prog_start_year']."<td>".$row['CPI']."<td>".$row['curr_sem']."<td>".$row['10th_per']."<td>".$row['12th_per']."<td>".$row['is_activated']."<td>".$row['is_approved']."<td>".$link."<td>".$row['gender'];
	$data .= "<tr><td>".$row['student_id']."<td>".$row['f_name']." ".$row['m_name']." ".$row['l_name']."<td>".$row['DOB']."<td>".$row['CPI']."<td>".$row['curr_sem']."<td>".$row['10th_per']."<td>".$row['12th_per']."<td>".$link."<td>".$row['gender']."<td>".$approve;
  $to_encode[] = $row;
}
$data .="</table>";
//echo "<h1> FINAL: <br>".json_encode($to_encode)."<BR>";
//////////

$fp = fopen("temp.csv", "w");
//echo $sf."<br>";
$res = mysql_query($sf);
//$res = $result;
// fetch a row and write the column names out to the file
$row = mysql_fetch_assoc($res);
$line = "";
$comma = "";
if(!empty($row)){
foreach($row as $name => $value) {
    $line .= $comma . '"' . str_replace('"', '""', $name) . '"';
    $comma = ",";
}
$line .= "\n";
fputs($fp, $line);

// remove the result pointer back to the start
mysql_data_seek($res, 0);

// and loop through the actual data
while($row = mysql_fetch_assoc($res)) {
   
    $line = "";
    $comma = "";
    foreach($row as $value) {
        $line .= $comma . '"' . str_replace('"', '""', $value) . '"';
        $comma = ",";
    }
    $line .= "\n";
    fputs($fp, $line);
   
}
}
include "change_pw.php";
fclose($fp);


/////////
mysql_close($con);
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
	                    	<li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown">Welcome, <?php echo $username?> <b class="caret"></b></a>
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
	<div class="container" style="width:90%; overflow:auto; border:1px;" >
  <!-- 		<div class="row-fluid">  -->

    		<!--Body content-->
    		<!-- <div class="span9 panel-box"> -->

    				  <?php 
					  echo $data;
					  ?>
				
		<input type="button" class="btn btn-primary" value="Download" onclick="window.open('temp.csv')">	  <br>	  <br>
    		<!-- </div> -->
  	<!-- 	</div>  -->
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
            