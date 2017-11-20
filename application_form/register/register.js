
.0// JavaScript Document
var PATH = 'register/';
var FORM_CTR = 1;

function displayOthers(){

	external_source = $('external_source').value;
	
	if(external_source == 'Others'){
		$('others_container').style.display = "block";
		$('external_source_others').value= "";
	}
	else{
		$('others_container').style.display = "none";
	}
}
	

function changeStateSelectOptions(country){
	
	var state_options = '<input name="state" type="text" id="state" value="" size="15" />';
	
	if(
		(country == 'PH') ||
		(country == 'AU') ||
		(country == 'BD') ||
		(country == 'ID') ||
		(country == 'IN') ||
		(country == 'TH') ||
		(country == 'MY') ||
		(country == 'VN') 
	){
	
		var country_state = [];
		
		country_state['PH'] = [['Select a State',''],['Armm','AR'],['Bicol Region','BR'],['C.A.R','CA'],['Cagayan Valley','CG'],['Central Luzon','CL'],['Central Mindanao','CM'],['Caraga','CR'],['Central Visayas','CV'],['Eastern Visayas','EV'],['Ilocos Region','IL'],['National Capital Reg','NC'],['Northern Mindanao','NM'],['Southern Mindanao','SM'],['Southern Tagalog','ST'],['Western Mindanao','WM'],['Western Visayas','WV']];	

		country_state['AU'] = [['Select a State',''],['A.C.T.','AT'],['Northern Territory','NO'],['New South Wales','NW'],['Queensland','QL'],['South Australia','SA'],['Tasmania','TS'],['Victoria','VI'],['Western Australia','WA']];
		
		country_state['BD'] = [['Select a Division',''],['Barisal','BS'],['Chittagong','CI'],['Dhaka','DK'],['Khulna','KN'],['Rajshahi','RH'],['Sylhet','YH']];
		
		country_state['ID'] = [['Select a State',''],['Aceh','AC'],['Bali','BA'],['Bangka Belitung','BB'],['Banten','BN'],['Bengkulu','BE'],['Gorontalo','GR'],['Jakarta Raya','JA'],['Jambi','JB'],['Jawa Barat','JR'],['Jawa Tengah','JT'],['Jawa Timur','JW'],['Kalimantan Barat','KB'],['Kalimantan Selatan','KS'],['Kalimantan Tengah','KU'],['Kalimantan Timur','KV'],['Lampung','LP'],['Maluku','ML'],['Maluku Utara','MJ'],['Nusa Tenggara Barat','NB'],['Nusa Tenggara Timur','NT'],['Papua','IJ'],['Riau','RI'],['Sulawesi Selatan','SE'],['Sulawesi Tengah','SF'],['Sulawesi Tenggara','SH'],['Sulawesi Utara','SJ'],['Sumatera Barat','SK'],['Sumatera Selatan','SN'],['Sumatera Utara','SP'],['Yogyakarta','YG']];
		
		country_state['IN'] = [['Select a State',''],['Andaman & Nicobar','AN:40100:'],['Andhra Pradesh - Hyderabad','AP:40210:Hyderabad:'],['Andhra Pradesh - Secunderabad','AP:40210:Secunderabad:'],['Andhra Pradesh - Vishakapatnam','AP:40220:Vishakapatnam:'],['Andhra Pradesh - Vijaywada','AP:40230:Vijaywada:'],['Andhra Pradesh - Other cities','AP:40299:'],['Assam - Gauhati','AS:40310:Gauhati:'],['Assam - Other cities','AS:40399:'],['Arunachal Pradesh','AU:40400:'],['Bihar - Patna','BI:40510:Patna:'],['Bihar - Other cities','BI:40599:'],['Chandigarh','CH:40600:'],['Chhattisgarh','CT:43400:'],['Daman & Diu','DD:40700:'],['Delhi - Delhi','DE:40800:Delhi:'],['Delhi - Faridabad','DE:40800:Faridabad:'],['Delhi - Ghaziabad','DE:40800:Ghaziabad'],['Delhi - Gurgoan','DE:40800:Gurgoan:'],['Delhi - Noida','DE:40800:Noida:'],['Dadra & Nagar Haveli','DN:40900:'],['Goa','GO:41000:'],['Gujarat - Ahmedabad','GU:41110:Ahmedabad:'],['Gujarat - Vadodara','GU:41120:Vadodara:'],['Gujarat - Other cities','GU:41199:'],['Haryana - Panipat','HA:41210:Panipat:'],['Haryana - Other cities','HA:41299:'],['Himachal Pradesh','HP:41300:'],['Jammu & Kashmir','JK:41400:'],['Jharkhand - Jamshedpur','JN:43510:Jamshedpur:'],['Jharkhand - Ranchi','JN:43520:Ranchi:'],['Jharkhand - Other cities','JN:43599:'],['Karnataka - Bangalore','KA:41510:Bangalore:'],['Karnataka - Mysore','KA:41520:Mysore:'],['Karnataka - Mangalore','KA:41530:Mangalore:'],['Karnataka - Other cities','KA:41599:'],['Kerala - Cochin','KE:41610:Cochin:'],['Kerala - Trivandrum','KE:41620:Trivandrum:'],['Kerala - Other cities','KE:41699:'],['Lakshadweep','LA:41700:'],['Maharashtra - Aurangabad','MA:41810:Aurangabad:'],['Maharashtra - Mumbai','MA:41820:Mumbai:'],['Maharashtra - Nagpur','MA:41830:Nagpur:'],['Maharashtra - Nashik','MA:41840:Nashik:'],['Maharashtra - Pune','MA:41850:Pune:'],['Maharashtra - Other cities','MA:41899:'],['Meghalaya','ME:41900:'],['Mizoram','MI:42000:'],['Manipur','MN:42100:'],['Madhya Pradesh - Bhopal','MP:42210:Bhopal:'],['Madhya Pradesh - Indore','MP:42220:Indore:'],['Madhya Pradesh - Other cities','MP:42299:'],['Nagaland','NA:42300:'],['Orissa - Bhubaneshwar','OR:42410:Bhubaneshwar:'],['Orissa - Other cities','OR:42499:'],['Pondicherry','PO:42500:'],['Punjab - Jalandhar','PU:42610:Jalandhar:'],['Punjab - Ludhiana','PU:42620:Ludhiana:'],['Punjab - Other cities','PU:42699:'],['Rajasthan - Jaipur','RA:42710:Jaipur:'],['Rajasthan - Kota','RA:42720:Kota:'],['Rajasthan - Other cities','RA:42799:'],['Sikkim','SI:42800:'],['Tamil Nadu - Chennai','TN:42910:Chennai:'],['Tamil Nadu - Coimbatore','TN:42920:Coimbatore:'],['Tamil Nadu - Madurai','TN:42930:Madurai:'],['Tamil Nadu - Trichy','TN:42940:Trichy:'],['Tamil Nadu - Salem','TN:42950:Salem:'],['Tamil Nadu - Hosur','TN:42960:Hosur:'],['Tamil Nadu - Other cities','TN:42999:'],['Tripura','TR:43000:'],['Uttaranchal','UT:43600:'],['Uttar Pradesh - Lucknow','UP:43110:Lucknow:'],['Uttar Pradesh - Kanpur','UP:43120:Kanpur:'],['Uttar Pradesh - Other cities','UP:43199:'],['West Bengal - Kolkata','WB:43210:Kolkata:'],['West Bengal - Other cities','WB:43299:']];
		
		country_state['TH'] = [['Select a State',''],['North','TA'],['North Eastern','TB'],['Central','TC'],['Eastern','TD'],['South','TE']];
		
		country_state['MY'] = [['Select a State',''],['Johor','JH'],['Kedah','KH'],['Kuala Lumpur','KL'],['Kelantan','KT'],['Melaka','MK'],['Negeri Sembilan','NS'],['Penang','PG'],['Perak','PK'],['Perlis','PS'],['Sabah','SB'],['Selangor','SL'],['Sarawak','SW'],['Terengganu','TG'],['Labuan','LB']];
		
		country_state['VN'] = [['Select a City',''],['An Giang','VN:110101:An Giang:'],['Ba Ria-Vung Tau','VN:110102:Ba Ria-Vung Tau:'],['Bac Can','VN:110103:Bac Can:'],['Bac Giang','VN:110104:Bac Giang:'],['Bac Lieu','VN:110105:Bac Lieu:'],['Bac Ninh','VN:110106:Bac Ninh:'],['Ben Tre','VN:110107:Ben Tre:'],['Binh Dinh','VN:110108:Binh Dinh:'],['Binh Duong','VN:110109:Binh Duong:'],['Binh Phuoc','VN:110110:Binh Phuoc:'],['Binh Thuan','VN:110111:Binh Thuan:'],['Ca Mau','VN:110112:Ca Mau:'],['Can Tho','VN:110113:Can Tho:'],['Cao Bang','VN:110114:Cao Bang:'],['Da Nang','VN:110115:Da Nang:'],['Dac Lac','VN:110116:Dac Lac:'],['Dong Nai','VN:110117:Dong Nai:'],['Dong Thap','VN:110118:Dong Thap:'],['Gia Lai','VN:110119:Gia Lai:'],['Ha Giang','VN:110120:Ha Giang:'],['Ha Nam','VN:110121:Ha Nam:'],['Ha Noi','VN:110122:Ha Noi:'],['Ha Tay','VN:110123:Ha Tay:'],['Ha Tinh','VN:110124:Ha Tinh:'],['Hai Duong','VN:110125:Hai Duong:'],['Haiphong','VN:110126:Haiphong:'],['Ho Chi Minh','VN:110127:Ho Chi Minh:'],['Hoa Binh','VN:110128:Hoa Binh:'],['Hung Yen','VN:110129:Hung Yen:'],['Khanh Hoa','VN:110130:Khanh Hoa:'],['Kien Giang','VN:110131:Kien Giang:'],['Kon Tum','VN:110132:Kon Tum:'],['Lai Chau','VN:110133:Lai Chau:'],['Lam Dong','VN:110134:Lam Dong:'],['Lang Son','VN:110135:Lang Son:'],['Lao Cai','VN:110136:Lao Cai:'],['Long An','VN:110137:Long An:'],['Nam Dinh','VN:110138:Nam Dinh:'],['Nghe An','VN:110139:Nghe An:'],['Ninh Binh','VN:110140:Ninh Binh:'],['Ninh Thuan','VN:110141:Ninh Thuan:'],['Phu Tho','VN:110142:Phu Tho:'],['Phu Yen','VN:110143:Phu Yen:'],['Quang Binh','VN:110144:Quang Binh:'],['Quang Nam','VN:110145:Quang Nam:'],['Quang Ngai','VN:110146:Quang Ngai:'],['Quang Ninh','VN:110147:Quang Ninh:'],['Quang Tri','VN:110148:Quang Tri:'],['Soc Trang','VN:110149:Soc Trang:'],['Son La','VN:110150:Son La:'],['Tay Ninh','VN:110151:Tay Ninh:'],['Thai Binh','VN:110152:Thai Binh:'],['Thai Nguyen','VN:110153:Thai Nguyen:'],['Thanh Hoa','VN:110154:Thanh Hoa:'],['Thua Thien-Hue','VN:110155:Thua Thien-Hue:'],['Tien Giang','VN:110156:Tien Giang:'],['Tra Vinh','VN:110157:Tra Vinh:'],['Tuyen Quang','VN:110158:Tuyen Quang:'],['Vinh Long','VN:110159:Vinh Long:'],['Vinh Phuc','VN:110160:Vinh Phuc:'],['Yen Bai','VN:110161:Yen Bai:'],['Others','VN:110199:']];
		
		//var country_state = [['AU',AU],['BD',BD],['ID',ID],['IN',IN],['PH',PH],['MY',MY],['TH',TH],['VN',VN]];
		
		var state_options="<select name='state' id='state'>";
		for(i=0;i<country_state[country].length;i++){
			state_options += "<option value='"+country_state[country][i][1]+"'>"+ country_state[country][i][0] +"</option>"
		
		}
		state_options += "</select>"
		
		//document.getElementById('state_field').innerHTML = state_options;
	}
	
	document.getElementById('state_field').innerHTML = state_options;
	
	
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
	if(document.getElementById('player')) document.getElementById('player').style.display="none";
}

function hidepopup(id){
	document.getElementById(id).style.display="none";		
	document.getElementById('main').style.display="none";
	document.getElementById('player').style.display="block";
} 



function RegisterApplicant(){
	//alert("Hello World");
	
	var staff_fname = $('fname').value;
	var staff_lname = $('lname').value;
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

	if(jQuery.trim(staff_fname)==""){
		alert("Please enter your first name");
		$('fname').focus();
		return false;
	}
	
	if(jQuery.trim(staff_lname)==""){
		alert("Please enter your last name");
		$('lname').focus();
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

function is_numeric(input){
	if(!isNaN(input)){
		return true;
	}
	else{
		return false;
	}
}

function CheckAltEmail(){

	var alt_email = $('alt_email').value; 
	var email = $('email').value; 
  
  	if(email == alt_email){
		alert("Alternate email must be different from your primary email");
	} 
  
}


function CheckStep1Form(){
  
  var fname = $('fname').value;
  var lname = $('lname').value; 
  
  var alt_email = $('alt_email').value; 
  var email = $('email').value; 

  var bmonth = $('bmonth').value;
  var bday = $('bday').value;
  var byear = $('byear').value;
  
  var dmonth = $('dmonth').value;
  var dday = $('dday').value;
  var dyear = $('dyear').value;
  
  var marital_status = $('marital_status').value;
  
  var no_of_kids = $('no_of_kids').value;
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
  
  var pass2 = $("pass2").value;
  
  if(fname == ""){
    alert("Please enter your first name");
    return false;
  }
  
  if(lname == ""){
    alert("Please enter your last name");
    return false;
  }
  
  if(bmonth == 0 || bday == "" || byear == ""){
    alert("Please enter your Date of Birth");
    return false;
  }
  
  if(!is_numeric(byear)){
	alert("Invalid birthyear");
	return false;
  }
  
  if(marital_status == ""){
    alert("Please select your marital status");
    return false;
  }
  
  if((no_of_kids != "")&&(!is_numeric(no_of_kids))){
    alert("Invalid number of kids");
    return false;
  }
  
  if(dmonth != 0 || dday != "" || dyear != ""){  
	  if(dmonth == 0 || dday == "" || dyear == ""){
		alert("Please enter your Date of Delivery");
		return false;
	  }
	  
	  if(!is_numeric(dyear)){
		alert("Invalid delivery year");
		return false;
	  }
  }
  
  if($('form_id').value == ""){
    var password = $('password').value;
    if(password == ""){
      alert("Please enter your password");
      return false;
    }else if (password.length<6){
      alert("Password should be more than 5 characters")
      return false;
    }
  }
  
  if(handphone_no == "" && tel_no =="" ){
    alert("Please specify your contact number");
    return false;
  }
  
  if(!is_numeric(handphone_no) || !is_numeric(tel_no)){
    alert("Invalid contact number");
    return false;
  }
  
   if(!is_numeric(handphone_country_code) || !is_numeric(tel_area_code)){
    alert("Invalid contact number");
    return false;
  }
  
	if(email == alt_email){
		alert("Alternate email must be different from your primary email");
		return false;
	} 
	
  if(address1 == ""){
    alert("Please enter your address");
    return false;
  }

  if(country_id == ""){
    alert("Please enter your Country");
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
  if(pass2==""){
	alert("Please type the code that you see in the image");
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
	//var noise_level = getCheckBoxValue('noise_level[]');
	
	var noise_levels = '';
	$.each($("input[name='noise_level[]']:checked"), function() {
	  noise_levels += ',' + $(this).val();
	});
	

	if(work_from_home_before==null){
		alert("Please state whether you have worked from home before or not");
		return false;
	}
	else{
		if(work_from_home_before=="Yes"){
			var start_worked_from_home_month = $('start_worked_from_home_month').value;
			var start_worked_from_home_day = $('start_worked_from_home_day').value;
			var start_worked_from_home_year = $('start_worked_from_home_year').value;
			if((start_worked_from_home_month=="")||(start_worked_from_home_day=="")){
				alert("Please enter when you started working from home");
				return false;
			}
			if(!is_numeric(start_worked_from_home_year)){
			alert("Invalid work from home year");
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
	
	if(noise_levels==""){
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
	if(graduate_month=="0"){
		alert("Please provide your graduation month");
		return false;
	}
	if(graduate_year==""){
		alert("Please provide your graduation year");
		return false;
	}
	
	if(!is_numeric(graduate_year)){
		alert("Invalid graduation year");
		return false;
	}
	
	if(!is_numeric(gpa)){
		alert("Invalid grade point avegrage");
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

function validateEmail(email){
	var regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
	return regex.test(email);
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
  
  if(!validateEmail(email)){
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
    $("email").focus();
    return false;
  }
  
  if(!validateEmail(email)){
    alert('Please enter a valid email address and try again!');
    $("email").focus();
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
	//toggle('code-form');
	$("send-btn").innerHTML ='';
  }else if (e.responseText == '03'){
	var itemText = '<span style="font-size:11px;" >The email address you have entered is already registered with Remotestaff.<br> Should you wish to log in to your account, please click <a href="/portal/">HERE</a><br></span>';
	$("send-btn").innerHTML = itemText;
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

function showEmailSender(){
	toggle("email-message-sent");
	toggle('code-form');
}

jQuery(document).ready(function(){
	jQuery("#register-step-1").submit(function(){
		var me = this;
		if (CheckStep1Form()){
			var captcha_text = jQuery("#pass2").val()
			jQuery.post("/portal/application_form/captcha-check.php", {captcha_text:captcha_text}, function(data){
				data = jQuery.parseJSON(data);
				if (data.success){
					me.submit();
				}else{
					alert("Code did not match.");
				}
			})
		}
		return false;
	});
	
	jQuery(".register-step-5-button").click(function(e){
		var skillsSelected = [];
		var proficienciesSelected = [];
		var experienceSelected = [];
		jQuery(".skill-dropdown").each(function(){
			skillsSelected.push(jQuery(this).val());			
		})
		jQuery(".prof-dropdown").each(function(){
			proficienciesSelected.push(jQuery(this).val());			
		})
		jQuery(".exp-dropdown").each(function(){
			experienceSelected.push(jQuery(this).val());			
		})
		
		var error = false;
		var errorIndex = 0;
		for(var i=0;i<jQuery(".prof-dropdown").length;i++){
			if ((skillsSelected[i]!="")||(proficienciesSelected[i]!="")||(experienceSelected[i]!="")){
				if (!(skillsSelected[i]!=""&&proficienciesSelected[i]!=""&&experienceSelected[i]!="")){
					error = true;
					errorIndex = i;
					break;						
				}
			}	
		};
		
		if (error){	
			if (skillsSelected[errorIndex]==""){
				alert("Please select a skill from the list");		
			}else if (proficienciesSelected[errorIndex]==""){
				alert("Please select a proficiency from the list");
			}else if (experienceSelected[errorIndex]==""){
				alert("Please select an experience from the list");
			}
		}else{
			jQuery("#register-step-5").submit();
			
		}
	});
	
	jQuery("#remove-voice, #remove-photo").click(function(e){
		jQuery("#action").val("remove");
		jQuery("#uploaded_file").val("");
		document.upload.submit();
	})
	jQuery("#upload-voice, #upload-photo").click(function(e){
		jQuery("#action").val("upload");
		showpopup('popup');
	});
});
