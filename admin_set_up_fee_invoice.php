<?
include 'config.php';
include 'conf.php';
include 'time.php';

$admin_id = $_SESSION['admin_id'];
$admin_status=$_SESSION['status'];
if($_SESSION['admin_id']=="")
{
	header("location:index.php");
}

$url=$_REQUEST['url'];
$leads_id = $_REQUEST['leads_id'];
if($leads_id!=""){
	$display = "style='display:block;'";
}else{
	$display = "style='display:none;'";
}


$sql ="SELECT * FROM admin WHERE admin_id = $admin_id;";
$res=mysql_query($sql);
$ctr2=@mysql_num_rows($res);
if ($ctr2 >0 )
{
	$row = mysql_fetch_array ($res); 
	$admin_lname = $row['admin_lname'];
	$admin_fname = $row['admin_fname'];
	//$desc= str_replace("\n","<br>",$desc);
	
}

/*
id, tracking_no, agent_id, timestamp, status, call_time_preference, remote_staff_competences, remote_staff_needed, remote_staff_needed_when, remote_staff_one_home, remote_staff_one_office, your_questions, lname, fname, company_position, company_name, company_address, email, password, website, officenumber, mobile, company_description, company_industry, company_size, outsourcing_experience, outsourcing_experience_description, company_turnover, referal_program, contacted_since, client_since, inactive_since, rating, personal_id, date_move, agent_from, authenticate, opt, show_to_affiliate, leads_country, leads_ip
*/
$queryAllLeads = "SELECT id, lname, fname , company_name,agent_id
FROM leads l
WHERE l.status != 'Inactive'
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
<link rel=stylesheet type=text/css href="adminmenu.css">
<script type="text/javascript" src="invoice/set_up_fee_invoice/agent_set_up_fee_invoice.js" ></script>

</head>
<body style="background:#ffffff" text="#000000" topmargin="0" leftmargin="0" marginheight="0" marginwidth="0">
<form name="form" action="pdf_report/spf/index.php">
<!-- HEADER -->
<? include 'header.php';?>
<? include 'admin_header_menu.php';?>
<table width=100% cellpadding=0 cellspacing=0 border=0 align=center>
<tr><td style='border-right: #006699 2px solid; width: 170px; vertical-align:top; '>
<? include 'adminleftnav.php';?>
</td>
<td width=100% valign=top >
	<table width="100%">
		<tr>
			<td width="36%" valign="top">
			
			<div class="box_title">Create Recruitment Set-Up Fee Tax Invoice </div>
			<div class="box" id="create_panel">
			<p style="color:#999999;"><B>NOTE :</B><br>
 1 Job Role for 1 Staff is $250.00.<br />For additional staff for the same Job Role is extra $150.00</p>
			<p><input type="button" id="create_new_btn"  value="Create New" onClick="show_hide('create_new_div');">&nbsp;<input type="button" value="Refresh" onClick="showAllSetUpFeeInvoice();"> <?php if ($url!="") {?>
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
<p><label>Select from the List :</label><select id="leads_id" name="leads_id" class="select" onChange="checkInputs();"><option value="0">--</option><?=$leads_Options;?></select></p>
<p><b>Manually Entered : </b></p>
<p><label>Name :</label><input type="text" name="leads_name" id="leads_name"  class="select" onKeyUp="checkInputs2();" /></p>
<p><label>Email :</label><input type="text" name="leads_email" id="leads_email" class="select" onKeyUp="checkInputs2();" /></p>
<p><label>Company : </label><input type="text" name="leads_company" id="leads_company" class="select"  /></p>
<p><label>Address : </label><textarea id="leads_address" name="leads_address" class="select"></textarea></p>

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
			  <p>Create New Invoice Set-Up Fee. Click the button "Create".</p>
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
