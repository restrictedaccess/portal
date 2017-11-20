function makeObject()
{
	var x ; 
	var browser = navigator.appName ;
	if(browser == 'Microsoft Internet Explorer')
	{
		x = new ActiveXObject('Microsoft.XMLHTTP')
	}
	else
	{
		x = new XMLHttpRequest()
	}
	return x ;
}