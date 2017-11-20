<?
include 'config.php';
include 'function.php';
include 'conf.php';
$agent_no = $_SESSION['agent_no'];
if($_SESSION['agent_no']==""){
	header("location:index.php");
}




?>
<html>

<head>

<title>Business Partner Affiliates</title>
<link rel=stylesheet type=text/css href="css/font.css">
<link rel=stylesheet type=text/css href="css/style.css">
<link rel=stylesheet type=text/css href="menu.css">
<script language=javascript src="js/functions.js"></script>
<script type='text/javascript' language='JavaScript' src='js/MochiKit.js'></script>
<script type="text/javascript">
<!--
function show_hide(element) 
{
	toggle(element);
}

function goto(id) 
{
	location.href = "apply_action_affiliates.php?id="+id;
}
-->
</script>

</head>





<body style="background:#ffffff" text="#000000" topmargin="0" leftmargin="0" marginheight="0" marginwidth="0">
<form method="POST" name="form" >
<!-- HEADER -->
<? include 'header.php';?>
<? include 'BP_header.php';?>
<table width=100% cellpadding=0 cellspacing=0 border=0 >
<tr><td width="173" style='border-right: #006699 2px solid; width: 170px; vertical-align:top; '>
<? include 'agentleftnav.php';?>
</td>
<td valign='top'>
<div style="font:12px Arial;">
<div style="padding:5px;"><b>Affiliate List</b></div>
	<div style="background:#CCCCCC; border:#CCCCCC outset 1px;"><b>
		<div style="float:left; width:220px; line-height:20px; padding-left:5px;">Name</div>
		<div style="float:left; width:250px;line-height:20px; border-left:#999999 solid 1px; padding-left:5px;">Email</div>
		<div style="float:left; width:50px;line-height:20px; border-left:#999999 solid 1px; padding-left:5px; ">&nbsp;Leads</div>
		<div style="float:left; line-height:20px; border-left:#999999 solid 1px; padding-left:5px;">Contact Information</div>
		<div style="clear:both;"></div>	
	</b>
	</div>
<?
//agent_no, lname, fname, email, agent_password, date_registered, agent_code, agent_address, agent_contact, agent_abn, email2, status, hosting, work_status, access_aff_leads, agent_bank_account, aff_marketing_plans, companyname, companyposition, integrate, country_location, commission_type
$sqlGetAllAffiliates="SELECT a.agent_no,a.fname,a.lname , email , agent_code , agent_address, agent_contact ,companyname, companyposition, country_location, hosting
						FROM agent a
						JOIN agent_affiliates f ON f.affiliate_id = a.agent_no
						WHERE
						a.work_status='AFF'
						AND
						a.status='ACTIVE'
						AND
						f.business_partner_id =$agent_no
						ORDER BY a.fname ASC;";
$resulta=mysql_query($sqlGetAllAffiliates);
while(list($aff_no,$aff_fname,$aff_lname,$email ,$agent_code,$agent_address ,$agent_contact)=mysql_fetch_array($resulta))
{
	$sql1="SELECT COUNT(id) FROM leads l WHERE agent_id = $aff_no AND status ='New Leads';";
	$result1=mysql_query($sql1);
	list($num1) = mysql_fetch_array($result1);
	$sql2="SELECT COUNT(id) FROM leads l WHERE agent_id = $aff_no AND status ='Follow-Up';";
	$result2=mysql_query($sql2);
	list($num2) = mysql_fetch_array($result2);
	$sql3="SELECT COUNT(id) FROM leads l WHERE agent_id = $aff_no AND status ='Keep In-Touch';";
	$result3=mysql_query($sql3);
	list($num3) = mysql_fetch_array($result3);
	$sql4="SELECT COUNT(id) FROM leads l WHERE agent_id = $aff_no AND status ='Client';";
	$result4=mysql_query($sql4);
	list($num4) = mysql_fetch_array($result4);
	
	$leads_count=$num1+$num2+$num3+$num4;
	//affiliate
	//lead_status
?>
	<div style="border-bottom:#CCCCCC solid 1px; font:11px Tahoma;">
		<div style="float:left; width:221px; line-height:20px; padding-left:5px;">
		<input type="radio" name="action" value="<? echo $aff_no;?>" onClick ="goto(<? echo $aff_no;?>); return false;" >
		<a href="javascript:show_hide('<?=$aff_no;?>');">
			<? echo $aff_fname." ".$aff_lname;?>
		</a>	
		</div>
		<div style="float:left; width:250px;line-height:20px; border-left:#999999 solid 1px; padding-left:5px;"><?=$email;?></div>
		<div style="float:left; width:50px;line-height:20px; border-left:#999999 solid 1px; padding-left:5px; text-align:center;"><?=$leads_count;?></div>
		<div style="float:left; line-height:20px; border-left:#999999 solid 1px; padding-left:5px;"><?=$agent_contact;?></div>
		<div style="clear:both;"></div>	
	</div>
	<div id="<?=$aff_no;?>" style="display:none; padding:5px; background:#F4F4F4; border:#CCCCCC ridge 1px;">
		<div><b>Address : </b><?=$agent_address;?></div>
		<ul>
			<li><a href="agent_aff_leads.php?affiliate=<?=$aff_no;?>&lead_status=New Leads"><?=$num1;?>&nbsp;New Leads</a></li>
			<li><a href="agent_aff_leads.php?affiliate=<?=$aff_no;?>&lead_status=Follow-Up"><?=$num2;?>&nbsp;Follow-Up Leads</a></li>
			<li><a href="agent_aff_leads.php?affiliate=<?=$aff_no;?>&lead_status=Keep In-Touch"><?=$num3;?>&nbsp;Keep In-Touch Leads</a></li>
			<li><a href="agent_aff_leads.php?affiliate=<?=$aff_no;?>&lead_status=Client"><?=$num4;?>&nbsp;Client</a></li>
		</ul>
	</div>
<?	
}

?>
</div>
</td>
</tr>
</table>

<? include 'footer.php';?>
</form>
<!-- ROY'S CODE -------------------><!-- ALARM BOX -->
<DIV ID='alarm' STYLE='POSITION: Absolute; RIGHT: 5px; TOP: 5px; width: 200px; VISIBILITY: HIDDEN'></DIV>
<div id="support_sound_alert"></div>
<!-- ROY'S CODE -------------------><!-- ALARM BOX -->
</body>
</html>

