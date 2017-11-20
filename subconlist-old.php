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



$AusTime = date("H:i:s"); 
$AusDate = date("Y")."-".date("m")."-".date("d");
$AustodayDate = date ("jS \of F Y");
$ATZ = $AusDate." ".$AusTime;

$admin_id = $_SESSION['admin_id'];
$admin_status=$_SESSION['status'];

$fname=$_REQUEST['fname'];
$lname=$_REQUEST['lname'];
$email=$_REQUEST['email'];
$date_subcontracted=$_REQUEST['date_subcontracted'];
$month=$_REQUEST['month'];
$agent=$_REQUEST['agent'];

$client_fname=$_REQUEST['client_fname'];
$client_lname=$_REQUEST['client_lname'];

$activate_overtime=$_REQUEST['overtime'];
$activate_day_off=$_REQUEST['day_off'];
$sid=$_REQUEST['sid'];


$subconid=$_REQUEST['subconid'];
$ap_id=$_REQUEST['ap_id'];
$DELETE=$_REQUEST['DELETE'];

$RESIGN=$_REQUEST['RESIGN'];
$move=$_REQUEST['move'];
$subcotractors_id=$_REQUEST['subcotractors_id'];


//// sEND eMAIL ///
if(isset($_POST['send']))
{
	///
	$subcon_email=$_REQUEST['subcon_email'];
	$send_to_all=$_REQUEST['send_to_all'];
	$message=$_REQUEST['txt_message'];
	$message=str_replace("\n","<br>",$message);
	$subject="MESSAGE FROM ADMIN REMOTESTAFF.COM.AU";
	$admin_email ="admin@remotestaff.com.au";
	$headers  = 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
	$headers .= "From: ".$admin_email." \r\n"."Reply-To: ".$admin_email."\r\n";	
	$image_url="<img src='http://www.philippinesatwork.com/dev/norman/Chris/images/banner/remoteStaff-small.jpg'>";
	$body=$image_url."<p>".$message."</p>";
	if($subcon_email!="0" && $send_to_all=="")
	{
		//echo $subcon_email."<p>".$body."</p>";
		$check_email=mail($subcon_email,$subject, $body, $headers);
		if($check_email) {
			$result_email ="<div style='margin-bottom:10px; text-align:center; background:#FFFFDF; padding-bottom:5px; padding-top:5px;'><b>Message Sent</b></div>";
		}	
		else
		{
	$result_email ="<div style='margin-bottom:10px; text-align:center; background:#FFFFDF; padding-bottom:5px; padding-top:5px;'><b>Message Sending Failed !</b></div>";
		}
	}
	if($subcon_email=="0" && $send_to_all=="YES")
	{
		//echo "Send to all<br>";
		$queryGetAllSubCon2 = "SELECT distinct(s.userid), p.email 
		from subcontractors as s left join personal as p on s.userid = p.userid where s.status ='ACTIVE' order by p.fname ASC;";
		$result5=mysql_query($queryGetAllSubCon2);
		$email_sent_count=0;
		$email_failed_count=0;
		$subcon_count=0;
		while(list($subcon_id,$subcon_emails) = mysql_fetch_array($result5))
		{
			//echo $subcon_emails."<br>";
			//echo $body;
			$subcon_count++;
		    $check_email=mail($subcon_emails,$subject, $body, $headers);
			if($check_email) {
					$email_sent_count++;
			}	
			else{
					$email_failed_count++;
			}
		}
		
$result_email ="<div style='margin-bottom:10px; text-align:center; background:#FFFFDF; padding-bottom:5px; padding-top:5px;'>
<b>No. of Message Sent &nbsp;:".$email_sent_count."</b>&nbsp;&nbsp;Status[".$email_sent_count."/".$subcon_count."]<br>
<b>No. of Message Sending Failed &nbsp;:".$email_failed_count."&nbsp;</b>&nbsp;&nbsp;Status[".$email_failed_count."/".$subcon_count."]
</div>";
		
	}		

	
}


if($RESIGN!="")
{
	if ($RESIGN=="TRUE")
	{
		$sqlResign="UPDATE subcontractors SET status ='RESIGN' , resignation_date='$ATZ' WHERE id = $subcotractors_id";
		mysql_query($sqlResign);
	}
}

if($move!="")
{
	if ($move=="TRUE")
	{
		$sqlReserve="UPDATE subcontractors SET status ='RESERVE' , resignation_date='$ATZ' WHERE id = $subcotractors_id";
		mysql_query($sqlReserve);
	}
}

if ($DELETE!="")
{
	if ($DELETE=="TRUE")
	{
		$sql1="DELETE FROM subcontractors WHERE id= $subconid";
		$sql2="DELETE FROM applicants WHERE id = $ap_id";
		mysql_query($sql1);
		mysql_query($sql2);
	}
}


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


if($activate_day_off!="")
{
	if($activate_day_off=="TRUE")
	{
		//echo "Activate day_off.";
		$sql="UPDATE subcontractors SET day_off='Yes' WHERE id=$sid;";
	}
	if($activate_day_off=="FALSE")
	{
		//echo "DE - Activate day_off.";
		$sql="UPDATE subcontractors SET day_off='No' WHERE id=$sid;";
	}
		mysql_query($sql);
		//echo $sql;
}

/*
admin_id, admin_fname, admin_lname, admin_email, admin_password, admin_created_on, status
*/
$sql="SELECT * FROM admin WHERE admin_id=$admin_id;";

$resulta=mysql_query($sql);
$ctr=@mysql_num_rows($resulta);
if ($ctr >0 )
{
	$row = mysql_fetch_array ($resulta); 
	$name = $row['admin_lname'].",  ".$row['admin_fname'];
	
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
   
//agent_no, lname, fname, email, agent_password, date_registered, agent_code, agent_address, agent_contact, agent_abn, email2, status
$query3 = "SELECT agent_no, lname, fname FROM agent WHERE status='ACTIVE' ORDER BY fname ASC;";
$result3=mysql_query($query3);
while(list($agent_no, $agent_lname, $agent_fname) = mysql_fetch_array($result3))
{
	 $agentFullname =$agent_fname." ".$agent_lname;
	 if ($agent==$agent_no)
	 {
	 	$usernameOptions .="<option selected value= ".$agent_no.">".$agentFullname."</option>";
	 }
	 else
	 {
	 	$usernameOptions .="<option value= ".$agent_no.">".$agentFullname."</option>";
	 }	
}
///// get all subcon ////
$queryGetAllSubCon = "SELECT distinct(s.userid), p.lname, p.fname, p.email from subcontractors as s left join personal as p on s.userid = p.userid where s.status ='ACTIVE' order by p.fname ASC;";
$result4=mysql_query($queryGetAllSubCon);
while(list($user_id, $sub_lname, $sub_fname, $sub_email) = mysql_fetch_array($result4))
{
	$subconOptions .="<option value= ".$sub_email.">".$sub_fname." ".$sub_lname."</option>";
}


////////////////// QUERIES ////////////////////
if($fname!="")
{
$query="SELECT DISTINCT u.userid, u.fname, u.lname,DATE_FORMAT(s.date_contracted,'%D %M %Y'),
aud_monthly, aud_weekly, aud_daily, aud_hourly, working_hours, working_days,
php_monthly, php_weekly, php_daily, php_hourly, details, agent_commission ,think_commission,
l.id,l.fname,l.lname,l.email,a.agent_no,a.fname,a.lname,a.email,a.agent_contact,s.id, overtime, s.work_status,
others ,client_price,tax,DATE_FORMAT(starting_date,'%D %b %Y'),
DATE_FORMAT(end_date,'%D %b %Y'),starting_hours, ending_hours,s.posting_id,u.skype_id,u.email,u.image,day_off,lunch_start,lunch_end,lunch_hour

FROM personal u
JOIN subcontractors s ON s.userid = u.userid
JOIN leads l ON l.id = s.leads_id
JOIN agent a ON a.agent_no =s.agent_id

WHERE  u.fname LIKE '$fname'

AND s.status = 'ACTIVE'

ORDER BY s.starting_date DESC;";
}

if($lname!="")
{
$query="SELECT DISTINCT u.userid, u.fname, u.lname,DATE_FORMAT(s.date_contracted,'%D %M %Y'),
aud_monthly, aud_weekly, aud_daily, aud_hourly, working_hours, working_days,
php_monthly, php_weekly, php_daily, php_hourly, details, agent_commission ,think_commission,
l.id,l.fname,l.lname,l.email,a.agent_no,a.fname,a.lname,a.email,a.agent_contact,s.id, overtime, s.work_status,
others ,client_price,tax,DATE_FORMAT(starting_date,'%D %b %Y'),
DATE_FORMAT(end_date,'%D %b %Y'),starting_hours, ending_hours,s.posting_id,u.skype_id,u.email,u.image,day_off,lunch_start,lunch_end,lunch_hour

FROM personal u
JOIN subcontractors s ON s.userid = u.userid
JOIN leads l ON l.id = s.leads_id
JOIN agent a ON a.agent_no =s.agent_id
WHERE  u.lname LIKE '$lname'

AND s.status = 'ACTIVE'

ORDER BY s.starting_date DESC;";
}
//WHERE DATE_FORMAT(datecreated,'%Y-%m-%d') = '$date_apply'

if($date_subcontracted!="")
{
$query="SELECT DISTINCT u.userid, u.fname, u.lname,DATE_FORMAT(s.date_contracted,'%D %M %Y'),
aud_monthly, aud_weekly, aud_daily, aud_hourly, working_hours, working_days,
php_monthly, php_weekly, php_daily, php_hourly, details, agent_commission ,think_commission,
l.id,l.fname,l.lname,l.email,a.agent_no,a.fname,a.lname,a.email,a.agent_contact,s.id, overtime, s.work_status,
others ,client_price,tax,DATE_FORMAT(starting_date,'%D %b %Y'),
DATE_FORMAT(end_date,'%D %b %Y'),starting_hours, ending_hours,s.posting_id,u.skype_id,u.email,u.image,day_off,lunch_start,lunch_end,lunch_hour

FROM personal u
JOIN subcontractors s ON s.userid = u.userid
JOIN leads l ON l.id = s.leads_id
JOIN agent a ON a.agent_no =s.agent_id

WHERE DATE_FORMAT(s.date_contracted,'%Y-%m-%d') = '$date_subcontracted'

AND s.status = 'ACTIVE'

ORDER BY s.starting_date DESC;";
}
//WHERE DATE_FORMAT(datecreated,'%m') = '$month'

if($month!="")
{
$query="SELECT DISTINCT u.userid, u.fname, u.lname,DATE_FORMAT(s.date_contracted,'%D %M %Y'),
aud_monthly, aud_weekly, aud_daily, aud_hourly, working_hours, working_days,
php_monthly, php_weekly, php_daily, php_hourly, details, agent_commission ,think_commission,
l.id,l.fname,l.lname,l.email,a.agent_no,a.fname,a.lname,a.email,a.agent_contact,s.id, overtime, s.work_status,
others ,client_price,tax,DATE_FORMAT(starting_date,'%D %b %Y'),
DATE_FORMAT(end_date,'%D %b %Y'),starting_hours, ending_hours,s.posting_id,u.skype_id,u.email,u.image,day_off,lunch_start,lunch_end,lunch_hour

FROM personal u
JOIN subcontractors s ON s.userid = u.userid
JOIN leads l ON l.id = s.leads_id
JOIN agent a ON a.agent_no =s.agent_id

WHERE DATE_FORMAT(s.date_contracted,'%m') = '$month'

AND s.status = 'ACTIVE'

ORDER BY s.starting_date DESC;";
}

if($agent!="")
{
$query="SELECT DISTINCT u.userid, u.fname, u.lname,DATE_FORMAT(s.date_contracted,'%D %M %Y'),
aud_monthly, aud_weekly, aud_daily, aud_hourly, working_hours, working_days,
php_monthly, php_weekly, php_daily, php_hourly, details, agent_commission ,think_commission,
l.id,l.fname,l.lname,l.email,a.agent_no,a.fname,a.lname,a.email,a.agent_contact,s.id, overtime, s.work_status,
others ,client_price,tax,DATE_FORMAT(starting_date,'%D %b %Y'),
DATE_FORMAT(end_date,'%D %b %Y'),starting_hours, ending_hours,s.posting_id,u.skype_id,u.email,u.image,day_off,lunch_start,lunch_end,lunch_hour

FROM personal u
JOIN subcontractors s ON s.userid = u.userid
JOIN leads l ON l.id = s.leads_id
JOIN agent a ON a.agent_no =s.agent_id

WHERE a.agent_no = $agent

AND s.status = 'ACTIVE'

ORDER BY s.starting_date DESC;";

}

if($client_fname!="")
{
$query="SELECT DISTINCT u.userid, u.fname, u.lname,DATE_FORMAT(s.date_contracted,'%D %M %Y'),
aud_monthly, aud_weekly, aud_daily, aud_hourly, working_hours, working_days,
php_monthly, php_weekly, php_daily, php_hourly, details, agent_commission ,think_commission,
l.id,l.fname,l.lname,l.email,a.agent_no,a.fname,a.lname,a.email,a.agent_contact,s.id, overtime, s.work_status,
others ,client_price,tax,DATE_FORMAT(starting_date,'%D %b %Y'),
DATE_FORMAT(end_date,'%D %b %Y'),starting_hours, ending_hours,s.posting_id,u.skype_id,u.email,u.image,day_off,lunch_start,lunch_end,lunch_hour

FROM personal u
JOIN subcontractors s ON s.userid = u.userid
JOIN leads l ON l.id = s.leads_id
JOIN agent a ON a.agent_no =s.agent_id

WHERE l.fname = '$client_fname'
AND s.status = 'ACTIVE'

ORDER BY s.starting_date DESC;";

}

if($client_lname!="")
{
$query="SELECT DISTINCT u.userid, u.fname, u.lname,DATE_FORMAT(s.date_contracted,'%D %M %Y'),
aud_monthly, aud_weekly, aud_daily, aud_hourly, working_hours, working_days,
php_monthly, php_weekly, php_daily, php_hourly, details, agent_commission ,think_commission,
l.id,l.fname,l.lname,l.email,a.agent_no,a.fname,a.lname,a.email,a.agent_contact,s.id, overtime, s.work_status,
others ,client_price,tax,DATE_FORMAT(starting_date,'%D %b %Y'),
DATE_FORMAT(end_date,'%D %b %Y'),starting_hours, ending_hours,s.posting_id,u.skype_id,u.email,u.image,day_off,lunch_start,lunch_end,lunch_hour

FROM personal u
JOIN subcontractors s ON s.userid = u.userid
JOIN leads l ON l.id = s.leads_id
JOIN agent a ON a.agent_no =s.agent_id
WHERE l.lname = '$client_lname' 

AND s.status = 'ACTIVE'

ORDER BY s.starting_date DESC;";

}



if($query=="")
{
$query="SELECT DISTINCT u.userid, u.fname, u.lname,DATE_FORMAT(s.date_contracted,'%D %M %Y'),
aud_monthly, aud_weekly, aud_daily, aud_hourly, working_hours, working_days,
php_monthly, php_weekly, php_daily, php_hourly, details, agent_commission ,think_commission,
l.id,l.fname,l.lname,l.email,a.agent_no,a.fname,a.lname,a.email,a.agent_contact,s.id, overtime, s.work_status,
others ,client_price,tax,DATE_FORMAT(starting_date,'%D %b %Y'),
DATE_FORMAT(end_date,'%D %b %Y'),starting_hours, ending_hours,s.posting_id,u.skype_id,u.email,u.image,day_off,lunch_start,lunch_end,lunch_hour

FROM personal u
JOIN subcontractors s ON s.userid = u.userid
JOIN leads l ON l.id = s.leads_id
JOIN agent a ON a.agent_no =s.agent_id
WHERE s.status = 'ACTIVE'
ORDER BY s.id DESC

";
}

///////////////////////////////////////////////
//echo $query;
?>
<html>
<head>
<title>Administrator-Home</title>
<link rel=stylesheet type=text/css href="css/font.css">
<link rel=stylesheet type=text/css href="adminmenu.css">
<script type='text/javascript' language='JavaScript' src='js/common_funcs.js'></script>
<script type='text/javascript' language='JavaScript' src='js/form_utils.js'></script>

<script type="text/javascript" src="js/calendar.js"></script> 
<script type="text/javascript" src="lang/calendar-en.js"></script> 
<script type="text/javascript" src="js/calendar-setup.js"></script>
<link rel="stylesheet" type="text/css" media="all" href="css/calendar-blue.css" title="win2k-1" />

<script type='text/javascript' language='JavaScript' src='js/MochiKit.js'></script>
<script type="text/javascript">
<!--
function show_hide(element) 
{
	toggle(element);
}
-->
</script>

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
<script language=javascript src="js/functions.js"></script>
<!-- HEADER -->
<? include 'header.php';?>
<? if ($admin_status=="FULL-CONTROL") {?>
<ul class="glossymenu">
 <li ><a href="adminHome.php"><b>Home</b></a></li>
  <li ><a href="adminadvertise_positions.php"><b>Applications</b></a></li>
  <li><a href="admin_advertise_list.php"><b>Advertisements</b></a></li>
  <li ><a href="adminnewleads.php"><b>New Leads</b></a></li>
  <li ><a href="admincontactedleads.php"><b>Contacted Leads</b></a></li>
  <li ><a href="adminclient_listings.php"><b>Clients</b></a></li>
  <li ><a href="adminscm.php"><b>Sub-Contractor Management</b></a></li>
   <li class="current"><a href="subconlist.php"><b>List of Sub-Contractors</b></a></li>
</ul>
<? } else { 
echo "<ul class='glossymenu'>
 <li ><a href='adminHome.php'><b>Home</b></a></li>
  <li ><a href='adminadvertise_positions.php'><b>Applications</b></a></li>
  <li><a href='admin_advertise_list.php'><b>Advertisements</b></a></li>
  <li ><a href='adminclient_listings.php'><b>Clients</b></a></li>
  <li ><a href='adminscm.php'><b>Sub-Contractor Management</b></a></li>
  <li class='current'><a href='subconlist.php'><b>List of Sub-Contractors</b></a></li>
</ul>";
}
?>
<table width=100% cellpadding=0 cellspacing=0 border=0 align=center>
<tr><td colspan=2 style='height: 1px;'>&nbsp;</td>
</tr>
<tr>
<td width=100% valign=top >
<table width=100%  cellspacing=0 cellpadding=2 border=0 align=left >
<tr>
  <td bgcolor="#666666" height="25" colspan=3><font color='#FFFFFF'><b>Admin Home</b></font></td>
</tr>
<tr ><td  valign="top" style="border-right: #006699 2px solid;"><b><? echo $name;?></b></td><td colspan="2">

</td></tr>
<tr><td width="14%" height="135" valign="top" style="border-right: #006699 2px solid;">
<? include 'adminleftnav.php';?>
</td>
<td width="86%" valign="top" align="left">
<?=$result_email;?>
<div class="animatedtabs">
<ul>
<li class="selected"><a href="subconlist.php" title="Sub-Contractors List"><span>Sub-Contractors List</span></a></li>
<li ><a href="adminaddsubcon.php" title="Add Sub-Contractors"><span>Add Sub-Contractors</span></a></li>
<li ><a href="inactive_subconlist.php" title="Non Working Staff"><span>Non Working Staff</span></a></li>
<li ><a href="reserve_staff.php" title="Reserve Staff"><span>Reserve Staff</span></a></li>
<li ><a href="freelance_staff.php" title="Reserve Staff"><span>Freelance Staff</span></a></li>
</ul>
</div>
<!-- LIST HERE -->
<form name="form" method="post" action="subconlist.php">
  <table width="100%" style="border:#CCCCCC solid 1px;">
    <tr>
      <td width="8%">First Name</td>
      <td width="1%">:</td>
      <td width="18%"><input type="text" name="fname" class="text" ></td>
      <td width="11%">Last Name</td>
      <td width="1%">:</td>
      <td width="13%"><input type="text" name="lname" class="text" ></td>
      <td width="13%">Date Sub-Contracted</td>
      <td width="1%">:</td>
      <td width="14%"><input type="text" name="date_subcontracted" class="text" style=" width:60%;" >
          <img align="absmiddle" src="images/calendar_ico.png"   id="bd" style="cursor: pointer; " title="Date selector" onMouseOver="this.style.background='red'" onMouseOut="this.style.background=''" />
          <script type="text/javascript">
                    Calendar.setup({
                        inputField     :    "date_subcontracted",     // id of the input field
                        ifFormat       :    "%Y-%m-%d",      // format of the input field
                        button         :    "bd",          // trigger for the calendar (button ID)
                        align          :    "Tl",           // alignment (defaults to "Bl")
		                showsTime	   :    false, 
                        singleClick    :    true
                    });                     
                  </script></td>
      <td width="20%">Month :
        <select name="month"  style="font-size: 11px;" class="text" onChange="javascript: document.form.submit();">
            <? echo $monthoptions;?>
        </select></td>
    </tr>
    <tr>
      <td width="8%">Agent</td>
      <td width="1%">:</td>
      <td width="18%"><select name="agent" style="font-size: 11px;" class="text" onChange="javascript: document.form.submit();">
	  <option value="">-</option>
	  <? echo $usernameOptions;?></select></td>
      <td width="11%">Client First tname</td>
      <td width="1%">:</td>
      <td width="13%"><input type="text" name="client_fname" class="text" ></td>
      <td width="13%">Client Last tname</td>
      <td width="1%">:</td>
      <td width="14%"><input type="text" name="client_lname" class="text" ></td>
	  <td><input type="submit" name="search" value="Search"></td>
    </tr>
	<tr><td height="49" colspan="10" ><a href='javascript: show_hide("email_form");' class="link5" ><b><img src="images/icon-envelope.jpg" alt="send email" align="absmiddle" border="0">SEND EMAIL</b></a>
	<div id="email_form" style="display:none; position:absolute; width:600PX; border: 5px solid #c0e0f5; padding-bottom:10px; padding-top:10px; padding-left:40px;background: #F7F9FD;">
<table width="98%">
<tr>
<td width="20%">Send Email to</td>
<td width="1%">:</td>
<td width="86%"><select name="subcon_email" id="subcon_email" class="text">
<option value="0">--choose sub-con--</option>
<?=$subconOptions;?>
</select></td>
</tr>
<tr>
<td>Send Emailto all ?</td>
<td>:</td>
<td><input type="checkbox" name="send_to_all" id="send_to_all" value="YES" /></td>
</tr>
<tr><td colspan="3">
<textarea name='txt_message' id='txt_message' cols='48' rows='5' wrap='physical' class='text'  style='width:98%'></textarea>
</td>
</tr>
<tr><td colspan="3"><input type="submit" name="send" id="send" value="Send Message"></td>
</tr>		
</table>

	</div>
	</td></tr>
  </table>
</form>
<table width="100%">
<tr><td width=100% bgcolor=#DEE5EB colspan=2><B>LIST OF SUB-CONTRACTORS</B></td></tr>
<tr>
<td height="50" valign="top">


<table width=100% class="tablecontent" cellspacing=0 cellpadding=7 align=center border=0 bgcolor=#DEE5EB style="border: #333366 solid 1px;">
<tr><td bgcolor=#333366 height=2 colspan="13"></td>
</tr>
<tr >
<td width='4%' height="20" align=left>#</td>
<td></td>
<td width='27%' align=left><b><font size='1'>Name </font></b></td>
<td colspan="4" align=left><b><font size='1'>&nbsp;</font></b></td>

<td width='25%'  align=CENTER><b><font size='1'>Actions</font></b></td>
</tr>
<?
//echo $query;
$result=mysql_query($query);
$bgcolor="#FFFFFF";
	while(list($userid, $fname, $lname,$date,$aud_monthly, $aud_weekly, $aud_daily, $aud_hourly, $working_hours, $working_days,$php_monthly, $php_weekly, $php_daily, $php_hourly, $details, $agent_commission ,$think_commission,$leads_id,$leads_fname,$leads_lname,$leads_email,$agent_no,$agent_fname,$agent_lname,$agent_email,$agent_contact,$subcotractors_id,$overtime, $work_status, $others,$client_price,$tax,$starting_date, $end_date,$starting_hours, $ending_hours, $posting_id,$skype,$email,$image,$day_off,$lunch_start,$lunch_end,$lunch_hour) = mysql_fetch_array($result))
	{
		$counter=$counter+1;
		if($image=="")
		{
			$image="images/Client.png";
		}
	
?>
	<tr bgcolor=<? echo $bgcolor;?>>
	<td width='4%' height="20" align=left valign="top" style="border-bottom:#999999 solid 1px; border-top:#999999 solid 1px;"><? echo $counter;?>) </td>
	<td width='12%' height="20" align=left valign="top" style="border-bottom:#999999 solid 1px; border-top:#999999 solid 1px;"><img src="<? echo $image;?>" width="107" height="123" /></td>
	<td width='27%' align=left valign="top" style="border-bottom:#999999 solid 1px; border-top:#999999 solid 1px;"><font size='1'>
	<a href='#'   class='link5' onClick= "javascript:popup_win('./resume3.php?userid=<? echo $userid;?>',800,500);"><b>
	<? echo $fname." ".$lname;?>	</b></a><br>
	<br>

	Skype ID: <? echo $skype;?><br>
	Email : <? echo $email;?><br><br>

	Date Sub-Contracted : <b style="color:#FF0000"><? echo $starting_date;?></b><br>
<br>
<? $subcon_status = new SubconStatus($userid);
	echo $subcon_status->GetStatus(); ?>
	</font></td>
	<td colspan="4" align=left style="border-left:#999999 solid 1px; border-bottom:#999999 solid 1px; border-top:#999999 solid 1px;" valign="top"><font size='1'>
	<b>Business Partner :</b><br>
	<? echo $agent_fname." ".$agent_lname." <br>".$agent_email;?><br>
	<br>
	<b>Client :</b><br>
	<? echo $leads_fname." ".$leads_lname." <br>".$leads_email;?>
	</font></td>
		
	<td width='25%'  style="border-left:#999999 solid 1px; border-bottom:#999999 solid 1px; border-top:#999999 solid 1px;" valign="top">
	<!--<p style="margin-bottom:2px; margin-top:2px;"><input name="users" id="users"type="checkbox" onClick="check_val();" value="<? echo $email;?>" title="Send Email to Applicant <?=$fname." ".$lname;?>"  > 
	  Email</p>-->
	<p style="margin-bottom:2px; margin-top:2px;"><a href="subconlist.php?subconid=<?=$subcotractors_id;?>&ap_id=<?=$ap_id;?>&DELETE=TRUE" class='link5'>
	<img src="images/delete.png" border="0" alt="Delete Sub-Contractor <? echo $fname." ".$lname;?>" align="absmiddle"> Delete</a></p>

	<p style="margin-bottom:2px; margin-top:2px;"><a href='#' class='link5' onClick= "javascript:popup_win('./update_subcon_client.php?userid=<? echo $userid;?>&leads_id=<?=$leads_id;?>&subcotractors_id=<?=$subcotractors_id;?>',600,400);">
	<img src="images/b_edit.png" alt="Edit Employer" border="0" align="absmiddle">
	Edit </a></p>
	
 <p style="margin-bottom:2px; margin-top:2px;"><a href='subconlist.php?userid=<? echo $userid;?>&subcotractors_id=<?=$subcotractors_id;?>&RESIGN=TRUE' class='link5'><b style="color:#FF0000"><img src="images/deleteuser16.png" alt="move to Non-Working Staff" border="0" align="absmiddle"> Move to Non Working Staff</b></a></p>
 
 <p style="margin-bottom:2px; margin-top:2px;"><a href='subconlist.php?userid=<? echo $userid;?>&subcotractors_id=<?=$subcotractors_id;?>&move=TRUE' class='link5' title="Move to Reserve List"><b style="color:#000099"><img src="images/userlock16.png" alt="move to Non-Working Staff" border="0" align="absmiddle"> MOVE to Reserve Staff</b></a></p></td>
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
	<td align='left' colspan="13"><a href='javascript: show_hide("reply_form<? echo $counter;?>");'>Show / Hide Contract Details</a></td></tr>
	<tr bgcolor=<? echo $bgcolor;?> ><td colspan='13' valign="top"><div id='reply_form<? echo $counter;?>' style='display:none;'>
	<!-- CONTRACT DETAILS -->
<table width="100%" style="border:#CCCCCC solid 1px;" cellpadding="1" cellspacing="0">
<tr bgcolor='#666666'>
<td><font size='1' color="#FFFFFF"><b>Sub-Contractor&nbsp;(<? echo $fname." ".$lname;?>)&nbsp;Contract Details</b></font><br></td><td align="right"><a href="editcontract.php?userid=<? echo $userid;?>&sid=<? echo $subcotractors_id;?>&pid=<? echo $posting_id;?>&lid=<? echo $leads_id;?>" class="link13">Edit</a>&nbsp;&nbsp;</td>
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
      <? if ($tax > 0) { echo "<br>
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
    <td >&nbsp;</td>
    <td>&nbsp;</td>
    <td >&nbsp;</td>
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
    <td>Working Hours Start at</td>
    <td>:</td>
    <td><? 
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
	echo $starting_hours." - ".$ending_hours;?></td>
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
    <td>
	<? 
	echo $overtime;
	echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"; //$subcotractors_id
	if($overtime =="Yes")
	{
		echo "<a href='subconlist.php?overtime=FALSE&sid=$subcotractors_id'>De-Activate</a>";
	}	
	else
	{
		echo "<a href='subconlist.php?overtime=TRUE&sid=$subcotractors_id'>Activate</a>";
	}
	?>	</td>
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
    <td >Leave Permitted</td>
    <td>:</td>
    <td><?
	echo $day_off;
	echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"; //$subcotractors_id
	if($day_off =="Yes")
	{
		echo "<a href='subconlist.php?day_off=FALSE&sid=$subcotractors_id'>De-Activate</a>";
	}	
	else
	{
		echo "<a href='subconlist.php?day_off=TRUE&sid=$subcotractors_id'>Activate</a>";
	}
	?></td>
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
    <td >Lunch Time</td>
    <td>:</td>
    <td>
	<? 
	if ($lunch_start=="10")
	{
		$lunch_start = "10:00 am";
	}
	if ($lunch_start=="11")
	{
		$lunch_start = "11:00 am";
	}
	if ($lunch_start=="12")
	{
		$lunch_start = "12:00 noon";
	}
	if ($lunch_start=="13")
	{
		$lunch_start = "1:00 pm";
	}
	if ($lunch_start=="14")
	{
		$lunch_start = "2:00 pm";
	}
	if ($lunch_start=="15")
	{
		$lunch_start = "3:00 pm";
	}
	if ($lunch_start=="16")
	{
		$lunch_start = "4:00 pm";
	}
	if ($lunch_start=="17")
	{
		$lunch_start = "5:00 pm";
	}
	if ($lunch_start=="18")
	{
		$lunch_start = "6:00 pm";
	}
	if ($lunch_start=="19")
	{
		$lunch_start = "7:00 pm";
	}
	if ($lunch_start=="20")
	{
		$lunch_start = "8:00 pm";
	}
	if ($lunch_start=="21")
	{
		$lunch_start = "9:00 pm";
	}
	if ($lunch_start=="22")
	{
		$lunch_start = "10:00 pm";
	}
	if ($lunch_start=="23")
	{
		$lunch_start = "11:00 pm";
	}
	if ($lunch_start=="24")
	{
		$lunch_start = "12:00 am";
	}
	
	//////////////////////////////////
	if ($lunch_end=="10")
	{
		$lunch_end = "10:00 am";
	}
	if ($lunch_end=="11")
	{
		$lunch_end = "11:00 am";
	}
	if ($lunch_end=="12")
	{
		$lunch_end = "12:00 noon";
	}
	if ($lunch_end=="13")
	{
		$lunch_end = "1:00 pm";
	}
	if ($lunch_end=="14")
	{
		$lunch_end = "2:00 pm";
	}
	if ($lunch_end=="15")
	{
		$lunch_end = "3:00 pm";
	}
	if ($lunch_end=="16")
	{
		$lunch_end = "4:00 pm";
	}
	if ($lunch_end=="17")

	{
		$lunch_end = "5:00 pm";
	}
	if ($lunch_end=="18")
	{
		$lunch_end = "6:00 pm";
	}
	if ($lunch_end=="19")
	{
		$lunch_end = "7:00 pm";
	}
	if ($lunch_end=="20")
	{
		$lunch_end = "8:00 pm";
	}
	if ($lunch_end=="21")
	{
		$lunch_end = "9:00 pm";
	}
	if ($lunch_end=="22")
	{
		$lunch_end = "10:00 pm";
	}
	if ($lunch_end=="23")
	{
		$lunch_end = "11:00 pm";
	}
	if ($lunch_end=="24")
	{
		$lunch_end = "12:00 am";
	}
	echo $lunch_start." - ".$lunch_end;
	
	if($lunch_hour!="") { echo "<br>".$lunch_hour." &nbsp;hour lunch break";}
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
	<td align='left' colspan="13" height="5"></td></tr>
	<?
	}
	?>

<tr><td bgcolor=#333366 height=1 colspan="13"></td></tr>
</table>
<script type="text/javascript">
<!--
function check_val()
{
	var ins = document.getElementsByName('users')
	var i;
	var x;
	var j=0;
	var vals= new Array();
	var vals2 =new Array();
	for(i=0;i<ins.length;i++)
	{
		if(ins[i].checked==true)
		{
			if(ins[i].value!="" || ins[i].value!="undefined")
			{
				vals[j]=ins[i].value;
				j++;
			}		
		}
	}
document.getElementById("emails").value =(vals);
}
-->
</script>
<!-- Sub Contractors Listing ends here---></td>
</tr>
</table>





<!-- LIST ENDS HERE --></td>
</tr>
</table>
</td>
</tr>
</table>
</td></tr>
</table>

<? include 'footer.php';?>

</body>
</html>
