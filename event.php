 <?php
 
include 'connect.php' ;
session_start();
if (isset($_SESSION['id'])) {
	$id=$_SESSION['id'];
//	$id="201001093";
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
	$userFname = $row['f_name'];
	$userLname = $row['l_name'];
} else {
	header('Location: login.php');
	}
 include 'change_pw.php';



$event_id=$_GET['eventid'];
$CompanyName="";
$Domain="";
$type="";
$CTC="";
$EliCri="";
$Deadline="";
$Description="";
$batch="";
$prog="";
$sql="";
if($privilege == 'student'){
$sql1="SELECT prog_start_year, prog_id from student
									where student_id='$id'";
						$res=mysql_query($sql1,$con);
						$row1=mysql_fetch_array($res);
						$batch = $row1['prog_start_year'];
						$progid = $row1['prog_id'];
						$sql="SELECT * FROM event where event_id='$event_id' AND is_completed=0 and batch = '$batch' and prog_id='$progid' LIMIT 2";
}else{
$sql="SELECT * FROM event where event_id='$event_id' AND is_completed=0 LIMIT 2";
}				
if(isset($_GET['eventid'])){
//$sql="SELECT * FROM event where event_id='$event_id' AND is_completed=0 LIMIT 2";
$result=mysql_query($sql);
$i=0;
while($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
if($row['org_name'] == ""){
header("Location: /error.html");
}
$i=$i+1;
$CompanyName=$row['org_name'];
if($i==2)
$Domain="CS and ECE";
else
$Domain=$row['domain'];

$type=$row['event_type'];
$CTC= $row['ctc'];
$EliCri=$row['eli_cri'];
$Deadline=$row['reg_deadline'];
$Description=$row['event_details'];
$batch=$row['batch'];
$prog=$row['prog_id'];
}
if($CompanyName == "")
header("Location: index.php");


$progName="";
if($prog == 1)
$progName="B.Tech";
elseif($prog == 11)
$progName="M.Tech";
else
$progName="Msc IT";

if($CTC == "0")
$CTC = "N.A.";
if($EliCri == "0")
$EliCri = "N.A.";

$sql2 = mysql_query("SELECT eli_cri FROM event WHERE event_id='$event_id' ", $con);
$y = mysql_fetch_array($sql2,MYSQL_ASSOC);
if($y['eli_cri'] != NULL && $y['eli_cri'] != 0 )
$req_cpi = $y['eli_cri'];
else
$req_cpi = 0;
//$req_cpi = 7;

$b=1;
$sql3 = mysql_query("SELECT * FROM eventregister WHERE event_id='$event_id' and student_id='$id' ", $con);
if(mysql_num_rows($sql3)>0){
	$b = 0;
}


$sql = mysql_query("SELECT CPI FROM student WHERE student_id='$id' ");
$x = mysql_fetch_array($sql,MYSQL_ASSOC);
$st_cpi = $x['CPI'];
$a = 1;

$today = date("Y-m-d H:i:s", time());
if( ($req_cpi>$st_cpi) or (strtotime($today) > strtotime($Deadline))  ){
	$a = 0;
}
/**
	$query_name = "select f_name, l_name from ((select student_id as id, f_name, l_name from student) UNION (select admin_no as id, f_name, l_name from admin) UNION (select faculty_id as id, f_name, l_name from faculty) UNION (select SPCmember_no as id, f_name, l_name from spc) ) as p where p.id='$id'"; 
		$result = mysql_query($query_name);
		$arr = mysql_fetch_array($result, MYSQL_BOTH);
		$userFname=$arr["f_name"];
		$userLname=$arr["l_name"];
	**/

	
	
}else{
header("Location: /error.html");
}
 
 
	$query_post = "SELECT * FROM post WHERE event_id='$event_id' AND deleted=0";
	$result_post = mysql_query($query_post);
	$html = "";	
	$post_id = "";
	$postArray = Array();
	$queNo = 0;
	$realQueNo = 0;
	while($row_post = mysql_fetch_array($result_post,MYSQL_BOTH)) {
		$queNo = $queNo + 1;
		$post_id =  $row_post['post_id'];
		$realQueNo = $post_id;
		$post_time = $row_post['post_timestamp'];
		$post_by = $row_post['posted_by'];
		$query_posted_by = "select f_name, l_name from ((select student_id as id, f_name, l_name from student) UNION (select admin_no as id, f_name, l_name from admin) UNION (select faculty_id as id, f_name, l_name from faculty) UNION (select SPCmember_no as id, f_name, l_name from spc) ) as p where p.id='$post_by'"; 
		$result_posted_by = mysql_query($query_posted_by);
		$arr_post = mysql_fetch_array($result_posted_by, MYSQL_BOTH);
		$pfname=$arr_post["f_name"];
		$plname=$arr_post["l_name"];
		$content=$row_post["content"];
		$co_cmnt = "SELECT count(comment_id) as number FROM comment WHERE post_id='$post_id' AND event_id='$event_id'";   
		$result_co_cmnt = mysql_query($co_cmnt);
		$num1 = "";
		while($row_c = mysql_fetch_array($result_co_cmnt,MYSQL_BOTH)) {
		  $num1 = $row_c['number'];
		  $postArray[$post_id] = $num1;
		}
		$co_cmnt = "SELECT count(comment_id) as number FROM comment WHERE post_id='$post_id' AND event_id='$event_id' AND deleted=0";   
		$result_co_cmnt = mysql_query($co_cmnt);
		$number = "";
		while($row_c = mysql_fetch_array($result_co_cmnt,MYSQL_BOTH)) {
		  $number = $row_c['number'];
		 // $postArray[$post_id] = $number;
		}
		if($privilege == 'admin' || $privilege == 'spc')
		$del='<span data-toggle="modal" class="close custom-close" onclick="delQuestion('.$post_id.')">x</span>';
		else
		$del="";
		$html_post = '<div class="row-fluid question-panel-box" id="ques--'.$post_id.'">
                    <div class="span2 question-panel-inner-lbox">
                        <a href="#" class="thumbnail custom-ques-thumbnail">  
                            <img src="assets/data/img/'.$post_by.'.png" width="100%" >  
                        </a>
                        <span><p class="user-info">'.$pfname.' '.$plname.'</p></span>                    
                    </div>
                    <div class="span10 question-panel-inner-rbox">
						'.$del.'
                        <p><strong>Question '.$queNo.': </strong>'.$content.'</p><a id="replies-link--'.$post_id.'" class="reply-link" >'.$number.' Reply</a>
                        <p class="posted-info" >Posted on '.$post_time.'</p><div id="replies-panel--'.$post_id.'" class="replies-panel-outer-box" >'; 
		$html .= $html_post;
		
		$query_cmnt = "SELECT * FROM comment WHERE post_id='$post_id' AND event_id='$event_id'";   
		$result_cmnt = mysql_query($query_cmnt);
		$num=0;
		while($row_cmnt = mysql_fetch_array($result_cmnt,MYSQL_BOTH)) {
			$num = $num + 1;
		if($row_cmnt['deleted'] == 0){
			$cmnt_id =  $row_cmnt['comment_id'];
			$cmnt_time = $row_cmnt['comment_timestamp'];
			$comm_by = $row_cmnt['commented_by'];
			$query_cmnted_by = "select f_name, l_name from ((select student_id as id, f_name, l_name from student) UNION (select admin_no as id, f_name, l_name from admin) UNION (select faculty_id as id, f_name, l_name from faculty) UNION (select SPCmember_no as id, f_name, l_name from spc) ) as p where p.id='$comm_by'";
			$result_cmnted_by = mysql_query($query_cmnted_by);
			
			$arr_cmnt = mysql_fetch_array($result_cmnted_by, MYSQL_BOTH);
			$fname = $arr_cmnt["f_name"];
			$lname = $arr_cmnt["l_name"];
			$comment = $row_cmnt['content']; // WHERE IS DATA !!!
			
			if($privilege == 'admin' || $privilege == 'spc')
			$delc='  <span data-toggle="modal" class="close custom-close" onclick="delCommnet('.$post_id.','.$num.')">x</span>';
			else
			$delc="";
			$html_comnt = '<div class="row-fluid replies-panel-inner-box" id="post--'.$post_id.'--comment--'.$num.'" >
                                <div class="span2">
                                    <a href="#" class="thumbnail custom-reply-thumbnail">  
                                        <img src="assets/data/img/'.$comm_by.'.png"" alt="Image" width="100%" >  
                                    </a>
                                    <span><p class="user-info" style="text-align:left">'.$fname.' '.$lname.' </p></span>                    
                                </div> 
                                <div class="span10 replies-panel-inner-rbox">
								 '.$delc.'
                                    <p>'.$comment.'</p>
                                    <p class="posted-info" style="margin-left:0" >Commented on '.$cmnt_time.'</p>
                                </div>    
                            </div><hr class="custom-hr">';
			$html .= $html_comnt;
			}
		}
		$html .= '<div class="row-fluid replies-panel-inner-box" id="reply--button--'.$post_id.'">
                                <form style="margin:0px">
                                    <textarea required name="question" placeholder="Post a Reply" style="width:90%" id="reply--'.$post_id.'"></textarea>
                                    <input type="button" class="btn btn-small" onclick="addReply('.$post_id.')" value="Submit">
                                </form>   
                            </div>';
							  $html .= "</div></div>    
                </div>";
	}
	$js_array = json_encode($postArray);
	echo "<script type='text/javascript'>";
echo "var postArray = ". $js_array . ";\n";
echo "</script>";
include "change_pw.php";
		
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Event</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<!-- Le styles -->
	<link href="assets/css/bootstrap.min.css" rel="stylesheet">
	<link href="assets/css/common.css" rel="stylesheet">
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
									<li><a href=\"eventgeneration.php\"><i class=\"icon-plus-sign\"></i> Add Event</a></li>"; 
							
									if(strcmp($privilege,"admin")==0) {
                                    echo "<li><a href=\"filtration.php\"><i class=\"icon-search\"></i> Filtration</a></li>    
                                    <li><a href=\"status.php\"><i class=\"icon-bullhorn\"></i> Status Update</a></li>
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
     		<div id="sidebar_box" class="span3 sidebar-box">
    			<div class="well sidebar-nav custom-well">
    				<img src="assets/img/daiict.png" class="img-rounded sidebar-img" >

    			    <ul class="nav nav-list">  
                        <li ><a href="index.php">Home</a></li>
                        <li class="active"><a href="listevents.php">Events</a></li>  
						<?php if(strcmp($privilege,"student")==0){
                        echo "<li><a href=\"profile.php\">Profile</a></li> ";}?> 
                        <li><a href="http://webmail.daiict.ac.in">Webmail</a></li>
                    </ul>
    			</div>	
    		</div>

    		<!--Body content-->
    			<div class="span9 panel-box" id='bodycontent' >
 <div class="leaderboard">    
     <h2>Event Details</h2>
	  	<div>
  			<div>
  			  <p><b><?php
			  if($type != "" && $progName != "" && $batch != "" ){
			  echo $type." opportunity for ".$progName."-".$batch; 
			 }
			  ?> </b></p>
		</div>
	  </div>
	  
    <div>
  			<div>
  			  <p><b>Company Name:</b>  <?php echo $CompanyName; ?> </p>
		</div>
	  </div>
	

        
    <div>
  			<div>
  			  <p><b>Domain:</b> <?php echo $Domain; ?> </p>
		</div>
	  </div>
    <div>
  			<div>
  			  <p> <b>CTC:</b> <?php echo $CTC; ?>  </p>
		</div>
	  </div>
    <div>
  			<div>
  			  <p><b>Eligibility Criteria(min. CPI):</b> <?php echo $EliCri; ?>   </p>
		</div>
	  </div>
    <div>
  			<div>
  			  <p><b>Deadline: </b><?php echo $Deadline; ?>  </p>
		</div>
	  </div>
     <div>
  			<div>
  			  <p><b>Description:</b><br><?php echo $Description; ?>  </p>
		  </div>
	  </div>
                </div> 
						<div class="row-fluid">
                        <button id="ask_question" class="btn btn-primary"> Ask a Question </button>
                        <!-- <button class="btn btn-success" style="margin-left:10px">Register</button> -->
						<?php
							if(strcmp($privilege,"student") == 0 ){
							if($a){
							echo "<a data-toggle=\"modal\" href=\"#confirm_register\" class=\"btn btn-success\" style=\"margin:10px\"> Register </a>";
							}
							}
						?>
						<?php if(strcmp($privilege,"admin")==0){
						echo '<button id="list_reg" class="btn btn-primary" onclick=\'window.open("excel.php?event_id=$event_id")\'>Registered Students</button>';
						}
						?> 
						
						
                        <div id="question_box" class="row-fluid question-box" style="width:95%; display:none;">
                            <form>
                                <textarea required name='question' style="width:94%" id='questiondata' ></textarea>
                                <input type="button" class="btn btn-success" onclick="addQuestion()" value="Submit" >
                            </form>
                        </div>

                    </div>
                <hr class="custom-hr" style="margin-top:25px; margin-bottom:10px;">
                
                <h4>Questions</h4>

               <?php echo $html; ?>

    		</div>
  		</div>
	</div> 
    <div id="confirm_register" class="modal hide fade in" style="display: none; ">  
        <div class="modal-header">  
            <a class="close custom-close" data-dismiss="modal">x</a>  
            <h4>PLease upload your resume</h4>  
			
			<?php
				if($b){
				echo "<form action='regevent.php' method='post' enctype='multipart/form-data'>";
				$myresult = mysql_query("SELECT domain FROM event WHERE event_id='$event_id' ");
				echo "<input type='hidden' name='event_id' value='".$event_id."' >";
				echo "<select name='domain'>";
				while($row = mysql_fetch_array($myresult,MYSQL_BOTH)){
					echo "<option>" .$row['domain']. "</option>"; 
				}
				echo "</select>";
				echo " <br>Uplaod your Resume : <input type='file' name='file' >";
				echo "<input type='Submit' class='btn btn-success'>";
				echo "</form>"; 
				}
				
				else{
				echo "Already Registered";
				}
			?>
        </div>  
        <div class="modal-body">               
                           
        </div>    
    </div>

    <div id="confirm_delete" class="modal hide fade in" style="display: none; ">  
        <div class="modal-header">  
            <a class="close custom-close" data-dismiss="modal">x</a>  
            <h4>Are you sure you want to delete?</h4>  
        </div>  
        <div class="modal-body">               
            <button class="btn btn-danger confirm-delete" data-dismiss="modal">Confirm</button>
            <button class="btn btn-success" data-dismiss="modal">Cancel</button>               
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
<script type="text/javascript">
var id = 0;
var queid = <?php echo '"'.$queNo.'"'; ?>;
	function addReply(postid){
        
				var text = document.getElementById('reply--'+postid);
			var content = text.value;
			text.value = "";
			if(content != ""){
			
            var reply_panel_id = "#reply--button--" + postid
	var d = new Date();
    var curr_date = d.getDate();
    var curr_month = d.getMonth() + 1; //Months are zero based
    var curr_year = d.getFullYear();
	var curr_hour = d.getHours();
    var curr_min = d.getMinutes();
    var curr_sec = d.getSeconds();
	var name = "First Name";
	//parseInt(a, 10) + parseInt(b, 10);
	var comtid = parseInt(postArray[postid],10) + 1;
	postArray[postid] = parseInt(postArray[postid],10) + 1;
	$.post("insert_comment.php", { event_id : <?php echo '"'.$event_id.'"'; ?> , content : content , id : <?php echo '"'.$id.'"'; ?>, post_id : postid , c_id : comtid },
	function(data , status){
   //alert("Data: " + data + "\nStatus: " + status);
    console.info(data);
    console.info(status);
	var user = <?php echo '"'.$id.'"'; ?>;
	var fname= <?php echo '"'.$userFname.'"'; ?>;
	var lname= <?php echo '"'.$userLname.'"'; ?>;
	var privilege= <?php echo '"'.$privilege.'"'; ?>;
	
	var delc="";
	if(privilege=='admin' || privilege=='spc')
	delc =   '<span data-toggle="modal" class="close custom-close" onclick="delCommnet('+postid+','+comtid +')" >x</span>';
	else
	delc = '';
	if(status == "success"){
            $(reply_panel_id).before(' <div class="row-fluid replies-panel-inner-box" id="post--'+postid+'--comment--'+comtid+'" >' +
                                '<div class="span2">' +
                                    '<a href="#" class="thumbnail custom-reply-thumbnail"> ' +
                                     '<img src="assets/data/img/'+user+'.png" alt="Image" width="100%" ></a><span><p class="user-info" style="text-align:left">'+fname+' '+lname+'</p></span>' +
                                '</div> ' +
                                '<div class="span10 replies-panel-inner-rbox">' +
							//	'  <a id="del__reply__repbox_ques-1_reply-1" data-toggle="modal" href="#confirm_delete" class="close custom-close">x</a>'+  // DEL
                                 delc +
                                    '<p>'+content+'</p>' +
                                   '<p class="posted-info" style="margin-left:0" >Commented on '+ curr_year  + "-" + curr_month + "-" + curr_date +'  '+ curr_hour+':'+curr_min+':'+curr_sec+'</p>' +
                                '</div>' +
                            '</div> <hr class="custom-hr">');			
		}	
	});
}
}	
	function addQuestion(){
	 $('#question_box').slideToggle();
		var text = document.getElementById('questiondata');
			var content = text.value;
			text.value = "";
console.info(content);
if(content != ""){
	var d = new Date();
    var curr_date = d.getDate();
    var curr_month = d.getMonth() + 1; //Months are zero based
    var curr_year = d.getFullYear();
	var curr_hour = d.getHours();
    var curr_min = d.getMinutes();
    var curr_sec = d.getSeconds();
	//var name = <?php echo $id; ?>;
	if(id==0){
	id = <?php if($realQueNo !=0)
				echo $realQueNo+1; 
				else
				echo 1; ?>;
	}else
	id = parseInt(id,10)+1;
	postArray[id]=0;
	$.post("insert_question.php", { event_id : <?php echo '"'.$event_id.'"'; ?> , content : content , id : <?php echo '"'.$id.'"'; ?> },
  function(data , status){
   //alert("Data: " + data + "\nStatus: " + status);
    console.info(data);
    console.info(status);
	var user = <?php echo '"'.$id.'"'; ?>;
	var fname= <?php echo '"'.$userFname.'"'; ?>;
	var lname= <?php echo '"'.$userLname.'"'; ?>;
	var privilege= <?php echo '"'.$privilege.'"'; ?>;
		queid = parseInt(queid,10) + 1;
	var del="";
	if(privilege=='admin' || privilege=='spc')
	del = '<span data-toggle="modal" class="close custom-close" onclick="delQuestion('+id+')">x</span>';
	else
	del = '';
	if(status == "success"){
	//
	         $('#bodycontent').append('<div class="row-fluid question-panel-box" id="ques--'+id+'" >' +
                    '<div class="span2 question-panel-inner-lbox">' +
                        '<a href="#" class="thumbnail custom-ques-thumbnail">' +
                            '<img src="assets/data/img/'+user+'.png"  width="100%" >' +  
                        '</a>' +
                        '<span><p class="user-info">'+fname+" "+lname+'</p></span>' +  
                    '</div>' +
                    '<div class="span10 question-panel-inner-rbox">' +
				//	' <a id="del__ques__ques--1" data-toggle="modal" href="#confirm_delete" class="close custom-close">x</a>'+  //DEL
							del +
                        '<p><strong>Question: '+queid+' </strong>'+content+'</p>' +
                        '<a id="replies-link--'+id+'" class="reply-link" onclick="toggleBox('+id+')">0 Reply</a>' +
                        '<p class="posted-info" >Posted on '+ curr_year  + "-" + curr_month + "-" + curr_date +'  '+ curr_hour+':'+curr_min+':'+curr_sec+'</p>'+
                '  <div id="replies-panel--'+id+'" class="replies-panel-outer-box" >' +
                            '<div class="row-fluid replies-panel-inner-box" id="reply--button--'+id+'">' +
                                '<form style="margin:0px">' +
                                    '<textarea required name="question" placeholder="Post a Reply" style="width:90%" id="reply--'+id+'"></textarea>' +
                                    '<input class="btn btn-small" onclick="addReply('+id+')" type="button" value="Submit">' +
                                '</form>' +
                            '</div></div></div></div>');
				 $("#replies-panel--"+id).toggle();
	
	
	//
	
	}
  });
	
	
	
   
	console.info("DONE ???");			
		}
	}
function delQuestion(postid){		
var r=confirm("Are you sure you want to delete question ?");
if (r==true)
  {
	
	$.post("delete_question.php", { event_id : <?php echo '"'.$event_id.'"'; ?> , post_id : postid , id : <?php echo '"'.$id.'"'; ?> },
  function(data , status){
   //alert("Data: " + data + "\nStatus: " + status);
    console.info(data);
    console.info(status);
	if(status == "success"){
	
	//postArray[id] = 0;
 	$("#ques--"+postid).remove();
	
	}
	
	});
	
	
  }
else
  {
  
  }
	
	}	
	
function delCommnet(postid,commentid){		

		var r=confirm("Are you sure you want to delete comment ?");
if (r==true)
  {
  
  	$.post("delete_comment.php", { event_id : <?php echo '"'.$event_id.'"'; ?> , post_id : postid , c_id : commentid , id : <?php echo '"'.$id.'"'; ?> },
  function(data , status){
   //alert("Data: " + data + "\nStatus: " + status);
    console.info(data);
    console.info(status);
	if(status == "success"){
  
  
		$("#post--"+postid+"--comment--"+commentid).remove();
	
	
		}
	});
	
	
  }
else
  {
  
  }
		
	}	
	
   $(document).ready(function(){
        $('#ask_question').click(function() {
            $('#question_box').slideToggle();
        });

        $('.reply-link').click(function() {
            var link_id = $(this).attr('id');
            var reply_panel_id = "#replies-panel--" + link_id.split("--")[1];
			console.info(reply_panel_id);
            $(reply_panel_id).slideToggle();
        });
    });	
	
	
	function toggleBox(postid){
	
	   var reply_panel_id = "#replies-panel--" + postid
			console.info(reply_panel_id);
            $(reply_panel_id).slideToggle();
	
	
	}
</script>
</body>
</html>
            