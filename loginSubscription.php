<?php
include 'config.php';
include 'conf.php';
include 'time.php';


$timeZone = preg_replace('/([+-]\d{2})(\d{2})/','\'\1:\2\'', date('O'));
mysql_query('SET time_zone='.$timeZone);


$userid = $_SESSION['userid'];
$month=$_REQUEST['month'];
//echo $month;

if($month=="")
{
	
	$AusDate = date("Y")."-".date("m")."-".date("d");
	$bmonth=date("F");
	$current_day=date("Y")."-".date("m")."-";
}
else
{
	$AusDate = date("Y")."-".$month."-".date("d");
	$current_day=date("Y")."-".$month."-";
	switch($month)
	{
		case '01':
		$bmonth= "January";
		break;
		case '02':
		$bmonth= "February";
		break;
		case '03':
		$bmonth= "March";
		break;
		case '04':
		$bmonth= "April";
		break;
		case '05':
		$bmonth= "May";
		break;
		case '06':
		$bmonth= "June";
		break;
		case '07':
		$bmonth= "July";
		break;
		case '08':
		$bmonth= "August";
		break;
		case '09':
		$bmonth= "September";
		break;
		case '10':
		$bmonth= "October";
		break;
		case '11':
		$bmonth= "November";
		break;
		case '12':
		$bmonth= "December";
		break;
		
	}
}

$AusTime = date("H:i:s"); 
$AustodayDate = date ("jS \of F Y");
$ATZ = $AusDate." ".$AusTime;
$AusDate2 = date("Y")."-".date("m")."-".date("d");

$query="SELECT * FROM personal WHERE userid=$userid";
$result=mysql_query($query);
$ctr=@mysql_num_rows($result);
if ($ctr >0 )
{
	$row = mysql_fetch_array ($result); 
	$name =$row['fname']." ".$row['lname'];
}



$monthArray=array("","01","02","03","04","05","06","07","08","09","10","11","12");
$monthName=array("-","January","February","March","April","May","June","July","August","September","October","November","December");
 for ($i = 0; $i < count($monthArray); $i++)
  {
      if($month == $monthArray[$i])
      {
	 $monthoptions .= "<option selected value=\"$monthArray[$i]\">$monthName[$i]</option>\n";
      }
      else
      {
	$monthoptions .= "<option value=\"$monthArray[$i]\">$monthName[$i]</option>\n";
      }
   }


?>

<html>
<head>
<title>Sub-contractor Home</title>
<link rel=stylesheet type=text/css href="css/font.css">
<link rel="stylesheet" href="css/light_subcon.css" type="text/css" />
<script language=javascript src="js/timer.js"></script>

</head>


<body style="background:#ffffff" text="#000000" topmargin="0" leftmargin="0" marginheight="0" marginwidth="0">
<form method="POST" name="form" action="loginSubscription.php">
<!-- HEADER -->
<? include 'header.php';?>
<table width="100%" bgcolor="#abccdd" >
<tr><td style="font: 8pt verdana; ">&#160;&#160;<b>Welcome  <? echo $name;?></b></td><td align="right" style="font: 8pt verdana; "></td></tr></table>
<table width="100%" cellpadding="0" cellspacing="0" border="0" align="center">
<tr>
<td width="170" valign="top" style='border-right: #006699 2px solid; width: 170px; vertical-align:top; '>
   <? include 'subconleftnav.php';?>
</td>
<td width="1081" valign="top" style="background-color:#F4F4F4">
<div class="month_calendar"><select name="month"  style="font-size: 12px;" class="text" onChange="javascript: document.form.submit();">
<? echo $monthoptions;?>
</select><?=strtoupper($bmonth);?></div>
<!-- Calendar Starts here -->
<?
/// Get the Total days of the current Month
$sqlTotalDaysMOnth="SELECT DATE_FORMAT(LAST_DAY('$AusDate'),'%d')AS total_days;"; //returns the total days of the curren month
//echo $sqlTotalDaysMOnth;
$result1=mysql_query($sqlTotalDaysMOnth);
$row1 = mysql_fetch_array ($result1); 
$total_days_of_month=$row1['total_days'];
//echo $total_days_of_month."<br>";
/////////////////////////////////////////

//$current_year_month=date("Y")."-".date("m");
//$current_day=date("Y")."-".date("m")."-";
//echo $AusDate ;
//$current_month=date("m");


$daynamesArray=array("Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday");
for($x=0;$x<count($daynamesArray);$x++)
{
?>
<div class="albumsbox">
<h4><?=$daynamesArray[$x];?></h4>
<?
for($i=1; $i<=$total_days_of_month;$i++)
{
	$sqlGetDayname="SELECT DATE_FORMAT('$current_day$i','%W')AS day_name ;";
	//echo $sqlGetDayname;
	$result2=mysql_query($sqlGetDayname);
	$row2 = mysql_fetch_array ($result2); 
	$day_name=$row2['day_name'];
	//echo $i." )<br>".$day_name;
	// Color Coding
	if($day_name=="Sunday")
	{
		$bgcolor="background: #FFEFEC;";	
	}
	elseif($day_name=="Saturday")
	{
		$bgcolor="background: #F5F3FE;";	
	}
	else
	{
		if(strlen($i)==1)
		{
			$i2="0".$i;
		}
		$today=$current_day.$i2;
		//echo $today;
		if($today==$AusDate2)
		{
			$bgcolor="background: #FCFDDF;";
		}
		else{
		$bgcolor="background: #F7F9FD;";
		}
	}	
	
	
	if($day_name==$daynamesArray[$x])
	{
		
?>
<div class="album" style=" <?=$bgcolor;?>">
<div class="thumb"><B><?=$i?></B></div>
<div class="albumdesc">
&nbsp;


</div>
<p style="clear: both; "></p>
</div>

<?
	}
}	
?>	
</div>
<?
}
?>

</div>


<!-- Ends Here -->

<p>&nbsp;</p>

</td>
</tr>
</table>
<? include 'footer.php';?>
</form>
</body>
</html>
