<?php

include 'connect.php' ;
session_start();
if (isset($_SESSION['id'])) {
	$id=$_SESSION['id'];
	include 'privileges.php';
} else {
	header('Location: login.php');
	}
 $result = mysql_query("SET NAMES utf8");	
 
 if($privilege == 'admin'){
		$student_id=$_GET['studentid'];
		$sql="UPDATE `student` SET `is_approved`=1 WHERE student_id='$student_id'";
		$result_delete_question = mysql_query($sql);
		if($result_delete_question != 1) {
			echo "Not Able to Approve Student ID ".$student_id;
			//echo "<script>alert(Not Able to Approve Student ID ".$student_id.") </script>";
		}else {
			//$msg = "Successfully Approved Student ID ".$student_id;
			//echo "<script>alert(Approved Student ID ".$student_id.") </script>";
			header("Location: success.php?studentid=$student_id&status=Approved");
		}
		
	}else{
			echo "NO Privilege defined to Approve student account for current Login user";
	}	
	//}
?>