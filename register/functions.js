/*function makeObject()
{
	var x 
	var browser = navigator.appName 
	if(browser == 'Microsoft Internet Explorer')
	{
		x = new ActiveXObject('Microsoft.XMLHTTP')
	}
	else
	{
		x = new XMLHttpRequest()
	}
	return x
}
var rq = makeObject();

function display(){
	if (milisec<=0){ 
		milisec=9 
		seconds-=1 
	} 
	if (seconds<=-1){ 
		milisec=0 
		seconds+=1 
	} 
	else {
		milisec-=1 
		$('tmr').value=seconds+"."+milisec 
		if($('tmr').value == "0.0"){
			toggle('code_div_form')
		}
		setTimeout("display()",100) 
	}
}

function tmr(){
	if($('tmr')!=null){
		alert("Registration code has been successfully sent.\n Please check your email Inbox / Spam box . ");
		display()
	}	
}

function handleHttpResponse() 
{
	if (rq.readyState == 4) 
	{
		var returned_data = rq.responseText;
		document.getElementById('responder_message').innerHTML = '<font color="#FF0000"><b>'+returned_data+'</b></font>' ;
		tmr();
	}
	else
		document.getElementById('responder_message').innerHTML = '<font color="#FF0000"><b>Loading...</b></font>';
		
}

function SendCode()
{
	emailReg = "^[\\w-_\.]*[\\w-_\.]\@[\\w]\.+[\\w]+[a-zA-Z]$"
	var regex = new RegExp(emailReg);

	if(document.getElementById('email').value == "")
	{
		alert("Please enter your email address.");
	}
	else if(regex.test(document.getElementById('email').value) == false)
	{
		alert('Please enter a valid email address and try again!');
	}	
	else
	{
		document.getElementById('responder_message').innerHTML = "Processing Please wait...";
		var email = document.getElementById('email').value;
		rq.open('get', 'personal_validate_email.php?email='+email)
		rq.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded')
		rq.onreadystatechange = handleHttpResponse;
		rq.send(1);	
	}	
}
*/