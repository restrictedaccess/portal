<?
include 'config.php';
include 'conf.php';
include 'time.php';
include 'function.php';
include 'time.php';
include 'time_recording/TimeRecording.php';

    /**
     *
     * extends TimeRecording class
     *
     */
    class SubconStatus extends TimeRecording {
        /**
        *
        *   returns a string indicating status of the subcontractor
        */
        function GetStatus() {
            if ($this->buttons['lunch_end']) {
                return "Out to lunch.";
            }
            if ($this->buttons['work_start']) {
                return "Not working.";
            }
            else {
                return "Working.&nbsp;<img src='images/onlinenowFINAL.gif' alt='working'>";
            }
        }
    }
$admin_id = $_SESSION['admin_id'];
$admin_status=$_SESSION['status'];
$leads_id =$_REQUEST['id'];
//echo $leads_id;


$activate_overtime=$_REQUEST['overtime'];
$sid=$_REQUEST['sid'];
if($activate_overtime!="")
{
	if($activate_overtime=="TRUE")
	{
		//echo "Activate Overtime.";
		$sql="UPDATE subcontractors SET overtime='Yes' WHERE id=$sid;";
	}
	if($activate_overtime=="FALSE")
	{
		//echo "DE - Activate Overtime.";
		$sql="UPDATE subcontractors SET overtime='No' WHERE id=$sid;";
	}
		mysql_query($sql);
		//echo $sql;
}
$sql ="SELECT * FROM leads WHERE id = $leads_id;";
//echo $sql;
$resulta=mysql_query($sql);
$ctr2=@mysql_num_rows($resulta);
if ($ctr2 >0 )
{
	//$row = mysql_fetch_array ($result, MYSQL_NUM);lname, fname
	$row = mysql_fetch_array($resulta);
	$client_fullname =$row['fname']." ".$row['lname'];
	
}
/*
admin_id, admin_fname, admin_lname, admin_email, admin_password, admin_created_on, status
*/
$query="SELECT * FROM admin WHERE admin_id=$admin_id;";

$result=mysql_query($query);
$ctr=@mysql_num_rows($result);
if ($ctr >0 )
{
	$row = mysql_fetch_array ($result); 
	$name = $row['admin_lname'].",  ".$row['admin_fname'];
}



?>
<html>
<head>
<title>Administrator-Home</title>
<link rel=stylesheet type=text/css href="css/font.css">
<link rel=stylesheet type=text/css href="adminmenu.css">
<link rel="stylesheet" href="css/light_admin.css" type="text/css" />

<script type='text/javascript' language='JavaScript' src='js/common_funcs.js'></script>
<script type='text/javascript' language='JavaScript' src='js/form_utils.js'></script>

<script type="text/javascript" src="js/calendar.js"></script> 
<script type="text/javascript" src="lang/calendar-en.js"></script> 
<script type="text/javascript" src="js/calendar-setup.js"></script>
<link rel="stylesheet" type="text/css" media="all" href="css/calendar-blue.css" title="win2k-1" />

<style type="text/css">
<!--
div.scroll {
	height: 400px;
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
-->
</style>
	
	
</head>


<body style="background:#ffffff" text="#000000" topmargin="0" leftmargin="0" marginheight="0" marginwidth="0">
<form method="POST" name="form" action="adminHome.php">
<input type="hidden" name="summary" value="<? echo $summary;?>">

<script language=javascript src="js/functions.js"></script>

<!-- HEADER -->
<? include 'header.php';?>
<? include 'admin_header_menu.php';?>
<table width=100% cellpadding=0 cellspacing=0 border=0 align=center>
<tr><td colspan=2 style='height: 1px;'>&nbsp;</td>
</tr>
<tr>
<td width=100% valign=top >
<table width=100%  cellspacing=0 cellpadding=2 border=0 align=left >
<tr>
  <td bgcolor="#666666" height="25" colspan=3><font color='#FFFFFF'><b>Admin Home</b></font></td>
</tr>
<tr ><td  valign="top" style="border-right: #006699 2px solid;"><b><? echo $name;?></b></td><td colspan="2">&nbsp;</td></tr>
<tr><td width="14%" height="135" valign="top" style="border-right: #006699 2px solid;">
<? include 'adminleftnav.php';?>
</td>
<td width="86%" valign="top" align="left">
<!-- LIST HERE -->
<?
$query="SELECT u.userid, u.fname, u.lname,DATE_FORMAT(s.date_contracted,'%D %M %Y'),
aud_monthly, aud_weekly, aud_daily, aud_hourly, working_hours, working_days,
php_monthly, php_weekly, php_daily, php_hourly, details, agent_commission ,think_commission,
l.id,l.fname,l.lname,l.email,a.agent_no,a.fname,a.lname,a.email,a.agent_contact,s.id,
overtime, s.work_status, s.others ,client_price,tax,DATE_FORMAT(starting_date,'%D %b %Y'),DATE_FORMAT(end_date,'%D %b %Y'),starting_hours, ending_hours , s.client_timezone , s.client_start_work_hour, s.client_finish_work_hour
FROM personal u
JOIN subcontractors s ON s.userid = u.userid
JOIN leads l ON l.id = s.leads_id
JOIN agent a ON a.agent_no =s.agent_id

WHERE s.leads_id = $leads_id
AND s.status = 'ACTIVE'
ORDER BY u.fname ASC;";
//echo $query;
$result=mysql_query($query);
if(!$result) die ($query."<br>".mysql_error());
?>
<table width="100%">
<tr><td width=100% bgcolor=#DEE5EB colspan=2><h5>CLIENT (<? echo $client_fullname; ?>) LIST OF SUB-CONTRACTORS</h5></td>
</tr>
<tr>
<td height="50" valign="top">


<table width=100% class="tablecontent" cellspacing=0 cellpadding=7 align=center border=0 bgcolor=#DEE5EB style="border: #333366 solid 1px;">
<tr><td bgcolor=#333366 height=2 colspan="12"></td>
</tr>
<tr >
<td width='6%' height="20" align=left>#</td>
<td width='45%' align=left><b><font size='1'>Name </font></b></td>
<td width='26%' align=left><b><font size='1'>Date Sub-Contracted</font></b></td>
<td width="23%" colspan="8" align=left><b><font size='1'>Agent</font></b></td>
</tr>
<?
	$bgcolor="#FFFFFF";
	while(list($userid, $fname, $lname,$date,$aud_monthly, $aud_weekly, $aud_daily, $aud_hourly, $working_hours, $working_days,$php_monthly, $php_weekly, $php_daily, $php_hourly, $details, $agent_commission ,$think_commission,$leads_id,$leads_fname,$leads_lname,$leads_email,$agent_no,$agent_fname,$agent_lname,$agent_email,$agent_contact,$subcotractors_id,$overtime, $work_status, $others,$client_price,$tax,$starting_date, $end_date,$starting_hours, $ending_hours , $timezone , $client_start_hour , $client_finsh_hour) = mysql_fetch_array($result))
	{
		$counter=$counter+1;
	
?>
	<tr bgcolor=<? echo $bgcolor;?>>
	<td width='6%' height="20" align=left valign="top" style="border-bottom:#999999 solid 1px; border-top:#999999 solid 1px;"><? echo $counter;?>)</td>
	<td width='45%' align=left valign="top" style="border-bottom:#999999 solid 1px; border-top:#999999 solid 1px;"><font size='1'>
	<a href='#' class='link5' onClick= "javascript:popup_win('./resume3.php?userid=<? echo $userid;?>',800,500);"><b>
	<? echo $fname." ".$lname;?>	</b></a><br>
	<? $subcon_status = new SubconStatus($userid);
	echo $subcon_status->GetStatus(); ?>
	</font></td>
	<td width='26%'  align=left valign="top" style="border-bottom:#999999 solid 1px; border-top:#999999 solid 1px;"><font size='1' color="#FF0000"><? echo $starting_date;?></font><br>
	  <font size='1'>
	<? //echo $companyname."<br><b>".$jobposition."</b>";?>		</font></td>
	<td colspan="8" align=left style="border-left:#999999 solid 1px; border-bottom:#999999 solid 1px; border-top:#999999 solid 1px;" valign="top">
	<font size='1'><? echo $agent_fname." ".$agent_lname." <br>".$agent_email;?></font></td>
	</tr>
 	<?
			 // if($bgcolor=="#f5f5f5")
			  //{
			  //	$bgcolor="#FFFFFF";
			  //}
			  //else
			 // {
			  	$bgcolor="#f5f5f5";
			 // }
	?>
	<tr bgcolor='#ced6de'>
	<td align='left' colspan="12"><a href='javascript: show_hide("reply_form<? echo $counter;?>");'>Show / Hide Contract Details</a></td></tr>
	<tr bgcolor=<? echo $bgcolor;?> ><td colspan='12' valign="top"><div id='reply_form<? echo $counter;?>' style='display:none;'>
	<!-- CONTRACT DETAILS -->
<table width="100%" style="border:#CCCCCC solid 1px;" cellpadding="1" cellspacing="0">
<tr bgcolor='#666666'>
<td><font size='1' color="#FFFFFF"><b>Sub-Contractor&nbsp;(<? echo $fname." ".$lname;?>)&nbsp;Contract Details</b></font><br></td><td align="right">Edit</td>
</tr>
<tr>
<td colspan="2" valign="top">
<!--table here -->

<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr><td colspan="15" bgcolor="#333333" height="2"></td></tr>
  <tr bgcolor="#FFFFFF">
    <td height="29" colspan="4" valign="middle"><strong>Australian Rate</strong></td>
    <td colspan="4" valign="middle"><strong>Philippine Rate</strong></td>
    <td colspan="4" valign="middle"><strong>Charge Rate Out</strong></td>
    <td colspan="3" valign="middle"><strong>Working Details</strong></td>
  </tr>
  <tr>
    <td width="9%">Monthly</td>
    <td width="1%">:</td>
    <td width="4%">$<? echo  number_format($aud_monthly,2);?></td>
    <td width="5%"></td>
    <td width="6%">Monthly</td>
    <td width="1%">:</td>
    <td width="9%">Php&nbsp;<? echo number_format($php_monthly,2);?></td>
    <td width="4%"></td>
    <td width="13%">Charge to Client</td>
    <td width="1%">:</td>
    <td width="11%"><b>$<? echo number_format($client_price,2);?></b><font size="1" color="#999999">
      <? if ($tax!="") { echo "<br>
10% GST included"; } else { echo "<br>
No GST Included"; }?>
    </font></td>
    <td width="3%"></td>
    <td width="14%">Working Days</td>
    <td width="1%">:</td>
    <td width="18%"><? echo $working_days;?></td>
  </tr>
  <tr>
    <td width="9%">Weekly</td>
    <td width="1%">:</td>
    <td width="4%">$<? echo  number_format($aud_weekly,2);?></td>
    <td width="5%"></td>
    <td width="6%">Weekly</td>
    <td width="1%">:</td>
    <td width="9%">Php&nbsp;<? echo number_format($php_weekly,2);?></td>
    <td width="4%"></td>
    <td width="13%">GST&nbsp;<font size="1" color="#999999">10%</font></td>
    <td width="1%">:</td>
    <td width="11%">$<? echo number_format($tax,2);?></td>
    <td width="3%"></td>
    <td>Working Hours</td>
    <td>:</td>
    <td><? echo $working_hours;?></td>
  </tr>
  <tr>
    <td width="9%">Daily</td>
    <td width="1%">:</td>
    <td width="4%">$<? echo number_format($aud_daily,2);?></td>
    <td width="5%"></td>
    <td width="6%">Daily</td>
    <td width="1%">:</td>
    <td width="9%">Php&nbsp;<? echo number_format($php_daily,2);?></td>
    <td width="4%"></td>
    <td width="13%">Agent Commission</td>
    <td width="1%">:</td>
    <td width="11%">$<? echo number_format($agent_commission,2);?></td>
    <td width="3%"></td>
    <td  >Duration</td>
    <td>:</td>
    <td ><? echo $starting_date." "."to<br />"." ".$end_date;?></td>
  </tr>
  <tr>
    <td width="9%">Hourly Rate</td>
    <td width="1%">:</td>
    <td width="4%">$<? echo number_format($aud_hourly,2);?></td>
    <td width="5%"></td>
    <td width="6%">Hourly</td>
    <td width="1%">:</td>
    <td width="9%">Php&nbsp;<? echo number_format($php_hourly,2);?></td>
    <td width="4%"></td>
    <td>Company Commission</td>
    <td>:</td>
    <td><b>$<? echo number_format($think_commission,2);?></b></td>
    <td width="3%"></td>
    <td>Working Hours </td>
    <td>:</td>
    <td><? echo $staff_working_hours = setConvertTimezones($timezone, 'Asia/Manila' , $client_start_hour, $client_finsh_hour);?></td>
  </tr>
  <tr>
    <td width="9%">&nbsp;</td>
    <td width="1%"></td>
    <td width="4%">&nbsp;</td>
    <td width="5%"></td>
    <td width="6%">&nbsp;</td>
    <td width="1%"></td>
    <td width="9%">&nbsp;</td>
    <td width="4%"></td>
    <td width="13%">&nbsp;</td>
    <td width="1%">&nbsp;</td>
    <td width="11%">&nbsp;</td>
    <td width="3%"></td>
    <td >Overtime Permitted</td>
    <td>:</td>
    <td><?
	echo $overtime;
	echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"; //$subcotractors_id
	if($overtime =="Yes")
	{
		echo "<a href='admin_Client_SubCon.php?overtime=FALSE&sid=$subcotractors_id&id=$leads_id'>De-Activate</a>";
	}	
	else
	{
		echo "<a href='admin_Client_SubCon.php?overtime=TRUE&sid=$subcotractors_id&id=$leads_id'>Activate</a>";
	}
	
	
	?></td>
  </tr>
</table>


<!--table here --></td>
</tr>
<tr><td height="20" colspan="2">Details :&nbsp;<? 
	if($details!="") echo $details;
	?></td></tr>
</table>



<!-- CONTRACT DETAILS ENDS HERE-->
	</div>
	</td>
	</tr>
	<tr bgcolor='#ced6de'>
	<td align='left' colspan="12" height="5"></td></tr>
	<?
	}
	?>

<tr><td bgcolor=#333366 height=1 colspan="12"></td></tr>
</table>


<!-- Sub Contractors Listing ends here---></td>
</tr>
</table>





<!-- LIST ENDS HERE -->
</td>
</tr>
</table>
</td>
</tr>
</table>
</td></tr>
</table>

<? include 'footer.php';?>
</form>	
</body>
</html>
