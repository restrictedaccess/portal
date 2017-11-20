var SPELABLE = "Your job specialization is the type of work that you do in the company. It is not the industry of the company you are working in.<br><br>";
var TABLESTYLE = "style=\'BACKGROUND-COLOR: #ffffcc; BORDER:solid #EFD76B 0.5pt\'";

// Funtion to check/auto pick Specialization base on Position Title
function whatSpecialization(frm,pop)
{
	if (pop==1) { //call for a popup window
		if (Trim(frm.title.value) == '') {
			alert('Please fill in your Position Title');
			frm.title.focus();
		} else
			popup_win("../resume/suggestSpe.asp?title=" + encodeURIComponent(frm.title.value) + "&frm=" + frm.name + "&pop=" + pop,440,440);
	} else {  //call for a non popup window (backend call)
		if (Trim(frm.title.value) == '')
			document.getElementById('spez').innerHTML = '';
		else
			myjsAJAX.sendRequest("myjsAJAX", "../resume/suggestSpeBackEndCall.asp?title=" + encodeURIComponent(frm.title.value), "evaluateResult","document.forms." + frm.name + ".dpt_field",pop);
	}
}

// call back function after sendRequest() to suggestSpeBackEndCall.asp
function evaluateResult(responseText,obj,pop){ 
	var spelable='';
	var tablestyle='';
	var newline='';
	//responseText return 4 info element:
	//1. position id - el[0], value = -1 means no codified
	//2. specialization id - el[1], value = -1 means no matched
	//3. specialization name -  el[2], value = -1 means no matched
	//4. position name - el[3]
	var el = responseText.split("|");

	if (pop==1) {
		spelable = SPELABLE;
		newline = "<br><br>"
	} else {
		tablestyle = TABLESTYLE;
		newline = "<br>";
	}

	if (el[1]==-1) { 
		// no specialization mapped, call kbjob to get candidates' stats
//		getKBJobRelationship(el[0],el[3],obj,pop); // temporary disabled
		if (pop==1)
			document.getElementById('spez').innerHTML = spelable + 'For example,<ul><li>If you are an <b>Accountant</b> working in the IT industry, your Job Specialization is <b>Finance-General Accounting</b> (not IT/Computer).</li><li>If you are a <b>Secretary</b> working in a Manufacturing company, your Job Specialization is <b>Secretarial</b> (not Manufacturing).</li><li>If you are a <b>Software Developer</b> working in a Logistics company, your Job Specialization is <b>IT/Computer-Software</b> (not Freight/Shipping/Logistics).</li></ul>Please select a specialization that best fits your job from the list below.';
		else
			document.getElementById('spez').innerHTML = '';
	} else { 
		// specialization mapped, show result in <div id='spez'>
		eval('SetValueToCtl(' + obj + ',\'' + el[1] + '\');');
//		document.getElementById('spez').innerHTML = '<table  width=100% ' + tablestyle + '><tr><td><img src=../_pic/bulb.gif width=25 heigh=25> ' + spelable + 'Based on your position title - <b>' + el[3] + '</b>,  we recommend that you select <b>' + el[2] + '</b> as your specialization.<br><br>If this specialization does not fit your job, please choose one from the list below.</td></tr>'
		document.getElementById('spez').innerHTML = '<table  width=100% ' + tablestyle + '><tr><td valign=top><img src=../_pic/bulb.gif ></td><td>' + spelable + 'Based on your position title - <b>' + el[3] + '</b>,  we recommend that you select <b>' + el[2] + '</b> as your specialization.' + newline + 'If this specialization does not fit your job, please choose one from the list below.</td></tr>'
	}
}