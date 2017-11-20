var xmlHttp

function showLoading(){
	document.getElementById("other_expenses").innerHTML="<div align='center' style='margin-top:50px;'>Processing....<br><img src=\"images/loader.gif\"></div>";
}

function addAmount(amount,payment_invoice_details_id){
	var id = document.getElementById("payments_invoice_id").value;
	//alert(amount +" "+payment_invoice_details_id);
	
	if(!isNaN(amount)){
		addClientPay(id,payment_invoice_details_id,amount);
	}else{
		alert("Amount you Entered is Not a Valid Number!");
		return false;
	}
}

function addClientPay(id,payment_invoice_details_id,amount){
	document.getElementById("subcon_section").innerHTML="<div align='center' style='margin-top:50px;'>Processing....<br><img src=\"images/loader.gif\"></div>";
	xmlHttp=GetXmlHttpObject();
	if (xmlHttp==null)
  	{
	  alert ("Your browser does not support AJAX!");
	  return;
  	}
	var url="addClientPay.php";
	url=url+"?id="+id;
	url+="&payment_invoice_details_id="+payment_invoice_details_id;
	url+="&amount="+amount;
	//url+="&total_amount="+total_amount;
	
	xmlHttp.onreadystatechange=stateChanged2;
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);
	
}
function stateChanged2() 
{ 
	if (xmlHttp.readyState==4)
	{ 
		document.getElementById("subcon_section").innerHTML = xmlHttp.responseText;
		document.getElementById("total_profit_div").innerHTML ="<span style=\"float:left;\">Total Profit from Client Payments made for Remote Staff : </span><span style=\"float:right;\">$"+ document.getElementById("total_profit_str").value +"</span><div style=\"clear:both;\"></div>";
		
		//Total Profit : $ "+ document.getElementById("total_profit_str").value ;
		
		
	}
}
function deleteExpenses(id){
	xmlHttp=GetXmlHttpObject();
	
	var payments_invoice_id = document.getElementById("payments_invoice_id").value;
	var total_amount = document.getElementById("total_amount_txt").value;
	
	if(confirm("Are you sure want to delete the selected Expenses ?"))
	{
		//showLoading();
		
		var url="deleteExpenses.php";
		url=url+"?id="+id;
		url+="&payments_invoice_id="+payments_invoice_id;
		url+="&total_amount="+total_amount;
		xmlHttp.onreadystatechange=stateChanged3;
		xmlHttp.open("GET",url,true);
		xmlHttp.send(null);
		return true;
	}else return false;		
	
}

function stateChanged3() 
{ 
	if (xmlHttp.readyState==4)
	{ 
		document.getElementById("other_expenses").innerHTML=xmlHttp.responseText;
		var amount = document.getElementById("total_expenses_txt").value;
		total_amount_hidden =document.getElementById("total_amount_hidden").value;
		total_amount_hidden2 =document.getElementById("total_amount_hidden2").value;
		
		document.getElementById("total_amount_txt").value = total_amount_hidden2;
		document.getElementById("total_expenses_div").innerHTML ="<b>"+amount+"</b>";
		document.getElementById("expenses_div").innerHTML =amount;
		document.getElementById("total_amount_div").innerHTML ="$ "+ total_amount_hidden;
		//alert(amount);//(parseInt(amount) + parseInt(total_amount));
	}
}


function addExpenses(){
		var id = document.getElementById("payments_invoice_id").value;
		var desc = document.getElementById("expenses_description").value;
		var price = document.getElementById("expenses_price").value;
		var total_amount = document.getElementById("total_amount_txt").value;
	if(price!=""){	
		if(!isNaN(price)){
				addOtherExpenses(id,desc,price,total_amount);
		}else{
			alert("Amount you Entered is Not a Valid Number!");
			return false;
		}
	}else{
			alert("There's no amount entered !");
			return false;
	}
		
}

function addOtherExpenses(id,desc,price,total_amount)
{ 
	
	showLoading();
	xmlHttp=GetXmlHttpObject();
	if (xmlHttp==null)
  	{
	  alert ("Your browser does not support AJAX!");
	  return;
  	}
	
	var url="addExpenses.php";
	url=url+"?id="+id;
	url+="&desc="+desc;
	url+="&amount="+price;
	url+="&total_amount="+total_amount;
	
	xmlHttp.onreadystatechange=stateChanged;
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);
	//alert (url);
	//location.href = url;
}

function stateChanged() 
{ 
	if (xmlHttp.readyState==4)
	{ 
		document.getElementById("other_expenses").innerHTML=xmlHttp.responseText;
		var amount = document.getElementById("total_expenses_txt").value;
		total_amount_hidden =document.getElementById("total_amount_hidden").value;
		total_amount_hidden2 =document.getElementById("total_amount_hidden2").value;
		
		document.getElementById("total_amount_txt").value = total_amount_hidden2;
		document.getElementById("total_expenses_div").innerHTML ="<b>"+amount+"</b>";
		document.getElementById("expenses_div").innerHTML =amount;
		document.getElementById("total_amount_div").innerHTML ="$ "+ total_amount_hidden;
		//alert(amount);//(parseInt(amount) + parseInt(total_amount));
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
