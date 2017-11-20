var xmlHttp

function showLoading(){
	document.getElementById("payment_summary_viewer").innerHTML="<div align='center' style='margin-top:50px;'>Processing....<br><img src=\"images/loader.gif\"></div>";
}


function createInvoiceByMonth(){
	
	month = document.getElementById("month").value;
	if(month==0){
		alert("Please Select Month !")
		return false;
	}else{
	document.getElementById("payment_invoice_list").innerHTML = "Loading.....";
	xmlHttp=GetXmlHttpObject();
	if (xmlHttp==null)
  	{
	  alert ("Browser does not support AJAX!");
	  return false;
  	} 
	var url="createPaymentsInvoice.php";
	url=url+"?month="+month;
	url=url+"&sid="+Math.random();
	xmlHttp.onreadystatechange=stateChanged4;
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);
	}
}

function stateChanged4() 
{ 
	if (xmlHttp.readyState==4)
	{ 
		document.getElementById("payment_invoice_list").innerHTML =xmlHttp.responseText;
		showInvoiceList();
	}
}


function deleteInvoice(id){
	
	document.getElementById("payment_summary_viewer").innerHTML ="Processing...";
	if(id==null){
		alert("Payments Invoice Number is Missing !")
		return false;
	}
	xmlHttp=GetXmlHttpObject();
	if (xmlHttp==null)
  	{
	  alert ("Browser does not support AJAX!");
	  return false;
  	} 
	var url="deleteInvoice.php";
	url=url+"?id="+id;
	url=url+"&sid="+Math.random();
	xmlHttp.onreadystatechange=stateChanged2;
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);
}

function showDetails(id)
{ 
	showLoading();
	xmlHttp=GetXmlHttpObject();
	if (xmlHttp==null)
  	{
	  alert ("Your browser does not support AJAX!");
	  return;
  	} 
	var url="getPaymentsSummaryDetail.php";
	url=url+"?id="+id;
	url=url+"&sid="+Math.random();
	xmlHttp.onreadystatechange=stateChanged;
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);
}
function stateChanged2() 
{ 
	if (xmlHttp.readyState==4)
	{ 
		document.getElementById("payment_summary_viewer").innerHTML =xmlHttp.responseText;
		showInvoiceList();
	}
}

function showInvoiceList(){
	document.getElementById("payment_invoice_list").innerHTML = "Loading.....";
	xmlHttp=GetXmlHttpObject();
	var url="getPaymentsInvoiceList.php";
	xmlHttp.onreadystatechange=stateChanged3;
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);
	
}
function stateChanged3() 
{ 
	if (xmlHttp.readyState==4)
	{ 
		document.getElementById("payment_invoice_list").innerHTML =xmlHttp.responseText;
	}
}



function stateChanged() 
{ 
if (xmlHttp.readyState==4)
{ 
document.getElementById("payment_summary_viewer").innerHTML=xmlHttp.responseText;
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
