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

$event_id = $_POST['company']; // NOT A COMPANY NAMAE...It is actual Event Id but I can not change name as Front Design will be affected
$students = $_POST['selected_students'];

//print_r($event_id);
//print_r($students);

	foreach($students as $val){
	$sql = "SELECT event_reg_id FROM eventregister WHERE event_id='$event_id' AND student_id='$val'";
	$result = mysql_query($sql);
	$row = mysql_fetch_row($result,MYSQL_ASSOC);
	$event_reg_id = $row['event_reg_id'];
	//echo $event_reg_id."<br>";
	date_default_timezone_set('Asia/Calcutta');
	$d=date("Y-m-d H:i:s", time());
	//echo $d;;
	$sqle = "INSERT INTO placement (event_reg_id, placement_date) VALUES ('$event_reg_id','$d')";
	//echo "<br>".$sqle;
	$result = mysql_query($sqle);


	$sqll = "UPDATE `event` SET `last_editor_id`='$id',`last_edited_on_timestamp`='$d',`is_completed`=1 WHERE event_id='$event_id'";
	$result = mysql_query($sqll);

	header("Location: index.php");
	}
}
else{
	echo "NO Privilege defined to complete event for current Login user";
}
?>