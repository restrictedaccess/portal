// JavaScript Document
var PATH = './';


function getAgentsPromocodes(agent_no){
	var promocode = document.getElementById("promocode").value;
	var query = queryString({'agent_no': agent_no, 'promocode' : promocode});
	var result = doXHR(PATH + 'getAgentsPromocodes.php', {method:'POST', sendContent: query, headers: {"Content-Type":"application/x-www-form-urlencoded"}});
	result.addCallbacks(onSuccessGetAgentsPromocodes, OnFailGetAgentsPromocodes);
}

function onSuccessGetAgentsPromocodes(e){
	document.getElementById("agent_promocodes").innerHTML=e.responseText;	
	
}

function OnFailGetAgentsPromocodes(e){
	alert("Failed to fetch Business Partner Promotional Codes.");	
}

function getBusinessPartnerAffiliates(affiliate_id){
	var agent_no = document.getElementById("agent").value;
	var query = queryString({'agent_no': agent_no, 'affiliate_id' : affiliate_id});
	var result = doXHR(PATH + 'getBusinessPartnerAffiliates.php', {method:'POST', sendContent: query, headers: {"Content-Type":"application/x-www-form-urlencoded"}});
	result.addCallbacks(onSuccessGetBusinessPartnerAffiliates, OnFailGetBusinessPartnerAffiliates);
}
function onSuccessGetBusinessPartnerAffiliates(e){
	document.getElementById("agent_affiliates").innerHTML=e.responseText;
}
function OnFailGetBusinessPartnerAffiliates(e){
	alert("Failed to fetch Business Partner Affiliates.");	
}


function checkFields()
{
	
	missinginfo = "";
	if(document.getElementById("agent").value==0){
		missinginfo += "\n     -  Please select a Business Partner or Affiliate";
	}
	if(document.getElementById("tracking_no").value==0){
		missinginfo += "\n     -  Please select a Business Partner or Affiliate Promotional Codes";
	}
	if (document.form.fname.value == "")
	{
		missinginfo += "\n     -  Please enter your First name";
	}
	if (document.form.lname.value == "")
	{
		missinginfo += "\n     -  Please enter your Last name";
	}
	
	if (document.form.email.value == "")
	{
		missinginfo += "\n     -  Please site a email address"; //
	}
	
	if (missinginfo != "")
	{
		missinginfo =" " + "You failed to correctly fill in the required information:\n" +
		missinginfo + "\n\n";
		alert(missinginfo);
		return false;
	}
	else return true;
	
}

