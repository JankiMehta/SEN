<?php
	$sql1 = "SELECT student_id FROM student WHERE student_id = '$id'";
	$sql2 = "SELECT admin_id FROM admin WHERE admin_no = '$id'";
	$sql3 = "SELECT faculty_id FROM faculty WHERE faculty_id = '$id'";
	$sql4 = "SELECT SPCmember_id FROM SPC WHERE SPCmember_no = '$id'";
	$privilege = "";
	$result = mysql_query($sql1);
	if(mysql_num_rows($result)==1){
		$privilege = "student";
		}
	$result = mysql_query($sql2);
	if(mysql_num_rows($result)==1){
		$privilege = "admin";
	}
	$result = mysql_query($sql3);
	if(mysql_num_rows($result)==1){
		$privilege = "faculty";
		}
	$result = mysql_query($sql4);
	if(mysql_num_rows($result)==1){
		$privilege = "spc";
		}
		
?>
