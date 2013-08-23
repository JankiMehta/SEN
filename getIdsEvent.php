<?php
include 'connect.php' ;
session_start();
if (isset($_SESSION['id'])) {
	$id=$_SESSION['id'];
	include 'privileges.php';	
} else {
	header('Location: login.php');
	}
 include 'change_pw.php';

$result = mysql_query("SET NAMES utf8");

if($privilege == 'admin'){

$event_id = $_POST['event_id'];
$sql = "SELECT student_id FROM eventregister WHERE event_id ='$event_id'";
$result = mysql_query($sql);
$to_encode = array();
while($row = mysql_fetch_array($result,MYSQL_ASSOC)){
 $to_encode[] = $row;
}
echo json_encode($to_encode);
}else{
header('Location: index.php');
}

?>