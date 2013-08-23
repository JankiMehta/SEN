<?php
if (isset($_POST['change_pw'])) {
    $error = array();//Declare An Array to store any error message  
    if (empty($_POST['old_pw'])) {//if no old password has been supplied 
        $error[] = 'Please enter old password ';//add to array "error"
    } else {
        $old_pw = $_POST['old_pw'];//else assign it a variable
    }
	if (empty($_POST['new_pw'])) {//if no new password has been supplied 
        $error[] = 'Please enter new password ';//add to array "error"
    } else {
        $new_pw = $_POST['new_pw'];//else assign it a variable
    }
	if (empty($_POST['confirm_pw'])) {//if no confirm password has been supplied 
        $error[] = 'Please enter confirm password ';//add to array "error"
    } else {
        $confirm_pw = $_POST['confirm_pw'];//else assign it a variable
    }
	
	$passwd="select password from user where user_id='$id'";
	$result_passwd=mysql_query($passwd,$con);
	$password=mysql_fetch_row($result_passwd);

	if($password[0]!=md5($old_pw)) {
		echo 'please enter your correct old password';
	} else {
		if ($new_pw!=$confirm_pw) {
			echo 'New and Confirm passwords do not match';				
		} else {
			$new_pw_enc = md5($new_pw);
			$query_change_password = "UPDATE user SET password='$new_pw_enc' WHERE user_id='$id'";
//$echo $query_change_password;
			$result_change_password=mysql_query($query_change_password, $con);
			if(!$result_change_password) {
				echo 'Your password could not be changed due to system error. please try again.';
			} else {
				header('Location: index.php');
				echo "You password has been successfully changed";
			}
		}
	}
}

?>
