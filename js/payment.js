/* 
This code use by editcontract.php : Admin Section 
Created on Nov. 10, 2008
Normaneil Macutay
*/
var xmlHttp
PATH ="";



function showContractDetails(sid,client_id){
	userid = document.getElementById("userid").value;
	document.getElementById("contract_details").innerHTML="Loading...";
	xmlHttp=GetXmlHttpObject();
	if (xmlHttp==null)
  	{
	  alert ("Your browser does not support AJAX!");
	  return;
  	}
	var url=PATH+"getSubConContract.php";
	url=url+"?sid="+sid;
	url=url+"&userid="+userid;
	url=url+"&lid="+client_id;
	url=url+"&ran="+Math.random();
	xmlHttp.onreadystatechange=onSuccessShowSubConContract;
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);
}
function onSuccessShowSubConContract(){
	if (xmlHttp.readyState==4)
	{ 
		document.getElementById("contract_details").innerHTML=xmlHttp.responseText;
	}
}
function gotoEditContractForm(sid,client_id){
	userid = document.getElementById("userid").value;
	//sid = document.getElementById("sid").value;
	//client_id = document.getElementById("leads_id").value;
	//&sid=138&pid=0&lid=82
	//if(userid=="" && sid =="" && client_id ==""){
	//	alert("Error Please try again!");
	//	return false;
	//}
	location.href = "contractForm.php?userid="+userid+"&sid="+sid+"&lid="+client_id;
	//alert(sid);
}



function highlight(obj) {
   obj.style.backgroundColor='yellow';
   obj.style.cursor='pointer';

}

function unhighlight(obj) {
   obj.style.backgroundColor='';
   obj.style.cursor='default';
}


function setSalary(salary)
{
	
	// Check if the entered amount is a valid number!
	
	if(isNaN(salary)){
		alert("Not a number !");
		document.getElementById("salary").value="";;
		return false;
	}else {
	
	//var agentPercent = .35;
	//var companyPercent;
	//if (salary >=26000){
	//	companyPercent =.50;
	//}
	//else
	//{
	//	companyPercent =.65;
	//}
	//var comm= parseFloat(salary) * .35 ;
	//var comm2= parseFloat(salary) * companyPercent ;
	
	// Get data
	//var hour = document.getElementById("hour").value;
	var hour = checkTime();
	var day = document.getElementById("days").value;
	var yearly =parseFloat(salary) *12; //12 months
	var weekly =parseFloat(yearly) / 52 ; // 52 weeks in a year
	var daily =parseFloat(weekly) / parseInt(day); // 5 days in a week
	var hourly =parseFloat(daily) / parseFloat(hour); // 
	
	//document.getElementById("client_price").disabled="";
	//document.getElementById("current_rate").disabled="";
	document.getElementById("show_other_currency").disabled="";
	//
	//Display the Calculations in Pesos
	document.getElementById("pesos_weekly").innerHTML=Math.round(weekly*100)/100 ;
	document.getElementById("pesos_daily").innerHTML=Math.round(daily*100)/100 ;
	document.getElementById("pesos_hourly").innerHTML=Math.round(hourly*100)/100 ;
	
	document.getElementById("salary_weekly").value=Math.round(weekly*100)/100 ;
	document.getElementById("salary_daily").value=Math.round(daily*100)/100 ;
	document.getElementById("salary_hourly").value=Math.round(hourly*100)/100 ;
	
	// Convert Pesos to Australian Dollar 
	var AUSD_Monthly = parseFloat(salary) / parseFloat(document.getElementById("dollar").value);//39; //Formula : $1 AUSD * 39 Pesos
	var AUSD_Weekly = (parseFloat(AUSD_Monthly)*12) / 52;
	var AUSD_Daily =parseFloat(AUSD_Weekly) / parseInt(day);
	var AUSD_Hourly =parseFloat(AUSD_Daily) / parseFloat(hour);
	///
	
	checkOtherCountryRate();
	
	//Display the Calculations in AUD Dollar
	document.getElementById("dollar_monthly").innerHTML=Math.round(AUSD_Monthly*100)/100 ;
	document.getElementById("dollar_monthly_hidden").value=Math.round(AUSD_Monthly*100)/100 ;
	document.getElementById("dollar_weekly").innerHTML=Math.round(AUSD_Weekly*100)/100 ;
	document.getElementById("dollar_daily").innerHTML=Math.round(AUSD_Daily*100)/100 ;
	document.getElementById("dollar_hourly").innerHTML=Math.round(AUSD_Hourly*100)/100 ;
	
	document.getElementById("aus_formula").innerHTML=salary + " / " + " 38.00  = " + Math.round(AUSD_Monthly*100)/100 ; 
	
	//dollar_salary_weekly
	document.getElementById("dollar_salary_weekly").value=Math.round(AUSD_Weekly*100)/100 ;
	document.getElementById("dollar_salary_daily").value=Math.round(AUSD_Daily*100)/100 ;
	document.getElementById("dollar_salary_hourly").value=Math.round(AUSD_Hourly*100)/100 ;
	
	//Calculate commissions
	//var comm= parseFloat(AUSD_Monthly) * .35 ;
	//var comm2= parseFloat(AUSD_Monthly) * companyPercent ;
	//var charge_rate =parseFloat(AUSD_Monthly) + parseInt(comm) + parseInt(comm2);
	//var client_charge_rate = checkTax(charge_rate);
	//Display Charge to Client
	//document.getElementById("client_price").value = Math.round(client_charge_rate*100)/100 ;//Math.round(client_charge_rate*100)/100 ;
	//document.getElementById("hiddenprice").value = client_charge_rate ;
	//document.getElementById("hiddenprice2").value = client_charge_rate ;
	//Display Commissions
	//document.getElementById("agent_com").innerHTML=Math.round(comm*100)/100 ;
	//document.getElementById("think_com").innerHTML=Math.round((comm + comm2)*100)/100 ;
	//document.getElementById("agent_commission").value=Math.round(comm*100)/100 ;
	//document.getElementById("think_commission").value=Math.round(comm2*100)/100 ;
	
	
	//Delete previous conversion of today's current rate
	/*
	document.getElementById("total_difference").innerHTML = "";
	document.getElementById("client_price").value = "";
	document.getElementById("current_rate").value="";
	document.getElementById("hiddenprice").value="";
	document.getElementById("hiddenprice2").value="";
	document.getElementById("difference").value="";
	document.getElementById("tax_formula").innerHTML ="";
	document.getElementById("gst").checked = false;
	*/
	}
	
}

function checkTax(amount){
   var gst = document.getElementById("gst");
  	   if(gst.checked == true)
   		{
			 gst = parseInt(amount) * .10;
			 amount = parseInt(amount) + gst;
	 		 return amount;
   		}else{
	 		return amount;
   		}
  
}

function setTax(amount,flag){
   var gst = document.getElementById("gst");
   //document.getElementById("hiddenprice2").value = amount;
   if(gst.checked == true)
   {
	 	gst = parseInt(amount) * .10;
		total_amount = parseInt(amount) + (Math.round(gst*100)/100);
		document.getElementById("hiddenprice2").value= total_amount;
		document.getElementById("tax").value = (Math.round(gst*100)/100);
		//document.getElementById("tax_formula").innerHTML = amount +" + "+ (Math.round(gst*100)/100) + " = " + total_amount;
		document.getElementById("tax_formula").innerHTML = "<label>Plus (+) 10% GST </label>" + "<span> $ " + (Math.round(gst*100)/100) + "</span>";
		//alert(amount);
	
   }else{
	 //return flag;
	 //alert(amount);
	
	 document.getElementById("hiddenprice2").value = amount;//returnAmount(amount,flag);
	 document.getElementById("tax_formula").innerHTML ="";
	 document.getElementById("tax").value ="";
	 //document.getElementById("hiddenprice2").value = document.getElementById("hiddenprice").value;
	 
   }
   
   //setCommission();
}

function returnAmount(amount,flag){
	if(flag=="false"){
		if(document.getElementById("hiddenprice2").value!="") {
			amount = document.getElementById("hiddenprice2").value;
			return amount;
		}
		if(document.getElementById("hiddenprice2").value ==""){
			amount = document.getElementById("hiddenprice").value;
			return amount;
		}
	}
	if(flag=="true"){
		amount = document.getElementById("hiddenprice3").value;
		return amount;
	
	}
}



function calculateCurrentRate(rate,flag)
{
			
	
			document.getElementById("gst").checked ="";
			if(flag=="true"){
			document.getElementById("tax_formula").innerHTML ="";
			}
			var client_price = document.getElementById("hiddenprice").value;
			var salary = document.getElementById("salary").value;
			var today_rate_salary =  (parseFloat(salary)) / parseInt(rate);
			var dollar_monthly = document.getElementById("dollar_monthly_hidden").value;
			difference = (parseFloat(today_rate_salary) - parseFloat(dollar_monthly)) ;
		
			if (!isNaN(difference)) {
			/*	
			document.getElementById("total_difference").innerHTML = " &nbsp; <b>"+ salary + " / " + rate + " = " + (Math.round(today_rate_salary*100)/100) + "</b><br> - " + salary + " / " + " 38.00  = " + (Math.round(dollar_monthly*100)/100) + "<br>&nbsp;&nbsp;-----------------<br>" + (Math.round(difference*100)/100) + " + " +(Math.round(client_price*100)/100)  + " = " + (Math.round((parseFloat(difference) + parseFloat(client_price))*100)/100);
			*/
		document.getElementById("total_difference").innerHTML ="<p><label>Currency Difference : plus(+)</label> <b>$ "+ (Math.round(difference*100)/100) + "</b> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<small> @&nbsp;(P "+ salary +" / $ "+ rate+ ")</small> " +"</p>";
			
			document.getElementById("difference").value = (Math.round(difference*100)/100);
			//document.getElementById("client_price").value = (Math.round((parseFloat(difference) + parseFloat(client_price))*100)/100);
			document.getElementById("hiddenprice2").value = (Math.round((parseFloat(difference) + parseFloat(client_price))*100)/100);
			document.getElementById("hiddenprice3").value = (Math.round((parseFloat(difference) + parseFloat(client_price))*100)/100);
			
			
			}else{
				document.getElementById("total_difference").innerHTML = "";
				//document.getElementById("client_price").value = document.getElementById("hiddenprice").value;
				document.getElementById("hiddenprice2").value=(Math.round((parseFloat(client_price))*100)/100);
				document.getElementById("hiddenprice3").value=(Math.round((parseFloat(client_price))*100)/100);
				document.getElementById("difference").value="";
			
			}
		
		setCommission();
	
}


function setBPCommission(str)
{
		//alert(str);
		comm = document.getElementById("agent_commission").value;
		comm2= document.getElementById("think_commission").value;
		if(str == "YES") {
			
			document.getElementById("agent_com").innerHTML=Math.round(comm*100)/100 ;
	    	document.getElementById("think_com").innerHTML=Math.round(comm2*100)/100 ;
		}
		if(str == "NO") {
			
			document.getElementById("agent_com").innerHTML="&nbsp;";
	    	document.getElementById("think_com").innerHTML=Math.round((parseFloat(comm)+parseFloat(comm2))*100)/100 ;
		}
}
function checkTime(){
	var lunch_start =document.getElementById("lunch_start").value;
	var lunch_out =document.getElementById("lunch_out").value;
	
	var start =document.getElementById("start").value;
	var out =document.getElementById("out").value;
	
	lunch_hour = (lunch_out - lunch_start);
	work_hour = (out - start);
	total_time = (work_hour - lunch_hour);
	return total_time;
}

function setHourDay(amount){
	if(amount != "" || amount !=null)
	{
			setSalary(amount);
			//alert(amount);
	}
}


function setWorkHour(amount){
	//alert(amount);
	var start =document.getElementById("start").value;
	var out =document.getElementById("out").value;
	var lunch_hour = document.getElementById("lunch_hour").value
	
	document.getElementById("hour").value = ((out - start) - lunch_hour);
	setSalary(amount);
}

function setLunchHour(amount){
	var lunch_start =document.getElementById("lunch_start").value;
	var lunch_out =document.getElementById("lunch_out").value;
	
	lunch_hour = (lunch_out - lunch_start);
	document.getElementById("lunch_hour").value = lunch_hour;
	
	
	var start =document.getElementById("start").value;
	var out =document.getElementById("out").value;
	work_hour = ((out - start)-lunch_hour);
	//alert(work_hour);
	document.getElementById("hour").value = work_hour;
	if(document.getElementById("salary").value != "")
	{
		setSalary(amount);
	}
}

function setCopy(amount,flag){
	
	
	if(document.getElementById("salary").value!=""){
		if(isNaN(amount)){
			alert("Not a number !");
			document.getElementById("client_price").value="";
			return false;
		}else {
			document.getElementById("current_rate").value ="";
			document.getElementById("hiddenprice").value = amount;
			document.getElementById("hiddenprice2").value = amount;
			document.getElementById("hiddenprice3").value = amount;
			document.getElementById("gst").disabled="";
			document.getElementById("gst").checked ="";
			document.getElementById("total_difference").innerHTML = "";
			
			//if(flag=='true'){
			//	document.getElementById("current_rate").value ="";
			//	document.getElementById("tax_formula").innerHTML ="";
			//	document.getElementById("hiddenprice2").value ="";
			//}
			//document.getElementById("hiddenprice2").value ="";
			monthly = amount;
			yearly = (monthly * 12);
			weekly = (yearly / 52);
			daily  = (weekly / 5 );
			hourly = (daily / 8);
			quote = document.getElementById("client_payment_rate");
			//quote.style.display ="block";
			//document.getElementById("client_payment_rate").innerHTML ="Yearly $" + yearly + "<br> Monthly $"+ monthly + "<br> Weekly $ " + weekly + "<br> Daily $ "+ daily + "<br>Hourly $ "+ hourly;
			
			setCommission();
			
		}
	}else{
			alert("Please enter a Salary First !")
			return false;
	}
}

function setCommission(){
	
	document.getElementById("think_com").innerHTML = 0;
	document.getElementById("think_commission").value =0;
	document.getElementById("agent_com").innerHTML = 0;
	document.getElementById("agent_commission").value =0;
	
	activate_agent_commission = document.getElementById("activate_agent_commission").value;
	amount = document.getElementById("hiddenprice2").value;
	monthly_hidden = document.getElementById("dollar_monthly_hidden").value;
	total =0;
	company_total_commission = 0;
	agent_commission = 0;
	
if(document.getElementById("client_price").value!=""){
	if(activate_agent_commission == "NO"){
		company_total_commission = (amount - monthly_hidden);
		
	}
	if(activate_agent_commission == "YES"){
		total = (amount - monthly_hidden); 
		agent_commission = (parseFloat(total) * .35);
		company_total_commission = (total - agent_commission);
	}
}
	
	//alert(activate_agent_commission);
	document.getElementById("think_com").innerHTML = "$ "+(Math.round((parseFloat(company_total_commission))*100)/100);
	document.getElementById("think_commission").value =(Math.round((parseFloat(company_total_commission))*100)/100);
	document.getElementById("agent_com").innerHTML = "$ "+(Math.round((parseFloat(agent_commission))*100)/100);
	document.getElementById("agent_commission").value = (Math.round((parseFloat(agent_commission))*100)/100);
	
	
}

function checkOtherCountryRate()
{
		if(document.getElementById("us_rate").value !="")
		{
				country = "US";
				rate = document.getElementById("us_rate").value;
				setOtherRate(country,rate);
		}
		if(document.getElementById("uk_rate").value !="")
		{
				country = "UK";
				rate = document.getElementById("uk_rate").value;
				setOtherRate(country,rate);
		}
		
}
function setOtherRate(country,rate){
		
		if(isNaN(rate)){
				alert(country +" rate not a number !");
				if(country == "US"){
					document.getElementById("us_rate").value ="";
				}
				if(country == "UK"){
					document.getElementById("uk_rate").value ="";
				}
		}else{
				if(rate!=""){
				// convert the salary
				salary  = document.getElementById("salary").value;
				day = document.getElementById("days").value;
				hour = checkTime();
				
				monthly_converted_salary = parseFloat(salary) / parseFloat(rate);
				weekly_converted_salary = (parseFloat(monthly_converted_salary)*12) / 52;
				daily_converted_salary =  parseFloat(weekly_converted_salary) / parseInt(day);
				hourly_converted_salary = parseFloat(daily_converted_salary) / parseInt(hour);
				
				if(country == "US")
				{
						document.getElementById("us_dollar_monthly").innerHTML = (Math.round(monthly_converted_salary*100)/100);
						document.getElementById("us_dollar_weekly").innerHTML = (Math.round(weekly_converted_salary*100)/100);
						document.getElementById("us_dollar_daily").innerHTML = (Math.round(daily_converted_salary*100)/100);
						document.getElementById("us_dollar_hourly").innerHTML = (Math.round(hourly_converted_salary*100)/100);
						
						document.getElementById("us_dollar_monthly_hidden").value = (Math.round(monthly_converted_salary*100)/100);
						document.getElementById("us_dollar_salary_weekly").value = (Math.round(weekly_converted_salary*100)/100);
						document.getElementById("us_dollar_salary_daily").value = (Math.round(daily_converted_salary*100)/100);
						document.getElementById("us_dollar_salary_hourly").value = (Math.round(hourly_converted_salary*100)/100);
						
						document.getElementById("us_formula").innerHTML = salary + " / " + rate + " = " +  (Math.round(monthly_converted_salary*100)/100);
				}
				if(country == "UK")
				{
						document.getElementById("uk_pounds_monthly").innerHTML = (Math.round(monthly_converted_salary*100)/100);
						document.getElementById("uk_pounds_weekly").innerHTML = (Math.round(weekly_converted_salary*100)/100);
						document.getElementById("uk_pounds_daily").innerHTML = (Math.round(daily_converted_salary*100)/100);
						document.getElementById("uk_pounds_hourly").innerHTML = (Math.round(hourly_converted_salary*100)/100);
						
						document.getElementById("uk_pounds_monthly_hidden").value = (Math.round(monthly_converted_salary*100)/100);
						document.getElementById("uk_pounds_salary_weekly").value = (Math.round(weekly_converted_salary*100)/100);
						document.getElementById("uk_pounds_salary_daily").value = (Math.round(daily_converted_salary*100)/100);
						document.getElementById("uk_pounds_salary_hourly").value = (Math.round(hourly_converted_salary*100)/100);
						
						document.getElementById("uk_formula").innerHTML = salary + " / " + rate + " = " +  (Math.round(monthly_converted_salary*100)/100);
				}
				}else{
						if(country == "US")
						{
							document.getElementById("us_dollar_monthly").innerHTML = "0.00";
							document.getElementById("us_dollar_weekly").innerHTML = "0.00";
							document.getElementById("us_dollar_daily").innerHTML = "0.00";
							document.getElementById("us_dollar_hourly").innerHTML = "0.00";
							
							document.getElementById("us_dollar_monthly_hidden").value = "";
							document.getElementById("us_dollar_salary_weekly").value = "";
							document.getElementById("us_dollar_salary_daily").value = "";
							document.getElementById("us_dollar_salary_hourly").value = "";
							
							document.getElementById("us_formula").innerHTML="";
						}
						if(country == "UK")
						{
							document.getElementById("uk_pounds_monthly").innerHTML ="0.00";
							document.getElementById("uk_pounds_weekly").innerHTML = "0.00";
							document.getElementById("uk_pounds_daily").innerHTML = "0.00";
							document.getElementById("uk_pounds_hourly").innerHTML = "0.00";
							
							document.getElementById("uk_pounds_monthly_hidden").value = "";
							document.getElementById("uk_pounds_salary_weekly").value = "";
							document.getElementById("uk_pounds_salary_daily").value = "";
							document.getElementById("uk_pounds_salary_hourly").value = "";
							
							document.getElementById("uk_formula").innerHTML="";
						}
				}
				
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