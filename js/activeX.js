<!--
if (self.parent.frames.length != 0) {
	self.parent.location = window.document.URL;
}

var IE = document.all?true:false;
if (!IE) {
	document.captureEvents(Event.MOUSEMOVE);
}

document.onmousemove = getMouseXY;
var tempX=0;
var tempY=0;

function getMouseXY(e) 
{
	if (IE) {
		tempX = event.clientX + document.body.scrollLeft;
		tempY = event.clientY + document.body.scrollTop;
	} else {
		tempX = e.pageX;
		tempY = e.pageY;
	}
	if (tempX < 0) {   tempX = 0;   }
	if (tempY < 0) {   tempY = 0;   }
	return true;
}

function showTip(ele, left, top)
{
	var tipbox = document.getElementById(ele);
	tipbox.style.visibility = 'visible';
	tipbox.style.left = tempX + left;
	tipbox.style.top = tempY + top;
}

function showTip2(ele, left, top)
{
	var tipbox = document.getElementById(ele);
	tipbox.style.visibility = 'visible';
}

function hideTip(ele)
{
	document.getElementById(ele).style.visibility='hidden';
}

function showEle(ele)
{
	if (document.getElementById(ele)) 
		document.getElementById(ele).style.visibility='visible';
}

function hideEle(ele)
{
	if (document.getElementById(ele)) 
		document.getElementById(ele).style.visibility='hidden';
}

function assignInnerHTML(ele, value)
{	
	if (document.getElementById(ele)) 
		document.getElementById(ele).innerHTML = value;
}

function assignClassName(ele, value)
{
	if (document.getElementById(ele)) 
		document.getElementById(ele).className = value;
}
//Making HTTP GET Requests - only call function to initialize when needed
//IE, Firefox, Opera

function initReq()
{
	var req = null;
	//find the most recent version on user machine
	var arr = ['MSXML2.XMLHttp.5.0', 'MSXML2.XMLHttp.4.0', 'MSXML2.XMLHttp.3.0', 'Msxml2.XMLHTTP', 'Microsoft.XMLHTTP'];
	if (window.XMLHttpRequest) 
	{
		req = new XMLHttpRequest();
		return req;
	} else {
		for (var i=0; i<arr.length; i++) {
			try {
				req = new ActiveXObject(arr[i]);
				return req;
			} catch (e) { }
		}
	}
	throw new Error("XmlHttp not supported.");
}

function mkGetReq(url, str, callBack, ele, imgEle)
{
	var request = initReq();
	if (request != null) 
	{
		request.onreadystatechange = function() 
		{
		if (request.readyState == 4 && request.status == 200) {
			if (request.responseText) {
				eval("var output = '" + request.responseText + "';");
				eval(callBack + "('" + output + "', '" + ele + "', '" + imgEle + "');");		
				return;
			} else {
				eval(callBack + "('', '" + ele + "', '" + imgEle + "');");
                return;			
            }
		}
		return;
		}
		request.open('GET', url + '?' + str, true);
		request.send(null);
	} 
}

function myjsAJAX() {
	this.processOutput = myjsProcessOutput;
	this.initXmlHttp = myjsInitXmlHttp;
	this.sendRequest = myjsSendRequest;	
	this.increment = 1;
	this.validData = '<validAjaxRs />';	
}

function myjsInitXmlHttp() {
	this.increment = this.increment + 1*1;
	if (window.XMLHttpRequest) { eval("req_" + this.increment + " = new XMLHttpRequest();") }
	else if (window.ActiveXObject) { eval("req_" + this.increment + " = new ActiveXObject(\"Microsoft.XMLHTTP\");") }	
	//eval("req_" + this.increment + " = new XMLHTTP();");
}

function myjsSendRequest (object, url, callBack, param1, param2, param3) {
	this.initXmlHttp();
	var req = eval("req_" + this.increment);
	if (req) {
		req.onreadystatechange = function () { if (req.readyState==4) { if (req.status==200) {
			if(req.responseText){
				eval("var output = " + object + ".processOutput('" + req.responseText.replace(/'/g, "\\'") + "');");
				eval(callBack + "('" + output + "', '" + param1 + "', '" + param2 + "', '" + param3 + "');");		
			}
			else {
				eval(callBack + "('', '" + param1 + "', '" + param2 + "', '" + param3 + "');");
			}
		}}}
		req.open('GET', url, true);
		req.send(null);
	}
}

function myjsProcessOutput(responseText) {
	if ( responseText.substring(0, this.validData.length) == this.validData ) {
		responseText = responseText.substring(this.validData.length).replace(/'/g, "\\'");			
		return responseText;		
	}
	return ;
}

//function setOpacity(divEle){
//	divEle.style.filter="alpha(opacity:97)";
//	divEle.style.KHTMLOpacity="0.97";
//	divEle.style.MozOpacity="0.97";
//	divEle.style.opacity="0.97";
//}
//-->
