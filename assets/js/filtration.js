function validateForm(thisform){

		var legalName=/[A-Za-z]/;
  		var legalnumber= /^[-+]?[0-9]+$/;
  		var cpiTo=thisform.cpiT.value;
  		var cpiFrom=thisform.cpiF.value;
  		var sscTo=thisform.xpT.value;
  		var sscFrom=thisform.xpF.value;
  		var hscTo=thisform.xiipT.value;
  		var hscFrom=thisform.xiipF.value;
  		var elct=thisform.elective.value;
  		var prg=thisform.program.value;
  		var btch=thisform.batch.value;
  		

  		//console.info(thisform.option[0].value);

  		/*if(thisform.option[0].checked== true){

  			if(cpiFrom==""){

  				alert("Enter the cpi From");
  				thisform.cpiF.focus();
  				return false;
  			}

  			else if(isNaN(cpiFrom) || cpiFrom < 0 || cpiFrom > 10){
				alert("Its not a valid CPI");
				thisform.cpiF.focus();
				return false;
			}

  		}*/


  		if(thisform.options[0].checked==true){


  			if(cpiFrom==""){

  				alert("Enter the cpi From");
  				thisform.cpiF.focus();
  				return false;
  			}

  			else if(isNaN(cpiFrom) || cpiFrom < 0 || cpiFrom > 10){
				alert("Its not a valid CPI");
				thisform.cpiF.focus();
				return false;
			}


			else if(cpiTo==""){

  				alert("Enter the cpi To");
  				thisform.cpiT.focus();
  				return false;
  			}

  			else if(isNaN(cpiTo) || cpiTo < 0 || cpiTo > 10){
				alert("Its not a valid CPI");
				thisform.cpiT.focus();
				return false;
			}

			else if(cpiFrom > cpiTo) {

				alert("CPI To has to be grater than or equal to CPI From");
				thisform.cpiF.focus();
				return false;
			}


  		}

  		if(thisform.options[1].checked==true){

  			if(elct==""){

  				alert("Choose atleast one eletive");
  				thisform.elective.focus();
  				return false;
  			}
  		}



  		if(thisform.options[2].checked==true){

  			if(prg==""){

  				alert("Choose a Program");
  				thisform.program.focus();
  				return false;
  			}
  		}


  		if(thisform.options[3].checked==true){

  			if(btch==""){

  				alert("Choose a Batch");
  				thisform.batch.focus();
  				return false;
  			}
  		}


  		if(thisform.options[4].checked==true){

  			if((thisform.gender[0].checked==false) && (thisform.gender[1].checked==false)){
		
				alert("please select your Gender");
				thisform.gender.focus();
				return false;
			}
  		}


  		if(thisform.options[5].checked==true){

  			if((thisform.status[0].checked==false) && (thisform.status[1].checked==false)){
		
				alert("please select your Status");
				thisform.status.focus();
				return false;
			}
  		}



  		if(thisform.options[6].checked==true){


  			if(sscFrom==""){

  				alert("Enter the % of SSC From");
  				thisform.xpF.focus();
  				return false;
  			}

  			else if(isNaN(sscFrom) || sscFrom < 0 || sscFrom > 100){
				alert("Its not a valid %");
				thisform.xpF.focus();
				return false;
			}


			else if(sscTo==""){

  				alert("Enter the % of SSC To");
  				thisform.xpT.focus();
  				return false;
  			}

  			else if(isNaN(sscTo) || sscTo < 0 || sscTo > 100){
				alert("Its not a valid %");
				thisform.xpT.focus();
				return false;
			}

			else if(sscFrom > sscTo) {

				alert("SSC To % has to be grater than or equal to SSC From %");
				thisform.xpF.focus();
				return false;
			}


  		}



  		if(thisform.options[7].checked==true){


  			if(hscFrom==""){

  				alert("Enter the % of HSC From");
  				thisform.xiipF.focus();
  				return false;
  			}

  			else if(isNaN(hscFrom) || hscFrom < 0 || hscFrom > 100){
				alert("Its not a valid %");
				thisform.xiipF.focus();
				return false;
			}


			else if(hscTo==""){

  				alert("Enter the % of HSC To");
  				thisform.xiipT.focus();
  				return false;
  			}

  			else if(isNaN(hscTo) || hscTo < 0 || hscTo > 100){
				alert("Its not a valid %");
				thisform.xiipT.focus();
				return false;
			}

			else if(hscFrom > hscTo) {

				alert("HSC To % has to be grater than or equal to HSC From %");
				thisform.xiipF.focus();
				return false;
			}


  		}




  		return true;

	}