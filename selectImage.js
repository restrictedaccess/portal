var ClientxmlHttp
function setPicture(id)
{ 
//alert (id);
//document.getElementById("client_details").innerHTML=id;


ClientxmlHttp=GetXmlHttpObject2();
if (ClientxmlHttp==null)
  {
  alert ("Your browser does not support AJAX!");
  return;
  } 
var url="getPicture.php";
url=url+"?id="+id;
url=url+"&ssid="+Math.random();
ClientxmlHttp.onreadystatechange=stateChanged2;
ClientxmlHttp.open("GET",url,true);
ClientxmlHttp.send(null);

}

function stateChanged2() 
{ 
	if (ClientxmlHttp.readyState==4)
	{ 
		document.getElementById("ad").innerHTML=ClientxmlHttp.responseText;
	}
}

function GetXmlHttpObject2()
{
var ClientxmlHttp=null;
try
  {
  // Firefox, Opera 8.0+, Safari
  ClientxmlHttp=new XMLHttpRequest();
  }
catch (e)
  {
  // Internet Explorer
  try
    {
    ClientxmlHttp=new ActiveXObject("Msxml2.XMLHTTP");
    }
  catch (e)
    {
    ClientxmlHttp=new ActiveXObject("Microsoft.XMLHTTP");
    }
  }
return ClientxmlHttp;
}

