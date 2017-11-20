function handleHttpResponse_t() 
	{
	
		if (http_t.readyState == 4) 
		{
	temp++;
			document.getElementById('timer').innerHTML = http_t.responseText;
		}
	}
	
	function getHTTPObject_t() 
	{
		var t 
		var browser = navigator.appName 
		if(browser == 'Microsoft Internet Explorer')
		{
			t = new ActiveXObject('Microsoft.XMLHTTP')
		}
		else
		{
			t = new XMLHttpRequest()
		}
		return t		
	}
	var http_t = getHTTPObject_t();
	var temp_counter = 0;
