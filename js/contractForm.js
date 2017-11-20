// JavaScript Document
var xmlHttp
PATH ="";

function check_val()
{
		
	var ins = document.getElementsByName('weekdays[]')
	var i;
	var j=0;
	var vals= new Array();
	for(i=0;i<ins.length;i++)
	{
		if(ins[i].checked==true) {
		vals[j]=ins[i].value;
		j++;
		}
	}
	document.form.days.value=(vals.length);
	setSalary();
	
}

function setSalary()
{
	salary = document.getElementById("salary").value;
	if(isNaN(salary)){
		alert("Not a number !");
		document.getElementById("salary").value="";
		return false;
	}
	
	var hour = document.getElementById("hour").value;
	var day = document.getElementById("days").value;
	var yearly =parseFloat(salary) *12; //12 months
	var weekly =parseFloat(yearly) / 52 ; // 52 weeks in a year
	var daily =parseFloat(weekly) / parseInt(day); // 5 days in a week
	var hourly =parseFloat(daily) / parseFloat(hour); // 
	
	//alert("setSalary() "+hour);
	
	// display the calculations in pesos
	document.getElementById("ph_peso_monthly").innerHTML=Math.round(salary*100)/100 ;
	document.getElementById("pesos_weekly").innerHTML=Math.round(weekly*100)/100 ;
	document.getElementById("pesos_daily").innerHTML=Math.round(daily*100)/100 ;
	document.getElementById("pesos_hourly").innerHTML=Math.round(hourly*100)/100 ;
	
	document.getElementById("salary_weekly").value=Math.round(weekly*100)/100 ;
	document.getElementById("salary_daily").value=Math.round(daily*100)/100 ;
	document.getElementById("salary_hourly").value=Math.round(hourly*100)/100 ;
	
	
	// Convert Pesos to Australian Dollar 
	var AUSD_Monthly = parseFloat(salary) / 38;
	var AUSD_Weekly = (parseFloat(AUSD_Monthly)*12) / 52;
	var AUSD_Daily = parseFloat(AUSD_Weekly) / parseInt(day);
	var AUSD_Hourly = parseFloat(AUSD_Daily) / parseFloat(hour);
	//Display the Calculations in AUD Dollar
	document.getElementById("dollar_monthly").innerHTML=Math.round(AUSD_Monthly*100)/100 ;
	document.getElementById("dollar_weekly").innerHTML=Math.round(AUSD_Weekly*100)/100 ;
	document.getElementById("dollar_daily").innerHTML=Math.round(AUSD_Daily*100)/100 ;
	document.getElementById("dollar_hourly").innerHTML=Math.round(AUSD_Hourly*100)/100 ;
	document.getElementById("aus_formula").innerHTML=salary + " / " + " 38.00  = " + Math.round(AUSD_Monthly*100)/100 ; 
	
	document.getElementById("dollar_monthly_hidden").value=Math.round(AUSD_Monthly*100)/100 ;
	document.getElementById("dollar_salary_weekly").value=Math.round(AUSD_Weekly*100)/100 ;
	document.getElementById("dollar_salary_daily").value=Math.round(AUSD_Daily*100)/100 ;
	document.getElementById("dollar_salary_hourly").value=Math.round(AUSD_Hourly*100)/100 ;
	
	//Convert Peso to US Dollar
	us_monthly_converted_salary = parseFloat(salary) / 45;
	us_weekly_converted_salary =  (parseFloat(us_monthly_converted_salary)*12) / 52;
	us_daily_converted_salary =  parseFloat(us_weekly_converted_salary) / parseInt(day);
	us_hourly_converted_salary = parseFloat(us_daily_converted_salary) / parseFloat(hour);
	
	document.getElementById("us_dollar_monthly").innerHTML = (Math.round(us_monthly_converted_salary*100)/100);
	document.getElementById("us_dollar_weekly").innerHTML = (Math.round(us_weekly_converted_salary*100)/100);
	document.getElementById("us_dollar_daily").innerHTML = (Math.round(us_daily_converted_salary*100)/100);
	document.getElementById("us_dollar_hourly").innerHTML = (Math.round(us_hourly_converted_salary*100)/100);
	
	document.getElementById("us_dollar_monthly_hidden").value = (Math.round(us_monthly_converted_salary*100)/100);
	document.getElementById("us_dollar_salary_weekly").value = (Math.round(us_weekly_converted_salary*100)/100);
	document.getElementById("us_dollar_salary_daily").value = (Math.round(us_daily_converted_salary*100)/100);
	document.getElementById("us_dollar_salary_hourly").value = (Math.round(us_hourly_converted_salary*100)/100);
	
	document.getElementById("us_formula").innerHTML = salary + " / 45.00  = " +  (Math.round(us_monthly_converted_salary*100)/100);
	
	//Convert Peso to UK Pounds
	uk_monthly_converted_salary = parseFloat(salary) / 72;
	uk_weekly_converted_salary =  (parseFloat(uk_monthly_converted_salary)*12) / 52;
	uk_daily_converted_salary =  parseFloat(uk_weekly_converted_salary) / parseInt(day);
	uk_hourly_converted_salary = parseFloat(uk_daily_converted_salary) / parseFloat(hour);
	
	document.getElementById("uk_pounds_monthly").innerHTML = (Math.round(uk_monthly_converted_salary*100)/100);
	document.getElementById("uk_pounds_weekly").innerHTML = (Math.round(uk_weekly_converted_salary*100)/100);
	document.getElementById("uk_pounds_daily").innerHTML = (Math.round(uk_daily_converted_salary*100)/100);
	document.getElementById("uk_pounds_hourly").innerHTML = (Math.round(uk_hourly_converted_salary*100)/100);
	
	document.getElementById("uk_pounds_monthly_hidden").value = (Math.round(uk_monthly_converted_salary*100)/100);
	document.getElementById("uk_pounds_salary_weekly").value = (Math.round(uk_weekly_converted_salary*100)/100);
	document.getElementById("uk_pounds_salary_daily").value = (Math.round(uk_daily_converted_salary*100)/100);
	document.getElementById("uk_pounds_salary_hourly").value = (Math.round(uk_hourly_converted_salary*100)/100);
	
	document.getElementById("uk_formula").innerHTML = salary + " / 72.00 = " +  (Math.round(uk_monthly_converted_salary*100)/100);
	
	calculateChargeOutRate();
	setFreelancerCalculation();
	
	
}

function setFreelancerCalculation(){
	/*
	salary = document.getElementById("salary").value;
	day = 5;
	hour = 8;
	// Convert Pesos to Australian Dollar 
	var AUSD_Monthly = parseFloat(salary) / 38;
	var AUSD_Weekly = (parseFloat(AUSD_Monthly)*12) / 52;
	var AUSD_Daily = parseFloat(AUSD_Weekly) / parseInt(day);
	var AUSD_Hourly = parseFloat(AUSD_Daily) / parseFloat(hour);
	
	document.getElementById("aud_prepaid_div").innerHTML= (Math.round(AUSD_Hourly*100)/100);
	//Convert Peso to US Dollar
	us_monthly_converted_salary = parseFloat(salary) / 45;
	us_weekly_converted_salary =  (parseFloat(us_monthly_converted_salary)*12) / 52;
	us_daily_converted_salary =  parseFloat(us_weekly_converted_salary) / parseInt(day);
	us_hourly_converted_salary = parseFloat(us_daily_converted_salary) / parseFloat(hour);
	
	document.getElementById("usd_prepaid_div").innerHTML= (Math.round(us_hourly_converted_salary*100)/100);
	
	//Convert Peso to UK Pounds
	uk_monthly_converted_salary = parseFloat(salary) / 82;
	uk_weekly_converted_salary =  (parseFloat(uk_monthly_converted_salary)*12) / 52;
	uk_daily_converted_salary =  parseFloat(uk_weekly_converted_salary) / parseInt(day);
	uk_hourly_converted_salary = parseFloat(uk_daily_converted_salary) / parseFloat(hour);
	
	document.getElementById("uk_prepaid_div").innerHTML= (Math.round(uk_hourly_converted_salary*100)/100);
	
	*/
	
	
	
	
}


function calculateChargeOutRate() { 
	currency =  document.getElementById("currency_rate").value;
	rate = document.getElementById("current_rate").value;
	client_price = document.getElementById("hiddenprice").value;
	salary = document.getElementById("salary").value;
	gst = document.getElementById("gst").value;
	//alert(currency_rate);
	fix_rate = 0
	if(currency == "AUD"){
		fix_rate = '38.00';
		document.getElementById("charge_out_rate_details").style.display = "block";
		document.getElementById("aud_tax_div").style.display = "block";
		document.getElementById("currency_quote_txt").innerHTML = "The Quote is in Autralian Dollar currency rate";
		
	}
	if(currency == "USD"){
		fix_rate = '45.00';
		document.getElementById("charge_out_rate_details").style.display = "block";
		document.getElementById("aud_tax_div").style.display = "none";
		document.getElementById("currency_quote_txt").innerHTML = "The Quote is in US Dollar currency rate";
	}
	if(currency == "POUND"){
		fix_rate = '72.00';
		document.getElementById("charge_out_rate_details").style.display = "block";
		document.getElementById("aud_tax_div").style.display = "none";
		document.getElementById("currency_quote_txt").innerHTML = "The Quote is in United Kindom Pound";
	}
	if(currency == ""){
		document.getElementById("charge_out_rate_details").style.display = "none";
		document.getElementById("aud_tax_div").style.display = "none";
		document.getElementById("total_difference").innerHTML = "";
		document.getElementById("hiddenprice2").value=(Math.round((parseFloat(client_price))*100)/100);
		document.getElementById("hiddenprice3").value=(Math.round((parseFloat(client_price))*100)/100);
		document.getElementById("difference").value="";
		document.getElementById("currency_quote_txt").innerHTML = "";
		return false;
	}
	
	document.getElementById("dollar").value = fix_rate;

	fix_rate_salary = salary / fix_rate ;
	today_rate_salary =  (parseFloat(salary)) / parseInt(rate);
	
	if(rate!=""){
		difference = (parseFloat(today_rate_salary) - parseFloat(fix_rate_salary));
	}else{
		difference =0;
	}
	
	

	if(currency == "AUD" && gst == "YES"){
		tax = (client_price * .10);
		tax_str = "With 10% GST $ " + (Math.round(tax*100)/100);
	}else{
		tax = 0;
		tax_str="";
	}
	
	
	//alert(tax);
	//if (!isNaN(difference)) {
	
document.getElementById("total_difference").innerHTML ="<p>Currency Difference : plus(+)<b>$ "+ (Math.round(difference*100)/100) + "</b> &nbsp;<small> @&nbsp;(P "+ salary +" / $ "+ rate + ") &nbsp;"+ tax_str +"</small> " +"</p>";
	
	document.getElementById("difference").value = (Math.round(difference*100)/100);
	document.getElementById("hiddenprice2").value = (Math.round((parseFloat(difference) + parseFloat(client_price) + tax)*100)/100);
	document.getElementById("hiddenprice3").value = (Math.round((parseFloat(difference) + parseFloat(client_price) + tax)*100)/100);
	
	
	//}else{
	//	document.getElementById("total_difference").innerHTML = "";
		//document.getElementById("client_price").value = document.getElementById("hiddenprice").value;
	//	document.getElementById("hiddenprice2").value=(Math.round((parseFloat(client_price))*100)/100);
	//	document.getElementById("hiddenprice3").value=(Math.round((parseFloat(client_price))*100)/100);
	//	document.getElementById("difference").value="";
		
	//}
	
}

function setCopy(amount){

	if(isNaN(amount)){
		alert("Not a number !");
		document.getElementById("client_price").value="";
		return false;
	}
		
	//document.getElementById("current_rate").value ="";
	document.getElementById("hiddenprice").value = amount;
	document.getElementById("hiddenprice2").value = amount;
	document.getElementById("hiddenprice3").value = amount;
	document.getElementById("total_difference").innerHTML = "";
	
	
	calculateChargeOutRate();
	//showClientChargeOutRateInMultipleCurrency();
	setCommission();
}
function showClientChargeOutRateInMultipleCurrency(){
	currency =  document.getElementById("currency_rate").value;
	client_price = document.getElementById("client_price").value
	hour = document.getElementById("hour").value;
	day = document.getElementById("days").value;
	document.getElementById("showClientChargeOutRateInMultipleCurrency").style.display="block";
	
	if(currency!=""){
		
		yearly = client_price * 12 ;
		monthly = client_price;
		weekly = yearly / 52;
		daily = weekly / day;
		hourly = daily / hour;
		
		
		// Display the Charge out rate conversion in multiple currencies
		document.getElementById("currency_charge_out_yearly").innerHTML = (Math.round(yearly*100)/100);
		document.getElementById("currency_charge_out_monhtly").innerHTML = (Math.round(monthly*100)/100);
		document.getElementById("currency_charge_out_weekly").innerHTML = (Math.round(weekly*100)/100);
		document.getElementById("currency_charge_out_daily").innerHTML = (Math.round(daily*100)/100);
		document.getElementById("currency_charge_out_hourly").innerHTML = (Math.round(hourly*100)/100);
		document.getElementById("currency_charge_out_txt").innerHTML=currency;
	}
	
	
		
		
	
	//
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

function setTimezone(tz){
	//alert(tz);
	//if(tz!=""){
		document.getElementById("tz_txt").innerHTML = tz;
		document.getElementById("tz_box_hour").style.display="block";
	//}
/*
	if(tz=="AU")
	{
		document.getElementById("tz_txt").innerHTML = tz;
		document.getElementById("tz_box_hour").style.display="block";
		//document.getElementById("staff_tz").style.display="block";
	}
	else if(tz=="US")
	{
		document.getElementById("tz_txt").innerHTML = "Unitesd States Time";
		document.getElementById("tz_box_hour").style.display="block";
		//document.getElementById("staff_tz").style.display="block";
	}
	else if(tz=="UK")
	{
		document.getElementById("tz_txt").innerHTML = "United Kingdom London Time";
		document.getElementById("tz_box_hour").style.display="block";
		//document.getElementById("staff_tz").style.display="block";
	}
	else{
		document.getElementById("tz_txt").innerHTML = "";
		document.getElementById("tz_box_hour").style.display="none";
		//document.getElementById("staff_tz").style.display="none";
	}
*/
}
function setLunchHour(){
	//lunch_start = document.getElementById("lunch_start").value;
	//lunch_out = document.getElementById("lunch_out").value;
	
	//if(lunch_start!="" && lunch_out!=""){
	//	lunch_hour = (lunch_out - lunch_start);	
	//	document.getElementById("lunch_hour").value = lunch_hour;
		//setTimeZoneHour();
	//}
	//setWorkHour();

	
}

function setWorkHour(){
	var start =document.getElementById("start").value;
	var out =document.getElementById("out").value;
	
	//alert(out);
	var lunch_start = document.getElementById("lunch_start").value;
	var lunch_out = document.getElementById("lunch_out").value;
	
	start = start.replace(/:30/g, ".5");
	out = out.replace(/:30/g, ".5");
	
	//alert(start);
	lunch_start = lunch_start.replace(/:30/g, ".5");
	lunch_out = lunch_out.replace(/:30/g, ".5");
	
	
	lunch_hour = (lunch_out - lunch_start);	
	total_hours = (out - start);	
	
	//alert(lunch_start+"\n"+lunch_out);
	if(total_hours < 0){

		total_hours = total_hours + 24 ;
	}
	if(lunch_hour < 0){
		lunch_hour = lunch_hour + 24;	
	}
	
	


	
	//alert(lunch_hour);
	document.getElementById("lunch_hour").value = lunch_hour;
	document.getElementById("hour").value = total_hours- lunch_hour;

	
	setSalary();
}
function setTimeZoneHourForClient(){
	client_timezone = document.getElementById("client_timezone").value;
	staff_start_work_hour = document.getElementById("start").value;
	staff_finish_work_hour = document.getElementById("out").value;
	
	
	if(client_timezone!="" && staff_start_work_hour!="" && staff_finish_work_hour!="") {
		//alert(client_timezone+" "+staff_start_work_hour + " " +staff_finish_work_hour);
		
		xmlHttp=GetXmlHttpObject();
		if (xmlHttp==null)
		{
		  alert ("Your browser does not support AJAX!");
		  return;
		}
		var url=PATH+"convertTimeZoneForClient.php";
		url=url+"?staff_start_work_hour="+staff_start_work_hour;
		url=url+"&staff_finish_work_hour="+staff_finish_work_hour;
		url=url+"&client_timezone="+client_timezone;
		url=url+"&ran="+Math.random();
		xmlHttp.onreadystatechange=onSuccessConfigureTimeZoneForClient;
		xmlHttp.open("GET",url,true);
		xmlHttp.send(null);
		
	}
	
}
function onSuccessConfigureTimeZoneForClient(){
	if (xmlHttp.readyState==4)
	{ 
		document.getElementById("client_tz").innerHTML=xmlHttp.responseText;
		setSalary();
	}
}
function setTimeZoneHour(){
	client_start_work_hour = document.getElementById("client_start_work_hour").value;
	client_finish_work_hour = document.getElementById("client_finish_work_hour").value;
	client_timezone = document.getElementById("client_timezone").value;
	
	lunch_hour = document.getElementById("lunch_hour").value
	
	// calculate working hours
	hour = (client_finish_work_hour - client_start_work_hour);
	document.getElementById("hour").value = hour;
	
	if(client_timezone!="" && client_start_work_hour!="" && client_finish_work_hour!="") {
		xmlHttp=GetXmlHttpObject();
		if (xmlHttp==null)
		{
		  alert ("Your browser does not support AJAX!");
		  return;
		}
		var url=PATH+"convertTimeZone.php";
		url=url+"?client_start_work_hour="+client_start_work_hour;
		url=url+"&client_finish_work_hour="+client_finish_work_hour;
		url=url+"&client_timezone="+client_timezone;
		url=url+"&lunch_hour="+lunch_hour;
		url=url+"&ran="+Math.random();
		xmlHttp.onreadystatechange=onSuccessConfigureTimeZone;
		xmlHttp.open("GET",url,true);
		xmlHttp.send(null);
	}


}
function onSuccessConfigureTimeZone(){
	if (xmlHttp.readyState==4)
	{ 
		document.getElementById("staff_tz").innerHTML=xmlHttp.responseText;
		setWorkHour();
		setSalary();
		
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
