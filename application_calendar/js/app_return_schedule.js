var APP_CALENDAR_chck = 0;
var APP_CALENDAR_temp = '';
var APP_CALENDAR_int=self.setInterval('APP_CALENDAR_check_schedule(APP_CALENDAR_temp,APP_CALENDAR_temp)',9000)	
var APP_CALENDAR_directory = ""; //optional & values could be(".." or "../..")

function APP_CALENDAR_directory_set(val)
{
	APP_CALENDAR_directory = val;
}

function APP_CALENDAR_check_schedule(id,method)
{
	APP_CALENDAR_chck = 0;
	APP_CALENDAR_http.open("GET", APP_CALENDAR_directory+"application_calendar/return_schedule.php?method="+method+"&id="+id, true);
	APP_CALENDAR_http.onreadystatechange = APP_CALENDAR_handleHttpResponse;
	APP_CALENDAR_http.send(null);
}

function APP_CALENDAR_hideAlarm(id,method)
{
	APP_CALENDAR_chck = 0;
	document.getElementById('alarm').style.visibility='hidden';
	APP_CALENDAR_check_schedule(id,method);
}

function APP_CALENDAR_handleHttpResponse() 
{
	if (APP_CALENDAR_http.readyState == 4) 
	{
		var temp = APP_CALENDAR_http.responseText;
		if(temp != "" || temp != null)
		{
			document.getElementById('alarm').innerHTML = temp;			
			document.getElementById('alarm').style.visibility='visible';							
		}	
	}
}

function APP_CALENDAR_getHTTPObject() 
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

var APP_CALENDAR_http = APP_CALENDAR_getHTTPObject();		
		
