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

if($privilege == 'admin' || $privilege == 'spc'){
		$event_id=$_POST['event_id']; 
		$post_id=$_POST['post_id'];
		$id=$_POST['id'];		
		$sql="UPDATE `post` SET `deleted`=1 ,`deleted_by`='$id' WHERE event_id='$event_id' AND post_id='$post_id'";
		$result_delete_question = mysql_query($sql);
		if($result_delete_question != 1) {
			echo "Question could not be Deleted due to a system error. We apologize for any inconvenience.";
		}else {
		echo "DONE!!!";
		}
}else{
echo "NO Privilege defined to Delete Question for current Login user";
}
?>