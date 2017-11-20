<!--

var validated=true;  // global

// call this from onchange
function valid(vl,errm) // varying number of arguments
{
	var i;
	var arrTypo = new Array();
	validated=true;
	// error message for typo error
	typoErrMsg="WARNING: Your email address might not be valid because it contains a spelling error. Please check again";

	// Regular expression for typo errors
	arrTypo[0] = "[\\w-\\.]{1,}\\@[\\w-\\.\\@]{0,}(rediff|htomail|htomil|htomai|htomal|htomial|hotmil|hotmai|hotmial|hotamil|hatmail|hotnail|hotrmail)s*.co[m]{0,1}[\\w\\.\\@]{0,}"
	arrTypo[1] = "[\\w-\\.]{1,}\\@[\\w-\\.]{1,}(rediff|rediffmail|hotmail|hotm[ail]s?).com[\\w-\\.\\@]{0,}"
	arrTypo[2] = "[\\w-\\.]{1,}\\@[\\w-\\.]{1,}(rediffmail|hotmail|hotm[ail]s?)[\\w-\\.]{1,}.com[\\w\\.\\@]{0,}"
	arrTypo[3] = "[\\w-\\.]{1,}\\@(rediffmail|hotmail)[\\w-\\.]{1,}.co[m]{0,1}[\\w-\\.\\@]{0,}"
	arrTypo[4] = "[\\w-\\.]{1,}\\@(rediffmail|hotmail).com[\\w-\\.\\@]{1,}"
	arrTypo[5] = "[\\w-\\.]{1,}\\@[\\w-\\.\\@]{1,}yahoo[\\w\\.]{1,}.(com|co.uk|co.in)"
	arrTypo[6] = "[\\w-\\.]{1,}\\@[\\w-\\.\\@]{1,}yahoo.(com|co.uk|co.in)"
	arrTypo[7] = "[\\w\\.\\@]{1,}\\@yahoo[\\w-\\.]{1,}.(com|co.uk|co.in)"
	arrTypo[8] = "[\\w-\\.]{1,}\\@[\\w-\\.\\@]{0,}yahoo[\\w]{0,}.com.in"
	arrTypo[9] = "[\\w-\\.]{1,}\\@[\\w-\\.\\@]{0,}yahoo[\\w]{0,}.com.uk"
	arrTypo[10] = "[\\w-\\.]{1,}\\@[\\w-\\.\\@]{0,}y(o|a)*ho{3,}[\\w]{0,}.(com|co.uk|co.in)"
	arrTypo[11] = "[\\w-\\.]{1,}\\@[\\w-\\.\\@]{0,}yahoo.uk.co[\\w-\\.]{0,}"
	arrTypo[12] = "[\\w-\\.]{1,}\\@[\\w-\\.\\@]{1,}tm[.,]net[.,]my[\\w]{1,}"
	arrTypo[13] = "[\\w-\\.]{1,}\\@[\\w-\\.\\@]{1,}tm[.,]net[.,]my"
	arrTypo[14] = "[\\w-\\.]{1,}\\@tm[.,]net[.,]my[\\w]{1,}"
	arrTypo[15] = "[\\w-\\.]{1,}\\@usa[.,]net[\\w-\\.\\@]{1,}"
	arrTypo[16] = "[\\w-\\.\\@]{1,}\\@[\\w-\\.\\@]{1,}usa[.,]net[\\w-\\.\\@]{1,}"
	arrTypo[17] = "[\\w-\\.\\@]{1,}\\@[\\w-\\.\\@]{1,}usa[.,]net"
	arrTypo[18] = "[\\w-\\.]{1,}\\@pacific[.,]net[.,]sg[\\w-\\.\\@]{1,}"
	arrTypo[19] = "[\\w-\\.]{1,}\\@[\\w-\\.\\@]{1,}pacific[.,]net[.,]sg"
	arrTypo[20] = "[\\w-\\.]{1,}\\@[\\w-\\.\\@]{1,}pacific[.,]net[.,]sg[\\w-\\.\\@]{1,}"
	arrTypo[21] = "[\\w-\\.]{1,}\\@www\\.[\\w-\\.]{0,}\\.[\\w-\\.]{0,}"
	arrTypo[22] = "[\\w-\\.]{1,}\\@(ya[\\w-]{1,}hoo|yh[\\w-]{1,}oo|yaho|yhoo).(com|co.uk|co.in)"
	arrTypo[23] = "[\\w-\\.]{1,}\\@tm(.net|net.com.my)"
	arrTypo[24] = "newmail@wipro.com"

	// check email format
	//rx=new RegExp("[\\w-_]+(\\.[\\w-_]+)*\\@+[\\w-_]+(\\.[\\w-_]+)+");
	for (i=2;i<valid.arguments.length;i++) 
	    rx=new RegExp(valid.arguments[i]);

	if ((a=rx.exec(vl))!=null && a[0].length==vl.length)
	{
		validated=true;
	}
	else{
		// return false once it finds any format error
		alert(errm)
		validated=false;
		return false;
	}

	// if the email don't have any format error
	// check for any typo error
	// the loop will exit once it found any typo error
	if (validated)
	{
		for (i=0;i<arrTypo.length;i++) 
		{
			var rx;
			//alert(arrTypo[i]);
			rx=new RegExp(arrTypo[i]);
			if ((a=rx.exec(vl))!=null && a[0].length==vl.length) {
				alert(typoErrMsg);
				validated=false;
				return false; 
			}
		}

		return validated;
	}

}

function ValidateOneEmail(ctl)
{
    var vl = ctl.value.toLowerCase();
    vl = Trim(vl);
	var validErr = true;
	validated = true;
	
	// scan for typo errors for the following domains:
	//	 - hotmail.com
	//   - yahoo.com, yahoo.co.uk, yahoo.co.in
	//   - rediffmail.com
	//   - tm.net.my
	//validErr=valid(vl,"Invalid email. Please enter a valid email address.","[\\w-_]+((\\.|')[\\w-_]+)*\\@[\\w-_]+(\\.[\\w-_]+){1,5}");
	validErr=valid(vl,"Invalid email. Please enter a valid email address.","[\\w-_]+((\\.)[\\w-_]+)*\\@[\\w-_]+(\\.[\\w-_]+){1,5}");

	if (!validErr) {
      ctl.focus();
    }
	
    if (vl.indexOf('@jobstreet.com') > 0) {
	   alert ("WARNING: Please change your email address. If you use an email address with the JobStreet.com name, you will not receive any email from the employers. You can open an email address with any of the free web-based email providers (www.hotmail.com or www.yahoo.com) before you create a MyJobStreet account.");
	   ctl.focus();
	   validated = false;
    } 
//    else if (vl.indexOf('@rediffmail') > 0) {
//	   alert ("WARNING: Please change your email address. If you use a rediffmail email address, you will not receive any email from JobStreet.com, as rediffmail is blocking emails from us. You can open an email address with any of the free web-based email providers (www.hotmail.com or www.yahoo.com) before you create a MyJobStreet account.");
//	   ctl.focus();
//	   validated = false;
//    } 
    else if (vl.indexOf('@bdonline') > 0) {
	   alert ("WARNING: Please change your email address. If you use a BDOnline email address, you will not receive any email from JobStreet.com, as BDOnline is blocking emails from us. You can open an email address with any of the free web-based email providers (www.hotmail.com or www.yahoo.com) before you create a MyJobStreet account.");
	   ctl.focus();
	   validated = false;
    } 
	else{
		return validErr;		
	}
}

function ValidateTwoEmail(email1, email2) {
  	if (Trim(email1.value) == Trim(email2.value)) {
		validated = true;
		return true;
	} else {
		alert('Your email confirmation does not match, please re-enter your email');
		email2.focus();
		validated = false;
		return false;
	}
}

function ValidateEmail(ctl)
{
    var vl = ctl.value;
	vl = Trim(vl);
	var validErr = true;
	
	// scan for typo errors for the following domains:
	//	 - hotmail.com
	//   - yahoo.com, yahoo.co.uk, yahoo.co.in
	//   - rediffmail.com
	//   - tm.net.my
	validErr=valid(vl,"Invalid email. Please enter a valid email address.","[\\w-_]+((\\.|')[\\w-_]+)*\\@[\\w-_]+(\\.[\\w-_]+){1,5}");

	if (!validErr) {
	      ctl.focus();
	    }
	else{
		return validErr;
	}
}

function isConfirm(msg) {
	var reply;
	
	reply = confirm(msg);
	if (reply)
		return true;
	else
		return false;	
}

function checkSpecializationLimit(objSpecialization, intLimit)
{
	intTotalSpecialization = 0;
	for(i=0;i<objSpecialization.length;i++)
	{
		if(objSpecialization[i].checked)
			intTotalSpecialization++;
	}
	if(intTotalSpecialization == 0)
	{
		alert("Please select at least one Job Specialization.");
		try{
			objSpecialization[0].focus();
		}
		catch(e){
			//alert('Could not focus on myinput.');
		}
		validated = false;
		return false;
	}
	else if(intTotalSpecialization > intLimit)
	{
		alert("Please do not select more than " + intLimit + " Job Specializations.");
		if (objSpecialization[0]) objSpecialization[0].focus();
		validated = false;
		return false;
	}
	else
		validated = true;
		return true;
}

function Trim(str) {
	var res = /^\s+/ig;
	var ree = /\s+$/ig;
	var out = str.replace(res,"").replace(ree,"");
    return out;
}

function ValidatePassword(ctlPassword, ctlConfirmPassword) {
	if (ctlPassword.value.length < 6) {
    		alert('Your password should contain at least 6 characters for security reasons.');
    		ctlPassword.focus();
    		validated = false;
    		return false;
  	}	
 	
  	if (ctlPassword.value == ctlConfirmPassword.value) {
		validated = true;
		return true;
	} else {
		alert('Your password confirmation does not match, please re-enter your password');
		ctlConfirmPassword.focus();
		validated = false;
		return false;
	}
}

function CountPassword(ctl) {
	if(ctl.value.length > 60 ) {	
		alert('Your password has exceeded 60 characters. Please keep to 6 to 60 characters.');
		ctl.focus();
		return false;
	}
	
}

function ValidateText(ctl,msg) {
	var temp_str = Trim(ctl.value);

	if (temp_str == "") {
		ctl.value = "";
	  	alert(msg);
	  	ctl.focus();
	  	validated = false;
	  	return false;
	} else {
		ctl.value = temp_str;
		validated = true;
		return true;
	}
}

function ValidateUpload(ctl, mode, msg) {
	//mode(bitwise) : 1 - doc, 2 - .txt, 4 - .pdf, 8 - .htm
	var temp_str = Trim(ctl.value);
	var str_len = String(temp_str).length;
       	var str_ext = String(temp_str).substring(str_len, str_len - 4);
	
	if (temp_str == "") {
		alert(msg);
	  	ctl.focus();
		validated = false;
		return false;
	}
	else if ( ((mode&1)==1 && str_ext.toLowerCase()==".doc") || ((mode&2)==2 && str_ext.toLowerCase()==".txt") || ((mode&4)==4 && str_ext.toLowerCase()==".pdf") || ((mode&8)==8 && str_ext.toLowerCase()==".htm")) {
		validated = true;
		return true;
	}
	else {
		alert(msg);
	  	ctl.focus();
	  	validated = false;
	  	return false;
	}
}

function ValidateCtl(ctl, msg, compulsory) {

//alert(GetValueFromCtl(ctl));

	if (GetValueFromCtl(ctl) == "" && compulsory=="1") {
		alert(msg);
		ctl.focus();
		validated = false;
		return false;
	} else {
		validated = true;
		return true;
	}
}

function ValidateRdo(ctl, msg, compulsory){
	var rdo = "";
	for (var i=0; i < ctl.length; i++) {
		if (ctl[i].checked) {
			rdo = ctl[i].value;
		}
    	}
	if (rdo == "" && compulsory == 1) {
		alert(msg);
		if ((ctl[0])) 
			ctl[0].focus();
		else
			ctl.focus();
		validated = false;
		return false;
	} else {
		validated = true;
		return true;
	}    
}

function ValidateList(ctl,msg,ctlfocus) {
	var temp_str = Trim(ctl.value);
	
	if (temp_str == "") {
	  alert(msg);
	  ctlfocus.focus();
	  validated = false;
	  return false;
	}
	else {
	  ctl.value = temp_str;
	  validated = true;
	  return true;
	}
}

function GetValueFromCtl (ctl) {
	for (var i=0; i < ctl.options.length; i++) {		
		if(ctl.options[i].selected ) {
			if (ctl.options[i].value == "" || ctl.options[i].value == "0" || ctl.options[i].value == "-" || ctl.options[i].value == "00" || ctl.options[i].value == "000") {
				return "";
			} else
				return ctl.options[i].value;
		}
	}
	return "";
}

function GetValueFromRdo (ctl) {
	var cv = "";
	if (ctl.length == undefined) {
		if (ctl.checked) cv = ctl.value;
	} else {
		for (var i=0; i < ctl.length; i++) {
			if (ctl[i].checked) {
				cv = ctl[i].value;
			}
	    }
	}
	return cv;
}

function GetRdoFromValue (ctl, val) {
	var cv = "";
	if (ctl.length != undefined) {
		for (var i=0; i < ctl.length; i++) {
			if (ctl[i].value == val) {
				cv = i;
			}
	    }
	}
	return cv;
}

function ValidateSkill(clt,drp,req){


	if(req=="1"){
		if (Trim(clt.value)==""){
			alert("Please enter your top 3 skills.");
			validated = false;
			return false;
		}
		else{
			if(GetValueFromCtl(drp) == ""){
				alert("Please give your Years of Experience with this skill.");
				drp.focus();
				validated = false;
				return false;
			}
		}
	}
	else{	

		if(Trim(clt.value)!=""){
			if(GetValueFromCtl(drp) == ""){
				alert("Please give your Years of Experience with this skill.");
				drp.focus();
				validated = false;
				return false;
			}
		}
		else{
			if(GetValueFromCtl(drp) != ""){
				alert("Please enter the Skill.");
				clt.focus();
				validated = false;
				return false;
			}
		}

	}

}

function ValidateDup(frm,clt,drp){

	var err=0;
	var arrSkill = new Array();
	arrSkill[0] = frm.skill1.value;
	arrSkill[1] = frm.skill2.value;
	arrSkill[2] = frm.skill3.value;
	arrSkill[3] = frm.skill4.value;
	arrSkill[4] = frm.skill5.value;

	if(Trim(clt.value)!=""){
		if(GetValueFromCtl(drp) == ""){
			alert("Please give your Years of Experience with this skill.");
			drp.focus();
			validated = false;
			return false;
		}
	}
	else{
		if(GetValueFromCtl(drp) != ""){
			alert("Please enter the Skill.");
			clt.focus();
			validated = false;
			return false;
		}
	}

	for(var i=0;i<5;i++){
		for(var j=0;j<5;j++){
			if(arrSkill[i] == arrSkill[j] && arrSkill[i] != "" && arrSkill[j] != "" && i!=j){
				err=1;
			}
		}		
	}

	if (err==1) {
		alert("You have entered one or more duplicate skills. Please enter another Skill.");
		frm.skill1.focus();
		validated = false;
		return false;
	}	
	
}

function GetTextFromCtl (ctl) {
	for (var i=0; i < ctl.options.length; i++) {
		if(ctl.options[i].selected ) {
			return ctl.options[i].text;
		}
	}
	return "";
}

function ValidateDate(aday,amonth,ayear,maxyear,intType,msg,compulsory) {
	var tempDate; //= aday.value + amonth.value + ayear.value;
	var tempDay;
	var tempMonth;
	var tempYear;

	if (intType & 1)
		tempDay	= GetValueFromCtl(aday);
	else
		tempDay	= 1;


	if (intType & 2)
		tempMonth = GetValueFromCtl(amonth);
	else
		tempMonth = 1;

	if (intType & 4)
		tempYear = ayear.value;
	else
		tempYear = 1900;

	if (maxyear == 0)
		maxyear = 2999;

	tempDate = tempDay + tempMonth + tempYear;

	if (tempYear != '' && tempYear < 1900  || tempYear > maxyear) 
		validated = false;
	else 
	{
		var test = new Date(tempYear,tempMonth-1,tempDay);
    		if ((test.getFullYear() == tempYear) && (tempMonth - 1 == test.getMonth()) && (tempDay == test.getDate()))
        			validated = true;
    		else
			validated = false;
	}    

	if (compulsory == '0' && tempDate == '')
		validated = true;

	if (validated == false) {
		alert(msg);
		if (tempDay =="0" && (intType & 1)) {
			aday.focus();
		} else if (tempMonth =="0" && (intType & 2)) {
			amonth.focus();
		} else {
			ayear.focus();
		}
	}
	return validated;
}

	
function ValidateNumber(ctl, min_val, max_val, msg, compulsory) {
    var temp_num = Trim(ctl.value);
    if (compulsory == "0" && temp_num.length == 0) {
          ctl.value = temp_num;
          validated = true;
          return true;
    }
    else {
      if (isReal(temp_num) && temp_num.length > 0) {
         if ((temp_num < min_val) || (temp_num > max_val)) {
  		    alert(msg + " within the range of " + min_val + " to " + max_val + ".");
            ctl.focus();
	        validated = false;
	        return false;
         }
         else {
		    ctl.value = temp_num;
	        validated = true;
            return true;
         }
       }
       else {
	  	    alert(msg + ". Your entry was invalid.");
	        ctl.focus();
	        validated = false;
	        return false;
       }
     }
}

function ValidateIC(vl,type,country) 
{
	validated=true;

	// Regular expression for typo errors
	var validMYIC = /^\d{6}-\d{2}-\d{4}$/;
	var validSGIC = /^[a-zA-Z]{1}\d{7}[a-zA-Z]{1}$/;

	// Error messages
	var MYErrorMsg = "Please fill in your New IC No. in a valid format,\ne.g. 810231-07-4123."
	var SGErrorMsg = "Please fill in your IC No. in a valid format,\ne.g. S1234567D."

	if (type.value=='1')
	{
		if (country.value=='MY')
		{
			if (vl.value=='000000-00-0000')
			{
				alert(MYErrorMsg);
				return false;
			}
			else if (!validMYIC.test(Trim(vl.value)) )
			{
				alert(MYErrorMsg);
				return false;
			}
		}
		else if (country.value=='SG')
		{
			if (!validSGIC.test(Trim(vl.value)) )
			{
				alert(SGErrorMsg);
				return false;
			}
		}
	}
}

function ValidateLanguage(frm, msg, compulsory) {
	var lang1 = GetValueFromCtl(frm.language_id1);
	var lang2 = GetValueFromCtl(frm.language_id2);
	var written1 = GetValueFromCtl(frm.written1);
	var written2 = GetValueFromCtl(frm.written2);
	var spoken1 = GetValueFromCtl(frm.spoken1);
	var spoken2 = GetValueFromCtl(frm.spoken2);

	if (compulsory == 1 && lang1 == "" && lang2 == "") {
		alert("Please enter at least one language");
		frm.language_id1.focus();
		validated = false;
	}
	if (validated && (lang1 != "" && (lang1 == lang2))) {
		alert("You have entered one or more duplicate languages. Please enter another language");
		frm.language_id2.focus();
	    validated = false;
	}
	if (validated && lang1 != "") {
		if (spoken1 == "" && written1 == "") {
			alert(msg);
			frm.spoken1.focus();
	        validated = false;
		} 
	} 
	if (validated && lang2 != "") {
		if (spoken2 == "" && written2 == "") {
			alert(msg);
			frm.spoken2.focus();
	        validated = false;
		} 
	}
	return validated;
}

function isInt(string) {
    for (var i=0;i < string.length;i++)
        if ((string.substring(i,i+1) < '0') || (string.substring(i,i+1) > '9') )
            return false;
	return true;
}

function isReal(string) {
    var decimal_found = false;
    var ws;

    for (var i=0;i < string.length;i++)
      if ((string.substring(i,i+1) < '0' || string.substring(i,i+1) > '9') && string.substring(i,i+1) != '.') {
            return false;
      }
      else {
        if (string.substring(i,i+1) == '.') {
          if (decimal_found == true) {
            return false;
          }
          else {
            decimal_found = true;
          }
        }   
      }
    return true;      
}

/// EXPERIENCE SECTION ///
function ExperienceChecked(frm) {
	var val = GetValueFromRdo(frm.freshgrad)
	if (val == "1" || val == "2") {
		frm.years_worked.value = "";
		//frm.qualification_id1.focus();
		//this.document.location.assign('#skip');
	} else {
		frm.years_worked.focus();
	}
}


function ValidateExperienceCtl(frm,ctl,msg) {

	if (typeof(frm.freshgrad) == 'undefined'  && GetValueFromCtl(ctl) == "") {
		alert(msg);
		ctl.focus();
		validated = false;
		return false;
	} else {
		if (frm.freshgrad[1].checked == true && GetValueFromCtl(ctl) == "") {
			alert(msg);
			ctl.focus();
			validated = false;
			return false;
		} else {
			validated = true;
			return true;
		}
	}
}

function ValidateExperienceCtl1(ctl,msg) {

	if (GetValueFromCtl(ctl) == "") {
		alert(msg);
		ctl.focus();
		validated = false;
		return false;
	} else {
		validated = true;
		return true;
	}
}

function ValidateExperienceNumber(frm,ctl,min_val,max_val,msg) {
	if (ctl.value != '') {
		var ctrl = GetRdoFromValue(frm.freshgrad, "0");
		if (frm.freshgrad[ctrl]) frm.freshgrad[ctrl].checked = true;
	}
	var value = GetValueFromRdo(frm.freshgrad);
	if (value == ""){
		alert("Please select your Experience Level");
		if (frm.freshgrad[0]) frm.freshgrad[0].focus();
		validated = false;
		return false;
	} else {

		if (typeof(frm.freshgrad) == 'undefined') {
			ValidateNumber(ctl,min_val,max_val,msg,'1');
		} else {
			if (value == "0") {
				ValidateNumber(ctl,min_val,max_val,msg,'1');
			}
		}
	}
}

function ValidateExperienceText(frm,ctl,msg) {
	var res = /^\s+/ig;
	var ree = /\s+$/ig;
	var temp_str = ctl.value.replace(res,"").replace(ree,"");

	if (typeof(frm.freshgrad) == 'undefined' && temp_str == "") {
		alert(msg);
		ctl.focus();
		validated = false;
		return false;
	} else {
		if (frm.freshgrad[1].checked == true && temp_str == "") {
			alert(msg);
			ctl.focus();
			validated = false;
			return false;
		} else {
			ctl.value = temp_str;
			validated = true;
			return true;
		}
	}
}

function ValidateExperienceText1(ctl,msg) {
	var res = /^\s+/ig;
	var ree = /\s+$/ig;
	var temp_str = ctl.value.replace(res,"").replace(ree,"");

	if (temp_str == "") {
		alert(msg);
		ctl.focus();
		validated = false;
		return false;
	} else {
		ctl.value = temp_str;
		validated = true;
		return true;
	}
}

function ValidateExperienceDate(frm,aday,amonth,ayear,maxyear,intType,msg) {

	if (frm.freshgrad[0].checked == false && frm.freshgrad[1].checked == false){
		alert("Please select whether you are a fresh graduate or you have working experience");
		validated = false;
		return false;
	} else {

		if (typeof(frm.freshgrad) == 'undefined') {
			ValidateDate(aday,amonth,ayear,maxyear,intType,msg,1);
		} else {
			if (frm.freshgrad[1].checked == true) {
				ValidateDate(aday,amonth,ayear,maxyear,intType,msg,1);
			}
		}
	}
}

function ValidateExperienceTextLimit(frm,ctl,min_len,max_len,msg) {
	if (frm.freshgrad[0].checked == false) {
		ValidateTextLimit(ctl,min_len,max_len,msg);
	}
}

function ValidateTextLimit(ctl,min_val,max_val,msg) {
	var strTemp = Trim(ctl.value);
	if (strTemp.length < min_val || strTemp.length > max_val) {
	  alert(msg);
	  ctl.focus();
	  return false;
	}
	else {
	  ctl.value = strTemp;
	  return true;
	}
}

/// EDUCATION SECTION ///
function ValidateConsistencySC(currency, salary) {
	var res = /^\s+/ig;
	var ree = /\s+$/ig;

	if (ValidateNumber(salary, '0', '999999999', 'Please enter numeric value without comma or other characters for Salary',0)) {
		if ((GetValueFromCtl(currency) == "" || GetValueFromCtl(currency) == 0 || GetValueFromCtl(currency) == "0") && salary.value.replace(res,"").replace(ree,"") != ""){
			alert("Please fill in your Salary Currency");
			currency.focus();
	    		return false;
		}		
		return true;
	} else {
		return false;
	}
}
/// EXPERIENCE SECTION ///

/// Job Specialization Section ///
function addOption(frm,frObj,toObj) {

	var optionRank = toObj.options.length
	var str='';
	str = frm.specialization.value;
	if (toObj.options.length == 0) { str = ""; }
	var optionObject = new Option('','')
	for (var i=0;i<frObj.options.length;i++){
	   if (frObj.options[i].selected){
			if (str.indexOf(frObj.options[i].value)== -1){
			optionObject = new Option( frObj.options[i].text, frObj.options[i].value)			
			toObj.options[optionRank] = optionObject;           
			str=(str!='') ? str + ', '+ frObj.options[i].value : frObj.options[i].value;	   	
			optionRank = optionRank + 1;
	    }
	   }		
	}
    frm.specialization.value = str;
}

function deleteOption(frm,toObj) {

	var optionObject = new Option('','')	
	var j=0;	
	var str='';
	var sel='';
	
	for (var i=0;i<toObj.options.length;i++){	   
	   if (toObj.options[i].selected){
			toObj.options[i]=null;
			i = i - 1;
	   }
	   else{
			str=(str!='') ? str + ', '+ toObj.options[i].value : toObj.options[i].value;	   				
	   }
	}
	
    frm.specialization.value = str;
}

function ValidateJPList(ctl,msg) {

	if (ctl.length == 0) {
	  	alert(msg);
	  	ctl.focus();
	  	validated = false;
	  	return false;
	} else {		
		validated = true;
		return true;
	}
}

/// Job Specialization Section ///

/// Text Resume Section ///
function ValidateTextResume(ctl, min_val, max_val, msg) {
	if (!ValidateTextLimit(ctl, min_val, max_val, msg)) {
		validated = false;
		return false;
	}
	else {
		validated = true;
		return true;
	}
}

function CountText(ctl, indicator) {
	indicator.value = ctl.value.length;
}
/// Text Resume Section ///

/// Searchable Resume Section ///
function ValidateSR(ctl) {
	var sel = GetValueFromRdo(ctl);
	if (sel == "") {
		ctl[0].focus();
		alert("To allow employers to find you, please open your resume for search.");
		validated = false;
		return false;
	} else if (sel == "0") {
		var cf = confirm("Employers will not be able to find you through Resume Search.  Are you sure?");
		ctl[0].focus();
		validated = cf;
		return cf;
	} else {
		validated = true;
		return true;
	}
}
/// Searchable Resume Section ///

/// Availability Section ///
function ValidateAvailability(aday, amonth, ayear, compulsory) {
	var tempDay	= GetValueFromCtl(aday);
	var tempMonth = GetValueFromCtl(amonth);
	var tempYear = ayear.value;
	var tempDate = tempDay + tempMonth + tempYear;
	var today = new Date();

	if (compulsory == 0 && tempDate == '')
		validated = true;
	else if (tempYear == '') {
		alert("Invalid or blank available date");
		validated = false;
	}
	else 
	{
		var test = new Date(tempYear,tempMonth-1,tempDay);
    		if ((test.getFullYear() == tempYear) && (tempMonth - 1 == test.getMonth()) && (tempDay == test.getDate())) {
        		if (test >= today)
        			validated = true;
        		else {
        			alert("Available date must be later than today");
        			validated = false;
        		}
    		} else {
    			alert("Invalid or blank available date");
				validated = false;
			}
	}    

	if (validated == false) {
		if (tempDay == "0") {
			aday.focus();
		} else if (tempMonth == "0") {
			amonth.focus();
		} else {
			ayear.focus();
		}
	}
	return validated;
}

/// Availability Section ///

// This scans all the onchanged routines
function onFrmSubmit(frm) {
	// force validation of all fields			  		
	var i;
	validated = true;	
	var NS4 = (document.layers) ? true : false;	
	
	for (i=0;i<frm.elements.length && validated;i++) {
		if (frm.elements[i].onchange!=null) {
			if (!NS4) {
				if (frm.elements[i].style.visibility != 'hidden') {
					frm.elements[i].onchange();  // force fire onchange event
				}
			}
		}
	}
	
	if (validated==true) {	  
	  frm.submit();
	}
}

function validateOption(ctl,msg) {
	var v = false;
	for (var i=0; i<ctl.length; i++) {            
		if (ctl[i].checked) {
			v = true;
		        break;
		}
	}
	if ((!v) && (msg!="")) {alert(msg);}
	return v;
}
		
function warnOnlinePayment(pm) {
	var v = true;
	v = validateOption(pm,"Please select your payment method.");
	if ((v) && (pm[0].checked)) 
		return confirm("IMPORTANT: \n\nIn order to provide the best security for your online purchase, details of this payment transaction is logged by JobStreet.com, including your IP address, and the date and time of this transaction. \n\nYou are required to use your own credit card to make the purchase. Fraudulent usage of credit cards is an offence and JobStreet.com is obliged to work with the authorities if fraudulent usage is suspected. \n\nSubscribers are fully advised to make their own informed decision before they subscribe to any of these services. Refunds will be given at the sole discretion of JobStreet.com if a subscribed member decides later to unsubscribe from these services. \n\nClick OK to proceed to make your payment.")
	else
		return v;
}		

// -->
