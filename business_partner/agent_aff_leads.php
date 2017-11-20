 <?
include '../config.php';
include '../conf.php';
include '../time.php';
include '../function.php';

$agent_no = $_SESSION['agent_no'];
if($_SESSION['agent_no']=="")
{
	header("location:../index.php");
}

$AusTime = date("H:i:s"); 
$AusDate = date("Y")."-".date("m")."-".date("d");
$AustodayDate = date ("jS \of F Y");
$ATZ = $AusDate." ".$AusTime;

/*
agent_no, lname, fname, email, agent_password, date_registered, agent_code, agent_address, agent_contact, agent_abn, email2, status, hosting, work_status, access_aff_leads
*/
$query="SELECT * FROM agent WHERE agent_no =$agent_no;";

$result=mysql_query($query);
$ctr=@mysql_num_rows($result);
if ($ctr >0 )
{
	$row = mysql_fetch_array ($result); 
	$name = $row['fname']." ".$row['lname'];
	$agent_code = $row['agent_code'];
	$length=strlen($agent_code);
	
}

$affiliate=$_REQUEST['affiliate'];
$sqlGetAllAffiliates="SELECT a.agent_no,a.fname,a.lname FROM agent a
JOIN agent_affiliates f ON f.affiliate_id = a.agent_no
WHERE
a.work_status='AFF'
AND
a.status='ACTIVE'
AND
f.business_partner_id =$agent_no
ORDER BY a.fname ASC;";
//echo $sqlGetAllAffiliates;
$resulta=mysql_query($sqlGetAllAffiliates);
while(list($aff_no,$aff_fname,$aff_lname)=mysql_fetch_array($resulta))
{
   if($affiliate == $aff_no)
      {
   $affoptions .= "<option selected value=\"$aff_no\">$aff_fname&nbsp;$aff_lname</option>\n";
      }
      else
      {
   $affoptions .= "<option value=\"$aff_no\">$aff_fname&nbsp;$aff_lname</option>\n";
      }
}

$lead_status=$_REQUEST['lead_status'];
$leads_statusArray=array("New Leads","Contacted Lead","Client");
 for ($i = 0; $i < count($leads_statusArray); $i++)
  {
      if($lead_status == $leads_statusArray[$i])
      {
	 $lead_status_options .= "<option selected value=\"$leads_statusArray[$i]\">$leads_statusArray[$i]&nbsp;</option>\n";
      }
      else
      {
	$lead_status_options .= "<option value=\"$leads_statusArray[$i]\">$leads_statusArray[$i]&nbsp;</option>\n";
      }
   }



?>
<html>
<head>
<title>Business Partner</title>
<link rel=stylesheet type=text/css href="../css/font.css">
<link rel=stylesheet type=text/css href="../menu.css">
<link rel=stylesheet type=text/css href="../css/affiliate.css">
<script language=javascript src="../js/functions.js"></script>
<script type='text/javascript' language='JavaScript' src='../js/MochiKit.js'></script>
<script type="text/javascript">
<!--
function show_hide(element) 
{
	toggle(element);
}
-->
</script>	
	
</head>


<body style="background:#ffffff" text="#000000" topmargin="0" leftmargin="0" marginheight="0" marginwidth="0">
<form method="POST" name="form" action="agent_aff_leads.php">

<script language=javascript src="../js/functions.js"></script>

<!-- HEADER -->
<? include 'header.php';?>

<ul class="glossymenu">
  <li ><a href="agentHome.php"><b>Home</b></a></li>
  <li><a href="advertise_positions.php"><b>Applications</b></a></li>
  <li ><a href="newleads.php"><b>New Leads</b></a></li>
  <li><a href="follow_up_leads.php"><b>Follow Up</b></a></li>
  <li><a href="keep_in_touch_leads.php"><b>Keep in Touch</b></a></li>
  <li><a href="client_listings.php"><b>Clients</b></a></li>
  <li><a href="scm.php"><b>Sub-Contractor Management</b></a></li>
</ul>
<table width=100% cellpadding=0 cellspacing=0 border=0 align=center>
<tr><td colspan=2 style='height: 1px;'>&nbsp;</td>
</tr>
<tr>
<td width="170" style='border-right: #006699 2px solid; width: 170px; vertical-align:top; '>
<? include 'agentleftnav.php';?></td>
<td width=1051 valign=top ><!-- Affiliates List Here-->
<div class="box_blue" >Affiliates List</div>
<div class="box_blue_content" >
<div style="clear:both;"></div>
<div id="form_info">
<p><label>Affiliate Name :</label><select name="affiliate" id="affiliate" class="text" onChange="javascript: document.form.submit();">
<option value="">Select Affiliates</option>
<?=$affoptions;?>
</select>
</p>
<p><label>Leads Status : </label><select name="lead_status" id="lead_status" class="text" onChange="javascript: document.form.submit();">
<option value="0">Select Lead Status</option>
<?=$lead_status_options;?>
</select></p>
<div style="clear:both;"></div>
</div>
<div style="clear:both;"></div>
<?
$sqlGetAffName="SELECT * FROM agent WHERE agent_no=$affiliate AND work_status='AFF';";
$re=mysql_query($sqlGetAffName);
$rerow=mysql_fetch_array($re);
$aff_fullname=$rerow['fname']." ".$rerow['lname'];;
?>
<h4 style="color:#999999;">Affiliate : <?=$aff_fullname." ".$lead_status;?></h4>
<?
/*
id, tracking_no, agent_id, timestamp, status, call_time_preference, remote_staff_competences, remote_staff_needed, remote_staff_needed_when, remote_staff_one_home, remote_staff_one_office, your_questions, lname, fname, company_position, company_name, company_address, email, password, website, officenumber, mobile, company_description, company_industry, company_size, outsourcing_experience, outsourcing_experience_description, company_turnover, referal_program, contacted_since, client_since, inactive_since, rating, personal_id, date_move, agent_from, authenticate, opt, show_to_affiliate
*/
$query="SELECT id,tracking_no,DATE_FORMAT(timestamp,'%D %b %Y'),lname,fname,email, officenumber , mobile ,company_address,status,company_position, company_name
FROM leads l
WHERE agent_id =$affiliate AND l.status = '$lead_status';";
$counter = 0;
$result=mysql_query($query);
$ctr=@mysql_num_rows($result);
if ($ctr>0) {
while(list($id,$tracking_no,$timestamp,$lname,$fname ,$email, $officenumber , $mobile ,$company_address,$lead_status,$company_position,$company_name) = mysql_fetch_array($result))
	{
		$counter++;
?>
<a href='javascript: show_hide("<? echo $id;?>");' class="leads_wrapper" title="<? echo $fname." ".$lname;?> Contact Information">
<label class="leads_wrapper_label" style="width:70px;"><? echo $counter;?>)</label>
<label class="leads_wrapper_label" style="width:300px; "><? echo $fname." ".$lname;?></label>
<label class="leads_wrapper_label" style="width:100px;"><? echo $timestamp;?></label>
<label class="leads_wrapper_label" style="width:195px;"><? echo $tracking_no;?></label>
<label class="leads_wrapper_label" style="width:195px;"><? echo $lead_status;?></label>
</a>
<span><a href='javascript: show_hide("<? echo $id;?>");' class="link10">view</a>
</span>
<div id='<? echo $id;?>' style='display:none; margin-top:5px; margin-bottom:5px; padding:5px 5px 5px 5px;'>
<span style="float:right; margin-right:20px;"><a href='javascript: show_hide("<? echo $id;?>");'title="close"><b>[X]</b></a></span>
<span style="color:#999999;"><? echo $fname." ".$lname;?></span>

	  <ul>
		  <li>Email : <?=$email;?></li>
 		  <li>Contact #: <?=$officenumber."&nbsp;".$mobile;?></li>
		  <li>Company : <?=$company_name;?></li>
		  <li>Position : <?=$company_position;?></li>
		  <li>Address : <?=$company_address;?></li>
	  </ul>
	   <input style="font:11px tahoma;" type="button" name="action" value="process" onClick ="goto(<? echo $id;?>,'<?=$lead_status;?>'); return false;">
	
</div>
<? 
	}
}
else{ echo "<p><b>No Records to be Shown</b></p>";}

?>
<script language=javascript>
<!--
	function goto(id,status) 
	{
	//alert(id+" "+status);
		if(status == "New Leads") {
			location.href = "apply_action.php?id="+id;
		}
		if(status == "Contacted Lead") {
			location.href = "apply_action2.php?id="+id;
		}
		if(status == "Client") {
			location.href = "client_workflow.php?id="+id;
		}			
		
	}
//-->
</script>
</div>
</td>
<td width="10">&nbsp;</td>
</tr>
</table>
<? include 'footer.php';?>
</form>	
</body>
</html>
