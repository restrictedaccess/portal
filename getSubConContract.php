<?
include 'config.php';
include 'conf.php';
include 'time.php';
include 'function.php';

if($_SESSION['admin_id']=="")
{
	header("location:index.php");
}

$admin_id = $_SESSION['admin_id'];

$AusTime = date("H:i:s"); 
$AusDate = date("Y")."-".date("m")."-".date("d");
$ATZ = $AusDate." ".$AusTime;

$admin_id = $_SESSION['admin_id'];
$admin_status=$_SESSION['status'];

$userid=$_REQUEST['userid'];
$leads_id=$_REQUEST['lid'];
$sid=$_REQUEST['sid'];
$posting_id=$_REQUEST['pid'];

	  


$query="SELECT l.fname,l.lname,DATE_FORMAT(starting_date,'%D %b %Y'), client_price,  working_hours, working_days, php_monthly, php_weekly, php_daily, php_hourly,
 s.starting_hours, s.ending_hours

FROM personal u JOIN applicants a ON a.userid = u.userid 
JOIN subcontractors s ON s.userid = u.userid
JOIN leads l ON l.id = s.leads_id
WHERE u.userid =$userid AND s.id=$sid;";

$result=mysql_query($query);
if(!$result){
	die($query.mysql_error());
}

list($lead_fname,$lead_lname,$starting_date,$client_price, $working_hours, $working_days, $php_monthly, $php_weekly, $php_daily, $php_hourly, $starting_hours, $ending_hours ) = mysql_fetch_array($result);

if ($starting_hours=="6")
{
	$starting_hours = "6:00 am";
}		
if ($starting_hours=="7")
{
	$starting_hours = "7:00 am";
}		
if ($starting_hours=="8")
{
	$starting_hours = "8:00 am";
}		
if ($starting_hours=="9")
{
	$starting_hours = "9:00 am";
}		
if ($starting_hours=="10")
{
	$starting_hours = "10:00 am";
}
if ($starting_hours=="11")
{
	$starting_hours = "11:00 am";
}
if ($starting_hours=="12")
{
	$starting_hours = "12:00 noon";
}
if ($starting_hours=="13")
{
	$starting_hours = "1:00 pm";
}
if ($starting_hours=="14")
{
	$starting_hours = "2:00 pm";
}
if ($starting_hours=="15")
{
	$starting_hours = "3:00 pm";
}
if ($starting_hours=="16")
{
	$starting_hours = "4:00 pm";
}
if ($starting_hours=="17")
{
	$starting_hours = "5:00 pm";
}
if ($starting_hours=="18")
{
	$starting_hours = "6:00 pm";
}
if ($starting_hours=="19")
{
	$starting_hours = "7:00 pm";
}
if ($starting_hours=="20")
{
	$starting_hours = "8:00 pm";
}
if ($starting_hours=="21")
{
	$starting_hours = "9:00 pm";
}
if ($starting_hours=="22")
{
	$starting_hours = "10:00 pm";
}
if ($starting_hours=="23")
{
	$starting_hours = "11:00 pm";
}
if ($starting_hours=="24")
{
	$starting_hours = "12:00 am";
}

//////////////////////////////////
if ($ending_hours=="6")
{
	$ending_hours = "6:00 am";
}
if ($ending_hours=="7")
{
	$ending_hours = "7:00 am";
}
if ($ending_hours=="8")
{
	$ending_hours = "8:00 am";
}
if ($ending_hours=="9")
{
	$ending_hours = "9:00 am";
}
if ($ending_hours=="10")
{
	$ending_hours = "10:00 am";
}
if ($ending_hours=="11")
{
	$ending_hours = "11:00 am";
}
if ($ending_hours=="12")
{
	$ending_hours = "12:00 noon";
}
if ($ending_hours=="13")
{
	$ending_hours = "1:00 pm";
}
if ($ending_hours=="14")
{
	$ending_hours = "2:00 pm";
}
if ($ending_hours=="15")
{
	$ending_hours = "3:00 pm";
}
if ($ending_hours=="16")
{
	$ending_hours = "4:00 pm";
}
if ($ending_hours=="17")
{
	$ending_hours = "5:00 pm";
}
if ($ending_hours=="18")
{
	$ending_hours = "6:00 pm";
}
if ($ending_hours=="19")
{
	$ending_hours = "7:00 pm";
}
if ($ending_hours=="20")
{
	$ending_hours = "8:00 pm";
}
if ($ending_hours=="21")
{
	$ending_hours = "9:00 pm";
}
if ($ending_hours=="22")
{
	$ending_hours = "10:00 pm";
}
if ($ending_hours=="23")
{
	$ending_hours = "11:00 pm";
}
if ($ending_hours=="24")
{
	$ending_hours = "12:00 am";
}	
//echo $query;
//echo $current_rate;
//echo $total_charge_out_rate;
//echo $starting_hours." - ".$ending_hours;
$client_price = $client_price ? $client_price : '0';
$php_monthly = $php_monthly ? $php_monthly : '0';
$starting_date = $starting_date ? $starting_date : '&nbsp;';
$php_monthly = $php_monthly ? $php_monthly : '0';
$php_weekly = $php_weekly ? $php_weekly : '0';
$php_daily = $php_daily ? $php_daily : '0';
$php_hourly = $php_hourly ? $php_hourly : '0';
$working_hours = $working_hours ? $working_hours : '&nbsp;';
$working_days = $working_days ? $working_days : '&nbsp;';
?>
<input type='hidden' name='sid' id='sid' value="<? echo $sid;?>">
<input type='hidden' name='leads_id' id='leads_id' value="<? echo $leads_id;?>">
<div style="padding:5px; background:#CCCCCC; border:#666666 outset 1px;"><b>Contract Details</b></div>
<div style="padding:5px; border:#666666 solid 1px;">
<p><label>Sub-Contracted to:</label><?=$lead_fname." ".$lead_lname;?></p>
<p><label>Client Price :</label>$ <?=number_format($client_price,2,'.',',');?></p>
<p><label>Work Date Started :</label><?=$starting_date;?></p>
<hr>
<p><label>Monthly Salary :</label>P <?=number_format($php_monthly,2,'.',',');?></p>
<p><label>Weekly Rate :</label>P <?=number_format($php_weekly,2,'.',',');?></p>
<p><label>Daily Rate :</label>P <?=number_format($php_daily,2,'.',',');?></p>
<p><label>Hourly Rate :</label>P <?=number_format($php_hourly,2,'.',',');?></p>
<hr>
<p><label>Working Hours :</label><?=$starting_hours." - ".$ending_hours;?></p>
<p><label>Working Days/Week :</label><?=$working_days;?></p>
<p><label>Working Hours/Day :</label><?=$working_hours;?></p>
<p align="center"><input type="button"  value="View Contract Details" onClick="gotoEditContractForm();"></p>



</div>








