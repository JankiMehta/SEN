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
		$id=$_POST['id'];
		$c_id=$_POST['c_id'];
		$post_id=$_POST['post_id'];
		$query_delete_comment = "UPDATE `comment` SET `deleted`=1,`deleted_by`='$id' WHERE event_id='$event_id' AND post_id='$post_id' AND comment_id='$c_id'";
		echo $query_delete_comment;
		$result_delete_comment = mysql_query($query_delete_comment);
		if($result_delete_comment != 1) {
			echo "Your comment could not be posted due to a system error. We apologize for any inconvenience.";
		}else {
		echo "DONE!!!";
		}
	}else{
	echo "NO Privilege defined to Delete comment for current Login user";
	}	
?>