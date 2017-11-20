var xmlHttp

function highlight(obj) {
   obj.style.backgroundColor='yellow';
   obj.style.cursor='pointer';
}

function unhighlight(obj) {
   obj.style.backgroundColor='';
   obj.style.cursor='default';
}
function gotoContractDetails(userid){
	//alert(userid);
	location.href = "editcontract.php?userid="+userid;
}


function show_hide(id) 
{
	obj = document.getElementById(id);
	//obj.innerHTML=sid;
	obj.style.display = (obj.style.display == "block") ? "none" : "block";
	
}

function getDiv(sid,element){
	obj = document.getElementById(sid);
	//obj.innerHTML=sid;
	obj.style.display = (obj.style.display == "block") ? "none" : "block";
	//toggle(obj);
	//getContractDetails(sid,element)	
	//getElementName(element);
	
}


function searchSubcon(){
	
	document.getElementById("subcon_listings").innerHTML = "<img src=\"images/ajax-loader.gif\"> Loading....";
	userid = document.getElementById("subcon_id").value;	
	//alert(userid);
	xmlHttp=GetXmlHttpObject();
	if (xmlHttp==null)
  	{
	  alert ("Browser does not support AJAX!");
	  return false;
  	} 
	var url="getSubcontractors.php";
	url=url+"?userid="+userid;
	url=url+"&sid="+Math.random();
	
	xmlHttp.onreadystatechange = OnSuccessGetAllSubcon;
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);
}

function OnSuccessGetAllSubcon(){
	if (xmlHttp.readyState==4)
	{ 
		document.getElementById("subcon_listings").innerHTML = xmlHttp.responseText;
	}
}


//////
function GetXmlHttpObject()
{
var xmlHttp=null;
try
  {
  // Firefox, Opera 8.0+, Safari
  xmlHttp=new XMLHttpRequest();
  }
catch (e)
  {
  // Internet Explorer
  try
    {
    xmlHttp=new ActiveXObject("Msxml2.XMLHTTP");
    }
  catch (e)
    {
    xmlHttp=new ActiveXObject("Microsoft.XMLHTTP");
    }
  }
return xmlHttp;
}
