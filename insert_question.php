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
	//	$id=$_POST['id'];
	/*	echo "event_ID :".$eventid;
		echo "<br>";
		echo "data :".$data;
		echo "<br>";
		echo "id :".$id;
		echo "<br>";
		*/
		$sql="SELECT max(post_id) as max FROM post WHERE event_id='$eventid'";
		$result = mysql_query($sql);
		$row = mysql_fetch_row($result,MYSQL_BOTH);
		$max = $row['max'] + 1;
		$query_insert_question = "INSERT INTO post (`post_id`,`event_id`, `content`, `posted_by`) VALUES ( '$max' , '$eventid', '$data', '$id' )";
		echo "<br><br>".$query_insert_question."<br><br>";
		$result_insert_question = mysql_query($query_insert_question);
	//	}
		if($result_insert_question != 1) {
			echo "Your query could not be posted due to a system error. We apologize for any inconvenience.";
		}else{
			echo "DONE!!!";
		}
	//}
?>