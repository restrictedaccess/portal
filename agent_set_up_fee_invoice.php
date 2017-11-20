<?
include 'config.php';
include 'conf.php';
include 'time.php';
$agent_no = $_SESSION['agent_no'];
$url=$_REQUEST['url'];
$tab = $_REQUEST['tab'];
if($_SESSION['agent_no']==""){
	header("location:index.php");
}


$leads_id = $_REQUEST['leads_id'];
if($leads_id!=""){
	$display = "style='display:block;'";
}else{
	$display = "style='display:none;'";
}

/*
agent_no, lname, fname, email, agent_password, date_registered, agent_code
*/

$sql ="SELECT * FROM agent WHERE agent_no = $agent_no;";
$res=mysql_query($sql);
$ctr2=@mysql_num_rows($res);
if ($ctr2 >0 )
{
	$row = mysql_fetch_array ($res); 
	$agent_code = $row['agent_code'];
	$agent_lname = $row['lname'];
	$agent_fname = $row['fname'];
	//$desc= str_replace("\n","<br>",$desc);
	
}

/*
id, tracking_no, agent_id, timestamp, status, call_time_preference, remote_staff_competences, remote_staff_needed, remote_staff_needed_when, remote_staff_one_home, remote_staff_one_office, your_questions, lname, fname, company_position, company_name, company_address, email, password, website, officenumber, mobile, company_description, company_industry, company_size, outsourcing_experience, outsourcing_experience_description, company_turnover, referal_program, contacted_since, client_since, inactive_since, rating, personal_id, date_move, agent_from, authenticate, opt, show_to_affiliate, leads_country, leads_ip

$queryAllLeads = "SELECT id, lname, fname , company_name,agent_id
FROM leads l
WHERE (l.status = 'New Leads' OR l.status = 'Follow-Up' OR l.status = 'Keep In-Touch' OR l.status = 'Client' )
AND l.agent_id = $agent_no
ORDER BY l.fname ASC;";

//echo $queryAllLeads;
$result = mysql_query($queryAllLeads);
while(list($id, $lname, $fname , $company_name)=mysql_fetch_array($result))
{
	$company_name ?  "( ".$company_name." )" : '&nbsp;';
	if($leads_id == $id ) {
		$leads_Options.="<option value=".$id." selected>".$fname." ".$lname." ". $company_name."</option>";
	}else{
		$leads_Options.="<option value=".$id.">".$fname." ".$lname." ". $company_name."</option>";
	}	
}

$sqlGetAgentAffiliate="SELECT affiliate_id FROM agent_affiliates WHERE business_partner_id = $agent_no";
$r=mysql_query($sqlGetAgentAffiliate);
$counter = 0;
$AffiliatesArray=array($agent_no);
while(list($affiliate_id)=mysql_fetch_array($r))
{
	array_push($AffiliatesArray, $affiliate_id);
}
//print_r($AffiliatesArray);
for($i=0; $i<count($AffiliatesArray);$i++)
{
	$queryAllLeads = "SELECT DISTINCT(id), lname, fname , company_name,agent_id
						FROM leads l
						WHERE l.status != 'Inactive'
						AND l.agent_id = ".$AffiliatesArray[$i]."
						ORDER BY l.fname ASC;";
	//echo $queryAllLeads."<br>";
	$result = mysql_query($queryAllLeads);
	while(list($id, $lname, $fname , $company_name)=mysql_fetch_array($result))
	{
		$company_name ?  "( ".$company_name." )" : '&nbsp;';
		if($leads_id == $id ) {
			$leads_Options.="<option value=".$id." selected>".$fname." ".$lname." ". $company_name."</option>";
		}else{
			$leads_Options.="<option value=".$id.">".$fname." ".$lname." ". $company_name."</option>";
		}	
	}
}
*/
$queryAllLeads = "SELECT DISTINCT(id), lname, fname , company_name,agent_id
					FROM leads l
					WHERE l.status != 'Inactive'
					AND l.business_partner_id = ".$agent_no."
					ORDER BY l.fname ASC;";
//echo $queryAllLeads."<br>";
$result = mysql_query($queryAllLeads);
while(list($id, $lname, $fname , $company_name)=mysql_fetch_array($result))
{
	$company_name ?  "( ".$company_name." )" : '&nbsp;';
	if($leads_id == $id ) {
		$leads_Options.="<option value=".$id." selected>".$fname." ".$lname." ". $company_name."</option>";
	}else{
		$leads_Options.="<option value=".$id.">".$fname." ".$lname." ". $company_name."</option>";
	}	
}


$rateArray=array("AUD","USD","POUND");
for($i=0; $i<count($rateArray);$i++)
{
	if($currency_rate == $rateArray[$i])
	{
		$rate_Options.="<option selected value= ".$rateArray[$i].">".$rateArray[$i]."</option>";
	}else{
		$rate_Options.="<option value= ".$rateArray[$i].">".$rateArray[$i]."</option>";
	}
}


?>
<html>
<head>
<title>Set Up Fee Invoice</title>
<link rel=stylesheet type=text/css href="css/font.css">
<link rel=stylesheet type=text/css href="css/set_up_fee.css">
<link rel=stylesheet type=text/css href="menu.css">
<script type="text/javascript" src="invoice/set_up_fee_invoice/agent_set_up_fee_invoice.js" ></script>

</head>
<body style="background:#ffffff" text="#000000" topmargin="0" leftmargin="0" marginheight="0" marginwidth="0">
<form name="form">
<!-- HEADER -->
<? include 'header.php';?>
<? include 'BP_header.php';?>
<table width=100% cellpadding=0 cellspacing=0 border=0 align=center>
<tr><td style='border-right: #006699 2px solid; width: 170px; vertical-align:top; '>
<img src='images/space.gif' width=1 height=10>
<br clear=all>
<? include 'agentleftnav.php';?>
<br></td>
<td width=100% valign=top >
	<table width="100%">
		<tr>
			<td width="36%" valign="top">
			
			<div class="box_title">Create Recruitment Set Up Fee Tax Invoice</div>
			<div class="box" id="create_panel">
			<p style="color:#999999;">1 Different Job Role for 1 Staff is $250.00.<br />For additional staff for the same Job Role is extra $150.00</p>
			<p><input type="button" id="create_new_btn"  value="Create New" onClick="show_hide('create_new_div');">&nbsp;<input type="button" value="Refresh" onClick="showAllSetUpFeeInvoice();"><?php if ($url!="") {?>
<input type="button" class="btn" value="Back" onClick="self.location='<?php echo $url;?>&lead_status=<?php echo $_GET['lead_status'];?>'"/>
<?php } ?></p>
<div id="create_new_div" <?=$display;?> >	
<p><label>Currency Rate</label>
<select name="currency" id="currency"  onChange="javascript:calculateChargeOutRate();" class="select">
<option value="">-</option>
<?=$rate_Options;?>
</select>
</p>
<span id="currency_desc" style="margin-left:10px; color:#666666;"></span>
<p><b>Choose : </b></p>
<p><label>Select from the List :</label><select id="leads_id" name="leads_id" class="select" onChange="">
<option value="0">--</option><?=$leads_Options;?></select></p>
<!--
<p><b>Manually Entered : </b></p>
<p><label>Name :</label><input type="text" name="leads_name" id="leads_name"  class="select" onKeyUp="checkInputs2();" /></p>
<p><label>Email</label><input type="text" name="leads_email" id="leads_email" class="select" onKeyUp="checkInputs2();" /></p>
<p><label>Company : </label><input type="text" name="leads_company" id="leads_company" class="select"  /></p>
<p><label>Address : </label><textarea id="leads_address" name="leads_address" class="select"></textarea></p>
-->

<p><input type="button" id="create" value="Create" onClick="createNewInvoiceSetUpFee();"/> &nbsp;<input type="button" id="cancel_new_btn" value="Cancel" onClick="show_hide('create_new_div');"></p>
</div>
				<div id="create_box"></div>
			</div>
<div style="background:#333333; color:#FFFFFF; padding:10px;">
<div style="float:left;"><b>Search</b></div>
<div style="float:left; margin-left:10px;"><input type="text" name="keyword" id="keyword" value="<?=$keyword;?>" class="select"  onKeyUp="searchSetupFeeTaxInvoice(this.value)"  ></div>	
<div style="clear:both;"></div>
</div>
			<div id="set_up_fee_invoice_list"></div>
			
		    </td>
			<td width="64%" valign="top">
			<div id="right_panel">
			
			  <p>Select an Invoice to the left to view its details .</p>
			  <p>Create New Invoice Set-Up Fee. Click the button "Create". </p>
			</div>
			</td>
		</tr>
	</table>
</td></tr>
</table>
<script type="text/javascript">
showAllSetUpFeeInvoice();
</script>
<? include 'footer.php';?>		
</form>	
</body>
</html>
