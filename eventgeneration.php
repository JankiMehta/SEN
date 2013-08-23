<?php 
include 'connect.php' ;
session_start();
if (isset($_SESSION['id'])) {
	$id=$_SESSION['id'];
	include 'privileges.php';
	if(strcmp($privilege,"student")==0) {
		$sql="SELECT * FROM student where student_id='$id'";
	}else if(strcmp($privilege,"admin")==0) {
		$sql="SELECT * FROM admin where admin_no='$id'";
	}else if(strcmp($privilege,"faculty")==0) {
		$sql="SELECT * FROM faculty where faculty_id='$id'";
	} else if(strcmp($privilege,"spc")==0) {
		$sql="SELECT * FROM spc where SPCmember_no='$id'";
	}
	
	$result=mysql_query($sql,$con);
	$row = mysql_fetch_array($result, MYSQL_ASSOC);
	$name = $row['f_name']." ".$row['l_name'];
} else {
	header('Location: login.php');
	}
 include 'change_pw.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Event Generation</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<!-- We don't need author field -->
	<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.2/themes/smoothness/jquery-ui.css">
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
	            <div class="brand" href="#">DA-IICT</div>
				
	          	<div class="nav-collapse collapse">
	              	<ul class="nav">
	                  	<li class="divider-vertical"></li>
	                	<li><a href="index.php"><i class="icon-home icon-white"></i> Home</a></li>
	              	</ul>
		     <?php if(strcmp($privilege,"admin")==0 or strcmp($privilege,"faculty")==0 or strcmp($privilege,"spc")==0) {
			 echo	"<div class=\"pull-right\">
	                	<ul class=\"nav pull-right\">
                            <li class=\"dropdown\"><a href=\"#\" class=\"dropdown-toggle\" data-toggle=\"dropdown\">Administration<b class=\"caret\"></b></a>
                                <ul class=\"dropdown-menu\">
									<li><a href=\"eventgen.php\"><i class=\"icon-plus-sign\"></i> Add Event</a></li>"; 
							
									if(strcmp($privilege,"admin")==0) {
                                    echo "<li><a href=\"filtration.php\"><i class=\"icon-search\"></i> Filtration</a></li>    
                                    <li><a href=\"eventcompletion.php\"><i class=\"icon-bullhorn\"></i>Complete Event </a></li>
                                    <li class=\"divider\"></li>
									<li class=\"dropdown-submenu pull-left\"><a tabindex=\"-1\" href=\"#\"><i class=\"icon-briefcase\"></i> Manage Database</a>
									<ul class=\"dropdown-menu\">
									</li>
                                          <li><a href=\"admin.php\"><i class=\"icon-plus-sign\"></i> Insert Admin</a></li>  
                                          <li><a href=\"spc.php\"><i class=\"icon-plus-sign\"></i> Insert SPC Member</a></li>
                                          <li><a href=\"faculty.php\"><i class=\"icon-plus-sign\"></i> Insert Faculty Member</a></li>
										  <li><a href=\"courses.php\"><i class=\"icon-plus-sign\"></i> Insert Courses</a></li>
										  <li><a href=\"organisation.php\"><i class=\"icon-plus-sign\"></i> Insert Organisation</a></li>
                                          <li><a href=\"delete.php\"><i class=\"icon-minus-sign\"></i> Delete Users</a></li>	
									</li> 
									</ul> "; 
									} 
									
                               echo "</ul>
                            </li>
                        </ul>
	                </div>";} ?>
	                	
	              	<div class="pull-right">
	                	<ul class="nav pull-right">
	                    	<li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown">Welcome, <?php echo $name?> <b class="caret"></b></a>
	                        	<ul class="dropdown-menu">
								<?php
								if(strcmp($privilege,"student")==0){
										$query_approved="select is_approved from student where student_id='$id'";
										$result=mysql_query($query_approved, $con);
										$row=mysql_fetch_array($result);
										if($row['is_approved']==0) {
										
											echo "<li><a href=\"editProfile.php\"><i class=\" icon-cog\"></i> Edit Profile</a></li> "; }} ?>
	                            	<li><a data-toggle="modal" href="#change_password"><i class="icon-pencil"></i> Change Password</a></li>
	                            	<li class="divider"></li>
	                            	<li><a href="logout.php"><i class="icon-off"></i> Logout</a></li>
	                        	</ul>
	                    	</li>
	                	</ul>
	              	</div>
	            </div>
	        </div>
	    </div>
	</div>
	<!-- BODY CONTAINER -->
	<div class="container">
  		<div class="row-fluid">
    		<!--Sidebar content-->
    		<div class="span3 sidebar-box">
                <div class="well sidebar-nav custom-well">
                    <img src="assets/img/daiict.png" class="img-rounded sidebar-img" >

                    <ul class="nav nav-list">  
                        <li><a href="index.php">Home</a></li>
                        <li><a href="listevents.php">Events</a></li>  
                       <?php if(strcmp($privilege,"student")==0){
                        echo "<li><a href=\"profile.php\">Profile</a></li> ";}?>  
                        <li><a href="http://webmail.daiict.ac.in">Webmail</a></li>
                    </ul>
                   
                </div>  
            </div>

    		<!--Body content-->
    		<div class="span9 panel-box">
    		    <div id="filer">
                    <h2>Event Generation</h2>
                    <form action="eventgen.php" method='post' onSubmit="return validateUrPw(this)" id="eventform">
                        <table style="width:100%;" class="table"> 
                            <tr>
                                <td>Company Name:</td>
                                <td>
                                    <input required  type="text" name="cname" style="margin-right:300px;" title="Please enter the Company name">
                                </td >
                            </tr>

                            <tr>
                                <td >Event Type:</td>
                                <td>
                                    <input type="radio" name="type" value="Job" checked="checked"> Job 
                                    <input type="radio" name="type" value="Internship"> Internship
                                </td>
                            </tr> 

                            <tr>
                                <td >Domain:</td>
                                <td>	
                                    <input type="checkbox" name="domain[]" value="CE" checked="checked"> CE
                                    <input type="checkbox" name="domain[]" value="ECE"> ECE
                                </td>
                            </tr>

                            <tr>
                                <td>CTC:</td>
                                <td>
                                    <input pattern="[+]?[0-9]*[.,]?[0-9]+" type="text" name="ctc" style="margin-right:300px; width:200px;" title="Numeric Field">
                                </td>
                            </tr>

                            <tr>
                                <td >Program</td>
                                <td>
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
                            </tr>

                            <tr>
                                <td>batch</td>
                                <td>
                                    <select name="batch">
                                        <option value="2013"> 2013 </option>
                                        <option value="2012"> 2012 </option>
                                        <option value="2011"> 2011 </option>
                                        <option value="2010"> 2010 </option>
                                        <option value="2009" selected> 2009 </option>
                                        <option value="2008"> 2008 </option>
                                        <option value="2007"> 2007 </option>
                                    </select>
                                </td>
                            </tr>

                            <tr>
                                <td>Eligibility Criteria(min. CPI):</td>
                                <td>
                                    <input required type="number" name="cpi" placeholder="CPI" id="cpi" pattern="[+]?[0-9]*[.,]?[0-9]+" min="0" max="10" step="0.01">
                                </td >
                            </tr>

                            <tr>
                                <td>Deadline:</td>
                                <td>
                                    <span id="date"><input type="text" id="datep" required name="date" ></span> <!-- PATTERN !!  -->
                                </td>
                            </tr>

                            <tr>
                                <td></td>
                                <td>Hour:
                                    <select name="hour" style="width:60px">
                                    	<option  value="00"> 00</option>
                                    	<option value="01"> 01 </option>
                                        <option value="02"> 02</option>
                                        <option value="03"> 03</option>
                                        <option value="04"> 04</option>
                                        <option value="05"> 05</option>
                                        <option value="06"> 06</option>
                                        <option value="07"> 07</option>
                                        <option value="08"> 08</option>
                                        <option value="09"> 09</option>
                                        <option value="10"> 10</option>
                                        <option value="11"> 11</option>
                                        <option value="12"> 12</option>
                                        <option value="13"> 13</option>
                                        <option value="14"> 14</option>
                                        <option value="15"> 15</option>
                                        <option value="16"> 16</option>
                                        <option value="17"> 17</option>
                                        <option value="18"> 18</option>
                                        <option value="19"> 19</option>
                                        <option value="20"> 20</option>
                                        <option value="21"> 21</option>
                                        <option value="22"> 22</option>
                                        <option selected value="23"> 23</option>
                                 	</select>
                                    Minute:
                                    <select name="min" style="width:60px">
                                        <option selected  value="00"> 00</option>
                                        <option value="01"> 01 </option>
                                        <option value="02"> 02</option>
                                        <option value="03"> 03</option>
                                        <option value="04"> 04</option>
                                        <option value="05"> 05</option>
                                        <option value="06"> 06</option>
                                        <option value="07"> 07</option>
                                        <option value="08"> 08</option>
                                        <option value="09"> 09</option>
                                        <option value="10"> 10</option>
                                        <option value="11"> 11</option>
                                        <option value="12"> 12</option>
                                        <option value="13"> 13</option>
                                        <option value="14"> 14</option>
                                        <option value="15"> 15</option>
                                        <option value="16"> 16</option>
                                        <option value="17"> 17</option>
                                        <option value="18"> 18</option>
                                        <option value="19"> 19</option>
                                        <option value="20"> 20</option>
                                        <option value="21"> 21</option>
                                        <option value="22"> 22</option>
                                        <option value="23"> 23</option>
                                        <option value="24"> 24</option>
                                        <option value="25"> 25</option>
                                        <option value="26"> 26</option>
                                        <option value="27"> 27</option>
                                        <option value="28"> 28</option>
                                        <option value="29"> 29</option>
                                        <option value="30"> 30</option>
                                        <option value="31"> 31</option>
                                        <option value="32"> 32</option>
                                        <option value="33"> 33</option>
                                        <option value="34"> 34</option>
                                        <option value="35"> 35</option>
                                        <option value="36"> 36</option>
                                        <option value="37"> 37</option>
                                        <option value="38"> 38</option>
                                        <option value="39"> 39</option>
                                        <option value="40"> 40</option>
                                        <option value="41"> 41</option>
                                        <option value="42"> 42</option>
                                        <option value="43"> 43</option>
                                        <option value="44"> 44</option>
                                        <option value="45"> 45</option>
                                        <option value="46"> 46</option>
                                        <option value="47"> 47</option>
                                        <option value="48"> 48</option>
                                        <option value="49"> 49</option>
                                        <option value="50"> 50</option>
                                        <option value="51"> 51</option>
                                        <option value="52"> 52</option>
                                        <option value="53"> 53</option>
                                        <option value="54"> 54</option>
                                        <option value="55"> 55</option>
                                        <option value="56"> 56</option>
                                        <option value="57"> 57</option>
                                        <option value="58"> 58</option>
                                        <option selected value="59"> 59</option>
                                    </select>
                                </td>   
                            </tr>

                            <tr>
                                <td>Description:</td>
                                <td>
                                    <textarea required rows="8" name='description' style="width:458px;"></textarea>
                                </td>
                            </tr>
                            
                            <tr>
                                <td>
                                    <input type='submit' class='btn btn-success' value="Done">
                                </td>
                                <td></td>
                            </tr>    
                        </table>
                    </form>
                </div>						
    		</div>
  		</div>
	</div>

	<div id="change_password" class="modal hide fade in" style="display: none; ">  
        <div class="modal-header">  
            <a class="close custom-close" data-dismiss="modal">x</a>  
            <h4>Change Password</h4>  
        </div>  
        <div class="modal-body">  
            <form class="well" method="POST" >
            	<table>          	
                	<tr>
                		<td >Old Password</td>
                		<td><input type="password" name="old_pw" pattern=".{4,}"td>
                	</tr>
                	<tr>
                		<td >New Password</td>
                		<td><input type="password" name="new_pw" pattern=".{4,}"></td>
                	</tr>
                	<tr>
                		<td >Confirm New Password</td>
                		<td><input type="password"name="confirm_pw" pattern=".{4,}"></td>
                	</tr>
                <table>  
                <button type="submit" class="btn btn-success" name="change_pw" >Change Password</button>
            </form>              
        </div>    
    </div> 


<!-- Le javascript
================================================== -->
<script src="assets/js/jquery.js"></script>
<script src="assets/js/bootstrap.min.js"></script>
<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
<script src="http://code.jquery.com/ui/1.10.2/jquery-ui.js"></script>
<script type="text/javascript" src="assets/js/eventgeneration.js"></script>
	<script>
	$(function() {
		$( "#datep" ).datepicker({
        showOn: 'button',
        buttonText: 'Show Date',
        buttonImageOnly: true,
        buttonImage: 'assets/img/calendar.gif',
    });
	});
	</script>
</body>
</html>
            