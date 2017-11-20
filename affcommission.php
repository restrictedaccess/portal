<?
include 'getAff_subcon_PaymentDetails.php';
include 'config.php';
include 'conf.php';
include 'time.php';
include 'function.php';

$agent_no = $_SESSION['agent_no'];
if($_SESSION['agent_no']=="")
{
	header("location:index.php");
}

//print date("t", mktime(0,0,0, date("n") ));
//echo date("t")." Days<br>";
//echo date("n")." MOnth<br>";
$month = $_REQUEST['month'];
if ($month=="") $month = ( int ) date( "m" );
$year = $_REQUEST['year'];
if ($year=="") $year = ( int ) date( "Y" );


$mess="";
$mess=$_REQUEST['mess'];
/*
agent_no, lname, fname, email, agent_password, date_registered, agent_code, agent_address, agent_contact, agent_abn*/
$query="SELECT * FROM agent WHERE agent_no =$agent_no;";

$result=mysql_query($query);
$ctr=@mysql_num_rows($result);
if ($ctr >0 )
{
	$row = mysql_fetch_array ($result); 
	$name = $row['fname']." ".$row['lname'];
	$agent_code = $row['agent_code'];
	$agent_email = $row['email'];
	$length=strlen($agent_code);
	$commission_type = $row['commission_type'];
	if($commission_type == "LOCAL")
	{
		$commission=81;
	}
	elseif($commission_type == "INTERNATIONAL")
	{
		$commission=90;
	}
	else
	{
		$commission=0;
	}
	
	
	
}

$query="SELECT DISTINCT(l.id),DATE_FORMAT(timestamp,'%D %b %Y'),lname,fname
FROM leads l
JOIN subcontractors s ON s.leads_id = l.id
WHERE l.status = 'Client' AND l.agent_id =$agent_no ORDER BY timestamp DESC;;";
//echo $query;
$counter = 0;
$result=mysql_query($query);
$ctr=@mysql_num_rows($result);

$monthArray=array("","1","2","3","4","5","6","7","8","9","10","11","12");
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

//$yearoptions
$yearArray=array("2008","2009","2010");
 for ($i = 0; $i < count($yearArray); $i++)
  {
      if($year == $yearArray[$i])
      {
	 $yearoptions .= "<option selected value=\"$yearArray[$i]\">$yearArray[$i]</option>\n";
      }
      else
      {
	$yearoptions .= "<option value=\"$yearArray[$i]\">$yearArray[$i]</option>\n";
      }
   }
?>
<html>
<head>
<title>Affiliate</title>
<link rel=stylesheet type=text/css href="css/font.css">
<link rel=stylesheet type=text/css href="menu.css">
<link rel=stylesheet type=text/css href="css/affiliate.css">
<script language=javascript src="js/functions.js"></script>
<script type='text/javascript' language='JavaScript' src='js/MochiKit.js'></script>
<script type="text/javascript" src="js/tooltip.js"></script>
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
#dhtmltooltip{
position: absolute;
font-family:Verdana;
font-size:11px;
left: -300px;
width: 110px;
height:150px;
border: 5px solid #6BB4C2;
background: #F7F9FD;
padding: 2px;

visibility: hidden;
z-index: 100;
/*Remove below line to remove shadow. Below line should always appear last within this CSS*/
filter: progid:DXImageTransform.Microsoft.Shadow(color=gray,direction=135);
}

#dhtmlpointer{
position:absolute;
left: -300px;
z-index: 101;
visibility: hidden;
}

-->
</style>

	
</head>
<!-- background:#E7F0F5; -->
<body  style="background: #F7F9FD; " text="#000000" topmargin="0" leftmargin="0" marginheight="0" marginwidth="0">
<form method="POST" name="form" action="affcommission.php">
<table width="1000px;" align="center" style="background:#FFFFFF; margin-top:10px; border:#E7F0F5 ridge 1px;">
<tr><td><div><img src="images/remotestafflogo.jpg"></div></td></tr>
<tr><td valign="top"><ul class="glossymenu">
   <li ><a href="affHome.php"><b>Home</b></a></li>
  <li  ><a href="affnewleads.php"><b>New Leads</b></a></li>
  <li ><a href="affcontactedleads.php"><b>Follow-Up Leads</b></a></li>
  <li><a href="affkeep_in_touch_leads.php"><b>Keep in Touch</b></a></li>
  <li ><a href="affclients.php"><b>Clients</b></a></li>
  <li class="current"><a href="affcommission.php"><b>Commission Payments</b></a></li>
  <li><a href="affprofile.php"><b>Profile</b></a></li>
</ul>
</td></tr>
<tr>
<td height="54" valign="top">
<!-- Contents Here -->
<h3 class="h3_style">Affiliate System</h3>
<div class="welcome">
Welcome <?=$name;?></div>
<div class="logout"><a href="logout.php">Logout</a></div>
<div style="clear:both"></div>
<div id="page_desc">
<ul>
<li><b>Commissions</b> are paid once a month electronically to your bank account.</li>
<li>Aus $90 commission is paid to any affiliate leads that convert into a <b>Think Innovations RemoteStaff</b> Client. <br>
(Only when a  client  hire at least 1 <b>full</b> time staff)

</li>
<li>This commission will be paid monthly for the life of the client. </li>
<li>We do not pay for when a client only wants part time staff or a freelance staff.</li>
<li>Affiliate System is only  for Full-Time position, this represents 90% of Remote Staff we hire. </li>
</ul>
</div>
<table width="99%">
<tr>
<td width="230px" valign="top"><? include 'aff_leftnav.php';?></td>
<td width="81%" valign="top">
<div class="box_blue" >Commission History</div>
<div class="box_blue_content" >
<div id="page_desc"><P><b><u>BANK ACCOUNT/PAYMENT DETAILS</u></b></P>
<?=str_replace("\n","<br>",$row['agent_bank_account']);?></div>
<p class="leads_wrapper">
<label class="leads_wrapper_label" style="width:50px; border:#FFFFFF solid 1px;"><b>Month :</b></label>
<label class="leads_wrapper_label" style="width:120px;border:#FFFFFF solid 1px;">
<select name="month"  style="font-size: 11px;" class="text" onChange="javascript: document.form.submit();">
<? echo $monthoptions;?>
</select>
</label>
<label class="leads_wrapper_label" style="width:40px;border:#FFFFFF solid 1px;"><b>Year :</b></label>
<label class="leads_wrapper_label" style="width:120px;border:#FFFFFF solid 1px;">
<select name="year"  style="font-size: 11px;" class="text" onChange="javascript: document.form.submit();">
<? echo $yearoptions;?>
</select>
</label>
</p>

<?
$payments = new Payments();
$payments -> agent_no = $agent_no;
$payments -> month = $month;
$payments -> year = $year;
$total_commission=0;
while(list($id,$timestamp,$lname,$fname ) = mysql_fetch_array($result))
	{
		$counter++;
		$payments -> leads_id = $id;
?>
<span class="leads_wrapper">
<label class="leads_wrapper_label" style="width:60px;"><? echo $counter;?>)</label>
<label class="leads_wrapper_label" style="width:230px; "><a href='javascript: show_hide("<? echo $id;?>");'><? echo $fname." ".$lname;?></a></label>
<label class="leads_wrapper_label" style="width:310px;"><?=$payments->PaymentsSubTotal();?></label>

</span>
<div id='<? echo $id;?>' style='margin-top:0px; margin-bottom:5px; margin-left:5px; padding:2px; display:none; color:#999999;'>
<p style="margin-top:2px;"><B><? echo $fname." ".$lname;?> Sub-Contractors</B></p>

<?
$sql="SELECT p.userid,p.fname,p.lname,DATE_FORMAT(s.date_contracted,'%D %b %Y'),p.image FROM subcontractors s JOIN personal p ON  p.userid = s.userid WHERE s.leads_id = $id AND agent_id = $agent_no  ORDER BY s.id ASC;";
$r=mysql_query($sql);
$count=0;
while(list($userid,$subcon_fname,$subcon_lname,$date_contracted,$image)=mysql_fetch_array($r))
{
	/// applicants image
	$count++;
	//$total_commission = $total_commission + $commission;
	//echo $userid;

$payments -> userid = $userid;
$payments -> subcon_name =$subcon_fname." ".$subcon_lname;


?>
	<p style="margin-bottom:2px; margin-top:1px; padding:2px;  ">
	<label style="float:left; display:block; width:40px; border:#CCCCCC dashed 1px; padding:2px;"><?=$count;?>)</label>
	<label style="float:left; display:block; width:230px;border:#CCCCCC dashed 1px; padding:2px;"><?=$payments->CheckSubconSalary();?></label>
	
	<label style="float:left; display:block; width:220px;border:#CCCCCC dashed 1px; padding:2px;"><small><?=$payments->checkTimeSheets();?></small></label>
	<label style="float:left; display:block; width:80px;border:#CCCCCC dashed 1px; padding:2px; text-align:right; "><?=$payments->ProcessAffiliatesCommission();?></label>
	</p>
	<div style="clear:both;"></div>
	
	
	
<?	
}
?>


</div>
<?
}
?> 
<span class="leads_wrapper">
<label class="leads_wrapper_label" style="width:370px; "><b>Total Commission (Australian Dollar):</b></label>
<label class="leads_wrapper_label" style="width:230px; text-align:right; padding-right:5px;"><?=$payments->PaymentsTotal();?><br style="clear:both;"></label>
</span>
<div style="clear:both;"></div>
</div>

</td>
</tr>
</table>


<!-- Contents Here -->
</td>
</tr>
<tr><td><? include 'footer.php';?></td></tr>
</table>
</form>	
</body>
</html>
