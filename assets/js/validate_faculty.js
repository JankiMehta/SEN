function validateForm() {
	
	document.getElementById("faculty_id1").innerHTML="";
	document.getElementById("f_name1").innerHTML="";
	document.getElementById("m_name1").innerHTML="";
	document.getElementById("l_name1").innerHTML="";
	
	var flag= true;
	var id= document.form1.faculty_id.value;
	var fname= document.form1.f_name.value;
	var mname=document.form1.m_name.value;
	var lname=document.form1.l_name.value;

		if(id.length!=9){
			document.getElementById("faculty_id1").innerHTML="ID length should be less than 9."
			flag = false;
		}
		if(id.length==9){
			if(isNaN(id)){
				document.getElementById("faculty_id1").innerHTML="Id should be a number"
				flag = false;
			}
		}
		if(fname.length>50){
			document.getElementById("f_name1").innerHTML="Large First Name."
			flag = false;
		}
		if(mname.length>50){
			document.getElementById("m_name1").innerHTML="Large First Name."
			flag = false;
		}
		if(lname.length>50){
			document.getElementById("l_name1").innerHTML="Large First Name."
			flag = false;
		}
	return flag;
}