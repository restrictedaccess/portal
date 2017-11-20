
.0// JavaScript Document
var PATH = 'register/';
var FORM_CTR = 1;

function changeStateSelectOptions(country){
	alert('country:'+country);
	if(country=='PH'){
		var PH = [['Select a State',''],['Armm','AR'],['Bicol Region','BR'],['C.A.R','CA'],['Cagayan Valley','CG'],['Central Luzon','CL'],['Central Mindanao','CM'],['Caraga','CR'],['Central Visayas','CV'],['Eastern Visayas','EV'],['Ilocos Region','IL'],['National Capital Reg','NC'],['Northern Mindanao','NM'],['Southern Mindanao','SM'],['Southern Tagalog','ST'],['Western Mindanao','WM'],['Western Visayas','WV']];
		
		var state_options="<select name='state' id='state'>";
		for(i=0;i<PH.length;i++){
			state_options += "<option value='"+PH[i][1]+"'>"+ PH[i][0] +"</option>"
		
		}
		state_options += "</select>"
		alert('result:'+state_options);
		document.getElementById('state_field').innerHTML = state_options;
	}
	
	
}

function serialize (mixed_value) {

    var _utf8Size = function (str) {
        var size = 0,
            i = 0,
            l = str.length,
            code = '';
        for (i = 0; i < l; i++) {
            code = str.charCodeAt(i);
            if (code < 0x0080) {
                size += 1;
            } else if (code < 0x0800) {
                size += 2;
            } else {
                size += 3;
            }
        }
        return size;
    };
    var _getType = function (inp) {
        var type = typeof inp,
            match;
        var key;
 
        if (type === 'object' && !inp) {
            return 'null';
        }
        if (type === "object") {
            if (!inp.constructor) {
                return 'object';
            }
            var cons = inp.constructor.toString();
            match = cons.match(/(\w+)\(/);
            if (match) {
                cons = match[1].toLowerCase();
            }
            var types = ["boolean", "number", "string", "array"];
            for (key in types) {
                if (cons == types[key]) {
                    type = types[key];
                    break;
                }
            }
        }
        return type;
    };
    var type = _getType(mixed_value);
    var val, ktype = '';
 
    switch (type) {
    case "function":
        val = "";
        break;
    case "boolean":
        val = "b:" + (mixed_value ? "1" : "0");
        break;
    case "number":
        val = (Math.round(mixed_value) == mixed_value ? "i" : "d") + ":" + mixed_value;
        break;
    case "string":
        val = "s:" + _utf8Size(mixed_value) + ":\"" + mixed_value + "\"";
        break;
    case "array":
    case "object":
        val = "a";
/*
            if (type == "object") {
                var objname = mixed_value.constructor.toString().match(/(\w+)\(\)/);
                if (objname == undefined) {
                    return;
                }
                objname[1] = this.serialize(objname[1]);
                val = "O" + objname[1].substring(1, objname[1].length - 1);
            }
            */
        var count = 0;
        var vals = "";
        var okey;
        var key;
        for (key in mixed_value) {
            if (mixed_value.hasOwnProperty(key)) {
                ktype = _getType(mixed_value[key]);
                if (ktype === "function") {
                    continue;
                }
 
                okey = (key.match(/^[0-9]+$/) ? parseInt(key, 10) : key);
                vals += this.serialize(okey) + this.serialize(mixed_value[key]);
                count++;
            }
        }
        val += ":" + count + ":{" + vals + "}";
        break;
    case "undefined":
        // Fall-through
    default:
        // if the JS object has a property which contains a null value, the string cannot be unserialized by PHP
        val = "N";
        break;
    }
    if (type !== "object" && type !== "array") {
        val += ";";
    }
    return val;
}

function expandWorkHistory(){
    var id;
    if(window.XMLHttpRequest)xmlhttp=new XMLHttpRequest();
    else xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");    
    xmlhttp.onreadystatechange=function(){
        if(xmlhttp.readyState==4&&xmlhttp.status==200) document.getElementById('resultarea').innerHTML = xmlhttp.responseText;		 
    }
	var query=new Array();
	arr = document.getElementsByName('history_company_name[]');		
    for(var i = 0; i < arr.length; i++){ 
		query[i]=new Array();
        query[i]['company'] = document.getElementsByName('history_company_name[]').item(i).value;
        query[i]['position'] = document.getElementsByName('history_position[]').item(i).value;
        query[i]['monthfrom'] = document.getElementsByName('history_monthfrom[]').item(i).value;
        query[i]['yearfrom'] = document.getElementsByName('history_yearfrom[]').item(i).value;
		query[i]['monthto'] = document.getElementsByName('history_monthto[]').item(i).value;
        query[i]['yearto'] = document.getElementsByName('history_yearto[]').item(i).value;
        query[i]['responsibilities'] = document.getElementsByName('history_responsibilities[]').item(i).value;
    }
	result = serialize(query);	
    xmlhttp.open("GET","register/expand-form4.php?query="+result); 
	xmlhttp.send(); 
}

function expandSkills(){
    var id;
    if(window.XMLHttpRequest)xmlhttp=new XMLHttpRequest();
    else xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");    
    xmlhttp.onreadystatechange=function(){
        if(xmlhttp.readyState==4&&xmlhttp.status==200) document.getElementById('resultarea').innerHTML = xmlhttp.responseText;		 
    }
	var query=new Array();
	arr = document.getElementsByName('skill[]');		
    for(var i = 0; i < arr.length; i++){ 
		query[i]=new Array();
        query[i]['skill'] = document.getElementsByName('skill[]').item(i).value;
        query[i]['skill_exp'] = document.getElementsByName('skill_exp[]').item(i).value;
        query[i]['skill_proficiency'] = document.getElementsByName('skill_proficiency[]').item(i).value;
    }
	result = serialize(query);	
    xmlhttp.open("GET","register/expand-form5.php?query="+result); 
	xmlhttp.send(); 
}

function expandLanguages(){
    var id;
    if(window.XMLHttpRequest)xmlhttp=new XMLHttpRequest();
    else xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");    
    xmlhttp.onreadystatechange=function(){
        if(xmlhttp.readyState==4&&xmlhttp.status==200) document.getElementById('resultarea').innerHTML = xmlhttp.responseText;		 
    }
	var query=new Array();
	arr = document.getElementsByName('language[]');		
    for(var i = 0; i < arr.length; i++){ 
		query[i]=new Array();
        query[i]['language'] = document.getElementsByName('language[]').item(i).value;
        query[i]['spoken'] = document.getElementsByName('spoken[]').item(i).value;
        query[i]['written'] = document.getElementsByName('written[]').item(i).value;
    }
	result = serialize(query);	
    xmlhttp.open("GET","register/expand-form6.php?query="+result); 
	xmlhttp.send(); 
}


function showpopup(id){
	document.getElementById(id).style.display="block";
	document.getElementById('main').style.display="block";
}

function hidepopup(id){
	document.getElementById(id).style.display="none";		
	document.getElementById('main').style.display="none";
} 

function RegisterApplicant(){
	//alert("Hello World");
	
	var staff_fname = $('staff_fname').value;
	var staff_lname = $('staff_lname').value;
	var staff_email = $('staff_email').value;
	
	var bmonth = $('bmonth').value;
	var bday = $('bday').value;
	var byear = $('byear').value;
	
	var identification = $('identification').value;
	var identification_number = $('identification_number').value;
	var gender = getRadioButtonValue('gender');
	
	var nationality = $('nationality').value;
	var permanent_residence = $('permanent_residence').value;
	
	emailReg = "^[\\w-_\.]*[\\w-_\.]\@[\\w]\.+[\\w]+[a-zA-Z]$"
	var regex = new RegExp(emailReg);
	
	var rv = $("rv").value;
	var pass2 = $("pass2").value;
	//alert(gender);

	if(staff_fname == ""){
		alert("Please enter your first name");
		return false;
	}
	
	if(staff_lname == ""){
		alert("Please enter your last name");
		return false;
	}
	
	if(staff_email == ""){
		alert("Please enter your email address");
		return false;
	}
	
	if(regex.test(staff_email) == false){
		alert('Please enter a valid email address and try again!');
		return false;
	}	
	
	
	if(gender == ""){
		alert("Please choose your gender");
		return false;
	}
	
	if(pass2==""){
		alert("Please type the code that you see in the image");
		return false;
	}
	
	$('application_result').innerHTML= "";
	$("reg_btn").innerHTML = "<img src='images/ajax-loader.gif'> Processing...";
	
	var query = queryString({'staff_fname' : staff_fname , 'staff_lname' : staff_lname , 'staff_email' : staff_email , 'bmonth' : bmonth , 'bday' : bday , 'byear' : byear , 'identification' : identification , 'identification_number' : identification_number , 'gender' : gender , 'nationality' : nationality , 'permanent_residence' : permanent_residence , 'rv' : rv, 'pass2' : pass2 });
	
	//alert(query);
	var result = doXHR(PATH + 'RegisterApplicant.php', {method:'POST', sendContent: query, headers: {"Content-Type":"application/x-www-form-urlencoded"}});
	result.addCallbacks(OnSuccessRegisterApplicant, OnFailRegisterApplicant);
	
}
function OnSuccessRegisterApplicant(e){
	if((e.responseText) == '0'){
		alert("Code is not correct!");
		$('application_result').innerHTML= "Code is not correct!";
		$("reg_btn").innerHTML ='<img src="images/btn-clicknext.png" onclick="RegisterApplicant()" style="cursor:pointer;" />';
	}else if((e.responseText) == '01'){
		alert("Invalid Email Address");
		$('application_result').innerHTML= "Invalid Email Address!";
		$("reg_btn").innerHTML ='<img src="images/btn-clicknext.png" onclick="RegisterApplicant()" style="cursor:pointer;" />';
	//hardcoded. remove comment
	//}else if((e.responseText) == '02'){
		//alert("Email Exist . Please try to enter different email address!");
		//$('application_result').innerHTML= "Email Exist . Please try to enter a different email address!";
		//$("reg_btn").innerHTML ='<img src="images/btn-clicknext.png" onclick="RegisterApplicant()" style="cursor:pointer;" />';
	}else{
	
		var staff_fname = $('staff_fname').value;
		var staff_lname = $('staff_lname').value;
		var staff_email = $('staff_email').value;
	
		var url="thankyou.php";
			url=url+"?email="+staff_email;
			url=url+"&fname="+staff_fname;
			url=url+"&lname="+staff_lname;
		location.href= url;	
		//alert("Thank You");
		//$('application_result').innerHTML=e.responseText;
		//$("reg_btn").innerHTML ='<img src="images/btn-clicknext.png" onclick="RegisterApplicant()" style="cursor:pointer;" />';
	}
	
}
function OnFailRegisterApplicant(e){
	alert("Failed to process applicants registration");
}

function getRadioButtonValue(name){
	var radio_bttn = document.getElementsByName(name);
	var radio_bttn_value;
	var i;
	for(i=0;i<radio_bttn.length;i++)
	{
		if(radio_bttn[i].checked==true) {
			radio_bttn_value = radio_bttn[i].value;
			return radio_bttn_value;
			break;
		}
	}
	return;
}

function getCheckBoxValue(name){
	var check_box = document.getElementsByName(name);
	var check_box_value = "";
	var i;
	for(i=0;i< check_box.length;i++)
	{
		if( check_box[i].checked==true) {
			check_box_value = check_box_value + "," + check_box[i].value;
		}
	}
	return check_box_value;
}

// JavaScript Document
var PATH = 'register/';


function CheckStep1Form(){
  
  var fname = $('fname').value;
  var lname = $('lname').value; 
  
  var bmonth = $('bmonth').value;
  var bday = $('bday').value;
  var byear = $('byear').value;
  
  var marital_status = $('marital_status').value;
  // 
  
  var handphone_country_code = $('handphone_country_code').value;
  var handphone_no = $('handphone_no').value;
  
  var tel_area_code = $('tel_area_code').value;
  var tel_no = $('tel_no').value;
  
  var address1 = $('address1').value;
  var postcode = $('postcode').value;
  var state = $('state').value;
  var country_id = $('country_id').value;
  var city = $('city').value;
  
  if(fname == ""){
    alert("Please enter your first name");
    return false;
  }
  
  if(lname == ""){
    alert("Please enter your first name");
    return false;
  }
  
  if(bmonth == "" || bday == "" || byear == ""){
    alert("Please enter your Date of Birth");
    return false;
  }
  
  if(marital_status == ""){
    alert("Please select your marital status");
    return false;
  }
  if($('form_id').value == ""){
    var password = $('password').value;
    if(password == ""){
      alert("Please enter your password");
      return false;
    }
  }
  
  if(handphone_no == "" && tel_no =="" ){
    alert("Please specify your contact number");
    return false;
  }
  
  if(isNaN(handphone_no) || isNaN(tel_no)){
    alert("Invalid contact number");
    return false;
  }
  
  if(address1 == ""){
    alert("Please enter your address");
    return false;
  }
  if(state == ""){
    alert("Please enter your state");
    return false;
  }
  if(city == ""){
    alert("Please enter your City");
    return false;
  }
  if(postcode == ""){
    alert("Please enter your Postal Code");
    return false;
  }
  if(country_id == ""){
    alert("Please enter your Country");
    return false;
  }
  return true;
}


function CheckStep2Form(){

	var work_from_home_before = getRadioButtonValue('work_from_home_before');
	var have_a_baby_in_the_house = getRadioButtonValue('have_a_baby_in_the_house');
	var why_do_you_want_to_work_from_home=$('why_do_you_want_to_work_from_home').value;
	var how_long_do_you_see_yourself_working_for_rs=$('how_long_do_you_see_yourself_working_for_rs').value;
	var home_working_environment=getRadioButtonValue('home_working_environment');
	var internet_connection=$('internet_connection').value;
	var internet_plan=$('internet_plan').value;
	var speed_test_result_link=$('speed_test_result_link').value;
	var desktop_computer=$('desktop_computer').checked;
	var loptop_computer=$('loptop_computer').checked;
	var noise_level = getCheckBoxValue('noise_level');
	

	if(work_from_home_before==null){
		alert("Please state whether you have worked from home before or not");
		return false;
	}
	else{
		if(work_from_home_before=="Yes"){
			var start_worked_from_home_month = $('start_worked_from_home_month').value;
			var start_worked_from_home_day = $('start_worked_from_home_day').value;
			if((start_worked_from_home_month=="")||(start_worked_from_home_day=="")){
				alert("Please enter when you started working from home");
				return false;
			}
		}
	}
	
	if(have_a_baby_in_the_house==null){
		alert("Please state whether you have a baby in the house or not");
		return false;
	}
	else{
		if(have_a_baby_in_the_house=="Yes"){
			var who_is_the_main_caregiver = $('who_is_the_main_caregiver').value;
			if(who_is_the_main_caregiver==""){
				alert("Please state who is the main care giver of your baby in your house");
				return false;
			}		
		}
	}
	
	if(why_do_you_want_to_work_from_home==""){
		alert("Please why do you want to work from home");
		return false;
	}
	
	if(how_long_do_you_see_yourself_working_for_rs==""){
		alert("Please state how long do you see yourselft working for Remotestaff");
		return false;
	}
	
	if(home_working_environment==null){
		alert("Please select your home working environment");
		return false;
	}
	
	if(internet_connection==""){
		alert("Please select your internet connection");
		return false;
	}
	
	if(internet_plan==""){
		alert("Please select your internet plan");
		return false;
	}
	
	if(speed_test_result_link==""){
		alert("Please provide your speed test result link");
		return false;
	}
 
	if((!desktop_computer)&&(!loptop_computer)){
		alert("You need to have either a desktop or a laptop");
		return false;
	}
	
	if(noise_level==""){
		alert("Please provide noise level from your work station");
		return false;
	}
}

function CheckStep3Form(){

	var highest_level=$('highest_level').value;
	var field_of_study=$('field_of_study').value;
	var gpa=$('gpa').value;
	var university=$('university').value;
	var graduate_month=$('graduate_month').value;
	var graduate_year=$('graduate_year').value;
	
	if(highest_level==""){
		alert("Please provide your highest educational attainment");
		return false;
	}
	if(field_of_study==""){
		alert("Please select your field of study");
		return false;
	}
	if(gpa==""){
		alert("Please enter your GPA");
		return false;
	}
	if(university==""){
		alert("Please provide your university");
		return false;
	}
	if(graduate_month==""){
		alert("Please provide your graduation month");
		return false;
	}
	if(graduate_year==""){
		alert("Please provide your graduation year");
		return false;
	}
}

function CheckStep4Form(){ 
	var status=getRadioButtonValue('current_status');
	var years_worked=$('years_worked').value;
	var months_worked=$('months_worked').value;
	var expected_salary=$('expected_salary').value;
	var salary_currency=$('salary_currency').value;
	var position_first_choice=$('position_first_choice').value;
	var position_first_choice_exp=$('position_first_choice_exp').value;

	if(status==null){
		alert("Please provide your current status");
		return false;
	}
	else{
		if(status=="experienced"){
			if((years_worked=="0")&&(months_worked=="0")){
				alert("Please provide your length of experience");
				return false;
			}
		}
	}
	
	if(expected_salary==""){
		alert("Please provide your expected salary");
		return false;
	}
	
	if(salary_currency==""){
		alert("Please provide your expected salary currency");
		return false;
	}
	/*if((position_first_choice=="")||(position_first_choice==null)){
		alert("Please provide your first choice job position");
		return false;
	}
	if(position_first_choice_exp==null){
		alert("Please state if you have any experience doing your first choice job position");
		return false;
	}*/
}

function CheckStep5Form(){ 

	var skill=$('skill').value;
	
	if(skill!=""){
		var skill_exp=$('skill_exp').value;
		var skill_proficiency=$('skill_proficiency').value;
		if(skill_exp==""){
			alert("Please provide your years of experience for your given skill");
			return false;		
		}
		if(skill_proficiency==""){
			alert("Please provide your proficiency for your given skill");
			return false;		
		}
	
	}
}

function CheckStep6Form(){ 

	var language=$('language').value;
	
	if(language!=""){
		var spoken=$('spoken').value;
		var written=$('written').value;
		if(spoken==""){
			alert("Please rate your ability in speaking using your given language");
			return false;		
		}
		if(written==""){
			alert("Please rate your ability in writing using your given language");
			return false;		
		}
	
	}

}

function ValidateEmail(){
  var email = $('email').value;
  var code = $('code').value
  emailReg = "^[\\w-_\.]*[\\w-_\.]\@[\\w]\.+[\\w]+[a-zA-Z]$"
  var regex = new RegExp(emailReg);
  
  if(email == ""){
    alert("Please enter your email address");
    return false;
  }
  
  if(regex.test(email) == false){
    alert('Please enter a valid email address and try again!');
    return false;
  }
  
  if(code == ""){
    alert("Please enter the code that was sent to your email");
    return false;
  }
  
  if(isNaN(code)){
    alert("Invalid code");
    return false;
  }
  
  return true;
}
function SendCode(){
  var email = $('email').value;
  
  emailReg = "^[\\w-_\.]*[\\w-_\.]\@[\\w]\.+[\\w]+[a-zA-Z]$"
  var regex = new RegExp(emailReg);
  
  if(email == ""){
    alert("Please enter your email address");
    return false;
  }
  
  if(regex.test(email) == false){
    alert('Please enter a valid email address and try again!');
    return false;
  }
  
  $("send-btn").innerHTML = "<img src='images/ajax-loader.gif'> Processing...";
  
  var query = queryString({'email' : email });
  
  var result = doXHR(PATH + 'SendCode.php', {method:'POST', sendContent: query, headers: {"Content-Type":"application/x-www-form-urlencoded"}});
  //hardcoded
  result.addCallbacks(OnSuccessSendCode, OnFailSendCode);

}

function OnSuccessSendCode(e){
  
  if((e.responseText) == '01'){
    alert("Invalid Email Address");
    $("send-btn").innerHTML ='';
  }else if((e.responseText) == '02'){
	//hardcoded. remove comments
    //alert("Email Exist . Please try to enter different email address!");
    //$("send-btn").innerHTML ='';
	//hardcoded.delete lines below
	toggle('code-form');
	$("send-btn").innerHTML ='';
  }else{
    toggle('code-form');
    $("send-btn").innerHTML = e.responseText;
  }
}

function OnFailSendCode(e){
  alert("Failed to send the code to your email");
}

function RegisterApplicant(){
  //alert("Hello World");
  
  var staff_fname = $('staff_fname').value;
  var staff_lname = $('staff_lname').value;
  var staff_email = $('staff_email').value;
  /*
  var bmonth = $('bmonth').value;
  var bday = $('bday').value;
  var byear = $('byear').value;
  
  var identification = $('identification').value;
  var identification_number = $('identification_number').value;
  var gender = getGender();
  
  var nationality = $('nationality').value;
  var permanent_residence = $('permanent_residence').value;
  */
  emailReg = "^[\\w-_\.]*[\\w-_\.]\@[\\w]\.+[\\w]+[a-zA-Z]$"
  var regex = new RegExp(emailReg);
  
  var rv = $("rv").value;
  var pass2 = $("pass2").value;
  //alert(gender);
  if(staff_fname == ""){
    alert("Please enter your first name");
    return false;
  }
  
  if(staff_lname == ""){
    alert("Please enter your last name");
    return false;
  }
  
  if(staff_email == ""){
    alert("Please enter your email address");
    return false;
  }
  
  if(regex.test(staff_email) == false){
    alert('Please enter a valid email address and try again!');
    return false;
  }  
  
  /*
  if(gender == ""){
    alert("Please choose your gender");
    return false;
  }
  */
  if(pass2==""){
    alert("Please type the code that you see in the image");
    return false;
  }
  
  $('application_result').innerHTML= "";
  $("reg_btn").innerHTML = "<img src='images/ajax-loader.gif'> Processing...";
  
  /*var query = queryString({'staff_fname' : staff_fname , 'staff_lname' : staff_lname , 'staff_email' : staff_email , 'bmonth' : bmonth , 'bday' : bday , 'byear' : byear , 'identification' : identification , 'identification_number' : identification_number , 'gender' : gender , 'nationality' : nationality , 'permanent_residence' : permanent_residence , 'rv' : rv, 'pass2' : pass2 });*/
  
  var query = queryString({'staff_fname' : staff_fname , 'staff_lname' : staff_lname , 'staff_email' : staff_email , 'rv' : rv, 'pass2' : pass2 });
  
  
  //alert(query);
  var result = doXHR(PATH + 'RegisterApplicant.php', {method:'POST', sendContent: query, headers: {"Content-Type":"application/x-www-form-urlencoded"}});
  result.addCallbacks(OnSuccessRegisterApplicant, OnFailRegisterApplicant);
  
  
    function OnSuccessRegisterApplicant(e){
      if((e.responseText) == '0'){
        alert("Code is not correct!");
        $('application_result').innerHTML= "Code is not correct!";
        $("reg_btn").innerHTML ='<img src="images/btn-clicknext.png" onclick="RegisterApplicant()" style="cursor:pointer;" />';
      }else if((e.responseText) == '01'){
        alert("Invalid Email Address");
        $('application_result').innerHTML= "Invalid Email Address!";
        $("reg_btn").innerHTML ='<img src="images/btn-clicknext.png" onclick="RegisterApplicant()" style="cursor:pointer;" />';
		//hardcoded. remove comments
      //}else if((e.responseText) == '02'){
        //alert("Email Exist . Please try to enter different email address!");
        //$('application_result').innerHTML= "Email Exist . Please try to enter a different email address!";
        //$("reg_btn").innerHTML ='<img src="images/btn-clicknext.png" onclick="RegisterApplicant()" style="cursor:pointer;" />';
      }else{
        
        $('application_result').innerHTML=e.responseText;
        alert(e.responseText);
        var url="registernow-step1-personal-details.php";
        url=url+"?email="+staff_email;
        url=url+"&fname="+staff_fname;
        url=url+"&lname="+staff_lname;
        /*url=url+"&bmonth="+bmonth;
        url=url+"&bday="+bday;
        url=url+"&byear="+byear;
        url=url+"&identification="+identification;
        url=url+"&identification_number="+identification_number;
        url=url+"&gender="+gender;
        url=url+"&nationality="+nationality;
        url=url+"&permanent_residence="+permanent_residence;*/
      
      
        location.href= url;
        
        //$('application_result').innerHTML=e.responseText;
        //$("reg_btn").innerHTML ='<img src="images/btn-clicknext.png" onclick="RegisterApplicant()" style="cursor:pointer;" />';
      }
      
    }
    function OnFailRegisterApplicant(e){
      alert("Failed to process applicants registration");
    }
  
  
}

