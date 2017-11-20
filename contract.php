<?
include 'config.php';
include 'conf.php';
include 'time.php';
include 'function.php';
include 'time.php';

$AusTime = date("H:i:s"); 
$AusDate = date("Y")."-".date("m")."-".date("d");
$ATZ = $AusDate." ".$AusTime;



$admin_id = $_SESSION['admin_id'];
$admin_status=$_SESSION['status'];

$agent_no =$_REQUEST['agent_no'];

//echo $agent_no;

$leads_id=$_REQUEST['leads_id'];
$posting_id=$_REQUEST['posting_id'];
$userid=$_REQUEST['userid'];
$aid=$_REQUEST['aid'];

$folder=$_REQUEST['folder'];



if(isset($_POST['move']))
{
	$query="UPDATE applicants SET  status='".$folder."' WHERE id = $aid;";
	mysql_query($query)or trigger_error("Query: $query\n<br />MySQL Error: " . mysql_error());	
	header("location:adminrecruitment.php?pid=$posting_id&id=$leads_id&stat=$folder");	
}
if(isset($_POST['process']))
{
/*

userid, lname, fname, byear, bmonth, bday, auth_no_type_id, msia_new_ic_no, gender, nationality, permanent_residence, email, pass, alt_email, handphone_country_code, handphone_no, tel_area_code, tel_no, address1, address2, postcode, country_id, state, city, msn_id, yahoo_id, icq_id, skype_id, image, datecreated, dateupdated, status, home_working_environment, internet_connection, isp, computer_hardware, headset_quality

id, agent_id, lead_id, date_created, outsourcing_model, companyname, jobposition, jobvacancy_no, skill, responsibility, status, heading

*/
$query="SELECT a.id,u.userid, u.fname, u.lname,DATE_FORMAT(a.date_apply,'%D %M %Y'),u.nationality,e.educationallevel,e.fieldstudy,u.email,u.skype_id,image,companyname,jobposition,l.fname,l.lname
		FROM personal u JOIN applicants a ON a.userid = u.userid 
		JOIN posting p ON a.posting_id = p.id 
		JOIN education e ON e.userid = u.userid
		JOIN leads l ON l.id = p.lead_id
		WHERE a.posting_id =$posting_id AND p.lead_id = $leads_id AND u.userid =$userid ORDER BY a.date_apply DESC;";
//echo $query;
$result=mysql_query($query);
list($aid,$userid,$fname,$lname,$date,$nationality,$educationallevel,$fieldstudy,$email,$skype,$image,$companyname,$jobposition,$lead_fname,$lead_lname) = mysql_fetch_array($result);

if($image=="")
{
$image="images/Client.png";
}
	 
		 


?>
<html>
<head>
<title>Sub-Contractors Details</title>
<link rel=stylesheet type=text/css href="css/font.css">
<link rel=stylesheet type=text/css href="adminmenu.css">

<script type="text/javascript" src="js/calendar.js"></script> 
<script type="text/javascript" src="lang/calendar-en.js"></script> 
<script type="text/javascript" src="js/calendar-setup.js"></script>
<link rel="stylesheet" type="text/css" media="all" href="css/calendar-blue.css" title="win2k-1" />

<script type="text/javascript">
<!--
function checkFields()
{
	var month = document.getElementById("salary_month").value;
	if(month=="0" || month=="")
	{
		alert("Please enter a Salary Amount!");
		return false;
	}
	return true;
}
function setSalary()
{
	
	
	//document.getElementById("hour").value=parseInt(end) - parseInt(start);
	
	var hour = document.getElementById("hour").value;
	var day = document.getElementById("days").value;
	var month = document.getElementById("salary_month").value;
	var month2 = document.getElementById("salary_month2").value;
	//var gst =document.getElementById("gst").value;
	var tax = 0;
	//////////// Convert Australian Dollar to Philippine Pesos /////////
	var Php_Monthly = parseFloat(month) * parseFloat(document.getElementById("dollar").value);//39; //Formula : $1 AUSD * 39 Pesos
	var Php_Weekly =(parseFloat(Php_Monthly) * 12) / 52;
	var Php_Daily =parseFloat(Php_Weekly) / parseInt(day); // 5 days in a week
	var Php_Hourly =parseFloat(Php_Daily) / parseFloat(hour); // 8.5 working hours
	
	////NEW FORMULA
	//var Php_Monthly = parseFloat(month) * parseFloat(document.getElementById("dollar").value);//39; //Formula : $1 AUSD * 39 Pesos
	//var Php_Yearly = parseFloat(Php_Monthly) * 12; //12 months
	//var Php_Daily =parseFloat(Php_Yearly) / 275; //working days;
	//var Php_Hourly =parseFloat(Php_Daily) / parseFloat(hour); // 8.5 (30 mins lunch deducted)
	//var Php_Weekly = parseFloat(Php_Daily) * 5; //working days a week
	
	////////////////
	
	var companyPercent;
	if (Php_Monthly >=26000){
		companyPercent =.50;
	}
	else
	{
		companyPercent =.65;
	}
	//alert(companyPercent);
	var comm= parseFloat(month) * .35 ;
	var comm2= parseFloat(month) * companyPercent;
	
	
	var yearly =parseFloat(month) *12; //12 months
	var weekly =parseFloat(yearly) / 52 ; // 52 weeks in a year
	var daily =parseFloat(weekly) / parseInt(day); // 5 days in a week
	var hourly =parseFloat(daily) / parseFloat(hour); // 8.5 working hours
	
	/////NEW FORMULA
	//var yearly =parseFloat(month) * 12 ;//months
	//var daily = parseFloat(yearly) / 275; //working days
	//var hourly = parseFloat(daily) / parseFloat(hour); // 8.5 (30 mins lunch deducted)
	//var weekly = parseFloat(daily) * 5; //working days a week
	////////////////
	
	//if(document.getElementById("gst").checked==true)
	//{
	//	tax = parseInt(month) * (gst);
	//}
	//client_charge // clien_price
	//alert(tax);
	document.getElementById("client_charge").innerHTML="CHARGE TO CLIENT $AUD "+Math.round((parseFloat(month)+parseFloat(comm)+parseFloat(comm2))*100)/100 ;
	document.getElementById("client_price").value=Math.round((parseFloat(month)+parseFloat(comm)+parseFloat(comm2))*100)/100 ;
	//document.getElementById("hiddenprice").value=Math.round((parseFloat(Php_Monthly)+parseFloat(comm)+parseFloat(comm2))*100)/100 ;

	
	///////////////////////////////////////////////////////////////////////////////////////////
	document.getElementById("salary_week").value=Math.round(weekly*100)/100 ;//Math.round(weekly);
	document.getElementById("salary_day").value=Math.round(daily*100)/100 ;//Math.round(daily);
	document.getElementById("salary_hour").value=Math.round(hourly*100)/100 ;//Math.round(hourly);
	
	//week_label
	document.getElementById("week_label").innerHTML="$AUD "+Math.round(weekly*100)/100 ;//Math.round(weekly);
	document.getElementById("day_label").innerHTML="$AUD "+Math.round(daily*100)/100 ;//Math.round(daily);
	document.getElementById("hour_label").innerHTML="$AUD "+Math.round(hourly*100)/100 ;//Math.round(hourly);
	//agent_com  agent_commission think_commission
	document.getElementById("agent_com").innerHTML="AGENT COMMISSION $AUD "+Math.round(comm*100)/100 ;
	document.getElementById("think_com").innerHTML="COMPANY COMMISSION $AUD "+Math.round(comm2*100)/100 ;
	document.getElementById("think_commission").value=Math.round(comm2*100)/100 ;
	document.getElementById("agent_commission").value=Math.round(comm*100)/100 ;
	
	
	document.getElementById("salary_month2").value=Math.round(Php_Monthly*100)/100 ; //Math.round(Php_Monthly);
	document.getElementById("salary_week2").value=Math.round(Php_Weekly*100)/100 ;//Math.round(Php_Weekly);
	document.getElementById("salary_day2").value=Math.round(Php_Daily*100)/100 ;//Math.round(Php_Daily);
	document.getElementById("salary_hour2").value=Math.round(Php_Hourly*100)/100 ;//Math.round(Php_Hourly);
	
	document.getElementById("week_label2").innerHTML="Php "+Math.round(Php_Weekly*100)/100 ;//Math.round(Php_Weekly);
	document.getElementById("day_label2").innerHTML="Php "+Math.round(Php_Daily*100)/100 ;//Math.round(Php_Daily);
	document.getElementById("hour_label2").innerHTML="Php "+Math.round(Php_Hourly*100)/100 ;//Math.round(Php_Hourly);
}

function setSalary2()
{
	var hour = document.getElementById("hour").value;
	var day = document.getElementById("days").value;
	var month = document.getElementById("salary_month2").value;
	var month2 = document.getElementById("salary_month").value;
	
	//var gst =document.getElementById("gst").value;
	var tax = 0;
	
	var yearly =parseFloat(month) *12; //12 months
	var weekly =parseFloat(yearly) / 52 ; // 52 weeks in a year
	var daily =parseFloat(weekly) / parseInt(day); // 5 days in a week
	var hourly =parseFloat(daily) / parseFloat(hour); // 9 working hours
	
	/////NEW FORMULA
	//var yearly =parseFloat(month) * 12 ;//months
	//var daily = parseFloat(yearly) / 275; //working days
	//var hourly = parseFloat(daily) / parseFloat(hour); // 8.5 (30 mins lunch deducted)
	//var weekly = parseFloat(daily) * 5; //working days a week
	
	//alert (yearly);
	////////////////
	
	//alert (hour);
	var agentPercent = .35;
	var companyPercent;
	if (month >=26000){
		companyPercent =.50;
	}
	else
	{
		companyPercent =.65;
	}
	
	
	document.getElementById("salary_week2").value=Math.round(weekly*100)/100 ;//Math.round(weekly);
	document.getElementById("salary_day2").value=Math.round(daily*100)/100 ;//Math.round(daily);
	document.getElementById("salary_hour2").value=Math.round(hourly*100)/100 ;//Math.round(hourly);
	
	document.getElementById("week_label2").innerHTML="Php "+Math.round(weekly*100)/100 ;//Math.round(weekly);
	document.getElementById("day_label2").innerHTML="Php "+Math.round(daily*100)/100 ;//Math.round(daily);
	document.getElementById("hour_label2").innerHTML="Php "+Math.round(hourly*100)/100 ;//Math.round(hourly);

	//////////// Convert Philippine Pesos to Australian Dollar /////////
	var AUSD_Monthly = parseFloat(month) / parseFloat(document.getElementById("dollar").value);//39; //Formula : $1 AUSD * 39 Pesos
	var AUSD_Weekly = (parseFloat(AUSD_Monthly)*12) / 52;
	var AUSD_Daily =parseFloat(AUSD_Weekly) / parseInt(day);
	var AUSD_Hourly =parseFloat(AUSD_Daily) / parseFloat(hour);
	
	
	////NEW FORMULA
	//var AUSD_Monthly = parseFloat(month) / parseFloat(document.getElementById("dollar").value);//39; //Formula : $1 AUSD * 39 Pesos
	//var AUSD_Yearly = parseFloat(AUSD_Monthly) * 12; //12 months
	
	//var AUSD_Daily =parseFloat(AUSD_Yearly) / 275; //working days;
	//var AUSD_Hourly =parseFloat(AUSD_Daily) / parseFloat(hour); // 8.5 (30 mins lunch deducted)
	//var AUSD_Weekly = parseFloat(AUSD_Daily) * 5; //working days a week
	
	////////////////
	var comm= parseFloat(AUSD_Monthly) * .35 ;
	var comm2= parseFloat(AUSD_Monthly) * companyPercent ;
	
	//if(document.getElementById("gst").checked==true)
	//{
	//	tax = parseInt(AUSD_Monthly) * (gst);
	//}
	
document.getElementById("client_charge").innerHTML="CHARGE TO CLIENT $AUD "+Math.round((parseFloat(AUSD_Monthly)+parseFloat(comm)+parseFloat(comm2))*100)/100 ;
document.getElementById("client_price").value=Math.round((parseFloat(AUSD_Monthly)+parseFloat(comm)+parseFloat(comm2))*100)/100 ;
document.getElementById("hiddenprice").value=Math.round((parseFloat(AUSD_Monthly)+parseFloat(comm)+parseFloat(comm2))*100)/100 ;
	
	document.getElementById("salary_month").value=Math.round(AUSD_Monthly*100)/100 ;//Math.round(weekly);
	document.getElementById("salary_week").value=Math.round(AUSD_Weekly*100)/100 ;//Math.round(weekly);
	document.getElementById("salary_day").value=Math.round(AUSD_Daily*100)/100 ;//Math.round(daily);
	document.getElementById("salary_hour").value=Math.round(AUSD_Hourly*100)/100 ;//Math.round(hourly);
	
	document.getElementById("week_label").innerHTML="$AUD "+Math.round(AUSD_Weekly*100)/100 ;//Math.round(weekly);
	document.getElementById("day_label").innerHTML="$AUD "+Math.round(AUSD_Daily*100)/100 ;//Math.round(daily);
	document.getElementById("hour_label").innerHTML="$AUD "+Math.round(AUSD_Hourly*100)/100 ;//Math.round(hourly);
	//agent_com
	
	document.getElementById("agent_com").innerHTML="AGENT COMMISSION $AUD "+Math.round(comm*100)/100 ;
	document.getElementById("think_com").innerHTML="COMPANY COMMISSION $AUD "+Math.round(comm2*100)/100 ;
	document.getElementById("think_commission").value=Math.round(comm2*100)/100 ;
	document.getElementById("agent_commission").value=Math.round(comm*100)/100 ;
	
}

function setHour()
{
	var start =document.getElementById("start").value;
	var end =document.getElementById("end").value;
		
	if(document.getElementById("start").selectedIndex!=0 || document.getElementById("end").selectedIndex!=0)
	{
		document.getElementById("hour").value  =(parseFloat(end) - parseFloat(start))-parseInt(document.getElementById("lunch_hour").value);
		//var hour =(parseInt(end) - parseInt(start))-1;
	}
}
function setHour2()
{
	var start =document.getElementById("lunch_start").value;
	var end =document.getElementById("lunch_end").value;
		
	if(document.getElementById("lunch_start").selectedIndex!=0 || document.getElementById("lunch_end").selectedIndex!=0)
	{
		document.getElementById("lunch_hour").value  =(parseFloat(end) - parseFloat(start));
		//var hour =(parseInt(end) - parseInt(start))-1;
	}
}
////////
function setFields()
{
	document.form.client_price.value=document.form.hiddenprice.value;
	document.getElementById("upside_label").innerHTML ="";
	document.getElementById("agent_upside_label").innerHTML ="";
	document.getElementById("company_upside_label").innerHTML ="";
			
	document.getElementById("agent_commission").value="";
	document.getElementById("think_commission").value="";
	
	document.getElementById("client_charge").innerHTML="CHARGE TO CLIENT $AUD ";
	document.getElementById("agent_com").innerHTML="AGENT COMMISSION $AUD ";
	document.getElementById("think_com").innerHTML="COMPANY COMMISSION $AUD ";
	document.getElementById("calculate").disabled=false;
	//disabled="disabled"
}
///////
function setTax()
{
	document.form.client_price.value=document.form.hiddenprice.value;
	document.getElementById("upside_label").innerHTML ="";
	document.getElementById("agent_upside_label").innerHTML ="";
	document.getElementById("company_upside_label").innerHTML ="";
			
	document.getElementById("agent_commission").value="";
	document.getElementById("think_commission").value="";
	
	document.getElementById("client_charge").innerHTML="CHARGE TO CLIENT $AUD ";
	document.getElementById("agent_com").innerHTML="AGENT COMMISSION $AUD ";
	document.getElementById("think_com").innerHTML="COMPANY COMMISSION $AUD ";
	document.getElementById("calculate").disabled=false;

}

function setSummary()
{
	document.form.hiddenprice.value = document.form.client_price.value;
}

function setCalculation()
{
	//
	var tax= 0;
	var agent_upside =0;
	
	if(document.getElementById("gst").checked==true)
	{
		var clientPriceMonthly = document.form.client_price.value;
		var gst =document.getElementById("gst").value;
		tax = parseFloat(clientPriceMonthly) * parseFloat(gst);
		document.getElementById("tax").value=Math.round(tax*100)/100;
		var price = parseFloat(clientPriceMonthly) + parseFloat(tax);
		var price2 =parseFloat(document.form.salary_month.value);
		var upside = price - price2;
		
		//alert(upside);
		if(document.form.activate_agent_commission.value=="Yes")
		{
			//alert("with agent commission");
			agent_upside = parseFloat(upside) * .35;
			document.getElementById("upside_label").innerHTML =Math.round((upside)*100)/100 ;
			document.getElementById("agent_upside_label").innerHTML =Math.round((parseFloat(agent_upside))*100)/100 ;
			document.getElementById("company_upside_label").innerHTML =Math.round((upside - agent_upside)*100)/100 ;
			
			document.getElementById("agent_commission").value=Math.round((parseFloat(agent_upside))*100)/100 ;
			document.getElementById("think_commission").value=Math.round((upside - agent_upside)*100)/100 ;
			document.getElementById("client_price").value=Math.round((price)*100)/100 ;
			////
	document.getElementById("client_charge").innerHTML="CHARGE TO CLIENT $AUD "+Math.round((price)*100)/100 ;
	document.getElementById("agent_com").innerHTML="AGENT COMMISSION $AUD "+Math.round((parseFloat(agent_upside))*100)/100 ;
	document.getElementById("think_com").innerHTML="COMPANY COMMISSION $AUD "+Math.round((upside - agent_upside)*100)/100 ;
				document.getElementById("calculate").disabled=true;
			
		}
		if(document.form.activate_agent_commission.value=="No")
		{
			//alert("without agent commission");
			document.getElementById("upside_label").innerHTML =Math.round((upside)*100)/100 ;
			document.getElementById("agent_upside_label").innerHTML =Math.round((parseFloat(agent_upside))*100)/100 ;
			document.getElementById("company_upside_label").innerHTML =Math.round((upside - agent_upside)*100)/100 ;
			
			document.getElementById("agent_commission").value=Math.round((parseFloat(agent_upside))*100)/100 ;
			document.getElementById("think_commission").value=Math.round((upside - agent_upside)*100)/100 ;
			document.getElementById("client_price").value=Math.round((price)*100)/100 ;
			///
			
			document.getElementById("client_charge").innerHTML="CHARGE TO CLIENT $AUD "+Math.round((price)*100)/100 ;
			document.getElementById("agent_com").innerHTML="AGENT COMMISSION $AUD "+Math.round((parseFloat(agent_upside))*100)/100 ;
			document.getElementById("think_com").innerHTML="COMPANY COMMISSION $AUD "+Math.round((upside - agent_upside)*100)/100 ;
				document.getElementById("calculate").disabled=true;
		}
	
		
	}
	else
	{
//////////////////////
		var clientPriceMonthly = document.getElementById("hiddenprice").value;
		var price3 = parseFloat(clientPriceMonthly);
		var price4 =parseFloat(document.form.salary_month.value);
		var upside = price3 - price4;
		
		document.getElementById("tax").value=Math.round(tax*100)/100;
		//alert(upside);
		if(document.form.activate_agent_commission.value=="Yes")
		{
			//alert("with agent commission");
			agent_upside = parseFloat(upside) * .35;
			document.getElementById("upside_label").innerHTML =Math.round((upside)*100)/100 ;
			document.getElementById("agent_upside_label").innerHTML =Math.round((parseFloat(agent_upside))*100)/100 ;
			document.getElementById("company_upside_label").innerHTML =Math.round((upside - agent_upside)*100)/100 ;
			
			document.getElementById("agent_commission").value=Math.round((parseFloat(agent_upside))*100)/100 ;
			document.getElementById("think_commission").value=Math.round((upside - agent_upside)*100)/100 ;
			document.getElementById("client_price").value=Math.round((price3)*100)/100 ;
			
	document.getElementById("client_charge").innerHTML="CHARGE TO CLIENT $AUD "+Math.round((price3)*100)/100 ;
	document.getElementById("agent_com").innerHTML="AGENT COMMISSION $AUD "+Math.round((parseFloat(agent_upside))*100)/100 ;
	document.getElementById("think_com").innerHTML="COMPANY COMMISSION $AUD "+Math.round((upside - agent_upside)*100)/100 ;
	
		document.getElementById("calculate").disabled=true;
		}
		if(document.form.activate_agent_commission.value=="No")
		{
			//alert("without agent commission");
			document.getElementById("upside_label").innerHTML =Math.round((upside)*100)/100 ;
			document.getElementById("agent_upside_label").innerHTML =Math.round((parseFloat(agent_upside))*100)/100 ;
			document.getElementById("company_upside_label").innerHTML =Math.round((upside - agent_upside)*100)/100 ;
			
			document.getElementById("agent_commission").value=Math.round((parseFloat(agent_upside))*100)/100 ;
			document.getElementById("think_commission").value=Math.round((upside - agent_upside)*100)/100 ;
			document.getElementById("client_price").value=Math.round((price3)*100)/100 ;
			
			
			document.getElementById("client_charge").innerHTML="CHARGE TO CLIENT $AUD "+Math.round((price3)*100)/100 ;
	document.getElementById("agent_com").innerHTML="AGENT COMMISSION $AUD "+Math.round((parseFloat(agent_upside))*100)/100 ;
	document.getElementById("think_com").innerHTML="COMPANY COMMISSION $AUD "+Math.round((upside - agent_upside)*100)/100 ;
			document.getElementById("calculate").disabled=true;
		}
		
//////////////////////		
	}


		
}

-->
</script>
<style type="text/css">
<!--
div.scroll {
	height: 100%;
	width: 100%;
	overflow: auto;
	padding: 8px;
	
}
.tableContent tr:hover
{
	background:#FFFFCC;
	
}

.tablecontent tbody tr:hover {
  background: #FFFFCC;
  }
.style2 {color: #3399FF}
-->
</style>
	
	
</head>


<body style="background:#ffffff" text="#000000" topmargin="0" leftmargin="0" marginheight="0" marginwidth="0">
<form name='form' action='contractphp.php' method='post' onSubmit="return checkFields();">

<script language=javascript src="js/functions.js"></script>

<!-- HEADER -->
<? include 'header.php';?>

<? if ($admin_status=="FULL-CONTROL") {?>
<ul class="glossymenu">
 <li ><a href="adminHome.php"><b>Home</b></a></li>
  <li class="current"><a href="adminadvertise_positions.php"><b>Applications</b></a></li>
  <li><a href="admin_advertise_list.php"><b>Advertisements</b></a></li>
  <li ><a href="adminnewleads.php"><b>New Leads</b></a></li>
  <li ><a href="admincontactedleads.php"><b>Contacted Leads</b></a></li>
  <li ><a href="adminclient_listings.php"><b>Clients</b></a></li>
  <li ><a href="adminscm.php"><b>Sub-Contractor Management</b></a></li>
  <li ><a href='subconlist.php'><b>List of Sub-Contractors</b></a></li>
</ul>
<? } else { 
echo "<ul class='glossymenu'>
 <li ><a href='adminHome.php'><b>Home</b></a></li>
  <li class='current'><a href='adminadvertise_positions.php'><b>Applications</b></a></li>
  <li><a href='admin_advertise_list.php'><b>Advertisements</b></a></li>
  <li ><a href='adminclient_listings.php'><b>Clients</b></a></li>
  <li ><a href='adminscm.php'><b>Sub-Contractor Management</b></a></li>
  <li ><a href='subconlist.php'><b>List of Sub-Contractors</b></a></li>
</ul>";
}
?>

<table width=100% cellpadding=0 cellspacing=0 border=0 align=center>
<tr><td colspan=2 style='height: 1px;'>&nbsp;</td>
</tr>
<tr>
<td style='border-right: #006699 2px solid; width: 170px; vertical-align:top; '>
<? include 'adminleftnav.php';?>
</td>
<td width=100% valign=top >
<table width="99%" style="border:#CCCCCC solid 1px;">
<tr bgcolor='#666666'>
<td><font size='1' color="#FFFFFF"><b>RemoteStaff / Sub-Contractors  &nbsp;Contract Details</b></font></td>
</tr>
<tr>
<td valign="middle">
<!-- here -->

<table width='98%' cellpadding='5' cellspacing='0' style='border:#CCCCCC solid 1px;' align="center">
	<tr><td width='31%' valign='top' style='border-right:#CCCCCC solid 1px;'>
	<table width='100%'>
	<tr>
	<td width='38%'><strong><font size='1'>Date Applied</font></strong></td>
	<td width='3%'><strong>:</strong></td>
	<td width='59%'><font size='1'><? echo $date;?></font></td>
	</tr>
	<tr>
	<td width='38%'><strong><font size='1'>Nationality</font></strong></td>
	<td width='3%'><strong>:</strong></td>
	<td width='59%'><font size='1'><? echo $nationality;?></font></td>
	</tr>
	<tr>
	<td width='38%'><strong><font size='1'>Email</font></strong></td>
	<td width='3%'><strong>:</strong></td>
	<td width='59%'><? echo $email;?></td>
	</tr>
	<tr>
	<td width='38%'><strong><font size='1'>Skype ID</font></strong></td>
	<td width='3%'><strong>:</strong></td>
	<td width='59%'><font size='1'><? echo $skype;?></font></td>
	</tr>
	
	<tr>
	<td height="354" colspan='3' align="center" valign="top"><br>
<h4 style="color:#333399;"><? echo $fname." ".$lname;?></h4>
<p align="center"><b><? echo $jobposition."<br>".$companyname;?></b></p>
<p>Client : <? echo $lead_fname." ".$lead_lname;?></p>
<img src='<? echo $image;?>' width='155' height='160' /></td>
	</tr>
	
		
	<tr><td height="32" colspan="3"><span class="style2"><img src="images/configure22.png" alt="Configure Client Charge Out Rate Tools" align="absmiddle"> <b>Configure Client Charge Out Rate </b></span></td>
	</tr>
	<tr><td valign="top" colspan="3"><table width="100%" style="border:#CCCCCC solid 1px;">
	
	<tr>
	<td width='50%'><strong><font size='1'>Client Price <br>
<font color='#999999' size='1'>(Australian Dollar)</font></font></strong></td>
	<td width='4%'><strong>:</strong></td>
	<td width='46%'><font size='1'>
	  <input type='text' name='client_price' id="client_price"  class='text' onKeyUp="setSummary();">
	  <input type='hidden' name='hiddenprice' id="hiddenprice"  class='text' >
	  </font></td>
	</tr>
	<tr>
	<td>With 10% GST</td><td>:</td>
	<td width='46%' ><input type="checkbox" name="gst" id="gst" value=".10" onClick="setTax();"><!-- setTax();-->	</td></tr>
	
	<tr>
	<td>Upside</td><td>:</td>
	<td width='46%' ><div id="upside_label"></div></td>
	</tr>
	
	<tr>
	<td>Activate Agent Commission</td><td>:</td>
	<td width='46%' ><select name="activate_agent_commission" id="activate_agent_commission" class="text" onChange="setTax();">
      <option value="">-</option>
      <option value="Yes">Yes</option>
      <option value="No">No</option>
    </select></td>
	</tr>
	<tr>
	<td height="16">Agent Commission 35%</td>
	<td>:</td>
	<td width='46%' ><div id="agent_upside_label"></div></td>
	</tr>
	
	<tr>
	<td>Company Upside </td><td>:</td>
	<td width='46%' ><div id="company_upside_label"></div></td>
	</tr>
	
	<tr>
	<td colspan="3" align="center"><input type="button" value="Calculate" name="calculate" id="calculate"  onClick="setCalculation();">&nbsp;
	<input  type="button" value="Cancel" name="cancel" id="cancel"  onClick="setFields();"></td>
	</tr>
	
	</table></td></tr>
	
	</table>
	</td>
	<td width='69%' colspan='2' valign='top'>
	<!-- Table Money -->
	<table width='100%' cellpadding='0' cellspacing='0'>
	<tr bgcolor='#666666'>
	<td colspan='2'>&nbsp;&nbsp;&nbsp;&nbsp;<font color='#FFFFFF' size='1'><b>Sub-Contracted At</b></font></td>
	</tr>
	<tr>
	<td width='57%' valign='top' style="border-right:#CCCCCC solid 1px;"><table width='99%'>
	<tr>
	<td width='42%' align='right'><strong><font size='1'>Salary per Month </font></strong><br />
<font color='#999999' size='1'>(Australian Dollar)</font></td>
	<td width='4%'><strong>:</strong></td>
	<td width='54%'><input type='text' name='salary_month' id='salary_month' onkeyup='setSalary();' value='0' class='text' ></td>
	</tr>
	<tr>
	<td width='42%' align='right'><strong><font size='1'>Salary per Week </font></strong><br />
<font color='#999999' size='1'>(Australian Dollar)</font></td>
	<td width='4%'><strong>:</strong></td>
	<td width='54%'>
	<div id='week_label'></div>
	<input type='hidden' name='salary_week' id='salary_week' style='color:#666666;' class='text'>	</td>
	</tr>
	<tr>
	<td width='42%' align='right'><strong><font size='1'>Salary per Day </font></strong><br />
<font color='#999999' size='1'>(Australian Dollar)</font></td>
	<td width='4%'><strong>:</strong></td>
	<td width='54%'>
	<div id='day_label'></div>
	<input type='hidden' name='salary_day' id='salary_day' style='color:#666666;' class='text'></td>
	</tr>
	<tr>
	<td width='42%' align='right'><strong><font size='1'>Hourly rate</font></strong><br />
<font color='#999999' size='1'>(Australian Dollar)</font></td>
	<td width='4%'><strong>:</strong></td>
	<td width='54%'>
	<div id='hour_label' style='color:#0000FF; font-weight:bold'></div>
	<input type='hidden' name='salary_hour' id='salary_hour' style='color:#0000FF;' class='text'></td>
	</tr>
	
	
	<tr>
	<td align='right'><strong><font size='1'>Hours per Day</font></strong></td>
	<td width='4%'><strong>:</strong></td>
	<td width='54%'><input type='text' name='hour' id='hour' style='color:#666666; width:40px;' value='8' class='text' /></td>
	</tr>
	
	<tr>
	<td align='right' valign="top" height="40"><strong><font size='1'>Days per week</font></strong></td>
	<td width='4%' valign="top"><strong>:</strong></td>
	<td width='54%' valign="top"><input type='text' name='days'  id='days' style='color:#666666; width:20px;' value='5' class='text' ></td>
	</tr>
	<tr><td colspan="3" bgcolor="#CCCCCC" height="1"></td></tr>
	<tr>
	<td align='right'><strong><font size='1'>Overtime Activation</font></strong></td>
	<td width='4%'><strong>:</strong></td>
	<td width='54%'><select name="overtime" id="overtime" class="text">
      <option value="">-</option>
      <option value="Yes">Yes</option>
      <option value="No">No</option>
    </select></td>
	</tr>
		<tr>
	<td align='right'><strong><font size='1'>Leave /Dayoff Permission</font></strong></td>
	<td width='4%'><strong>:</strong></td>
	<td width='54%'><select name="day_off" id="overtime" class="text">
      <option value="">-</option>
      <option value="Yes">Yes</option>
      <option value="No">No</option>
    </select></td>
	</tr>
	<tr>
	<td align='right'><strong><font size='1'>Work Status</font></strong></td>
	<td width='4%'><strong>:</strong></td>
	<td width='54%'>
	<select name="work_status" id="work_status" class="text">
	<option value="">-</option>
	<option value="Full-Time">Full-Time</option>
	<option value="Part-Time">Part-Time</option>
	<option value="Project Based">Project Based</option>
	<option value="Hourly-Rate">Hourly-Rate</option>
	</select>	</td>
	</tr>
	<tr>
	<td align='right'><strong><font size='1'>Working Hours Start at</font></strong></td>
	<td width='4%'><strong>:</strong></td>
	<td width='54%'><select name="start" id="start"  onChange="setHour();setSalary2();" class="text">
	 <option value="">-</option>
      <option value="6">6:00 am</option>
      <option value="7" selected="selected">7:00 am</option>
      <option value="8">8:00 am</option>
      <option value="9">9:00 am</option>
      <option value="10">10:00 am</option>
      <option value="11">11:00 am</option>
      <option value="12">12:00 noon</option>
      <option value="13">1:00 pm</option>
      <option value="14">2:00 pm</option>
      <option value="15">3:00 pm</option>
      <option value="16">4:00 pm</option>
      <option value="17">5:00 pm</option>
      <option value="18">6:00 pm</option>
      <option value="19">7:00 pm</option>
      <option value="20">8:00 pm</option>
      <option value="21">9:00 pm</option>
      <option value="22">10:00 pm</option>
      <option value="23">11:00 pm</option>
      <option value="24">12:00 am</option>
    </select> <font color='#999999'>Phil Time Zone</font></td>
	</tr>
	
	<tr>
	<td align='right'><strong><font size='1'>Working Hours Ends at</font></strong></td>
	<td width='4%'><strong>:</strong></td>
	<td width='54%'><select name="end" id="end" class="text" onChange="setHour();setSalary2();" >
	<option value="">-</option>
      <option value="6">6:00 am</option>
      <option value="7">7:00 am</option>
      <option value="8">8:00 am</option>
	  <option value="9">9:00 am</option>
      <option value="10">10:00 am</option>
      <option value="11">11:00 am</option>
	  <option value="12">12:00 noon</option>
      <option value="13">1:00 pm</option>
      <option value="14">2:00 pm</option>
	  <option value="15">3:00 pm</option>
	  <option value="16" selected="selected">4:00 pm</option>
	  <option value="17" >5:00 pm</option>
	  <option value="18">6:00 pm</option>
	  <option value="19">7:00 pm</option>
	  <option value="20">8:00 pm</option>
	  <option value="21">9:00 pm</option>
	  <option value="22">10:00 pm</option>
	  <option value="23">11:00 pm</option>
	  <option value="24">12:00 am</option>
    </select> <font color='#999999'>Phil Time Zone</font></td>
	</tr>
	<tr>
	<td align='right'><strong><font size='1'>Lunch Starts At</font></strong></td>
	<td width='4%'><strong>:</strong></td>
	<td width='54%'><select name="lunch_start" id="lunch_start"  onChange="setHour2();setSalary2();" class="text">
	 <option value="">-</option>
      <option value="6">6:00 am</option>
      <option value="7">7:00 am</option>
      <option value="8">8:00 am</option>
      <option value="9">9:00 am</option>
      <option value="10">10:00 am</option>
      <option value="11" selected="selected">11:00 am</option>
      <option value="12">12:00 noon</option>
      <option value="13">1:00 pm</option>
      <option value="14">2:00 pm</option>
      <option value="15">3:00 pm</option>
      <option value="16">4:00 pm</option>
      <option value="17">5:00 pm</option>
      <option value="18">6:00 pm</option>
      <option value="19">7:00 pm</option>
      <option value="20">8:00 pm</option>
      <option value="21">9:00 pm</option>
      <option value="22">10:00 pm</option>
      <option value="23">11:00 pm</option>
      <option value="24">12:00 am</option>
    </select> <font color='#999999'>Phil Time Zone</font></td>
	</tr>
	
	<tr>
	<td align='right'><strong><font size='1'>Lunch Ends At</font></strong></td>
	<td width='4%'><strong>:</strong></td>
	<td width='54%'><select name="lunch_end" id="lunch_end" class="text" onChange="setHour2();setSalary2();" >
	<option value="">-</option>
      <option value="6">6:00 am</option>
      <option value="7">7:00 am</option>
      <option value="8">8:00 am</option>
	  <option value="9">9:00 am</option>
      <option value="10">10:00 am</option>
      <option value="11">11:00 am</option>
	  <option value="12"selected="selected">12:00 noon</option>
      <option value="13">1:00 pm</option>
      <option value="14">2:00 pm</option>
	  <option value="15">3:00 pm</option>
	  <option value="16" >4:00 pm</option>
	  <option value="17" >5:00 pm</option>
	  <option value="18">6:00 pm</option>
	  <option value="19">7:00 pm</option>
	  <option value="20">8:00 pm</option>
	  <option value="21">9:00 pm</option>
	  <option value="22">10:00 pm</option>
	  <option value="23">11:00 pm</option>
	  <option value="24">12:00 am</option>
    </select>
	<font color='#999999'> Phil Time Zone</font></td>
	</tr>
	<tr>
	<td align='right'><strong><font size='1'>Lunch Hour</font></strong></td>
	<td width='4%'><strong>:</strong></td>
	<td width='54%'><input type='text' name='lunch_hour' id='lunch_hour' style='color:#666666;width:40px;' class='text' value="1"/> </td>
	</tr>
	<tr>
	<td align='right'><strong><font size='1'>Starting Date</font></strong></td>
	<td width='4%'><strong>:</strong></td>
	<td width='54%'><input type='text' id="starting_date" name='starting_date' style='color:#666666;' class='text' value="<? echo $AusDate;?>" >&nbsp;<img align="absmiddle" src="images/calendar_ico.png"   id="bd" style="cursor: pointer; " title="Date selector" onMouseOver="this.style.background='red'" onMouseOut="this.style.background=''" />
	 <script type="text/javascript">
                    Calendar.setup({
                        inputField     :    "starting_date",     // id of the input field
                        ifFormat       :    "%Y-%m-%d",      // format of the input field
                        button         :    "bd",          // trigger for the calendar (button ID)
                        align          :    "Tl",           // alignment (defaults to "Bl")
		                showsTime	   :    false, 
                        singleClick    :    true
                    });                     
                  </script>	</td>
	</tr>
	<tr>
	<td align='right'><strong><font size='1'>End date</font></strong></td>
	<td width='4%'><strong>:</strong></td>
	<td width='54%'><input type='text' name='end_date' id="end_date" style='color:#666666;' class='text' >&nbsp;<img align="absmiddle" src="images/calendar_ico.png"   id="bd2" style="cursor: pointer; " title="Date selector" onMouseOver="this.style.background='red'" onMouseOut="this.style.background=''" />
	 <script type="text/javascript">
                    Calendar.setup({
                        inputField     :    "end_date",     // id of the input field
                        ifFormat       :    "%Y-%m-%d",      // format of the input field
                        button         :    "bd2",          // trigger for the calendar (button ID)
                        align          :    "Tl",           // alignment (defaults to "Bl")
		                showsTime	   :    false, 
                        singleClick    :    true
                    });                     
                  </script>	</td>
	</tr>
	<tr>
	<td valign='top' align='right'><strong><font size='1'>Other Details</font></strong></td>
	<td width='4%' valign='top'>:</td>
	<td width='54%'><textarea name='details' id='details' rows='5' cols='20' class='text'></textarea></td>
	</tr>
	
	<tr>
	<td colspan='2' align='center'>&nbsp;</td>
	<td><input type='hidden' name='userid' id='userid' value="<? echo $userid;?>">
	  <input type='hidden' name='aid' id='aid' value="<? echo $aid;?>">
	<input type='hidden' name='leads_id' id='leads_id' value="<? echo $leads_id;?>">
	<input type='hidden' name='posting_id' id='posting_id' value="<? echo $posting_id;?>">
	<input type='hidden' name='agent_no' id='agent_no' value='<? echo $agent_no;?>'>
	
	<input type='submit' name='process' id='process' value='Process'>
	<input type="button" name="Back"  value="Back" onClick="self.location='adminrecruitment.php?id=<? echo $leads_id;?>&pid=<? echo $posting_id;?>&stat=Hired'"/></td>
	</tr>
	</table></td>



	<td width='43%' valign='top'><table width='100%' style="margin-left:8px;">
	<tr>
	<td width='37%'><strong><font size='1'>Salary per Month </font></strong><br />
<font color='#999999' size='1'>(Philippine Pesos)</font></td>
	<td width='3%'><strong>:</strong></td>
	<td width='60%'><input type='text' name='salary_month2' id='salary_month2' class='text' onkeyup='setSalary2();' ></td>
	</tr>
	<tr>
	<td width='37%'><strong><font size='1'>Salary per Week </font></strong><br />
<font color='#999999' size='1'>(Philippine Pesos)</font></td>
	<td width='3%'><strong>:</strong></td>
	<td width='60%'>
	<div id='week_label2'></div>
	<input type='hidden' name='salary_week2' id='salary_week2' style='color:#666666;' class='text'></td>
	</tr>
	<tr>
	<td width='37%'><strong><font size='1'>Salary per Day </font></strong><br />
<font color='#999999' size='1'>(Philippine Pesos)</font></td>
	<td width='3%'><strong>:</strong></td>
	<td width='60%'>
	<div id='day_label2'></div>
	<input type='hidden' name='salary_day2' id='salary_day2' style='color:#666666;' class='text'  /></td>
	</tr>
	<tr>
	<td width='37%'><strong><font size='1'>Hourly rate</font></strong><br />
<font color='#999999' size='1'>(Philippine Pesos)</font></td>
	<td width='3%'><strong>:</strong></td>
	<td width='60%'>
	<div id='hour_label2' style='color:#0000FF; font-weight:bold'></div>
	<input type='hidden' name='salary_hour2' id='salary_hour2' style='color:#0000FF;' class='text'></td>
	</tr>
	<tr>
	<td width='37%' colspan='3' height="64" >&nbsp;
	
	
	
	</td></tr>
	<tr><td colspan="3" bgcolor="#CCCCCC" height="1"></td></tr>
	<tr>
	<td width='37%' colspan='3'><br>

<font color='#999999' size='1'> <b>CURRENCY RATE : $AUD 1.00 = Php <input type="text" name="dollar" id="dollar" value="39.00" style="width:40px;" class="text"></b><br>
<a href="http://www.xe.com/ucc/" target="_blank" class="link10">Check Currency</a><br><br>

	Think Innovations commission 65% from the <br>
	Salary per Month and <br />
	Agent Commission 35%<br />
	</font><br><br>


  <div style=" margin-top:80px;"><b>Charged Out Rate</b></div>
          <div id='client_charge' style='color:#666666; margin-top:10px; margin-bottom:10px;'>CHARGE TO CLIENT $AUD </div>
          <div id='agent_com' style='color:#666666;margin-top:10px; margin-bottom:10px;'>AGENT COMMISSION $AUD </div>
          <div id='think_com' style='color:#666666; margin-top:10px; margin-bottom:10px;'>COMPANY COMMISSION $AUD </div>
          <input type='hidden' name='agent_commission' id='agent_commission'  class='text'>
          <input type='hidden' name='think_commission' id='think_commission'  class='text'>
          <input type='hidden' name='tax' id='tax'  class='text'>
	
	</td>
	</tr>
	</table></td>
	</tr>
	</table>
	<!-- Table Money End Here-->
	</td>
	</tr>
	</table>
<!-- here -->

</td>
</tr>
</table>

</td>
</tr>
</table>

<? include 'footer.php';?>
</form>
</body>
</html>
<? }?>