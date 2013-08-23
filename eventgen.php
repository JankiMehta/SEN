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

if($privilege != 'student' ){ 

if(isset($_POST['cname'])){
//echo "Generation";
$cname=$_POST['cname'];
$domain=$_POST['domain'];
$ctc=$_POST['ctc'];
$elicri=$_POST['cpi'];
$date=$_POST['date'];
$hour=$_POST['hour'];
$min=$_POST['min'];
$type=$_POST['type'];
$des=$_POST['description'];
$batch=$_POST['batch'];
$prog_name=$_POST['program'];
$query_prog = "SELECT prog_id FROM program WHERE prog_name='$prog_name'"; 
	$result_prog = mysql_query($query_prog, $con);
	$arr = mysql_fetch_array($result_prog, MYSQL_ASSOC);
	$prog = $arr['prog_id'];

//echo $date."<br>";
$date = str_replace("/","-",$date);
$yr=substr( $date , 6 , 4 );
$dd=substr( $date , 3 , 2 );
$mm=substr( $date , 0 , 2 );
if(strlen($date) == 10 && strlen($yr) == 4 && strlen($dd) == 2 && strlen($mm) == 2  && checkdate( $mm ,$dd ,$yr )){
		$deadline = $yr."-".$mm."-".$dd." ".$hour.":".$min.":00";
		if(date('Y-m-d H:i:s', strtotime($deadline)) == $deadline){
		//	
		$sql10 = "INSERT INTO organisation (org_name) VALUES ('$cname')";
		$result1 = mysql_query($sql10,$con);
					if (!$con)
						{
						die('Could not connect: ' . mysql_error());
						}
					
					$s = "SELECT max(event_id) as event_id FROM event";
					$result = mysql_query($s,$con) or die ('Could not query: ' . mysql_error());
					$evid="NA";
					while($row = mysql_fetch_array($result)){
						$evid =  $row['event_id'] + 1;
						}
					if($evid != "NA"){
						$des = mysql_real_escape_string($des);
						$cname = mysql_real_escape_string($cname);
					//	print_r($_POST['domain']);
						if(count($_POST['domain']) == 2){
						
						
						$sql="INSERT INTO event ( event_id ,org_name , event_type , event_details, generator_id, last_editor_id, reg_deadline, ctc, eli_cri, domain, prog_id, batch )
						VALUES ( '$evid' ,'$cname', '$type','$des','$id','$id','$deadline', '$ctc', '$elicri' ,'CS', '$prog' , '$batch' )";
						
						
						if(mysql_query($sql,$con) or die('Could not query: ' . mysql_error())){
							//header("Location: index.php");
							}else{
						//	echo "1";
							//header("Location: error.html");
							}
						
						$sql="INSERT INTO event ( event_id ,org_name , event_type , event_details, generator_id, last_editor_id, reg_deadline, ctc, eli_cri, domain, prog_id, batch )
						VALUES ( '$evid' ,'$cname', '$type','$des','$id','$id','$deadline', '$ctc', '$elicri' ,'ECE', '$prog' , '$batch' )";
						
						
						if(mysql_query($sql,$con) or die('Could not query: ' . mysql_error())){
						header("Location: index.php");
							}else{
					//		echo "111";
							//header("Location: error.html");
							}		
						
						}else{
							$dom = "";
							foreach($domain as $val){
							$dom = $val;
							}
							
						$sql="INSERT INTO event ( event_id ,org_name , event_type , event_details, generator_id, last_editor_id, reg_deadline, ctc, eli_cri, domain, prog_id, batch )
						VALUES ( '$evid' ,'$cname', '$type','$des','$id','$id','$deadline', '$ctc', '$elicri' ,'$dom', '$prog' , '$batch' )";
						
						if(mysql_query($sql,$con) or die('Could not query: ' . mysql_error())){
							
							$query_student = "SELECT student_id FROM student WHERE prog_start_year='$batch' AND prog_id='$prog'";
							$result_student = mysql_query($query_student, $con);
							while($arr = mysql_fetch_array($result_student, MYSQL_BOTH))
							{
								$student_id = $arr['student_id'];
								// Send the email for event notification:
								$message = $cname."wil be visiting campus for ".$type." opportunity. Check event page on website for further details";
								$subject = $type." opportunity at ".$cname;
								$email = $student_id."@daiict.ac.in";
								$headers = 'From: jvmehta.92@gmail.com' . "\r\n" .
											'Reply-To: jvmehta.92@gmail.com' . "\r\n" .
											'MIME-Version: 1.0' . "\r\n" .
											'Content-type: text/html; charset=iso-8859-1' . "\r\n" .
											'X-Mailer: PHP/' . phpversion();

								mail($email, $subject, $message, 'From: jvmehta.92@gmail.com');
							}
							
							header("Location: listevents.php");
							}else{
							//echo "1";
							//header("Location: error.html");
							}
						}	
					}else{
						//header("Location: error.html");
					//	echo "2";
						}
				}else{
				//	echo $deadline." dl <br>";
				//	header("Location: error.html");
					}
			}else{
			//	echo $date." long cnd <br>";
				//header("Location: error.html");
				}
		}else{
		 // echo "3";
			//header("Location: error.html");

}
}else{
	header('Location: index.php');
}
mysql_close($con);
?>