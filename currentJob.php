<?php
include 'conf.php';
$userid=$_SESSION['userid'];
//echo $userid;
$mess="";
$mess=$_REQUEST['mess'];

$dpt_field="";
$specializationoptions="";
$positionlevel="";
$positionleveloptions="";
$currency="";
$currencyoptions="";
$years_worked="";
$yearsoptions="";
$months_worked="";
$company_industry="";
$monthjoined="";
$monthleft="";
$amonth="";
$aday="";
$iday="";
$imonth="";
$intern_notice="";

$industrytypeArray=array("Accounting / Audit / Tax Services","Advertising / Marketing / Promotion / PR","Aerospace / Aviation / Airline","Agricultural / Plantation / Poultry / Fisheries","Apparel","Architectural Services / Interior Designing","Arts / Design / Fashion","Automobile / Automotive Ancillary / Vehicle","Banking / Financial Services","BioTechnology / Pharmaceutical / Clinical research","Call Center / IT-Enabled Services / BPO","Chemical / Fertilizers / Pesticides","Computer / Information Technology (Hardware)","Computer / Information Technology (Software)","Construction / Building / Engineering","Consulting (Business &amp; Management)","Consulting (IT, Science, Engineering &amp; Technical)","Consumer Products / FMCG","Education","Electrical & Electronics","Entertainment / Media","Environment / Health / Safety","Exhibitions / Event management / MICE","Food & Beverage / Catering / Restaurant","Gems / Jewellery","General & Wholesale Trading","Government / Defence","Grooming / Beauty / Fitness","Healthcare / Medical","Heavy Industrial / Machinery / Equipment","Hotel / Hospitality","Human Resources Management / Consulting","Insurance","Journalism","Law / Legal","Library / Museum","Manufacturing / Production","Marine / Aquaculture","Mining","Non-Profit Organisation / Social Services / NGO","Oil / Gas / Petroleum","Others","Polymer / Plastic / Rubber / Tyres","Printing / Publishing","Property / Real Estate","R&D","Repair & Maintenance Services","Retail / Merchandise","Science & Technology","Security / Law Enforcement","Semiconductor/Wafer Fabrication","Sports","Stockbroking / Securities","Telecommunication","Textiles / Garment","Tobacco","Transportation / Logistics","Travel / Tourism","Utilities / Power","Wood / Fibre / Paper");
    
for ($i = 0; $i < count($industrytypeArray); $i++) {
      if($company_industry == $industrytypeArray[$i])
      {
	 $industrytypeoptions .= "<option selected value=\"$industrytypeArray[$i]\">$industrytypeArray[$i]</option>\n";
      }
      else
      {
	 $industrytypeoptions .= "<option value=\"$industrytypeArray[$i]\">$industrytypeArray[$i]</option>\n";
      }
   }	


$specializationArray=array("Actuarial Science/Statistics","Advertising/Media Planning","Agriculture/Forestry/Fisheries","Architecture/Interior Design","Arts/Creative/Graphics Design","Aviation/Aircraft Maintenance","Banking/Financial Services","Biotechnology","Chemistry","Clerical/Administrative Support","Corporate Strategy/Top Management","Customer Service","Education","Engineering - Chemical","Engineering - Civil/Construction/Structural","Engineering - Electrical","Engineering - Electronics/Communication","Engineering - Environmental/Health/Safety","Engineering - Industrial","Engineering - Mechanical/Automotive","Engineering - Oil/Gas","Engineering - Others","Entertainment/Performing Arts","Finance - Audit/Taxation","Finance - Corporate Finance/Investment/Merchant Banking","Finance - General/Cost Accounting","Food Technology/Nutritionist","Food/Beverage/Restaurant Service","General Work (Housekeeper, Driver, Dispatch, Messenger, etc)","Geology/Geophysics","Healthcare - Doctor/Diagnosis","Healthcare - Nurse/Medical Support & Assistant","Healthcare - Pharmacy","Hotel Management/Tourism Services","Human Resources","IT/Computer - Hardware","IT/Computer - Network/System/Database Admin","IT/Computer - Software","Journalist/Editor","Law/Legal Services","Logistics/Supply Chain","Maintenance/Repair (Facilities & Machinery)","Manufacturing/Production Operations","Marketing/Business Development","Merchandising","Personal Care/Beauty/Fitness Service","Process Design & Control/Instrumentation","Property/Real Estate","Public Relations/Communications","Publishing/Printing","Purchasing/Inventory/Material & Warehouse Management","Quality Control/Assurance","Quantity Surveying","Sales - Corporate","Sales - Engineering/Technical/IT","Sales - Financial Services (Insurance, Unit Trust, etc)","Sales - Retail/General","Sales - Telesales/Telemarketing","Science & Technology/Laboratory","Secretarial/Executive & Personal Assistant","Security/Armed Forces/Protective Services","Social & Counselling Service","Technical & Helpdesk Support","Training & Development");

for ($count = 0; $count < count($specializationArray); $count++) {
  if($dpt_field == $specializationArray[$count])
  {
$specializationoptions .= "<option selected value=\"$specializationArray[$count]\">$specializationArray[$count]</option>\n";
  }
  else
  {
$specializationoptions .= "<option value=\"$specializationArray[$count]\">$specializationArray[$count]</option>\n";
  }
}


$positionlevelArray=array("CEO/SVP/AVP/VP/Director","Assistant Manager / Manager","Supervisor / 5 Yrs & Up Experienced Employee","1-4 Yrs Experienced Employee","Fresh Grad / Less than 1 Year"); 
 
  for ($i = 0; $i < count($positionlevelArray); $i++)
  {
      if($positionlevel == $positionlevelArray[$i])
      {
	 $positionleveloptions .= "<option selected value=\"$positionlevelArray[$i]\">$positionlevelArray[$i]</option>\n";
      }
      else
      {
	 $positionleveloptions .= "<option value=\"$positionlevelArray[$i]\">$positionlevelArray[$i]</option>\n";
      }
   }
   
$currencyArray=array("Australian Dollar","Bangladeshi Taka","British Pound","Chinese RenMinBi","Euro","HongKong Dollar","Indian Rupees","Indonesian Rupiah","Japanese Yen","Malaysian Ringgit","New Zealand Dollar","Philippine Peso","Singapore Dollar","Thai Baht","US Dollars","Vietnam Dong");   
for ($i = 0; $i < count($currencyArray); $i++)
{
  if($currency == $currencyArray[$i])
  {
 $currencyoptions .= "<option selected value=\"$currencyArray[$i]\">$currencyArray[$i]</option>\n";
  }
  else
  {
 $currencyoptions .= "<option value=\"$currencyArray[$i]\">$currencyArray[$i]</option>\n";
  }
}

$numArray=array("1","2","3","4","5","6","7","8","9","10","11","12","13","14","15","16");
for ($i = 0; $i < count($numArray); $i++)
{
  if($years_worked == $numArray[$i])
  {
 $yearsoptions .= "<option selected value=\"$numArray[$i]\">$numArray[$i]</option>\n";
  }
  else
  {
 $yearsoptions .= "<option value=\"$numArray[$i]\">$numArray[$i]</option>\n";
  }
}

//
$numArray2=array("0","1","2","3","4","5","6","7","8","9","10","11");
for ($i = 0; $i < count($numArray2); $i++)
{
  if($months_worked == $numArray2[$i])
  {
 $monthoptions .= "<option selected value=\"$numArray2[$i]\">$numArray2[$i]</option>\n";
  }
  else
  {
 $monthoptions .= "<option value=\"$numArray2[$i]\">$numArray2[$i]</option>\n";
  }
  
  if($available_notice == $numArray2[$i])
  {
 $monthoptions2 .= "<option selected value=\"$numArray2[$i]\">$numArray2[$i]</option>\n";
  }
  else
  {
 $monthoptions2 .= "<option value=\"$numArray2[$i]\">$numArray2[$i]</option>\n";
  }
  
}
$numArray3=array("1","2","3","4","5","6","7","8","9","10","11","12");
//$intern_notice
for ($i = 0; $i < count($numArray3); $i++)
{
  if($intern_notice == $numArray3[$i])
  {
 	$monthnums .= "<option selected value=\"$numArray3[$i]\">$numArray3[$i]</option>\n";
  }
  else
  {
 	$monthnums .= "<option value=\"$numArray3[$i]\">$numArray3[$i]</option>\n";
  }
}
$monthnamesArray=array("January","February","March","April","May","June","July","August","September","October","November","December");
for ($i = 0; $i < count($monthnamesArray); $i++)
{
  if($monthjoined == $monthnamesArray[$i])
  {
 $monthnameoptions .= "<option selected value=\"$monthnamesArray[$i]\">$monthnamesArray[$i]</option>\n";
  }
  else
  {
 $monthnameoptions .= "<option value=\"$monthnamesArray[$i]\">$monthnamesArray[$i]</option>\n";
  }
  
  /////
  
  if($monthleft == $monthnamesArray[$i])
  {
 	$monthnameoptions2 .= "<option selected value=\"$monthnamesArray[$i]\">$monthnamesArray[$i]</option>\n";
  }
  else
  {
 	$monthnameoptions2 .= "<option value=\"$monthnamesArray[$i]\">$monthnamesArray[$i]</option>\n";
  }//
  
  if($amonth == $monthnamesArray[$i])
  {
 	$monthnameoptions3 .= "<option selected value=\"$monthnamesArray[$i]\">$monthnamesArray[$i]</option>\n";
  }
  else
  {
 	$monthnameoptions3 .= "<option value=\"$monthnamesArray[$i]\">$monthnamesArray[$i]</option>\n";
  }
  
  //$imonth
  if($imonth == $monthnamesArray[$i])
  {
 	$monthnameoptions4 .= "<option selected value=\"$monthnamesArray[$i]\">$monthnamesArray[$i]</option>\n";
  }
  else
  {
 	$monthnameoptions4 .= "<option value=\"$monthnamesArray[$i]\">$monthnamesArray[$i]</option>\n";
  }
  
}

$numArrays=array("1","2","3","4","5","6","7","8","9","10","11","12","13","14","15","16","17","18","19","20","21","22","23","24","25","26","27","28","29","30","31");
for ($i = 0; $i < count($numArrays); $i++)
{
  if($aday == $numArrays[$i])
  {
 	$nums .= "<option selected value=\"$numArrays[$i]\">$numArrays[$i]</option>\n";
  }
  else
  {
 	$nums .= "<option value=\"$numArrays[$i]\">$numArrays[$i]</option>\n";
  }
  //$iday
  if($iday == $numArrays[$i])
  {
 	$nums2 .= "<option selected value=\"$numArrays[$i]\">$numArrays[$i]</option>\n";
  }
  else
  {
 	$nums2 .= "<option value=\"$numArrays[$i]\">$numArrays[$i]</option>\n";
  }
}

?>
<html>
<head>
<title>MyProfile &copy; RemoteStaff.com</title>
<link rel=stylesheet type=text/css href="css/font.css">
<script language=javascript src="js/util.js"></script>
<script language="javascript">
var items=1;
function AddItem() {
  div=document.getElementById("items");
  button=document.getElementById("add");
  items++;
  newitem="<b>Item " + items + ": </b>";
  newitem+="<input type=\"text\" name=\"item" + items;
  newitem+="\" size=\"45\"><br>";
  newnode=document.createElement("span");
  newnode.innerHTML=newitem;
  div.insertBefore(newnode,button);
  document.getElementById("counter").value=items;
}
function AddWork() {

if (document.getElementById("counter").value <=4)
{
  div=document.getElementById("workhistory");
  button=document.getElementById("addwork");
  items++;
  newitem1="<label>Company Name " + items + ": </label>";
  newitem1+="<input type=\"text\" name=\"companyname" + items;
  newitem1+="\" size=\"45\"><br>";
  
  newitem2="<label>Position/Title " + items + ": </label>";
  newitem2+="<input type=\"text\" name=\"position" + items;
  newitem2+="\" size=\"45\"><br>";
  
  newitem3="<label>Responsibilities / Achievments: " + items + ": </label>";
  newitem3+="<textarea rows=\"7\" name=\"duties" + items;
  newitem3+="\" cols=\"30\"></textarea><br>";

  newitem4="<label>Employment Period " + items + ": </label>";
  newitem4+="<select name=\"monthfrom" + items+"\"><option value=\"JAN\">JAN </option><option value=\"FEB\">FEB </option><option value=\"MAR\">MAR </option><option value=\"APR\">APR </option><option value=\"MAY\">MAY </option><option value=\"JUN\">JUN </option><option value=\"JUL\">JUL </option><option value=\"AUG\">AUG </option><option value=\"SEP\">SEP </option><option value=\"OCT\">OCT </option><option value=\"NOV\">NOV </option><option value=\"DEC\">DEC </option></select>";
  newitem4+="<select name=\"yearfrom" + items+"\"> <option value=\"2010\">2010 </option><option value=\"2009\" selected>2009 </option><option value=\"2008\">2008 </option><option value=\"2007\">2007 </option><option value=\"2006\">2006 </option><option value=\"2005\">2005 </option><option value=\"2004\">2004 </option><option value=\"2003\">2003 </option><option value=\"2002\">2002 </option><option value=\"2001\">2001 </option><option value=\"2000\">2000 </option><option value=\"1999\">1999 </option><option value=\"1998\">1998 </option><option value=\"1997\">1997 </option><option value=\"1996\">1996 </option><option value=\"1995\">1995 </option><option value=\"1994\">1994 </option><option value=\"1993\">1993 </option><option value=\"1992\">1992 </option><option value=\"1991\">1991 </option><option value=\"1990\">1990 </option><option value=\"1989\">1989 </option><option value=\"1988\">1988 </option><option value=\"1987\">1987 </option><option value=\"1986\">1986 </option><option value=\"1985\">1985 </option><option value=\"1984\">1984 </option><option value=\"1983\">1983 </option><option value=\"1982\">1982 </option><option value=\"1981\">1981 </option><option value=\"1980\">1980 </option><option value=\"1979\">1979 </option><option value=\"1978\">1978 </option><option value=\"1977\">1977 </option><option value=\"1976\">1976 </option><option value=\"1975\">1975 </option><option value=\"1974\">1974 </option></select>";
  
  
  
  newitem4+="<select name=\"monthto" + items+"\">><option value=\"JAN\">JAN </option><option value=\"FEB\">FEB </option><option value=\"MAR\">MAR </option><option value=\"APR\">APR </option><option value=\"MAY\">MAY </option><option value=\"JUN\">JUN </option><option value=\"JUL\">JUL </option><option value=\"AUG\">AUG </option><option value=\"SEP\">SEP </option><option value=\"OCT\">OCT </option><option value=\"NOV\">NOV </option><option value=\"DEC\">DEC </option></select>";
  newitem4+="<select name=\"yearto" + items+"\"><option value=\"2010\">2010 </option><option value=\"2009\" selected>2009 </option><option value=\"2008\">2008 </option><option value=\"2007\">2007 </option><option value=\"2006\">2006 </option><option value=\"2005\">2005 </option><option value=\"2004\">2004 </option><option value=\"2003\">2003 </option><option value=\"2002\">2002 </option><option value=\"2001\">2001 </option><option value=\"2000\">2000 </option><option value=\"1999\">1999 </option><option value=\"1998\">1998 </option><option value=\"1997\">1997 </option><option value=\"1996\">1996 </option><option value=\"1995\">1995 </option><option value=\"1994\">1994 </option><option value=\"1993\">1993 </option><option value=\"1992\">1992 </option><option value=\"1991\">1991 </option><option value=\"1990\">1990 </option><option value=\"1989\">1989 </option><option value=\"1988\">1988 </option><option value=\"1987\">1987 </option><option value=\"1986\">1986 </option><option value=\"1985\">1985 </option><option value=\"1984\">1984 </option><option value=\"1983\">1983 </option><option value=\"1982\">1982 </option><option value=\"1981\">1981 </option><option value=\"1980\">1980 </option><option value=\"1979\">1979 </option><option value=\"1978\">1978 </option><option value=\"1977\">1977 </option><option value=\"1976\">1976 </option><option value=\"1975\">1975 </option><option value=\"1974\">1974 </option></select><br>";
  
  //<select name="monthfrom2">
  newnode=document.createElement("spanwork");
  newnode.innerHTML=newitem1 + newitem2 +newitem4 +newitem3 ;
  div.insertBefore(newnode,button);
  document.getElementById("counter").value=items;
 }
 else
 {
 	alert("You can add up to 5 Work History only");
 } 
}

</script>

<script type="text/javascript">
<!--
function checkFields()
{
	var iyear=document.frmWorkExp.iyear.value
	var ayear=document.frmWorkExp.ayear.value;
	if (document.frmWorkExp.freshgrad[0].checked ==false && document.frmWorkExp.freshgrad[1].checked ==false && document.frmWorkExp.freshgrad[2].checked ==false )
	{
		 alert("Please choose your current Status");
		 return false;
		
	}
	
	if (document.frmWorkExp.available_status[0].checked==false && document.frmWorkExp.available_status[1].checked==false && document.frmWorkExp.available_status[2].checked==false && document.frmWorkExp.available_status[3].checked==false && document.frmWorkExp.freshgrad[0].checked==false)
	{
		alert("Please choose your Availability Status");
		return false;
	}
	if (document.frmWorkExp.available_status[1].checked==true)
	{
		
		if (document.frmWorkExp.aday.selectedIndex=="0")
		{
			alert("Please choose your duration Day");
			return false;
		}
		if (document.frmWorkExp.amonth.selectedIndex=="0")
		{
			alert("Please choose your duration Month");
			return false;
		}
		if(ayear=="")
		{
			alert("Please choose your duration Year");
			return false;
		}
		if(ayear!=""){
			if(ayear.length <4 )
			{
				alert("Please enter a valid Year Format (YYYY)");
				return false;
			}
			if (isNaN(ayear)==true)
			{
				alert("Please enter a valid Year Format (YYYY)");
				return false;
			}
		}	
	
	}
	/////
	if (document.frmWorkExp.freshgrad[0].checked==true)
	{
		if (document.frmWorkExp.intern_status[0].checked==false && document.frmWorkExp.intern_status[1].checked==false)
		{
			alert("Please choose Internship Status");
			return false;
		}
		if (document.frmWorkExp.intern_status[0].checked==true)
		{
			if (document.frmWorkExp.imonth.selectedIndex=="0")
			{
				alert("Please choose Internship Month Period");
				return false;
			}
			if (iyear=="")
			{
				alert("Please choose Internship Year Period");
				return false;
			}
			if(iyear!="")
			{
				if(iyear.length <4 )
				{
					alert("Please enter a valid Year Format (YYYY)");
					return false;
				}
				if (isNaN(iyear)==true)
				{
					alert("Please enter a valid Year Format (YYYY)");
					return false;
				}
			}
			if(document.frmWorkExp.intern_notice.selectedIndex=="0")
			{
				alert("Please choose Duration Month Period");
				return false;
			}
		
		}
	}
	////
	if (document.frmWorkExp.salary_currency.selectedIndex=="0")
	{
		alert("Please choose a Currency");
		return false;
	}
	if (document.frmWorkExp.expected_salary.value=="")
	{
		alert("Please enter your expected salary");
		return false;
	}
	if (document.frmWorkExp.expected_salary.value!=""){
		if (IsNumeric(document.frmWorkExp.expected_salary.value)==false)
		{
			alert("Please enter a valid Salary . Must be a number");
			return false;
		}
	}	
	
return true;
	

}	
-->
</script>
</head>
<body style="background:#ffffff" text="#000000" topmargin="0" leftmargin="0" marginheight="0" marginwidth="0">


<script language=javascript src="js/functions.js"></script>
<script language=javascript src="js/cookie.js"></script>
<script language=javascript src="js/js2/functions.js"></script>
<script language=javascript src="js/js2/png.js"></script>

<script language=javascript src="js/validation.js"></script>
<script language=javascript src="js/java.js"></script>
<script language=javascript src="js/activeX.js"></script>
<script language=javascript src="js/aj_ptitle_spe.js"></script>

<script language = "javascript">
<!--
var myjsAJAX = new myjsAJAX();
function resetCurrentJob()
{
	var frmCurrent = document.frmWorkExp;
	frmCurrent.company_name.value = '';
	frmCurrent.company_industry.options[0].selected = true;
	frmCurrent.title.value = '';
	frmCurrent.position_level.options[0].selected = true;
	frmCurrent.dpt_field.options[0].selected = true;
	frmCurrent.jmonth.options[0].selected = true;
	frmCurrent.jyear.value = '';
	frmCurrent.lmonth.options[0].selected = true;
	frmCurrent.lyear.value = '';
	frmCurrent.media_code.options[0].selected = true;
	frmCurrent.media_others.value = '';
	document.getElementById('spez').innerHTML = '';
}

//-->
</script>
<!-- header -->
<table width="100%" cellpadding="0" cellspacing="0" border="0"  style="background-color:#FFFFFF; background-repeat: repeat-x;">
<tr><td width="546" style="width: 220px; height: 60px;"><img src="images/remotestafflogo.jpg" alt="think" width="416" height="108"></td>
<td width="474">&nbsp;</td>
<td width="211" align="right" valign="bottom"></td>
</tr>
</table>
<table width="100%" border="0" cellpadding="0" cellspacing="0" style="width: 100%; background: URL('images/bg1.gif'); background-repeat: repeat-x">
<tr><td style="border-bottom: 2px #0d509e solid; " >&nbsp;</td>
</tr>
</table>
<!-- header -->
<table cellpadding="0" cellspacing="0" border="0" width="744">
<tr><td width="736" bgcolor="#ffffff" align="center">
<table width="736" cellpadding="0" cellspacing="0" border="0" align="center">
<tr><td>
<table width=736 cellpadding=0 cellspacing=0 border=0 align=center>
<tr><td colspan=2 style='height: 1px;'>
<?php if ($mess!="") {echo "<center><b><font color='#FF0000' size='3'>There's an  ".$mess." Please try again</font></b></center>"; }?>
</td></tr>
<tr><td style='border-right: #006699 2px solid; width: 170px; vertical-align:top; '>
<div style="border: #FFFFFF solid 1px; width:230px; margin-top:20px;">
<p><a href="index.php" class="link12b">Home</a></p>
<p>Applicants Registration Form</p>
<ul>-- Status --
<li style="margin-bottom:10px;">Personal Details <img src="images/action_check.gif" align="absmiddle"></li>
<li style="margin-bottom:10px;">Educational Details <img src="images/action_check.gif" align="absmiddle"></li>
<li style="margin-bottom:10px;"><b style="color:#0000FF">Work Experinced Details </b><img src="images/arrow.gif"></li>
<li style="margin-bottom:10px;">Skills Details <img src="images/cross.gif"></li>
<li style="margin-bottom:10px;">Languages Details <img src="images/cross.gif"></li>
<li style="margin-bottom:10px;">Upload Photo <img src="images/cross.gif"></li>
<li style="margin-bottom:10px;">Voice Recording <img src="images/cross.gif"></li>
</ul>
</div>

</td>
<td width=566 valign=top align=right><img src='images/space.gif' width=1 height=10><br clear=all>
<table width=566 cellpadding=10 cellspacing=0 border=0>
<tr><td><table width=98% cellspacing=0 cellpadding=0 align=center><tr><td class=msg><b>Fill in this section to give employers a snapshot of your profile.</b> <br></td>
</tr></table>
<br>
<script language="javascript">
function toggleWorkExp(oRd, iYr, iMth)
{
	if (iYr != '' || iMth != '')
	{
		oRd[2].checked = true;
	}
}
</script>
<form name="frmWorkExp" method="POST" action="currentJobphp.php" onSubmit="return checkFields();">
<input type="hidden" name="userid" value="<?php echo $userid?>">
<b>Current Status:</b>
<table width=100% cellspacing=8 cellpadding=2 border=0>
<tr><td width=5% ><input name="freshgrad" type="radio"  onClick="javascript: switchAvailability(this.value);" value="2"></td>
<td>I am still pursuing my studies and seeking internship or part-time jobs</td></tr>
<tr><td width=5% ><input type="radio" name="freshgrad" value="1"  onClick="javascript: switchAvailability(this.value);"></td>
<td>I am a fresh graduate seeking my first job</td></tr>
<tr><td width=5% ><input type="radio" name="freshgrad" value="0" onClick="javascript: switchAvailability(this.value);"></td>
<td >I have been working for
 <select name="years_worked" style="width:40px;" class="text">
<option value='0'>0</option>
<?php echo $yearsoptions;?>
</select>
&nbsp;year(s)
 <select name="months_worked" style="width:40px;" class="text">
 <?php echo $monthoptions;?>
 </select>
 &nbsp;month(s)</td></tr></table>
 <br clear=all>
<table width=100% cellspacing=8 cellpadding=2 border=0 align=left >
<tr><td width=100% bgcolor=#DEE5EB colspan=3><b> Current / Latest Job Title</b></td></tr>
<tr valign=top><td align=right width=30% >Title :</td>
<td><INPUT maxLength=100 size=30 style='width:270px' class="text" name="latest_job_title" value=""></td></tr>

<tr><td width=100% bgcolor=#DEE5EB colspan=2><b>Current Job (SKIP if you have no working experience)</b></td></tr>
<tr><td colspan=2 >
<input type="hidden" name="counter" id="counter" value=0 />
<div id="work">
<div id="workhistory">
<label>Company Name:</label>
<input name="companyname" type="text" id="companyname" size="45"  />						
<br />
<label>Position/Title:</label>
<input name="position" type="text" id="position"  size="45"  />
<br />
<label>Employment Period:</label>
<select name="monthfrom">
                <option value="JAN">JAN </option>
                <option value="FEB">FEB </option>
                <option selected="selected" value="MAR">MAR </option>
                <option value="APR">APR </option>
                <option value="MAY">MAY </option>
                <option value="JUN">JUN </option>
                <option value="JUL">JUL </option>
                <option value="AUG">AUG </option>
                <option value="SEP">SEP </option>
                <option value="OCT">OCT </option>
                <option value="NOV">NOV </option>
                <option value="DEC">DEC </option>
              </select>
			  <select name="yearfrom" >
              	<option value="2011"selected>2011 </option>
                <option value="2010">2010 </option>
				<option value="2009">2009 </option>
				  <option value="2008">2008 </option>
				  <option value="2008">2008 </option>
                  <option value="2007">2007 </option>
                  <option value="2006">2006 </option>
                  <option value="2005">2005 </option>
                  <option value="2004">2004 </option>
                  <option value="2003">2003 </option>
                  <option value="2002">2002 </option>
                  <option value="2001">2001 </option>
                  <option value="2000">2000 </option>
                  <option value="1999">1999 </option>
                  <option value="1998">1998 </option>
                  <option value="1997">1997 </option>
                  <option value="1996">1996 </option>
                  <option value="1995">1995 </option>
                  <option value="1994">1994 </option>
                  <option value="1993">1993 </option>
                  <option value="1992">1992 </option>
                  <option value="1991">1991 </option>
                  <option value="1990">1990 </option>
                  <option value="1989">1989 </option>
                  <option value="1988">1988 </option>
                  <option value="1987">1987 </option>
                  <option value="1986">1986 </option>
                  <option value="1985">1985 </option>
                  <option value="1984">1984 </option>
                  <option value="1983">1983 </option>
                  <option value="1982">1982 </option>
                  <option value="1981">1981 </option>
                  <option value="1980">1980 </option>
                  <option value="1979">1979 </option>
                  <option value="1978">1978 </option>
                  <option value="1977">1977 </option>
                  <option value="1976">1976 </option>
                  <option value="1975">1975 </option>
                  <option value="1974">1974 </option>
                  <option value="1973">1973 </option>
                  <option value="1972">1972 </option>
                  <option value="1971">1971 </option>
                  <option value="1970">1970 </option>
                  <option value="1969">1969 </option>
                  <option value="1968">1968 </option>
                  <option value="1967">1967 </option>
                  <option value="1966">1966 </option>
                  <option value="1965">1965 </option>
                  <option value="1964">1964 </option>
                  <option value="1963">1963 </option>
                  <option value="1962">1962 </option>
                  <option value="1961">1961 </option>
                  <option value="1960">1960 </option>
                  <option value="1959">1959 </option>
                  <option value="1958">1958 </option>
                  <option value="1957">1957 </option>
                  <option value="1956">1956 </option>
                  <option value="1955">1955 </option>
                  <option value="1954">1954 </option>
                  <option value="1953">1953 </option>
                  <option value="1952">1952 </option>
                  <option value="1951">1951 </option>
                  <option value="1950">1950 </option>
                </select>
			  <select name="monthto" >
                <option value="JAN">JAN </option>
                <option value="FEB">FEB </option>
                <option  value="MAR">MAR </option>
                <option value="APR">APR </option>
                <option value="MAY">MAY </option>
                <option value="JUN">JUN </option>
                <option value="JUL">JUL </option>
                <option value="AUG">AUG </option>
                <option value="SEP">SEP </option>
                <option value="OCT">OCT </option>
                <option value="NOV">NOV </option>
                <option value="DEC">DEC </option>
                </select>
			  <select name="yearto" >
              	<option value="2011"selected>2011 </option>
                <option value="2010">2010 </option>
				<option value="2009">2009 </option>
                <option value="2008">2008 </option>
                <option value="2007">2007 </option>
                <option value="2006">2006 </option>
                <option value="2005">2005 </option>
                <option value="2004">2004 </option>
                <option value="2003">2003 </option>
                <option value="2002">2002 </option>
                <option value="2001">2001 </option>
                <option value="2000">2000 </option>
                <option value="1999">1999 </option>
                <option value="1998">1998 </option>
                <option value="1997">1997 </option>
                <option value="1996">1996 </option>
                <option value="1995">1995 </option>
                <option value="1994">1994 </option>
                <option value="1993">1993 </option>
                <option value="1992">1992 </option>
                <option value="1991">1991 </option>
                <option value="1990">1990 </option>
                <option value="1989">1989 </option>
                <option value="1988">1988 </option>
                <option value="1987">1987 </option>
                <option value="1986">1986 </option>
                <option value="1985">1985 </option>
                <option value="1984">1984 </option>
                <option value="1983">1983 </option>
                <option value="1982">1982 </option>
                <option value="1981">1981 </option>
                <option value="1980">1980 </option>
                <option value="1979">1979 </option>
                <option value="1978">1978 </option>
                <option value="1977">1977 </option>
                <option value="1976">1976 </option>
                <option value="1975">1975 </option>
                <option value="1974">1974 </option>
                <option value="1973">1973 </option>
                <option value="1972">1972 </option>
                <option value="1971">1971 </option>
                <option value="1970">1970 </option>
                <option value="1969">1969 </option>
                <option value="1968">1968 </option>
                <option value="1967">1967 </option>
                <option value="1966">1966 </option>
                <option value="1965">1965 </option>
                <option value="1964">1964 </option>
                <option value="1963">1963 </option>
                <option value="1962">1962 </option>
                <option value="1961">1961 </option>
                <option value="1960">1960 </option>
                <option value="1959">1959 </option>
                <option value="1958">1958 </option>
                <option value="1957">1957 </option>
                <option value="1956">1956 </option>
                <option value="1955">1955 </option>
                <option value="1954">1954 </option>
                <option value="1953">1953 </option>
                <option value="1952">1952 </option>
                <option value="1951">1951 </option>
                <option value="1950">1950 </option>
              </select>
			  <br />			 
<label>Responsibilities / Achievments:</label>
<textarea rows="7" cols="30" name="duties" ></textarea>
<br />



</div>
</div>
<br /><br />
<strong><a href="javascript: AddWork();"><font color="#FF0000">Don't forgtet to add more work history</font></a></strong>

</td></tr>
</table>
  
<!--
<br clear=all><br>
<table width=100% cellspacing=8 cellpadding=2 border=0 align=left ><tr><td width=100% bgcolor=#DEE5EB colspan=2><b>Availability Status</b></td></tr>
<tr><td>
<div id='availNormal' class='toggle' >
<table width=100% cellspacing=2 cellpadding=2 border=0><tr><td width='5%'>


<INPUT type="radio" value="a" name="available_status" ></td>
<td width=95% >I can start work after
<select style='width:40px' class="text" name="available_notice">
<?php echo $monthoptions2;?>
</select>&nbsp;month(s) of notice period
</td></tr>


<tr><td width=5% >
<INPUT type=radio value="b" name="available_status" ></td>
<td width=95% >I can start work after
<select name="aday" class="text"> 
<option value='0'></option>
<?php echo $nums;?>
</select>
 - <select name="amonth" class="text">
<option value='0'></option>
<?php echo $monthnameoptions3;?>
</select> - <input type=text name="ayear" size=4 maxlength=4 style='width=50px' value=''  class=text> (YYYY)</td></tr>


<tr><td width=5% >
<INPUT type=radio value="p" name="available_status" >
</td>
<td width=95% >I am not actively looking for a job now</td></tr>


<tr><td width=5% >
<INPUT type=radio value="Work Immediately" name="available_status" >
</td>
<td width=95% >Work Immediately</td></tr>

</table>
</div>
-->
<INPUT type="hidden" value="Work Immediately" name="available_status" >







<div id='availIntern' class='toggle'>
<table width=100% cellspacing=2 cellpadding=2 border=0>
<tr valign=top><td width='5%'>

<INPUT type=radio value="x" name="intern_status" ></td>
<td width='95%' >I am available for internship jobs.<div style='padding-top:3px;'>My internship period is from 
<select name="iday" class="text"> 
<?php echo $nums2;?>
</select> - 
<select name="imonth" class="text">
<option value='0'></option>
<?php echo $monthnameoptions4;?>
</select> - 

<input type=text name="iyear" size=4 maxlength=4 style='width=50px' value=''  class=text> (YYYY),<br> and the duration is 
<select style='width:40px' class="text" name="intern_notice">
<option value='0'></option>
<?php echo $monthnums;?>
</select> month(s)

</div>
</td></tr>
<tr>
<td width='5%' ><INPUT type=radio value="p" name="intern_status" ></td>
<td width='95%' >I am not looking for an internship now</td>
</tr>
</table>
</div></td></tr>
</table>
<br clear=all><br>
<table width=100% cellspacing=8 cellpadding=2 border=0 align=left >
<tr><td width=100% bgcolor=#DEE5EB colspan=2>
<b>Expected Salary (Optional)</b></td>
</tr><tr><td width=30% align=right>Expected Monthly Salary :</td><td width=70% >
<select name="salary_currency" style="font:8pt, Verdana" >  
<option value="0">-</option>
<?php echo $currencyoptions;?>
</select>&nbsp;&nbsp;
<input type="text" class="text" name="expected_salary" maxlength="15" size="16" value="">&nbsp;&nbsp;
<INPUT type="checkbox" value="Yes" name="expected_salary_neg" >Negotiable</td></tr></table>
<br clear=all><table border=0 align=center cellpadding=4 cellspacing=2><tr><td align=center>
<input type="submit"  value="Save &amp; Next" name=btnSubmit class="button" style="width:120px;"></td></tr></table></form>
<script language="javascript">
<!--
	switchAvailability (GetValueFromRdo(document.frmWorkExp.freshgrad));
	//enableFill(document.frmWorkExp.media_code.options[document.frmWorkExp.media_code.selectedIndex].value);
	function switchAvailability (ExpType) {
		if (ExpType == "2") {
			document.all.availNormal.className = 'toggle';
			document.all.availIntern.className = 'toggleshow';
			document.frmWorkExp.available_status[0].checked = false;
			document.frmWorkExp.available_status[1].checked = false;
			document.frmWorkExp.available_status[2].checked = false;
			document.frmWorkExp.available_notice.value = "";
			document.frmWorkExp.aday.selectedIndex = 0;
			document.frmWorkExp.amonth.selectedIndex = 0;
			document.frmWorkExp.ayear.value = "";
		} else {
			document.all.availNormal.className = 'toggleshow';
			document.all.availIntern.className = 'toggle';
			document.frmWorkExp.intern_status[0].checked = false;
			document.frmWorkExp.intern_status[1].checked = false;
			document.frmWorkExp.intern_notice.value = "0"
			document.frmWorkExp.iday.selectedIndex = 0;
			document.frmWorkExp.imonth.selectedIndex = 0;
			document.frmWorkExp.iyear.value = "";
		}		
	}
	
	
//-->
</script>
</td></tr></table></td></tr></table>
				</td></tr>
			</table>
		</td></tr>
</table>
<?php include 'footer.php'?>
</body>
</html>
