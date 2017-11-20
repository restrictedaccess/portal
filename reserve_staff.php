<?
include 'config.php';
include 'conf.php';
include 'function.php';
include 'time.php';

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
$sid=$_REQUEST['sid'];


$subconid=$_REQUEST['subconid'];
$ap_id=$_REQUEST['ap_id'];
$DELETE=$_REQUEST['DELETE'];

$RESIGN=$_REQUEST['RESIGN'];
$move=$_REQUEST['move'];
$subcotractors_id=$_REQUEST['subcotractors_id'];
if($RESIGN!="")
{
	if ($RESIGN=="TRUE")
	{
		$sqlResign="UPDATE subcontractors SET status ='RESIGN' , resignation_date='$ATZ' WHERE id = $subcotractors_id";
		mysql_query($sqlResign);
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

////////////////// QUERIES ////////////////////
if($fname!="")
{
$query="SELECT DISTINCT u.userid, u.fname, u.lname,DATE_FORMAT(s.date_contracted,'%D %M %Y'),
aud_monthly, aud_weekly, aud_daily, aud_hourly, working_hours, working_days,
php_monthly, php_weekly, php_daily, php_hourly, details, agent_commission ,think_commission,
l.id,l.fname,l.lname,l.email,a.agent_no,a.fname,a.lname,a.email,a.agent_contact,s.id, overtime, s.work_status,
others ,client_price,tax,DATE_FORMAT(starting_date,'%D %b %Y'),
DATE_FORMAT(end_date,'%D %b %Y'),starting_hours, ending_hours,s.posting_id,u.skype_id,u.email,DATE_FORMAT(s.resignation_date,'%D %b %Y'),u.image

FROM personal u
JOIN subcontractors s ON s.userid = u.userid
JOIN leads l ON l.id = s.leads_id
JOIN agent a ON a.agent_no =s.agent_id

WHERE  u.fname LIKE '$fname'

AND s.status = 'RESERVE'

ORDER BY s.starting_date DESC;";
}

if($lname!="")
{
$query="SELECT DISTINCT u.userid, u.fname, u.lname,DATE_FORMAT(s.date_contracted,'%D %M %Y'),
aud_monthly, aud_weekly, aud_daily, aud_hourly, working_hours, working_days,
php_monthly, php_weekly, php_daily, php_hourly, details, agent_commission ,think_commission,
l.id,l.fname,l.lname,l.email,a.agent_no,a.fname,a.lname,a.email,a.agent_contact,s.id, overtime, s.work_status,
others ,client_price,tax,DATE_FORMAT(starting_date,'%D %b %Y'),
DATE_FORMAT(end_date,'%D %b %Y'),starting_hours, ending_hours,s.posting_id,u.skype_id,u.email,DATE_FORMAT(s.resignation_date,'%D %b %Y'),u.image

FROM personal u
JOIN subcontractors s ON s.userid = u.userid
JOIN leads l ON l.id = s.leads_id
JOIN agent a ON a.agent_no =s.agent_id
WHERE  u.lname LIKE '$lname'

AND s.status = 'RESERVE'

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
DATE_FORMAT(end_date,'%D %b %Y'),starting_hours, ending_hours,s.posting_id,u.skype_id,u.email,DATE_FORMAT(s.resignation_date,'%D %b %Y'),u.image

FROM personal u
JOIN subcontractors s ON s.userid = u.userid
JOIN leads l ON l.id = s.leads_id
JOIN agent a ON a.agent_no =s.agent_id

WHERE DATE_FORMAT(s.date_contracted,'%Y-%m-%d') = '$date_subcontracted'

AND s.status = 'RESERVE'

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
DATE_FORMAT(end_date,'%D %b %Y'),starting_hours, ending_hours,s.posting_id,u.skype_id,u.email,DATE_FORMAT(s.resignation_date,'%D %b %Y'),u.image

FROM personal u
JOIN subcontractors s ON s.userid = u.userid
JOIN leads l ON l.id = s.leads_id
JOIN agent a ON a.agent_no =s.agent_id

WHERE DATE_FORMAT(s.date_contracted,'%m') = '$month'

AND s.status = 'RESERVE'

ORDER BY s.starting_date DESC;";
}

if($agent!="")
{
$query="SELECT DISTINCT u.userid, u.fname, u.lname,DATE_FORMAT(s.date_contracted,'%D %M %Y'),
aud_monthly, aud_weekly, aud_daily, aud_hourly, working_hours, working_days,
php_monthly, php_weekly, php_daily, php_hourly, details, agent_commission ,think_commission,
l.id,l.fname,l.lname,l.email,a.agent_no,a.fname,a.lname,a.email,a.agent_contact,s.id, overtime, s.work_status,
others ,client_price,tax,DATE_FORMAT(starting_date,'%D %b %Y'),
DATE_FORMAT(end_date,'%D %b %Y'),starting_hours, ending_hours,s.posting_id,u.skype_id,u.email,DATE_FORMAT(s.resignation_date,'%D %b %Y'),u.image

FROM personal u
JOIN subcontractors s ON s.userid = u.userid
JOIN leads l ON l.id = s.leads_id
JOIN agent a ON a.agent_no =s.agent_id

WHERE a.agent_no = $agent

AND s.status = 'RESERVE'

ORDER BY s.starting_date DESC;";

}

if($client_fname!="")
{
$query="SELECT DISTINCT u.userid, u.fname, u.lname,DATE_FORMAT(s.date_contracted,'%D %M %Y'),
aud_monthly, aud_weekly, aud_daily, aud_hourly, working_hours, working_days,
php_monthly, php_weekly, php_daily, php_hourly, details, agent_commission ,think_commission,
l.id,l.fname,l.lname,l.email,a.agent_no,a.fname,a.lname,a.email,a.agent_contact,s.id, overtime, s.work_status,
others ,client_price,tax,DATE_FORMAT(starting_date,'%D %b %Y'),
DATE_FORMAT(end_date,'%D %b %Y'),starting_hours, ending_hours,s.posting_id,u.skype_id,u.email,DATE_FORMAT(s.resignation_date,'%D %b %Y'),u.image

FROM personal u
JOIN subcontractors s ON s.userid = u.userid
JOIN leads l ON l.id = s.leads_id
JOIN agent a ON a.agent_no =s.agent_id

WHERE l.fname = '$client_fname'
AND s.status = 'RESERVE'

ORDER BY s.starting_date DESC;";

}

if($client_lname!="")
{
$query="SELECT DISTINCT u.userid, u.fname, u.lname,DATE_FORMAT(s.date_contracted,'%D %M %Y'),
aud_monthly, aud_weekly, aud_daily, aud_hourly, working_hours, working_days,
php_monthly, php_weekly, php_daily, php_hourly, details, agent_commission ,think_commission,
l.id,l.fname,l.lname,l.email,a.agent_no,a.fname,a.lname,a.email,a.agent_contact,s.id, overtime, s.work_status,
others ,client_price,tax,DATE_FORMAT(starting_date,'%D %b %Y'),
DATE_FORMAT(end_date,'%D %b %Y'),starting_hours, ending_hours,s.posting_id,u.skype_id,u.email,DATE_FORMAT(s.resignation_date,'%D %b %Y'),u.image

FROM personal u
JOIN subcontractors s ON s.userid = u.userid
JOIN leads l ON l.id = s.leads_id
JOIN agent a ON a.agent_no =s.agent_id
WHERE l.lname = '$client_lname' 

AND s.status = 'RESERVE'

ORDER BY s.starting_date DESC;";

}



if($query=="")
{
$query="SELECT DISTINCT u.userid, u.fname, u.lname,DATE_FORMAT(s.date_contracted,'%D %M %Y'),
aud_monthly, aud_weekly, aud_daily, aud_hourly, working_hours, working_days,
php_monthly, php_weekly, php_daily, php_hourly, details, agent_commission ,think_commission,
l.id,l.fname,l.lname,l.email,a.agent_no,a.fname,a.lname,a.email,a.agent_contact,s.id, overtime, s.work_status,
others ,client_price,tax,DATE_FORMAT(starting_date,'%D %b %Y'),
DATE_FORMAT(end_date,'%D %b %Y'),starting_hours, ending_hours,s.posting_id,u.skype_id,u.email,DATE_FORMAT(s.resignation_date,'%D %b %Y'),u.image

FROM personal u
JOIN subcontractors s ON s.userid = u.userid
JOIN leads l ON l.id = s.leads_id
JOIN agent a ON a.agent_no =s.agent_id

WHERE s.status = 'RESERVE'

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
<tr ><td  valign="top" style="border-right: #006699 2px solid;"><b><? echo $name;?></b></td><td colspan="2">

</td></tr>
<tr><td width="14%" height="135" valign="top" style="border-right: #006699 2px solid;">
<? include 'adminleftnav.php';?>
</td>
<td width="86%" valign="top" align="left">
<div class="animatedtabs">
<ul>
<li ><a href="subconlist.php" title="Sub-Contractors List"><span>Sub-Contractors List</span></a></li>
<li ><a href="adminaddsubcon.php" title="Add Sub-Contractors"><span>Add Sub-Contractors</span></a></li>
<li ><a href="inactive_subconlist.php" title="Non Working Staff"><span>Non Working Staff</span></a></li>
<li class="selected"><a href="reserve_staff.php" title="Reserve Staff"><span>Reserve Staff</span></a></li>
<li ><a href="freelance_staff.php" title="Reserve Staff"><span>Freelance Staff</span></a></li>

</ul>
</div>
<!-- LIST HERE -->
<form name="form" method="post" action="reserve_staff.php">
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
  </table>
</form>
<table width="100%">
<tr><td width=100% bgcolor=#DEE5EB colspan=2><B>LIST OF RESERVE SUB-CONTRACTORS</B></td></tr>
<tr><td height="50" valign="top">
<table width=100% class="tablecontent" cellspacing=0 cellpadding=7 align=center border=0 bgcolor=#DEE5EB style="border: #333366 solid 1px;">
<tr><td bgcolor='#333366' height=1 colspan="13"></td></tr>
<tr >
<td width='4%' height="20" align=left>#</td>
<td></td>
<td width='22%' align=left><b><font size='1'>Name </font></b></td>
<td colspan="4" align=left><b><font size='1'>&nbsp;</font></b></td>
<td width='37%'  align=CENTER><b><font size='1'>&nbsp;</font></b></td>
</tr>
<?
//echo $query;
$result=mysql_query($query);
$bgcolor="#FFFFFF";
	while(list($userid, $fname, $lname,$date,$aud_monthly, $aud_weekly, $aud_daily, $aud_hourly, $working_hours, $working_days,$php_monthly, $php_weekly, $php_daily, $php_hourly, $details, $agent_commission ,$think_commission,$leads_id,$leads_fname,$leads_lname,$leads_email,$agent_no,$agent_fname,$agent_lname,$agent_email,$agent_contact,$subcotractors_id,$overtime, $work_status, $others,$client_price,$tax,$starting_date, $end_date,$starting_hours, $ending_hours, $posting_id,$skype,$email,$resignation_date,$image) = mysql_fetch_array($result))
	{
		$counter=$counter+1;
		if($image=="")
		{
			$image="images/Client.png";
		}
		$add_note_form="<form name='admin_add_note' method='post' action='admin_add_note.php'>
<input type='hidden' name='userid' id='userid' value=$userid>
<textarea name='admin_subcon_note_txt' id='admin_subcon_note_txt' style='width:98%'></textarea>
<input type='submit' name='add_note' value='save'/>
</form>";
	
?>
	<tr bgcolor=<? echo $bgcolor;?>>
	<td width='4%' height="20" align=left valign="top" style="border-bottom:#999999 solid 1px; border-top:#999999 solid 1px;"><? echo $counter;?>) </td>
	<td width='12%' height="20" align=left valign="top" style="border-bottom:#999999 solid 1px; border-top:#999999 solid 1px;"><img src="<? echo $image;?>" width="107" height="123" /></td>
	<td width='22%' align=left valign="top" style="border-bottom:#999999 solid 1px; border-top:#999999 solid 1px;"><font size='1'>
	<a href='#'   class='link5' onClick= "javascript:popup_win('./resume3.php?userid=<? echo $userid;?>',800,500);"><b>
	<? echo $fname." ".$lname;?>	</b></a><br>
	<br>

	Skype ID: <? echo $skype;?><br>
	Email : <? echo $email;?><br><br>

	Date Sub-Contracted : <b style="color:#FF0000"><? echo $starting_date;?></b>
	</font></td>
	<td colspan="4" align=left style="border-left:#999999 solid 1px; border-bottom:#999999 solid 1px; border-top:#999999 solid 1px;" valign="top">
	<font size='1'>
	<p><b>Business Partner :</b><br>
	<? echo $agent_fname." ".$agent_lname." <br>".$agent_email;?>
	</p>
	
	<p><b>Client :</b><br>
	<? echo $leads_fname." ".$leads_lname." <br>".$leads_email;?>
	</p>
	</font></td>
		
	<td width='37%'  align="left"  style="border-left:#999999 solid 1px; border-bottom:#999999 solid 1px; border-top:#999999 solid 1px;" valign="top">
	<b>Date Moved :<?=$resignation_date;?></b>
	<p><img src="images/addfile16.png" alt="Add Notes" align="absmiddle">
	<a href='javascript: show_hide("add_note_form<? echo $counter;?>");' class="link5">Add Note</a></p>
	<div id='add_note_form<? echo $counter;?>' style='position:absolute;display:none; margin-bottom:5px; border: 8px solid #6BB4C2; padding:5 5 5 5px; background-color:#FFFFFF;width:270px'>
	<div style="text-align:right"><a href='javascript: show_hide("add_note_form<? echo $counter;?>");' class="link10">[X]</a></div>
	<font size='1'>Notes for <? echo $fname." ".$lname;?></font>
	<?=$add_note_form;?>
	</div>
	<div id="mydiv" style="display:none; overflow:hidden; height:9px;opacity:0.0;filter: alpha(opacity=0);"><h3>This is a test!<br>Can you see me?</h3></div>
	<p><a href="reserve_staff.php?subconid=<?=$subcotractors_id;?>&ap_id=<?=$ap_id;?>&DELETE=TRUE" class='link5'>
	<img src="images/delete.png" border="0" alt="Delete Sub-Contractor <? echo $fname." ".$lname;?>" align="absmiddle"> Delete</a></p>
	
	 <p><a href='reserve_staff.php?userid=<? echo $userid;?>&subcotractors_id=<?=$subcotractors_id;?>&RESIGN=TRUE' class='link5'><b style="color:#FF0000"><img src="images/deleteuser16.png" alt="move to Non-Working Staff" border="0" align="absmiddle"> Move to Non Working Staff</b></a></p>
 

	</td>
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
	<tr bgcolor='#F2F2F2'>
	<td align='left' colspan="13" valign="top">
	<?
	/// Get all Admin NOTES for this subcon
	$sqlGEtAllNotes="SELECT id, admin_subcon_note_txt, DATE_FORMAT(date_created,'%D %b %Y') FROM admin_subcon_notes WHERE userid = $userid;";
	$result_sqlGEtAllNotes = mysql_query($sqlGEtAllNotes);
	if(mysql_num_rows($result_sqlGEtAllNotes) > 0)
	{
		$ctr=0;
		echo "<p><b><font size='1'>Notes for $fname&nbsp;$lname</font></b></p>";
		while(list($admin_note_id, $admin_subcon_note_txt, $admin_note_date_created)=mysql_fetch_array($result_sqlGEtAllNotes))
		{
			$admin_subcon_note_txt=str_replace("\n","<br>",$admin_subcon_note_txt);
			$ctr++;
	?>
	
		<div style="float:left; margin:10px; margin-bottom:2px; "><font size='1'><b><?=$ctr;?>)</b>&nbsp;<?=$admin_note_date_created;?></font></div>
		<div style="float:left; margin:10px; margin-bottom:2px; width:85%"><font size='1'><I><?=$admin_subcon_note_txt;?></I></font></div>
	
	<?	
		}
	}
	?>
	</td></tr>
	<tr bgcolor='#ced6de'>
	<td align='left' colspan="13"><a href='javascript: show_hide("reply_form<? echo $counter;?>");'>Show / Hide Contract Details</a></td></tr>
	<tr bgcolor=<? echo $bgcolor;?> ><td colspan='13' valign="top"><div id='reply_form<? echo $counter;?>' style='display:none;'>
	<!-- CONTRACT DETAILS -->
<table width="100%" style="border:#CCCCCC solid 1px;" cellpadding="1" cellspacing="0">
<tr bgcolor='#666666'>
<td><font size='1' color="#FFFFFF"><b>Sub-Contractor&nbsp;(<? echo $fname." ".$lname;?>)&nbsp;Contract Details</b></font><br></td><td align="right">&nbsp;</td>
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
    <td>Working Hours Start at</td>
    <td>:</td>
    <td><? 
	
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
    <td><? 	echo $overtime;	?>	</td>
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
	<?
	}
	?>


</table>


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
