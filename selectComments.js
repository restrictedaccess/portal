var xmlHttp

function getComments(str)
{ 
xmlHttp=GetXmlHttpObject3();
if (xmlHttp==null)
  {
  alert ("Your browser does not support AJAX!");
  return;
  } 
var url="getReply.php";
url=url+"?q="+str;
url=url+"&sid="+Math.random();
xmlHttp.onreadystatechange=stateChanged3;
xmlHttp.open("GET",url,true);
xmlHttp.send(null);
}

function stateChanged3() 
{ 
if (xmlHttp.readyState==4)
{ 
document.getElementById("text_comments").innerHTML=xmlHttp.responseText;
}
}

function GetXmlHttpObject3()
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
