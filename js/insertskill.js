var xmlHttp
function insertSkills(skill,yoe,pro,u)
{ 
	xmlHttp=GetXmlHttpObject()
	if (xmlHttp==null)
 	{
 		alert ("Browser does not support HTTP Request")
 		return
 	}
	var url="insertSkill.php"
	url=url+"?skill="+skill
	url=url+"&yoe="+yoe
	url=url+"&pro="+pro
	url=url+"&u="+u
	url=url+"&sid="+Math.random()
	xmlHttp.onreadystatechange=stateChanged 
	xmlHttp.open("POST",url,true)
	xmlHttp.send(null)
}
function stateChanged() 
{ 
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
 	{ 
 		document.getElementById("txtHint").innerHTML=xmlHttp.responseText 
 	} 
}


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
 //Internet Explorer
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