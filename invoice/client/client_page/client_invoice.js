var xmlHttp
PATH ="invoice/client/client_page/";

function highlight(obj , clicked) {
 
   obj.style.backgroundColor='yellow';
  obj.style.cursor='default';
}
function unhighlight(obj , clicked) {
   obj.style.backgroundColor='';
   obj.style.cursor='default';
}

function sendPaymentMethod(method){
	//card_type , card , expiration_date , cvv
	//document.getElementById("chosen_payment_method").innerHTML = "HERE";
	id = document.getElementById("client_invoice_id").value;
	if(method=="")
	{
		alert("Payment Method is Missing..");
		return false;
	}
	
	if(method=="send"){
		//card_type = document.getElementById("card_type").value; 
		//card =document.getElementById("card").value; 
		//expiration_date = document.getElementById("expiration_date").value; 
		//cvv = document.getElementById("cvv").value;
		//if(card_type =="" || card =="" || expiration_date =="" || cvv =="")
		//{
		//	alert("Please enter your Credit Card Details!");
		//	return false;
		//}else{
			var url=PATH+"sendPaymentMethod.php";
			url=url+"?method=2";
			//url=url+"&card_type="+card_type;
			//url=url+"&card="+card;
			//url=url+"&expiration_date="+expiration_date;
			//url=url+"&cvv="+cvv;
			url=url+"&id="+id;
			url=url+"&sid="+Math.random();
		//}
	}
	if(method == 1 || method == 3 || method == 2)
	{
		//alert(method);
		var url=PATH+"sendPaymentMethod.php";
		url=url+"?method="+method;
		url=url+"&id="+id;
		url=url+"&sid="+Math.random();
	}
	
	// Send to server script
	xmlHttp=GetXmlHttpObject();
	xmlHttp.onreadystatechange=onSuccessSendPaymentMethod;
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);
	
}
function onSuccessSendPaymentMethod()
{
	if (xmlHttp.readyState==4)
	{ 
		document.getElementById("right_panel").innerHTML=xmlHttp.responseText;
		id = document.getElementById("client_invoice_id").value;
		showClientInvoiceDetail(id);
	}
}
function showAllClientInvoiceList(){
	xmlHttp=GetXmlHttpObject();
	if (xmlHttp==null)
  	{
	  alert ("Your browser does not support AJAX!");
	  return;
  	}
	var url=PATH+"adminGetBlankClientInvoiceForm.php";
	url=url+"?mode=blank";
	url=url+"&sid="+Math.random();
	xmlHttp.onreadystatechange=stateChanged;
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);
	
}
function refreshList(){
	showAllClientInvoiceList();
	//alert("hello");
}

function showAllClientInvoiceList(){
	month = document.getElementById("month").value;
	leads_id = document.getElementById("client_id").value;
	year = document.getElementById("year").value;
	xmlHttp=GetXmlHttpObject();
	if (xmlHttp==null)
  	{
	  alert ("Your browser does not support AJAX!");
	  return;
  	}
	var url=PATH+"getAllClientInvoiceList.php";
	url=url+"?month="+month;
	url=url+"&year="+year;
	url=url+"&leads_id="+leads_id;
	url=url+"&sid="+Math.random();
	xmlHttp.onreadystatechange=stateChanged3;
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);
	
}
function stateChanged3() 
{ 
	if (xmlHttp.readyState==4)
	{ 
		document.getElementById("invoice_list").innerHTML=xmlHttp.responseText;
	}
}

function showClientInvoiceDetail(id){
	document.getElementById("right_panel").innerHTML="Loading...";
	xmlHttp=GetXmlHttpObject();
	if (xmlHttp==null)
  	{
	  alert ("Your browser does not support AJAX!");
	  return;
  	}
	var url=PATH+"getClientInvoiceDetails.php";
	url=url+"?id="+id;
	url=url+"&sid="+Math.random();
	xmlHttp.onreadystatechange=stateChanged;
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);
}


function stateChanged() 
{ 
	if (xmlHttp.readyState==4)
	{ 
		document.getElementById("right_panel").innerHTML=xmlHttp.responseText;
		showAllClientInvoiceList();
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
