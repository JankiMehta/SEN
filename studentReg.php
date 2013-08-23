<?php
include ('connect.php');
if (isset($_POST['submit'])) {
    $error = array();//Declare An Array to store any error message  
    if (empty($_POST['fname'])) {//if no first name has been supplied 
        $error[] = 'Please enter first name ';//add to array "error"
    } else {
		if(strlen($_POST['fname'])>50) {
			$error[]='First Name  too long. Maximum 50 characters allowed.';
		} else {
        $fname = $_POST['fname'];//else assign it a variable
		}
	}
	
	if (empty($_POST['lname'])) {//if no last name has been supplied 
        $error[] = 'Please enter last name ';//add to array "error"
    } else {
		if(strlen($_POST['lname'])>50) {
			$error[]='Last name too long. Maximum 50 characters allowed.';
		} else {
        $lname = $_POST['lname'];//else assign it a variable
		}
    }
	
	
	if (empty($_POST['id'])) {//if no id has been supplied 
        $error[] = 'Please enter id ';//add to array "error"
    } else {
		if(!is_numeric($_POST['id'])) {
			$error[] = 'Student ID must have only digits';
		} else {
			if(strlen($_POST['id']) != 9) {
				$error[] = 'Student ID must contain only 9 digits';
			} else {
        		$id = $_POST['id'];//else assign it a variable
			}
		}
	}
	
	
	if (empty($_POST['cpi'])) {//if no cpi has been supplied 
        $error[] = 'Please enter CPI ';//add to array "error"
    } else {
		if(!is_numeric($_POST['cpi'])) {
			$error[] = 'CPI must be a number';
		} else {
			if($_POST['cpi']<0 || $_POST['cpi']>10) {
				$error[] = 'CPI must be between 0 to 10';
			} else {
        		$cpi = $_POST['cpi'];//else assign it a variable
			}
		}
    }
	
	
	if (empty($_POST['Xper'])) {//if no Xper has been supplied 
        $error[] = 'Please enter Std.X percentage ';//add to array "error"
    } else {
		if(!is_numeric($_POST['Xper'])) {
			$error[] = 'percentage must be a number';
		} else {
			if($_POST['Xper']<0 || $_POST['Xper']>100) {
				$error[] = 'percentage must be between 0 to 100';
			} else {
        		$Xper = $_POST['Xper'];//else assign it a variable
			}
		}
    }
	
	
	if (empty($_POST['XIIper'])) {//if no XIIper has been supplied 
        $error[] = 'Please enter Std.XII percentage ';//add to array "error"
    } else {
		if(!is_numeric($_POST['XIIper'])){
			$error[] = 'percentage must be a number';
		} else {
			if($_POST['XIIper']<0 || $_POST['XIIper']>100) {
				$error[] = 'percentage must be between 0 to 100';
			} else {
        		$XIIper = $_POST['XIIper'];//else assign it a variable
			}
		}	
    }
	
    
	if (empty($_POST['password'])) {
        $error[] = 'Please Enter Your Password ';
    }
	
	
	if (empty($_POST['confirm-password'])) {
        $error[] = 'Please enter your passwordfor confirmation ';//add to array "error"
    } else {
		if(strcmp($_POST['confirm-password'],$_POST['password'])!=0) {
			$error[]='Passwords do not match';
		} else {
       		$password = md5($_POST['password']);
		}
    }
	
	
	if (empty($_POST['elective'])){ // if no electives is provided
		 $error[] = 'Please enter your electives ';//add to array "error"
	} else {
			$electives=$_POST['elective'];//else assign it a variable
	}
	
	
//resume upload	
	if(!empty($_FILES['resume']['name'])) {
		if (($_FILES["resume"]["type"] == "application/pdf") && ($_FILES["resume"]["size"] < 1000000)){
			if ($_FILES["resume"]["error"] > 0){
				echo "Return Code: " . $_FILES["resume"]["error"] . "<br>";
			}
			else{	
				$filenameR = $id.".pdf";
				move_uploaded_file($_FILES["resume"]["tmp_name"], "assets/data/".$filenameR);
				$resume_path = "assets/data/".$filenameR;
			}
		} else{
			$error[]='Invalid Resume';
		}
	} else {
		$error[] = "Upload your resume<br>";
	}
	  


//profile pic
	if(!empty($_FILES['dp']['name'])) {
		if (($_FILES["dp"]["type"] == "image/png") && ($_FILES["dp"]["size"] < 1000000)){
			if ($_FILES["dp"]["error"] > 0){
				echo "Return Code: " . $_FILES["dp"]["error"] . "<br>";
			} else{
				$filenameP = $id.".png";
				move_uploaded_file($_FILES["dp"]["tmp_name"], "assets/data/img/".$filenameP);
				$dp_path = "assets/data/img/".$filenameP;
			}
		} else {
			$error[]='Invalid Profile Picture';
		}
	} else {
		$error[]= "Upload your profile picture<br>";
	}
	  
	
	////////////////////////////////////////////////////////////////////////////
	$program = $_POST['program'];
	$query_prog = "SELECT prog_id FROM program WHERE prog_name='$program'"; 
	$result_prog = mysql_query($query_prog, $con);
	$arr = mysql_fetch_array($result_prog, MYSQL_ASSOC);
	$prog_id = $arr['prog_id'];
	
    //send to Database if there's no error
	if (empty($error)){ // If everything's OK...// Make sure the student_id is not repeated:
		$query_verify_id = "SELECT * FROM student WHERE student_id='$id'";
        $result_verify_id = mysql_query($query_verify_id, $con);
        if (mysql_num_rows($result_verify_id)) {
            echo ' You are already registered ';
        } else { // IF no previous user is using this id .
		// Create a unique  activation code:
        $activation = md5(uniqid(rand(), true));
		$mname = $_POST['mname'];
		$dob = $_POST['dob'];
		$gender = $_POST['gender'];
		$batch = $_POST['batch'];
		$curr_sem = $_POST['curr_sem'];		
		$backlog = $_POST['backlog'];
		
		$query_insert_password = "INSERT INTO user (user_id, password, event_generation) VALUES ('$id', '$password', 0)";
		$result_insert_password = mysql_query($query_insert_password, $con);
			if($result_insert_password) {
				$query_insert_student = "INSERT INTO student ( student_id, f_name, m_name, l_name, DOB, prog_id, prog_start_year, CPI, backlog, curr_sem, 10th_per, 12th_per, resume, gender, confirmation_key, profile_picture) 
										VALUES ( '$id', '$fname', '$mname', '$lname', '$dob', $prog_id, $batch, $cpi, $backlog, $curr_sem, $Xper, $XIIper, '$resume_path', '$gender', '$activation', '$dp_path' )";			
				$result_insert_student = mysql_query($query_insert_student, $con);
			
				if($result_insert_student) {
					for($i=0;$i<count($electives);$i++) {
						$query_select_courseid = "SELECT course_id from course where course_name='$electives[$i]'";
						$result_select_courseid = mysql_query($query_select_courseid, $con);
						$courseid = mysql_fetch_row($result_select_courseid);
						$query_insert_electives = "INSERT INTO electives (student_id, course_id) VALUES ('$id', '$courseid[0]')";
						$result_insert_electives = mysql_query($query_insert_electives, $con) or die('You could not be registered due to a system error. We apologize for any inconvenience1.');			
					}
					
				} else { // If user insert did not run OK.
					echo 'You could not be registered due to a system error. We apologize for any inconvenience2.';
				}
			} else { // If student insert did not run OK.
                echo 'You could not be registered due to a system error. We apologize for any inconvenience3.';
            }
			
            if ($result_insert_electives) { //If the Insert Queries were successfull.
			
                // Send the email:
                $message = " To activate your account, please enter the confirmation code:\n";
                $message .= $activation;
				$email = $id."@daiict.ac.in";
				$headers = 'From: jvmehta.92@gmail.com' . "\r\n" .
							'Reply-To: jvmehta.92@gmail.com' . "\r\n" .
							'MIME-Version: 1.0' . "\r\n" .
							'Content-type: text/html; charset=iso-8859-1' . "\r\n" .
							'X-Mailer: PHP/' . phpversion();

                mail($email, 'Registration Confirmation', $message, 'From: jvmehta.92@gmail.com');

                // Confirmation Page:
				header('Location:confirm.php');
                echo 'Thank you for registering! A confirmation email has been sent to '.$email.' Please enter the confirmation code below';
				session_start();
				$_SESSION['id'] = $id;
            }
        } 
		
    } else {//If the "error" array contains error msg , display them
        
		echo '<ol>';
        foreach ($error as $key => $values) { 
            echo '	<li>'.$values.'</li>';
        }
        echo '</ol>';

    }

  
    mysql_close($con);//Close the DB Connection

} // End of the main Submit conditional.

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Registration</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<!-- We don't need author field -->
	<!-- Le styles -->
	<link href="assets/css/bootstrap.min.css" rel="stylesheet">
	<link href="assets/css/common.css" rel="stylesheet">
	<link href="assets/css/bootstrap-responsive.min.css" rel="stylesheet">
	<!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
	<!--[if lt IE 9]>
	<script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->
	<!-- Le fav and touch icons -->
</head>

<body>
	<!-- NAVIGATION BAR -->
	<div class="navbar navbar-inverse nav">
	    <div class="navbar-inner">
	        <div class="container">
	            <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
	                <span class="icon-bar"></span>
	                <span class="icon-bar"></span>
	                <span class="icon-bar"></span>
	            </a>
	            <a class="brand" href="#">DA-IICT</a>
	        </div>
	    </div>
	</div>

	<!-- BODY CONTAINER -->
	<div class="container">
  		<div class="row-fluid">

    		<!--Body content-->
    		<div class="span9 panel-box" style="margin-left:auto; margin-right:auto; float:none">
				<h2>Registration</h2>
				<div id="regtr">
					<form onSubmit="validateForm(this)" enctype="multipart/form-data" method="POST">
						<table class="table" style="width:100%;">
							<tr>
								<td>First Name:</td>
						    	<td> <input required type="text" name="fname" placeholder="firstname" id="firstname" pattern="[a-z A-Z]{1,20}" title="Please enter the First name" ></td>
								<td></td> 
							</tr>
						    <tr>
						    	<td>Middle Name:</td>
								<td ><input type="text" name="mname" placeholder="middlename" id="middlename" pattern="[a-z A-Z]{1,20}" title="Please enter the Middle name"></td>
								<td></td>
							</tr>
      
 							<tr>
 								<td>Last Name:</td>
								<td><input required type="text" name="lname" placeholder="lastname" id="lastname" pattern="[a-z A-Z]{1,20}" title="Please enter the Last name"></td>
								<td></td>
							</tr> 
   
   							<tr>
								<td>Gender</td>
								<td>
									<select name="gender">
                                 		<option value="M"> Male </option>
                                 		<option value="F"> Female </option>
    								</select>
    							</td>
								<td></td>
    						</tr>
    
   							<tr>
    							<td>Student Id</td>
    							<td><input required type="text" name="id" placeholder="ID" id="idno" pattern="[+]?[0-9]{9,9}" title="Student ID must contain exact 9 digits"></td>
   								<td></td>
   							</tr>
   							
   							<tr>
    							<td >Password</td>
    							<td ><input id="password" name="password" type="password" pattern=".{5,}" title="Minmimum 5 letters or numbers." required></td>
   								<td></td>
   							</tr>
   
   							<tr>
    							<td >Confirm Password</td>
    							<td ><input id="confirm-password" name="confirm-password" type="password" pattern=".{5,}" title="Minmimum 5 letters or numbers." required></td>
   								<td></td>
   							</tr>
   
   							<tr>
    							<td >Current Semester</td>
    							<td >
    								<select name="curr_sem">
										<option value="1" selected> 1 </option>
										<option value="2"> 2 </option>
										<option value="3"> 3 </option>
										<option value="4"> 4 </option>
										<option value="5"> 5 </option>
										<option value="6"> 6 </option>
										<option value="7"> 7 </option>
										<option value="8"> 8 </option>
										<option value="9"> 9 </option>
										<option value="10"> 10 </option>
										<option value="11"> 11 </option>
										<option value="12"> 12 </option>
									</select>
								</td>
								<td></td>
   							</tr>
   
   							<tr>
								<td >CPI</td>
								<td ><input required type="number" name="cpi" placeholder="CPI" id="cpi" pattern="[+]?[0-9]*[.,]?[0-9]+" min="0" max="10" step="0.01"></td>
   								<td></td>
   							</tr>
    
    						<tr>
	 							<td >Date of Birth</td>
	 							<td > <input required type="date" name="dob"></td>
     							<td></td>
	 						</tr>
	
							<tr>
								<td >Program</td>
								<td >
									<select name="program">
										<?php
										$sql1 = mysql_query("SELECT distinct prog_name FROM program", $con);
										if(mysql_num_rows($sql1)){
										while($row1 = mysql_fetch_assoc($sql1)){
											echo "<option value=\"".$row1['prog_name']."\">".$row1['prog_name']."</option>";
											}
										}
										?>
									</select>
								</td>
    							<td></td>
							</tr>
    
    						<tr>
								<td >Batch</td>
								<td >
									<select name="batch">
										<option value="2013" selected> 2013 </option>
										<option value="2012"> 2012 </option>
										<option value="2011"> 2011 </option>
										<option value="2010"> 2010 </option>
										<option value="2009"> 2009 </option>
										<option value="2008"> 2008 </option>
										<option value="2007"> 2007 </option>
									</select>
    							</td>
								<td></td>
    						</tr>
    
    						<tr>
								<td >Electives Chosen</td>
								<td >
									<select name="elective[]" multiple size="6" id="elec">
										<?php
										$sql2 = mysql_query("SELECT distinct course_name FROM course where course_type='Group Elective' or course_type='Humanity Elective' or course_type='Technical Elective' or course_type='Science Elective'", $con);
										if(mysql_num_rows($sql2)){
										while($row2 = mysql_fetch_assoc($sql2)){
											echo "<option value=\"".$row2['course_name']."\">".$row2['course_name']."</option>";
											}
										}
										?>
									</select>
								<td></td><
    						</tr>
							
							<tr>
								<td> Backlog </td>
								<td colspan="2"> 
									<input type="radio" value="1" name="backlog"> Yes 
									<input type="radio" value="0" name="backlog" checked> No
								</td>
							</tr>

							<tr>
								<td >Std X</td>
    							<td >Board:
									<select name="Xboard" style="width:100px">
                    					<option value="CBSE" selected> CBSE </option>
                    					<option value="ICSE"> ICSE </option>
                    					<option value="State Board"> State Board </option>
				   					</select>
				   				</td>
								<td >Percentage
									<input style="width:100px" required type="number" name="Xper" id="perc10" pattern="[-+]?[0-9]*[.,]?[0-9]+" min="0" max="100" step="0.01">
								</td>
 							</tr>
	
    						<tr>
								<td>Std XII</td>
								<td>Board:
									<select name="XIIboard" style="width:100px">
					                    <option value="CBSE"> CBSE </option>
					                    <option value="ICSE"> ICSE </option>
					                    <option value="State Board"> State Board </option>
				   					</select>
				   				</td>
								<td>Percentage
									<input style="width:100px" required type="number" name="XIIper" id="perc12" pattern="[-+]?[0-9]*[.,]?[0-9]+" min="0" max="100" step="0.01">
								</td>
 							</tr>
    
							<tr>
    							<td>Profile Picture<br>(Upload png file of size no more than 1MB)</td>
    							<td><input type="file" name="dp" size="10"></td>
    							<td></td>
							</tr>
	
    						<tr>
    							<td>Resume<br>(Upload pdf file of size no more than 1MB)</td>
    							<td><input type="file" name="resume" size="10"></td>
    							<td></td>
							</tr>
						</table>
						<input type="submit" class="btn btn-success" name="submit">
					</form>	
    			</div>
  			</div>
  		</div>
	</div>
 

<!-- Le javascript
================================================== -->
<script src="assets/js/jquery.js"></script>
<script src="assets/js/bootstrap.min.js"></script>
<script src="assets/js/studReg.js></script>
  
</body>
</html>