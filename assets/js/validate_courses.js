function validateForm() {
	
	document.getElementById("courseid1").innerHTML="";
	document.getElementById("coursename1").innerHTML="";
	document.getElementById("coursetype1").innerHTML="";
	
	var flag= true;
	var id= document.form1.courseid.value;
	var coursename= document.form1.coursename.value;
	var coursetype=document.form1.coursetype.value;
	
		if(id.length>7){
			document.getElementById("courseid1").innerHTML="ID length should not be greater than 7."
			flag = false;
		}
		if(coursename.length>50){
			document.getElementById("coursename1").innerHTML="Large course Name."
			flag = false;
		}
		if(coursetype.length>50){
			document.getElementById("coursetype1").innerHTML="Large Course Type."
			flag = false;
		}
		
	return flag;
}
