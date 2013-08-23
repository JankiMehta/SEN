
function valideForm(thisform)
{
	var FName = thisform.firstname.value;
	var which = thisform.firstname.value;
	
	var MName = thisform.middlename.value;
	var which2 = thisform.middlename.value;
	
	var LName = thisform.lastname.value;
	var which3 = thisform.lastname.value;
	
	var Id= thisform.ID.value;
	
	var Pass1 = thisform.password.value;
	var Pass2 = thisform.confirmpassword.value;
	
	var cpi= thisform.CPI.value;
	
	var Per1= thisform.Xper.value;
	var Per2= thisform.XIIper.value;
	
	
	
	
	
if (FName=="")
{
	window.alert("Please enter your First Name.");
	thisform.firstname.focus();
	return false;
}
			
if(FName.length>50)
	{
		alert("Max Length of Fname is 50");
		thisform.firstname.focus();
		return false;
	}	
if (/[^A-z]/gi.test(which)) 
			{
				alert ("Only Alphabets Are Valid In This Field");
				which = "";
				which.focus();
				return false;
			}
	
if(MName=="")
	{
		alert("Please enter the Middle name");	
		thisform.middlename.focus();
		return false;
	}
if(MName.length>50)
	{
		alert("Max Length of Mname is 50");
		thisform.middlename.focus();
		return false;
	}
if (/[^A-z]/gi.test(which2)) 
			{
				alert ("Only Alphabets Are Valid In This Field");
				which2 = "";
				which2.focus();
				return false;
			}
			
if(LName=="")
	{
		alert("Please enter the Last name");	
		thisform.lastname.focus();
		return false;
	}
if(LName.length>50)
	{
		alert("Max Length of Mname is 50");
		thisform.lastname.focus();
		return false;
	}
if (/[^A-z]/gi.test(which3)) 
			{
				alert ("Only Alphabets Are Valid In This Field");
				which3 = "";
				which3.focus();
				return false;
			}
			
if(Id=="")
	{
		alert("Please enter the Your ID");	
		thisform.id.focus();
		return false;
	}
if(Id.length>9 || Id.length<9) 
	{
		alert("ID contains 9 numbers only");	
		thisform.id.focus();
		return false;	
	}
if(isNaN(Id))
	{
		alert("Its not a valid ID");
		thisform.id.focus();
		return false;
	}
	
if (Pass1 == '' )
 {
alert('Please enter your password.');
return false;
}

if (Pass2 == '')
 {
alert('Please enter your password again.');
return false;
}


if (Pass1 != Pass2) 
{
alert ("Passwords do not match.");
return false;
}

if(cpi=="")
	{
		alert("Please enter your CPI");	
		thisform.cpi.focus();
		return false;
	}
	
	if(isNaN(cpi) || cpi < 0 || cpi > 10)
	{
		alert("Its not a valid CPI");
		thisform.CPI.focus();
		return false;
	}
	
if(Per1=="")
	{
		alert("Please enter your X std Percentage");	
		thisform.Xper.focus();
		return false;
	}
	
	if(isNaN(Per1) || Per1 < 0 || Per1 > 100)
	{
		alert("Its not a valid Percentage");
		thisform.Xper.focus();
		return false;
	}
if(Per2=="")
	{
		alert("Please enter your XII std Percentage");	
		thisform.XIIper.focus();
		return false;
	}
	
	if(isNaN(Per2) || Per2 < 0 || Per2 > 100)
	{
		alert("Its not a valid Percentage");
		thisform.XIIper.focus();
		return false;
	}
	
	return true;

}
