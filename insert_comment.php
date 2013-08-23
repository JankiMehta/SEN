<?php 

include 'connect.php' ;
session_start();
if (isset($_SESSION['id'])) {
	$id=$_SESSION['id'];
	include 'privileges.php';	
	//$result=mysql_query($sql,$con);
} else {
	header('Location: login.php');
	}
 
$result = mysql_query("SET NAMES utf8");	

		$eventid=$_POST['event_id']; 
		$data=$_POST['content'];
		$c_id=$_POST['c_id'];
		$postid=$_POST['post_id'];
			if($_SESSION['id'] == $_POST['id']){
		$query_insert_comment = "INSERT INTO comment (`event_id`, `post_id`, `content`, `comment_id` , `commented_by`) VALUES ('$eventid', '$postid', '$data', '$c_id' , '$id' )";
		echo $query_insert_comment;
		$result_insert_comment = mysql_query($query_insert_comment);
		
		if($result_insert_comment != 1) {
			echo "Your comment could not be posted due to a system error. We apologize for any inconvenience.";
		}else {
		echo "DONE!!!";
		}
		}else{
		echo "Something Unexpected Happen. We apologize for any inconvenience.";
		}
		
?>