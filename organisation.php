<?php
include 'connect.php';
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
			$orgname=$_POST['org_name'];
			$addr=$_POST['addr'];
			$city=($_POST['city']);
			$pin=$_POST['pincode'];
			$country=$_POST['country'];
			$personname1=$_POST['first_contact_person'];
			$personno1=$_POST['first_contact_number'];
			$personname2=$_POST['second_contact_person'];
			$personno2=$_POST['second_contact_number'];
			$email=$_POST['email'];
			$website=$_POST['website'];

			$error = array();
			if(strlen($pin)!=0){
				if(strlen($pin)!=6 or is_numeric($pin)==0)
					$error[] = 'Invalid pincode.';
			}
			if(strlen($orgname)>100 )
				$error[] =  "Organization Name too Long.Max 100 characters allowed.";
			if(strlen($addr)>200  )
				$error[] = "Address too Long.Max 200 characters allowed.";
			if(strlen($city)>100  )
				$error[] = "City name too Long.Max 100 characters allowed.";
			if(strlen($country)>200  )
				$error[] = "Country name too Long.Max 200 characters allowed.";
			if(strlen($personname1)>100  )
				$error[] = "Name too Long.Max 100 characters allowed."; 
			if(strlen($personno1)!=0){
				if(strlen($personno1)!=10 or is_numeric($personno1)==0 ){
					$error[] = "Invalid Number";
					}
			}
			if(strlen($personname2)>100  )
				$error[] = "Name too Long.Max 100 characters allowed.";
			if(strlen($personno2)!=0){
				if(strlen($personno2)!=10 or is_numeric($personno2)==0 ){
					$error[] = "Invalid Number";
					}
			}
			if(!empty($email)){
				if(strlen($email)>100 or !filter_var($email,FILTER_VALIDATE_EMAIL))
					$error[] = "Invalid EMAIL.";
			}
			if(!empty($website)){
				if(strlen($website)>100 or !filter_var($website, FILTER_VALIDATE_URL))
					$error[] = "Invalid website name.";
			}
			foreach ($error as $key => $values) { 
						echo '	<li>'.$values.'</li>';
					}
			$query_verify_org="select * from organisation where org_name='$orgname'";
			$result_verify_org=mysql_query($query_verify_org,$con);
			if(!mysql_num_rows($result_verify_org)) {
				$insert_query="insert into organisation (org_name,address,city,postal_code,country,contact_person1,contact_no1,contact_person2,contact_no2,email,website)
							values('$orgname','$addr','$city','$pin','$country','$personname1','$personno1','$personname2','$personno2','$email','$website')";

				if(sizeof($error)==0){				
				if (!mysql_query($insert_query,$con)) {
				  echo "ERROR";
				  die('Error: could not be inserted' );
				} else {
					header('Location: organisation.php');
					}
				}
			} else {
				echo 'Organisation already exists';
			} mysql_close($con);
		} else {
				echo 'You are not privileged to insert admin details ';
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
	<title>Organisation Details</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<!-- We don't need author field -->
	<!-- Le styles -->
	<link href="assets/css/bootstrap.min.css" rel="stylesheet">
	<link href="assets/css/common.css" rel="stylesheet">
<link href="assets/css/bootstrap-responsive.min.css" rel="stylesheet">
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
				<h2>Organisation Details</h2>
				<div id="regtr">
					<form name="form1"  method ="post" >
						<table style="margin-left:50px; width:100%;">
	
						<tr> 
							<td>Organisation Name:</td>
							<td > <input required type="text" name="org_name" placeholder="Name" id="org_name" pattern="{1,100}" title="Please enter the Organization Name" ></td> 
                            <tr><td></td><td><div id="org_name1"></div></td></tr>
							<td></td>
						</tr>
						</br>
						</br>
	
						<tr> 
							<td>Address</td>
							<td><input type="text" name="addr" placeholder="Address of Organization" id="addr"></td>
                            <tr><td></td><td><div id="addr1"></div></td></tr>
							<td></td> 
							<td></td> 
							<td></td>
							<td></td>
						</tr>
						
					   
						<tr>
							<td>City</td>
							<td><input type="text" name="city" placeholder="City Name" id="city"></td>
                            <tr><td></td><td><div id="city1"></div></td></tr>
							<td></td> 
							<td></td> 
							<td></td>
							<td></td>
						</tr>
					   
					   <tr>
							<td>Postal Code</td>
							<td><input type="text" name="pincode" placeholder="Pincode" id="pincode"></td>
                            <tr><td></td><td><div id="pincode1"></div></td></tr>
							<td></td> 
							<td></td> 
							<td></td>
							<td></td>
						</tr>
		
						<tr>
							<td>Country</td>
							<td><input type="text" name="country" placeholder="Country Name" id="country"></td>
                            <tr><td></td><td><div id="country1"></div></td></tr>
							<td></td> 
							<td></td> 
							<td></td>
							<td></td>
						</tr>
						
						<tr>
							<td>First Contact Person</td>
							<td><input type="text" name="first_contact_person" placeholder="Person Name" id="first_contact_person"></td>
                            <tr><td></td><td><div id="first_contact_person1"></div></td></tr>
							<td></td> 
							<td></td> 
							<td></td>
							<td></td>
						</tr>
						
						<tr>
							<td>Contact Number</td>
							<td><input type="text" name="first_contact_number" placeholder="Person Number" id="first_contact_number"></td>
                            <tr><td></td><td><div id="first_contact_number1"></div></td></tr>
							<td></td> 
							<td></td> 
							<td></td>
							<td></td>
						</tr>
						
						<tr>
							<td>Second Contact Person</td>
							<td><input type="text" name="second_contact_person" placeholder="Person Name" id="second_contact_person"></td>
                            <tr><td></td><td><div id="second_contact_person1"></div></td></tr>
							<td></td> 
							<td></td> 
							<td></td>
							<td></td>
						</tr>
		
						<tr>
							<td>Contact Number</td>
							<td><input type="text" name="second_contact_number" placeholder="Person Number" id="second_contact_number"></td>
                            <tr><td></td><td><div id="second_contact_number1"></div></td></tr>
							<td></td> 
							<td></td> 
							<td></td>
							<td></td>
						</tr>
						
						<tr>
							<td>EMail ID</td>
							<td><input type="text" name="email" placeholder="EMail ID" id="email"></td>
                            <tr><td></td><td><div id="email1"></div></td></tr>
							<td></td> 
							<td></td> 
							<td></td>
							<td></td>
						</tr>
						
						<tr>
							<td>Website(append with http://)</td>
							<td><input type="text"  name="website" placeholder="Website" id="website"></td>
                            <tr><td></td><td><div id="website1"></div></td></tr>
							<td></td> 
							<td></td> 
							<td></td>
							<td></td>
						</tr>
						
						<tr>
						</table>
		<input type="submit" class="btn btn-success" name="submit" >
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
<script src="assets/js/validate_organisation.js"></script>
  
</body>
</html>
            