function validateForm() {
	
	document.getElementById("org_name1").innerHTML="";
	document.getElementById("addr1").innerHTML="";
	document.getElementById("city1").innerHTML="";
	document.getElementById("pincode1").innerHTML="";
	document.getElementById("country1").innerHTML="";
	document.getElementById("first_contact_person1").innerHTML="";
	document.getElementById("first_contact_number1").innerHTML="";
	document.getElementById("second_contact_person1").innerHTML="";
	document.getElementById("second_contact_number1").innerHTML="";
	document.getElementById("email1").innerHTML="";
	document.getElementById("website1").innerHTML="";
	
	
	var flag= true;
	var orgname= document.form1.org_name.value;
	var addr= document.form1.addr.value;
	var city=document.form1.city.value;
	var pincode=document.form1.pincode.value;
	var country=document.form1.country.value;
	var fcp=document.form1.first_contact_person.value;
	var fcn=document.form1.first_contact_number.value;
	var scp=document.form1.second_contact_person.value;
	var scn=document.form1.second_contact_number.value;
	var email= document.form1.email.value;
	var web= document.form1.website.value;
	var txtEmail=document.form1.email.value;
	var illegalChars= /[\(\)\<\>\,\;\:\\\/\"\[\]]/;
	var atrate=/[@]/;
	var dot=/[.]/;
	var n1=txtEmail.indexOf("@");
	var n2=txtEmail.lastIndexOf(".");


		if(orgname.length>100){
			document.getElementById("org_name1").innerHTML="Organisation Name should be less than 100."
			flag = false;
		}
		if(addr.length==200){
			
				document.getElementById("addr1").innerHTML="Address should be less than 200"
				flag = false;
			
		}
		if(city.length>50){
			document.getElementById("city1").innerHTML="City Length should be less than 50."
			flag = false;
		}
		if(pincode.length!=6){
			document.getElementById("pincode1").innerHTML="Invalid Pincode "
			if(isNaN(pincode))
			{
			document.getElementById("pincode1").innerHTML="Invalid Pincode."
			flag = false;
			}
		}
		if(pincode.length==6){
			//document.getElementById("pincode1").innerHTML="Invalid "
			if(isNaN(pincode))
			{
			document.getElementById("pincode1").innerHTML="Invalid Pincode."
			flag = false;
			}
		}
		
		if(country.length>200){
			document.getElementById("l_name1").innerHTML="Country Name should be less than 200."
			flag = false;
		}
		if(fcp.length>200){
			document.getElementById("first_contact_person1").innerHTML="Name should be less than 200."
			flag = false;
		}
		if(fcn.length!=10 || fcn.length!=11){
			document.getElementById("first_contact_number1").innerHTML="Contact Number should be of 10 digits."
			if(isNaN(fcn))
			{
			document.getElementById("first_contact_number1").innerHTML="Contact Number should be of 10 digits."
			flag = false;
			}
		}
		if(fcn.length==10 || fcn.length==11){
			//document.getElementById("first_contact_number1").innerHTML="Contact Number should be of 10 digits."
			if(isNaN(fcn))
			{
			document.getElementById("first_contact_number1").innerHTML="Contact Number should be of 10 digits."
			flag = false;
			}
		}
		if(scp.length>200){
			document.getElementById("second_contact_person1").innerHTML="Name should be less than 200."
			flag = false;
		}
		if(scn.length!=10 || scn.length!=11){
			if(isNaN(scn))
					 {
			document.getElementById("second_contact_number1").innerHTML="Country Name should be less than 200."
			flag = false;
					 }
		}
		if(email.length>200){
			document.getElementById("email1").innerHTML="Email Name should be less than 200."
			flag = false;
		}
		if(web.length>200){
			document.getElementById("web1").innerHTML="Website Name should be less than 200."
			flag = false;
		}
			if(!email.match(atrate))
	{
		document.getElementById("email1").innerHTML="*Invalid Email address";
		flag=false;
	}
	if(!email.match(dot))
	{
		document.getElementById("email1").innerHTML="*Invalid Email address";
		flag=false;
	}
	if(email.match(illegalChars))
	{
		document.getElementById("email1").innerHTML="*Invalid Email address";
		flag=false;
	}
	if(n1<1)
	{
		document.getElementById("email1").innerHTML="*Invalid Email address";
		flag=false;
	}	
    if(n2-n1 <2)
	{
		document.getElementById("email1").innerHTML="*Invalid Email address";
		flag=false;
	}
	if(!email.match(atrate))
	{
		document.getElementById("email1").innerHTML="*Invalid Email address";
		flag=false;
	}
	return flag;
}