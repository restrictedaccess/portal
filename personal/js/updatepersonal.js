function validateEmail(email){
	var regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
	return regex.test(email);
}

function checkFields(){
	var missinginfo = "";
	if (jQuery("#fname").val()==""){
		missinginfo += "\n     -  Please enter your First Name";	
	}
	if (jQuery("#lname").val()==""){
		missinginfo += "\n     -  Please enter your Last Name";	
	}
	if (jQuery("#bmonth").val()=="0"){
		missinginfo += "\n     -  Please select your birth month"; 
	}
	if (jQuery("#nationality").attr("selectedIndex")==0){
		missinginfo += "\n     -  Please choose your nationality";	
	}
	if (jQuery("#email").length>=1){
		if (jQuery("#email").val()==""){
			missinginfo += "\n     -  Please site a email address"; 
		}
		
		if (!validateEmail(jQuery("#email").val())){
			missinginfo += "\n     -  Please site a valid email address format"; 
		}
		jQuery.ajax({
			type:"GET",
			url:"/portal/candidates/email-existing.php",
			data:"email="+jQuery("#email").val()+"&userid="+jQuery("#userid").val(),
			dataType:"html",
			async:false,
			success:function(msg){
				msg = jQuery.parseJSON(msg);
				if (msg.success){
					missinginfo += "\n     -  The email you entered is already existing"; 
				}	
			}
		});
	}
	
	if (jQuery("#handphone_no").val()==""){
		missinginfo += "\n     -  Please enter your mobile num"; 
	}
	if (jQuery("#tel_area_code").val()==""){
		missinginfo += "\n     -  Please enter your area code"; 
	}
	
	if (jQuery("#tel_no").val()==""){
		missinginfo += "\n     -  Please enter your telephone number"; 
	}
	if (jQuery("#address1").val()==""){
		missinginfo += "\n     -  Please enter your Address"; 
	}
	if (jQuery("#postcode").val()==""){
		missinginfo += "\n     -  Please enter your Postal Code"; 
	}
	if (jQuery("#byear").val()==""){
		missinginfo += "\n     -  Please enter your Date of birth"; 
	}
	if (jQuery("#pregnant").val()=="Yes"){
		if (jQuery("#dyear").val()==""){
			missinginfo += "\n     -  Please enter your Date of delivery"; 
		}	
	}
	
	if (jQuery("#country_id").attr("selectedIndex")==0){
		missinginfo += "\n     -  Please state your Country";	
	}
	var countryid = jQuery("#country_id").val();
	
	if (countryid=="AU"|| countryid=="BD"|| countryid=="HK"|| countryid=="ID"|| countryid=="IN"|| countryid=="MY"|| countryid=="PH"|| countryid=="SG"|| countryid=="TH"|| countryid=="VN"){
		if (jQuery("#msia_state_id").selectedIndex==0)
		{
			missinginfo += "\n     -  Please enter your State or Region";
		}
	}
	else
	{
		if (jQuery("#state").selectedIndex==0)
		{
			missinginfo += "\n     -  Please enter your State or Region";
	
		}
	}
	
	if(jQuery("#city").val() == "")
	{
		missinginfo += "\n     -  Please enter your City";
	}
	if (jQuery("#byear").val() == "")
	{
		missinginfo += "\n     -  Please enter your Birth Year";
	}
	
	
	if (missinginfo != "")
	{
		missinginfo =" " + "You failed to correctly fill in the required information:\n" +
		missinginfo + "\n\n";
		alert(missinginfo);
		return false;
	}else {
		
		var recruiterYesNo = jQuery("select[name=have_you_spoken]").val();
		if (recruiterYesNo=="Yes"){
			var recruiter = jQuery("select[name=recruiter]").val();
			if (recruiter==""){
				alert("Please select a recruiter from the list");
				return false;
			}
		}
		return true;
	}

	
}
  
function enterCity(ld,  objCitySelect, objLocationSelect, cls){  
	var id = ld.split(":") ; 
objLocationSelect.value = "";
if(id[1] != null && id[1].length > 0){ 
	objLocationSelect.value = id[1]; 
		if(id[2] != null && id[2].length > 0 ){ 
			objCitySelect.value = ""; 
			objCitySelect.value = id[2]; 
	} else{  
		if(cls == true) { 
			objCitySelect.value = ""; 
		} 
	} 
}else{ 
   if(cls == true) { 
	objCitySelect.value = ""; 
	   } 
	} 
} 
 function repopulateLocation(objMsiaState, data, startindex, endindex) {  
	for(var i =0 ; i< objMsiaState.options.length; i++)  
	{		
		var tempVar =  data;  
		if(objMsiaState.options[i].value == tempVar 
		||  (objMsiaState.options[i].value.substring(startindex, endindex) == tempVar.substring(startindex, endindex))) 
		{ 
			objMsiaState.selectedIndex = i; 
			break; 
		} 
	} 
   return i;  
} 
function populateDuplicateLocation(objMsiaState, data, strmsia, strloc, strcity){   
	for(var i =0 ; i< objMsiaState.options.length; i++){  
 		if(objMsiaState.options[i].value == data){  
			objMsiaState.selectedIndex = i;  
			break; 
		}else{ 
			var tmpst =  strmsia; 
			var tmplc =  strloc; 
			var tmpct =  strcity;	 
				var d = objMsiaState.options[i].value.split(":"); 
			if(d[0] == tmpst && d[1] == tmplc){ 
				var c = d[2].toLowerCase(); 
				var tmpct = tmpct.toLowerCase(); 
				if ( c.indexOf(tmpct) >= 0 || tmpct.indexOf(c) >= 0 ){ 
					objMsiaState.selectedIndex = i; 
						break; 
				} 
			} 
		} 
   }  
   return i;  
}  
function populateOtherLocation(objMsiaState, objCity, objLocation, strmsia, strcity){ 
  for(var i =0 ; i< objMsiaState.options.length; i++){ 
	var tmpst = strmsia; 
	var tmpct =  strcity;	 
				var d = objMsiaState.options[i].value.split(":"); 
			if(d[0] == tmpst){ 
			   if(d[2] != null && d[2].length > 0 ){ 
				var c = d[2].toLowerCase();  
				var tmpct = tmpct.toLowerCase(); 
				if ( c.indexOf(tmpct) >= 0 || tmpct.indexOf(c) >= 0 ){ 
					objMsiaState.selectedIndex = i; 
					break; 
				} 
				} 
			}
		} 
	if(i <  objMsiaState.options.length){ 
		enterCity(objMsiaState.options[i].value, objCity, objLocation, false) 
   }  
   return i;  
  }  
function emptyLocationSelect(objOtherState, strCountry, objStateSelect, objCitySelect, objLocationSelect){ 
	var NS4 = (document.layers) ? true : false; 
	var temp = "";  
		if(!NS4){ 	objStateSelect.style.visibility = 'hidden'; } 
		if(strArrayList.indexOf(strCountry) > 0){ 
			while(objStateSelect.options.length > eval(strCountry + ".length")){  
				objStateSelect.options[(objStateSelect.options.length-1)] = null;  
			}  
		objOtherState.disabled = true;  
		objOtherState.value = '';  
		for(i=0;i<eval(strCountry + ".length");i++){  
			temp = eval(strCountry + "[i]");	 
				if(!NS4){  
					objOtherState.size = 10  
					objOtherState.style.visibility = 'hidden';  
					objStateSelect.style.visibility = 'visible';  
				}  
				else{  
					objOtherState.disabled = true;  
				}  
				eval("objStateSelect.options[i] = new Option" + temp);  
		}  
	}else{  
		while(objStateSelect.options.length > 1){  
			objStateSelect.options[(objStateSelect.options.length-1)] = null;  
		}  
		if(!NS4){  
			objStateSelect.options[0] = new Option("","00");  
			objStateSelect.style.visibility = 'hidden';  
			objOtherState.style.visibility = 'visible';  
			objOtherState.size = 20  
			objOtherState.disabled = false; 
		}else{	  
			objStateSelect.options[0] = new Option(Others,"00");  
			objOtherState.disabled = false;  
		}  
	}  
	objStateSelect.selectedIndex = 0;  
	
}
	

function displayOthers(){

	external_source = $('#external_source').val();
	
	if(external_source == 'Others'){
		jQuery('#others_container').css("display", "block");
		//jQuery('#external_source_others').val("");
	}
	
	else{
		jQuery('#others_container').css("display", "none");
	}
}
	
function changeState(){
	var selectedState = jQuery("#state").val();
	if (jQuery("#country_id").val()=="PH"){
		var states = ['Armm','Bicol Region','C.A.R.','Cagayan Valley','Central Luzon','Central Mindanao','Caraga','Central Visayas','Eastern Visayas','Ilocos Region','National Capital Region','Northern Mindanao','Southern Mindanao','Southern Tagalog','Western Mindanao','Western Visayas'];
		var state_codes = ["AR", "BR", "CA", "CG", "CL", "CM", "CR", "CV", "EV", "IL", "NC", "NM", "SM", "ST", "WM", "WV"];
		var options = "";
		for(var i=0;i<states.length;i++){
			if (selectedState==states[i]||selectedState==state_codes[i]){
				options += "<option value='"+state_codes[i]+"' selected>"+states[i]+"</option>";
			}else{
				options += "<option value='"+state_codes[i]+"'>"+states[i]+"</option>";
			}
		}
		var select = "<select name='state' id='state'>"+options+"</select>";
		jQuery("#state_field").html(select);
	}else{
		var select = "<input type='text' name='state' id='state' value='"+selectedState+"' size='15'/>";
		jQuery("#state_field").html(select);			
	}
}

$(document).ready(function(){
	displayOthers();
	changeState();
	jQuery("#country_id").change(changeState);
	jQuery(".gender").click(function(){
		var selected = jQuery(this).val();
	});
	
});