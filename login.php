<?php
	
	include("connect.php");
	
	if(isset($_POST['submit'])){
		$error= array();
		
		//user_id
		if (empty($_POST['id'])) 
		{//if no id has been supplied 
        	$error[] = "Please enter id ";//add to array "error"
    	} else {
				if(strlen($_POST['id']) >9) {
					$error[] = 'Login ID must contain less than 9 characters';
				}
				else {
					$id = mysql_real_escape_string($_POST['id']);//else assign it a variable
					}
			}
		//password
		if(empty($_POST['password'])){
			$error[]='Please enter a password. ';
		} else {
			$password = mysql_real_escape_string($_POST['password']);
		}	
		
		if (empty ($error)){
				$password_enc=md5($password);
				$result = mysql_query("SELECT * FROM user WHERE user_id='$id' AND password='$password_enc'",$con) or die (mysql_error());
				$row = mysql_fetch_array($result,MYSQL_BOTH);
				if (mysql_num_rows($result)==1){
					session_start();
					$_SESSION['id'] =  $row['user_id'];
					$id=$_SESSION['id'];
					echo $id;
					include 'privileges.php';
					echo $privilege;
					if(strcmp($privilege, "student")==0) {
						$result_student = mysql_query("SELECT * FROM student WHERE student_id='$id'",$con) or die (mysql_error());
						$student=mysql_fetch_array($result_student,MYSQL_BOTH);
						if($student['is_activated'] == 1){	
						header('Location: index.php');
						} else { 
						header('Location: confirm.php');
						}
					}else {
					if(strcmp($privilege, "admin")==0 or strcmp($privilege, "faculty")==0 or strcmp($privilege, "spc")==0) {
						header('Location: index.php');
					}
					}
				}
				else{
					$error_message ='Email or password is incorrect <br /> <br />' ;
				}
		}
		else{
				foreach($error as $key => $values) {
					$error_message.= "$values";
				}
				
		}
				echo $error_message;

}
// forgot password
if (isset($_POST['forgot_pw'])) {
	$id = $_POST['id'];
	include 'privileges.php';
	if(strcmp($privilege,"student")==0 or strcmp($privilege,"faculty")==0 ) {
		echo "A new temporary password will be sent to your webmail which you can change later_student or faculty.";
		$temp_pw = substr(md5(uniqid(rand(), true)), 0, 8);
		
		$temp_pw_enc=md5($temp_pw);
		$query_change_password = "UPDATE user SET password = '$temp_pw_enc' WHERE user_id='$id'";
		$result_change_password = mysql_query($query_change_password, $con);
		
		$message = " Temporary password:\n";
		$message .= $temp_pw;
		$email = $id."@daiict.ac.in";
		
		//mail($email, 'New Password', $message, 'From: spc_daiict@gmail.com');

		//header('Location:login.php');
		} else {
	if(strcmp($privilege,"admin")==0) {
		$query_admin_id="select admin_id from admin where admin_no='$id'";
		$result=mysql_query($query_admin_id,$con);
		if(mysql_num_rows($result)==1) {
		
			$row=mysql_fetch_array($result);
			echo "A new temporary password will be sent to your webmail which you can change later_admin.";
			$temp_pw = substr(md5(uniqid(rand(), true)), 0, 8);
			$temp_pw_enc=md5($temp_pw);
			$query_change_password = "UPDATE user SET password = '$temp_pw_enc' WHERE user_id='$id'";
			$result_change_password = mysql_query($query_change_password, $con);
			
			$message = " Temporary password:\n";
			$message .= $temp_pw;
			$email = $row."@daiict.ac.in";
			
			//mail($email, 'New Password', $message, 'From: spc_daiict@gmail.com');

			//header('Location:login.php');
			}
		} else {
		$query_spc_id="select SPCmember_id from spc where SPCmember_no='$id'";
		$result=mysql_query($query_spc_id,$con);
		if(mysql_num_rows($result)==1) {
		
			$row=mysql_fetch_array($result);
			echo "A new temporary password will be sent to your webmail which you can change later_spc.";
			$temp_pw =substr(md5(uniqid(rand(), true)), 0, 8);
			$temp_pw_enc=md5($temp_pw);
			$query_change_password = "UPDATE user SET password = '$temp_pw_enc' WHERE user_id='$id'";
			$result_change_password = mysql_query($query_change_password, $con);
			
			$message = " Temporary password:\n";
			$message .= $temp_pw;
			$email = $row."@daiict.ac.in";
			
			//mail($email, 'New Password', $message, 'From: spc_daiict@gmail.com');

			//header('Location:login.php');
			}
		}
	}
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Login to DAIICT SPC!</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<!-- Le styles -->
	<link href="assets/css/bootstrap.min.css" rel="stylesheet">
	<link href="assets/css/bootstrap-responsive.min.css" rel="stylesheet">
	<link href="assets/css/common.css" rel="stylesheet">
	<!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
	<!--[if lt IE 9]>
	<script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->
	<!-- Le fav and touch icons -->
</head>

<body class="login_body">

	<!-- BODY CONTAINER -->
	<div class="navbar navbar-inverse nav login-header">

        	<div style="margin-left:35%; margin-right:auto; width:600px ">
	        	<img src="assets/img/daiict.png" style="height:100px; float:left"></img>
	            <h3 style="line-height:100px; color:white; ">PLACEMENT CELL, DAIICT</h3>
            </div>			
  
	</div>

	<div class="container">
		<div id="login_box">
			<h3>Login</h3>
			<form method="POST">
				<table>
					<tr>
						<td>Username:</td>
						<td>
							<input required type="text" name="id" placeholder="Enter your ID" id="idno" pattern="[+]?[0-9a-z]{4,9}" title="Student ID must contain exact 9 digits">
						</td>
					</tr>
					<tr>
						<td>Password</td>
						<td>
							<input id="password" name="password" placeholder="Enter your password" type="password" pattern=".{4,}" title="Minimum 5 letters or numbers." required>
						</td>
					</tr>
				</table>
				<br />
				<input type="submit" class="btn btn-success" name="submit" value="Login">
				<a href="studentReg.php" class="btn btn-primary" style="margin-left:20px">Register</a>
			</form>
			<button data-toggle="modal" href="#forgot_password" class="btn btn-link" style="margin-left:0; margin-top:0; padding:0">Forgot Password?</button>
		</div>	    	
	</div>

    <div id="forgot_password" class="modal hide fade in" style="display: none; ">  
        <div class="modal-header">  
            <a class="close" data-dismiss="modal">×</a>  
            <h4>Password Recovery</h4>  
        </div>  
        <div class="modal-body"> 
            <p>Provide us with your ID so that we can help you in recovering your password.</p> 
            <form class="well" method="POST">          	
                <input type="text" placeholder="Enter your ID" style="margin-top:10px" name="id">  
                <button type="submit" class="btn btn-success" name="forgot_pw">Submit</button>
            </form>               
        </div>    
    </div>

<!-- Le javascript
================================================== -->
<script src="assets/js/jquery.js"></script>
<script src="assets/js/bootstrap.min.js"></script>
</body>
</html>