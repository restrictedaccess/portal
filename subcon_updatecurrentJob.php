<?php
//  2011-08-24 Lawrence Sunglao <lawrence.sunglao@remotestaff.com.au>
//  -   Made the script aware of current year
//  -   Add Tiny MCE on Responsibilities / Achievements
//  -   Made the script unix format
//  2010-02-26 Lawrence Sunglao <lawrence.sunglao@remotestaff.com.au>
//  -   Add year 2010 to the Employment year list
include 'conf.php';
include 'config.php';
include 'conf/zend_smarty_conf.php';

define(MIN_YEAR, 1950);

$userid=$_SESSION['userid'];
//echo $userid;
$mess="";
$mess=$_REQUEST['mess'];

$query="SELECT * FROM currentjob WHERE userid=$userid";
$result=mysql_query($query);
$ctr=@mysql_num_rows($result);
if ($ctr >0 )
{
	$row3 = mysql_fetch_array ($result); 
	// 1
	$company = $row3['companyname'];
	$position= $row3['position'];
	$monthfrom = $row3['monthfrom'];
	$yearfrom = $row3['yearfrom'];
	$monthto = $row3['monthto'];
	$yearto = $row3['yearto'];
	$duties =$row3['duties'];
	// 2
	$company2 = $row3['companyname2'];
	$position2= $row3['position2'];
	$monthfrom2 = $row3['monthfrom2'];
	$yearfrom2 = $row3['yearfrom2'];
	$monthto2 = $row3['monthto2'];
	$yearto2 = $row3['yearto2'];
	$duties2 =$row3['duties2'];
	// 3
	$company3 = $row3['companyname3'];
	$position3= $row3['position3'];
	$monthfrom3 = $row3['monthfrom3'];
	$yearfrom3 = $row3['yearfrom3'];
	$monthto3 = $row3['monthto3'];
	$yearto3 = $row3['yearto3'];
	$duties3 =$row3['duties3'];
	// 4
	$company4 = $row3['companyname4'];
	$position4= $row3['position4'];
	$monthfrom4 = $row3['monthfrom4'];
	$yearfrom4 = $row3['yearfrom4'];
	$monthto4 = $row3['monthto4'];
	$yearto4 = $row3['yearto4'];
	$duties4 =$row3['duties4'];
	//5
	$company5 = $row3['companyname5'];
	$position5= $row3['position5'];
	$monthfrom5 = $row3['monthfrom5'];
	$yearfrom5 = $row3['yearfrom5'];
	$monthto5 = $row3['monthto5'];
	$yearto5 = $row3['yearto5'];
	$duties5 =$row3['duties5'];
	
	///////////////////////////
	$currency =$row3['salary_currency'];
	$salary =$row3['expected_salary'];
	$neg = $row3['expected_salary_neg'];
	
	$freshgrad = $row3['freshgrad'];
	$available_status = $row3['available_status'];
	$latest_job_title = $row3['latest_job_title'];
	$years_worked = $row3['years_worked'];
	$months_worked = $row3['months_worked'];
	$available_notice =$row3['available_notice'];
	$aday =$row3['aday'];
	$amonth = $row3['amonth'];
	//echo $latest_job_title;
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

/*
$monthfrom = $row3['monthfrom'];
$monthto = $row3['monthto'];
*/

$monthShortNamesArray=array("JAN","FEB","MAR","APR","MAY","JUN","JUL","AUG","SEP","OCT","NOV","DEC");
for ($i = 0; $i < count($monthShortNamesArray); $i++)
{
	if($monthfrom == $monthShortNamesArray[$i])
	{
		$monthfromoptions .= "<option selected value=\"$monthShortNamesArray[$i]\">$monthShortNamesArray[$i]</option>\n";
	}
	else
	{
		$monthfromoptions .= "<option value=\"$monthShortNamesArray[$i]\">$monthShortNamesArray[$i]</option>\n";
	}
	
	if($monthfrom2 == $monthShortNamesArray[$i])
	{
		$monthfromoptions2 .= "<option selected value=\"$monthShortNamesArray[$i]\">$monthShortNamesArray[$i]</option>\n";
	}
	else
	{
		$monthfromoptions2 .= "<option value=\"$monthShortNamesArray[$i]\">$monthShortNamesArray[$i]</option>\n";
	}
	
	if($monthfrom3 == $monthShortNamesArray[$i])
	{
		$monthfromoptions3 .= "<option selected value=\"$monthShortNamesArray[$i]\">$monthShortNamesArray[$i]</option>\n";
	}
	else
	{
		$monthfromoptions3 .= "<option value=\"$monthShortNamesArray[$i]\">$monthShortNamesArray[$i]</option>\n";
	}
	if($monthfrom4 == $monthShortNamesArray[$i])
	{
		$monthfromoptions4 .= "<option selected value=\"$monthShortNamesArray[$i]\">$monthShortNamesArray[$i]</option>\n";
	}
	else
	{
		$monthfromoptions4 .= "<option value=\"$monthShortNamesArray[$i]\">$monthShortNamesArray[$i]</option>\n";
	}
	if($monthfrom5 == $monthShortNamesArray[$i])
	{
		$monthfromoptions5 .= "<option selected value=\"$monthShortNamesArray[$i]\">$monthShortNamesArray[$i]</option>\n";
	}
	else
	{
		$monthfromoptions5 .= "<option value=\"$monthShortNamesArray[$i]\">$monthShortNamesArray[$i]</option>\n";
	}
	// monthto
	if($monthto == $monthShortNamesArray[$i])
	{
		$monthtooptions .= "<option selected value=\"$monthShortNamesArray[$i]\">$monthShortNamesArray[$i]</option>\n";
	}
	else
	{
		$monthtooptions .= "<option value=\"$monthShortNamesArray[$i]\">$monthShortNamesArray[$i]</option>\n";
	}
	
	if($monthto2 == $monthShortNamesArray[$i])
	{
		$monthtooptions2 .= "<option selected value=\"$monthShortNamesArray[$i]\">$monthShortNamesArray[$i]</option>\n";
	}
	else
	{
		$monthtooptions2 .= "<option value=\"$monthShortNamesArray[$i]\">$monthShortNamesArray[$i]</option>\n";
	}
	
	if($monthto3 == $monthShortNamesArray[$i])
	{
		$monthtooptions3 .= "<option selected value=\"$monthShortNamesArray[$i]\">$monthShortNamesArray[$i]</option>\n";
	}
	else
	{
		$monthtooptions3 .= "<option value=\"$monthShortNamesArray[$i]\">$monthShortNamesArray[$i]</option>\n";
	}
	
	if($monthto4 == $monthShortNamesArray[$i])
	{
		$monthtooptions4 .= "<option selected value=\"$monthShortNamesArray[$i]\">$monthShortNamesArray[$i]</option>\n";
	}
	else
	{
		$monthtooptions4 .= "<option value=\"$monthShortNamesArray[$i]\">$monthShortNamesArray[$i]</option>\n";
	}
	
	if($monthto5 == $monthShortNamesArray[$i])
	{
		$monthtooptions5 .= "<option selected value=\"$monthShortNamesArray[$i]\">$monthShortNamesArray[$i]</option>\n";
	}
	else
	{
		$monthtooptions5 .= "<option value=\"$monthShortNamesArray[$i]\">$monthShortNamesArray[$i]</option>\n";
	}
}  

/*
$yearfrom = $row3['yearfrom'];
$yearto = $row3['yearto'];
*/

$now = new Zend_Date();
$now_year = $now->toString("yyyy");
$yearArray = array();

for ($i = $now_year; $i >= MIN_YEAR; $i--) {
    $yearArray[] = sprintf('%s', $i);
}
for ($i = 0; $i < count($yearArray); $i++)
{
	if($yearfrom == $yearArray[$i])
	{
		$yearfromoptions .= "<option selected value=\"$yearArray[$i]\">$yearArray[$i]</option>\n";
	}
	else
	{
		$yearfromoptions .= "<option value=\"$yearArray[$i]\">$yearArray[$i]</option>\n";
	}
	
	if($yearfrom2 == $yearArray[$i])
	{
		$yearfromoptions2 .= "<option selected value=\"$yearArray[$i]\">$yearArray[$i]</option>\n";
	}
	else
	{
		$yearfromoptions2 .= "<option value=\"$yearArray[$i]\">$yearArray[$i]</option>\n";
	}
	
	if($yearfrom3 == $yearArray[$i])
	{
		$yearfromoptions3 .= "<option selected value=\"$yearArray[$i]\">$yearArray[$i]</option>\n";
	}
	else
	{
		$yearfromoptions3 .= "<option value=\"$yearArray[$i]\">$yearArray[$i]</option>\n";
	}
	
	if($yearfrom4 == $yearArray[$i])
	{
		$yearfromoptions4 .= "<option selected value=\"$yearArray[$i]\">$yearArray[$i]</option>\n";
	}
	else
	{
		$yearfromoptions4 .= "<option value=\"$yearArray[$i]\">$yearArray[$i]</option>\n";
	}
	
	if($yearfrom5 == $yearArray[$i])
	{
		$yearfromoptions5 .= "<option selected value=\"$yearArray[$i]\">$yearArray[$i]</option>\n";
	}
	else
	{
		$yearfromoptions5 .= "<option value=\"$yearArray[$i]\">$yearArray[$i]</option>\n";
	}
	
	//$yearto
	if($yearto == $yearArray[$i])
	{
		$yeartooptions .= "<option selected value=\"$yearArray[$i]\">$yearArray[$i]</option>\n";
	}
	else
	{
		$yeartooptions .= "<option value=\"$yearArray[$i]\">$yearArray[$i]</option>\n";
	}
	
	if($yearto2 == $yearArray[$i])
	{
		$yeartooptions2 .= "<option selected value=\"$yearArray[$i]\">$yearArray[$i]</option>\n";
	}
	else
	{
		$yeartooptions2 .= "<option value=\"$yearArray[$i]\">$yearArray[$i]</option>\n";
	}
	
	if($yearto3 == $yearArray[$i])
	{
		$yeartooptions3.= "<option selected value=\"$yearArray[$i]\">$yearArray[$i]</option>\n";
	}
	else
	{
		$yeartooptions3 .= "<option value=\"$yearArray[$i]\">$yearArray[$i]</option>\n";
	}
	
	if($yearto4 == $yearArray[$i])
	{
		$yeartooptions4 .= "<option selected value=\"$yearArray[$i]\">$yearArray[$i]</option>\n";
	}
	else
	{
		$yeartooptions4 .= "<option value=\"$yearArray[$i]\">$yearArray[$i]</option>\n";
	}
	
	if($yearto5 == $yearArray[$i])
	{
		$yeartooptions5 .= "<option selected value=\"$yearArray[$i]\">$yearArray[$i]</option>\n";
	}
	else
	{
		$yeartooptions5 .= "<option value=\"$yearArray[$i]\">$yearArray[$i]</option>\n";
	}
}


?>
<html>
<head>
<title>Sub-Contractor Home</title>
<link rel=stylesheet type=text/css href="css/font.css">
<link rel=stylesheet type=text/css href="menu.css">
<link rel="icon" href="favicon.ico" type="image/x-icon" />
<link rel="shortcut icon" href="favicon.ico" type="image/x-icon" />

<script language=javascript src="js/util.js"></script>
<script type="text/javascript">
<!--
function checkFields()
{
}
-->
</script>
</head>
<body style="background:#ffffff" text="#000000" topmargin="0" leftmargin="0" marginheight="0" marginwidth="0">
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
<ul class="glossymenu">
 <li ><a href="subconHome.php"><b>Home</b></a></li>
  <li class="current" ><a href="subcon_myresume.php"><b>MyResume</b></a></li>
  <li><a href="subcon_myapplications.php"><b>Applications</b></a></li>
   <li><a href="subcon_jobs.php"><b>Search Jobs</b></a></li>
</ul>

<!-- header -->
<table cellpadding="0" cellspacing="0" border="0" width="800">
<tr><td width="736" bgcolor="#ffffff" align="center">
<table width="736" cellpadding="0" cellspacing="0" border="0" align="center">
<tr><td>
<table width=736 cellpadding=0 cellspacing=0 border=0 align=center>
<tr><td colspan=2 style='height: 1px;'>
<?php if ($mess!="") {echo "<center><b><font color='#FF0000' size='3'>There's an  ".$mess." Please try again</font></b></center>"; }?>
</td></tr>
<tr><td style='border-right: #006699 2px solid; width: 170px; vertical-align:top; '>
<? include 'subcon_leftnav.php';?>

</td>
<td width=566 valign=top align=right><img src='images/space.gif' width=1 height=10><br clear=all>
<table width=600 cellpadding=10 cellspacing=0 border=0>
<tr><td><table width=98% cellspacing=0 cellpadding=0 align=center><tr><td class=msg><b>Fill in this section to give employers a snapshot of your profile.</b> <br></td>
</tr></table>
<br>
<form name="frmWorkExp" method="POST" action="subcon_updatecurrentJobphp.php" onSubmit="return checkFields();">
<input type="hidden" name="userid" value="<?php echo $userid?>">
<b>Current Status:</b>
<table width=100% cellspacing=8 cellpadding=2 border=0>
<tr><td width=5% ><input name="freshgrad" type="radio"  onClick="" value="I am still pursuing my studies and seeking internship or part-time jobs"></td>
<td>I am still pursuing my studies and seeking internship or part-time jobs</td></tr>
<tr><td width=5% ><input type="radio" name="freshgrad" value="I am a fresh graduate seeking my first job"  onClick=""></td>
<td>I am a fresh graduate seeking my first job</td></tr>
<tr><td width=5% ><input type="radio" name="freshgrad" value="I have been working for" ></td>
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
<td><INPUT maxLength=100 size=30 style='width:270px' class="text" name="latest_job_title" value="<?php echo $latest_job_title?>"></td></tr>

<tr><td width=100% bgcolor=#DEE5EB colspan=2><b>Current Job (SKIP if you have no working experience)</b></td></tr>
<tr><td colspan=2 >
<input type="hidden" name="counter" id="counter" value="" />
<div id="work">
<div id="workhistory">
<label>Company Name 1:</label>
<input name="companyname" type="text" id="companyname" size="45" value="<?php echo $company;?>"  />						
<br />
<label>Position/Title:</label>
<input name="position" type="text" id="position"  size="45"  value="<?php echo $position;?>" />
<br />
<label>Employment Period:</label>
<select name="monthfrom"><?php echo $monthfromoptions ;?></select>
			  <select name="yearfrom" >
                 <?php echo $yearfromoptions;?>
                </select>
			  <select name="monthto" ><?php echo $monthtooptions ;?></select>
			  <select name="yearto" >
               <?php echo $yeartooptions;?>
              </select>
			  <br />			 
<label>Responsibilities / Achievements:</label>
<textarea rows="7" cols="30" name="duties" ><?php echo $duties;?></textarea>
<br />
<br>
<label>Company Name 2:</label>
<input name="companyname2" type="text" id="companyname2" size="45" value="<?php echo $company2;?>"  />						
<br />
<label>Position/Title:</label>
<input name="position2" type="text" id="position2"  size="45" value="<?php echo $position2;?>"  />
<br />
<label>Employment Period:</label>
<select name="monthfrom2"><?php echo $monthfromoptions2 ;?></select>
			  <select name="yearfrom2" >
                  <?php echo $yearfromoptions2;?>
                </select>
			  <select name="monthto2" ><?php echo $monthtooptions2 ;?></select>
			  <select name="yearto2" >
                <?php echo $yeartooptions2;?>
              </select>
			  <br />			 
<label>Responsibilities / Achievements:</label>
<textarea rows="7" cols="30" name="duties2" ><?php echo $duties2;?></textarea>
<br>
<br>
<label>Company Name 3:</label>
<input name="companyname3" type="text" id="companyname3" size="45" value="<?php echo $company3;?>"  />						
<br />
<label>Position/Title:</label>
<input name="position3" type="text" id="position3"  size="45"  value="<?php echo $position3;?>"  />
<br />
<label>Employment Period:</label>
<select name="monthfrom3"><?php echo $monthfromoptions3 ;?></select>
			  <select name="yearfrom3" >
                  <?php echo $yearfromoptions3;?>
                </select>
			  <select name="monthto3" ><?php echo $monthtooptions3 ;?></select>
			  <select name="yearto3" >
              <?php echo $yeartooptions3;?>
              </select>
			  <br />			 
<label>Responsibilities / Achievements:</label>
<textarea rows="7" cols="30" name="duties3" ><?php echo $duties3;?></textarea>
<br>
<br>
<label>Company Name 4:</label>
<input name="companyname4" type="text" id="companyname4" size="45" value="<?php echo $company4;?>"  />						
<br />
<label>Position/Title:</label>
<input name="position4" type="text" id="position4"  size="45" value="<?php echo $position4;?>"  />
<br />
<label>Employment Period:</label>
<select name="monthfrom4"><?php echo $monthfromoptions4 ;?></select>
			  <select name="yearfrom4" >
                 <?php echo $yearfromoptions4;?>
                </select>
			  <select name="monthto4" ><?php echo $monthtooptions4 ;?></select>
			  <select name="yearto4" >
              <?php echo $yeartooptions4;?>
              </select>
			  <br />			 
<label>Responsibilities / Achievements:</label>
<textarea rows="7" cols="30" name="duties4" ><?php echo $duties4;?></textarea><br>
<br>
<label>Company Name 5 :</label>
<input name="companyname5" type="text" id="companyname5" size="45" value="<?php echo $company5;?>"  />						
<br />
<label>Position/Title:</label>
<input name="position5" type="text" id="position5"  size="45" value="<?php echo $position5;?>"  />
<br />
<label>Employment Period:</label>
<select name="monthfrom5"><?php echo $monthfromoptions5 ;?></select>
			  <select name="yearfrom5" >
                <?php echo $yearfromoptions5;?>
                </select>
			  <select name="monthto5" ><?php echo $monthtooptions5 ;?></select>
			  <select name="yearto5" >
              <?php echo $yeartooptions5;?>
              </select>
			  <br />			 
<label>Responsibilities / Achievements:</label>
<textarea rows="7" cols="30" name="duties5" ><?php echo $duties5;?></textarea>
<!--<input type="button" name="addwork" class="button" id="addwork" value="Add More Work History" onClick="AddWork();" />-->
</div>
</div>


</td></tr>
</table>
  
<br clear=all><br>
<table width=100% cellspacing=8 cellpadding=2 border=0 align=left ><tr><td width=100% bgcolor=#DEE5EB colspan=2><b>Availability Status</b></td></tr>
<tr><td>


<table width=100% cellspacing=2 cellpadding=2 border=0><tr><td width='5%'>

<!-- 1 -->
<INPUT type="radio" value="a" name="available_status" ></td>
<td width=95% >I can start work after
<select style='width:40px' class="text" name="available_notice">
<?php echo $monthoptions2;?>
</select>&nbsp;month(s) of notice period
</td></tr>

<!-- 2 -->
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
</select> - <input type=text name="ayear" size=4 maxlength=4 style='width=50px' value='<?php echo $ayear;?>'  class=text> (YYYY)</td></tr>

<!-- 3 -->
<tr><td width=5% >
<INPUT type=radio value="p" name="available_status" >
</td>
<td width=95% >I am not actively looking for a job now</td></tr>

<!-- 4 -->
<tr><td width=5% >
<INPUT type=radio value="Work Immediately" name="available_status" >
</td>
<td width=95% >Work Immediately</td></tr>

</table>
<div id='availNormal' class='toggle'>&nbsp;</div>
<!-- ########### -->

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
<input type="submit"  value="Update" name=btnSubmit class="button" style="width:120px;"></td></tr></table></form>
</td></tr></table></td></tr></table>
				</td></tr>
			</table>
		</td></tr>
</table>
<?php include 'footer.php'?>
</body>
<script type="text/javascript" src="media/js/tinymce/jscripts/tiny_mce/tiny_mce.js"></script>	
<script type="text/javascript">
tinyMCE.init({
    mode : "textareas",

    theme : "simple",
});

</script>

</html>
