// page usage by apply_action.php
// Created By Normaneil Macutay 
// Feb.4,2009

var xmlHttp
PATH ="product_need/";

function highlight(obj) {
   obj.style.backgroundColor='yellow';
   obj.style.cursor='pointer';
}
function unhighlight(obj) {
   obj.style.backgroundColor='';
   obj.style.cursor='default';
}
function show_hide(sid) 
{
   obj = document.getElementById(sid);
   obj.style.display = (obj.style.display == "block") ? "none" : "block";
}

function deleteProductItem(id){
	
	if(confirm("Are you sure you want to delete this Item?"))
	{
		xmlHttp=GetXmlHttpObject();
		if (xmlHttp==null)
		{
		  alert ("Your browser does not support AJAX!");
		  return;
		}
		document.getElementById("leads_product_list").innerHTML = "Loading...";
		var url=PATH+"deleteProductItem.php";
		url=url+"?id="+id;
		url=url+"&sid="+Math.random();
		xmlHttp.onreadystatechange=onSuccessDeleteProductItem;
		xmlHttp.open("GET",url,true);
		xmlHttp.send(null);
	}else{
		return false;
	}
}
function onSuccessDeleteProductItem(){
	if (xmlHttp.readyState==4)
	{
		//document.getElementById("leads_product_list").innerHTML=xmlHttp.responseText;	
		showProductForm();
	}
}

function saveProduct(){
	leads_id = document.getElementById("leads_id").value;
	product = document.getElementById("product").value;
	product_position = document.getElementById("product_position").value;
	product_quantity = document.getElementById("product_quantity").value;
	product_notes = document.getElementById("product_notes").value;
	product_requested_price = document.getElementById("product_requested_price").value;
	
	if(leads_id==""){
		alert("Leads Id is Missing.");
		return false;
	}
	if(product=="" || product_position == "")
	{
		alert("Please choose a Product Category and Specify a Job Position needed by the Lead.");
		return false;
	}
	
	if(product_requested_price==""){
		alert("Please enter a valid amount");
		return false;
	}
	
	xmlHttp=GetXmlHttpObject();
	if (xmlHttp==null)
	{
	  alert ("Your browser does not support AJAX!");
	  return;
	}
	document.getElementById("leads_product_list").innerHTML = "Loading...";
	var url=PATH+"addProductRequest.php";
	url=url+"?leads_id="+leads_id;
	url=url+"&product="+product;
	url=url+"&product_position="+product_position;
	url=url+"&product_quantity="+product_quantity;
	url=url+"&product_notes="+product_notes;
	url=url+"&product_requested_price="+product_requested_price;
	url=url+"&sid="+Math.random();
	xmlHttp.onreadystatechange=onSuccessAddProductRequest;
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);
}
function onSuccessAddProductRequest(){
	if (xmlHttp.readyState==4)
	{
		document.getElementById("leads_product_list").innerHTML=xmlHttp.responseText;	
		document.getElementById("product").value ="";
		document.getElementById("product_position").value="";
		document.getElementById("product_quantity").value="";
		document.getElementById("product_notes").value="";
		document.getElementById("product_requested_price").value="";
	}
}


function showProductForm(){
	leads_id = document.getElementById("leads_id").value;
	document.getElementById("product_form").innerHTML = "<img src=\"images/ajax-loader.gif\">";
	xmlHttp=GetXmlHttpObject();
	if (xmlHttp==null)
	{
	  alert ("Your browser does not support AJAX!");
	  return;
	}
	
	var url=PATH+"showProductForm.php";
	url=url+"?leads_id="+leads_id;
	url=url+"&sid="+Math.random();
	xmlHttp.onreadystatechange=onSuccessShowQuoteAgentForm;
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);
}

function onSuccessShowQuoteAgentForm(){
	if (xmlHttp.readyState==4)
	{
		document.getElementById("product_form").innerHTML=xmlHttp.responseText;	
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
