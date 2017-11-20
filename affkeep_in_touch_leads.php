 <?
include 'config.php';
include 'conf.php';
include 'time.php';
include 'function.php';

$agent_no = $_SESSION['agent_no'];
if($_SESSION['agent_no']=="")
{
	header("location:index.php");
}
$query="";
$mess="";
$mess=$_REQUEST['mess'];
/*
agent_no, lname, fname, email, agent_password, date_registered, agent_code, agent_address, agent_contact, agent_abn*/
$sql="SELECT * FROM agent WHERE agent_no =$agent_no;";

$result_sql=mysql_query($sql);
$ctr_sql=@mysql_num_rows($result_sql);
if ($ctr_sql >0 )
{
	$row = mysql_fetch_array ($result_sql); 
	$name = $row['fname']." ".$row['lname'];
	$agent_code = $row['agent_code'];
	$agent_email = $row['email'];
	$length=strlen($agent_code);
	
}

/////Checking the leads table for possible Unknown Leads ////
$querycheck="SELECT * FROM leads WHERE agent_id =0 AND SUBSTRING(tracking_no,1,$length)='$agent_code'";
$result2=mysql_query($querycheck);
$ctr3=@mysql_num_rows($result2);
if ($ctr3 >0 )
{
	//echo "Numrows ".$ctr3;
	$updateLeads="UPDATE leads SET agent_id = $agent_no WHERE agent_id =0 AND SUBSTRING(tracking_no,1,$length)='$agent_code'";
	mysql_query($updateLeads);
}

// Get all Affiliate's New Leads...
if($query=="")
{
/*
id, tracking_no, agent_id, timestamp, status, call_time_preference, remote_staff_competences, remote_staff_needed, remote_staff_needed_when, remote_staff_one_home, remote_staff_one_office, your_questions, lname, fname, company_position, company_name, company_address, email, password, website, officenumber, mobile, company_description, company_industry, company_size, outsourcing_experience, outsourcing_experience_description, company_turnover, referal_program, contacted_since, client_since, inactive_since, rating, personal_id, date_move, agent_from, authenticate, opt, show_to_affiliate
*/	
$query="SELECT id,tracking_no,DATE_FORMAT(timestamp,'%D %b %Y'),lname,fname,email, officenumber , mobile ,company_address,show_to_affiliate
FROM leads l
WHERE status = 'Keep In-Touch' AND agent_id =$agent_no ORDER BY timestamp DESC;";
}
//echo $query;
$counter = 0;
$result=mysql_query($query);
$ctr=@mysql_num_rows($result);
//echo $ctr; 
?>
<html>
<head>
<title>Affiliate</title>
<link rel=stylesheet type=text/css href="css/font.css">
<link rel=stylesheet type=text/css href="menu.css">
<link rel=stylesheet type=text/css href="css/affiliate.css">
<script language=javascript src="js/functions.js"></script>
<script type='text/javascript' language='JavaScript' src='js/MochiKit.js'></script>
<script type="text/javascript">
<!--
function show_hide(element) 
{
	toggle(element);
}
-->
</script>
	
</head>
<!-- background:#E7F0F5; -->
<body  style="background: #F7F9FD; " text="#000000" topmargin="0" leftmargin="0" marginheight="0" marginwidth="0">
<form method="POST" name="form" action="aff_addnewleadphp.php">
<table width="1000px;" align="center" style="background:#FFFFFF; margin-top:10px; border:#E7F0F5 ridge 1px;">
<tr><td><div><img src="images/remotestafflogo.jpg"></div></td></tr>
<tr><td valign="top">

<? include 'aff_header_menu.php';?>
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
<p>Dear Affiliate, </p>
<p> A contact has been made via phone to the following leads.  If and when your lead is converted into a client, the lead will be transferred to the “Client” tab. </p>
<p>Cheers, <br>
Team RemoteStaff
</p>
 </div>

<table width="100%">
<tr>
<td width="230px" valign="top"><? include 'aff_leftnav.php';?></td>
<td width="81%" valign="top">
<div class="box_contacted_leads" >Keep In-Touch Leads List
<div class="box_new_leads_content" >
<?
if ($ctr>0) {
while(list($id,$tracking_no,$timestamp,$lname,$fname ,$email, $officenumber , $mobile ,$company_address, $show) = mysql_fetch_array($result))
	{
		$counter++;
?>
<span class="leads_wrapper">
<label class="leads_wrapper_label" style="width:40px;"><? echo $counter;?>)</label>
<label class="leads_wrapper_label" style="width:300px; "><a href='javascript: show_hide("<? echo $id;?>");' title="<? echo $fname." ".$lname;?> Contact Information"><? echo $fname." ".$lname;?></a></label>
<label class="leads_wrapper_label" style="width:85px;"><? echo $timestamp;?></label>
<label class="leads_wrapper_label" style="width:195px;"><? echo $tracking_no;?></label>
</span>
<div id='<? echo $id;?>' style='display:none; margin-top:5px; margin-bottom:5px; padding:5px 5px 5px 5px;'>
<span style="float:right; margin-right:20px;"><a href='javascript: show_hide("<? echo $id;?>");'title="close"><b>[X]</b></a></span>
<span style="color:#999999;"><? echo $fname." ".$lname;?></span>
<? if ($show=="YES") { 
	  echo "<ul>
		  <li>Email : $email</li>
 		  <li>Contact #: $officenumber&nbsp;&nbsp;$mobile</li>
		  <li>Address : $company_address</li>
		  <li><a href='aff_updatelead.php?leads_id=$id'>Edit</a></li>
		  </ul>";
	}else{
	echo "<p><b>Restriction Access !</b><br>You can only view full contract details of the leads you add manually from the &quot;Add New Leads&quot; tab on your left. !</p>";
	}
?> 
</div>
<? }
}
else{ echo "<p><b>No Records to be Shown</b></p>";}

?>
</div>
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
