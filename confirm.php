<?php

include ('connect.php');
session_start();
$id = $_SESSION['id'];
if (isset($_POST['submit'])) {
	$result = mysql_query("SELECT confirmation_key FROM student WHERE student_id='$id'", $con);
	$arr = mysql_fetch_row($result);
	$confirm_key = $arr[0];
	if($_POST['key'] == $confirm_key) {
		$query_activate_student = "UPDATE student SET is_activated = 1 WHERE student_id='$id'";
		$result_activate_student = mysql_query($query_activate_student, $con);
		if(!$result_activate_student) {
			echo "You could not be confirmed due to a system error. We apologize for any inconvenience. Please try again later.";
		} else {
			header('Location: index.php');
			echo "You have been successfully registered and your account has been activated";
		}
	} else {
		echo "Confirmation key should match to that sent to your mail";
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

        	<div style="margin-left:35%; margin-right:auto; width:600px">
	        	<img src="assets/img/daiict.png" style="height:100px; float:left"></img>
	            <h3 style="line-height:100px; color:white;">PLACEMENT CELL, DAIICT<h3>
            </div>			
  
	</div>

	<div class="container">
		<div id="login_box">
			<h3>Verification</h3>
			<form method="POST">
				<table>
					<tr>
						<td>Enter Verification Code:</td>
						<td>
							<input required type="text" name="key" placeholder="Enter your code" id="idno" title="This code is mailed to you on your email id">
						</td>
					</tr>
					
				</table>
				<br />
				<input type="submit" class="btn btn-success" name="submit">
				
			</form>
			
		</div>	    	
	</div>

    

<!-- Le javascript
================================================== -->
<script src="assets/js/jquery.js"></script>
<script src="assets/js/bootstrap.min.js"></script>
</body>
</html>
            