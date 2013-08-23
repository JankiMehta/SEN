<?php
include 'connect.php' ;
session_start();
if (isset($_SESSION['id'])) {
	$id=$_SESSION['id'];
	include 'privileges.php';	
	
} else {
	header('Location: login.php');
	}

	if($privilege == 'student'){
	
	$event_id = $_POST['event_id'];
	
	$res1 = mysql_query("SELECT prog_id, prog_start_year, CPI, backlog FROM student WHERE student_id='$id'", $con);
	$arr1 = mysql_fetch_array($res1, MYSQL_BOTH);
	$res2 = mysql_query("SELECT prog_id, batch, eli_cri FROM event WHERE event_id='$event_id'", $con);
	$arr2 = mysql_fetch_array($res2, MYSQL_BOTH);
	
	if(($arr1[0]==$arr2[0]) && ($arr1[1]==$arr2[1]) && ($arr1[2]>=$arr2[2]) && $arr1[3]==0) {
	
	$sql = "SELECT org_name from event where event_id='$event_id'";
	$result = mysql_query($sql);
	$row = mysql_fetch_array($result,MYSQL_BOTH);
	$org = $row['org_name'];
	$dom = $_POST['domain'];
	
	$allowedExts = array("pdf");
	$ext = explode(".", $_FILES["file"]["name"]);
	$extension = end($ext);
	
	if(($_FILES["file"]["name"])==""){
		$sql = "SELECT resume from student where student_id='$id'";
		$res = mysql_query($sql,$con);
		$row = mysql_fetch_array($res);
		$path = $row['resume'];
		$filename = $id."_".$event_id.".pdf";
		$path = "assets/data/event/".$filename;
		copy("assets/data/".$id,"assets/data/event/".$filename);
		$sql2 = "INSERT INTO eventregister (event_id,student_id,resume,domain)
							VALUES ('$event_id','$id','$path','$dom')";
		$result = mysql_query($sql2);
		header("Location: index.php");
	}
	
	if (($_FILES["file"]["type"] == "application/pdf")
		&& ($_FILES["file"]["size"] < 1000000)
		&& in_array($extension, $allowedExts)){
		
		if ($_FILES["file"]["error"] > 0){
			echo "Return Code: " . $_FILES["file"]["error"] . "<br>";
		}
		else{
			$filename = $id."_".$event_id.".pdf";
			$path = "assets/data/event/" . $filename;
			//echo $path;
			if (file_exists($path)){
				echo "Already Register. ";
			}
			else{
				$sql2 = "INSERT INTO eventregister (event_id,student_id,resume,domain)
							VALUES ('$event_id','$id','$path','$dom')";
				$result = mysql_query($sql2);
				move_uploaded_file($_FILES["file"]["tmp_name"], "assets/data/event/".$filename);
				header("Location: index.php");
			}
		}
	}
	else{
		echo "Invalid file OR Something Went Wronge. Please Try Again";
	}
} else { 
    echo "You cannot register for this event";
}
} else {
	header("Location: index.php");
}	
	
?>