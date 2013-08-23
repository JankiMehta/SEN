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
		$sql="UPDATE `student` SET `is_approved`=0 WHERE student_id='$student_id'";
		$result_delete_question = mysql_query($sql);
		if($result_delete_question != 1) {
			echo "Not Able to Approve Student ID ".$student_id;
		}else {
			header("Location: success.php?studentid=$student_id&status=Deactivated");
		}
		
	}else{
			echo "NO Privilege defined to Approve student account for current Login user";
	}	
	//}
?>