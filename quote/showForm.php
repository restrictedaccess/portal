<?
include '../config.php';
include '../conf.php';

$mode = $_REQUEST['mode'];
if($_SESSION['agent_no']==NULL and $_SESSION['admin_id']==NULL){
	die("ID is Missing.");
}

$agent_no = $_SESSION['agent_no'];
$admin_id = $_SESSION['admin_id'];
$leads_id = $_REQUEST['leads_id'];


if($admin_id!=NULL){
	$created_by = $admin_id;
	$created_by_type = 'admin';
	$queryAllLeads = "SELECT id, lname, fname , company_name,agent_id
	FROM leads l
	WHERE l.status != 'Inactive'
	ORDER BY l.fname ASC;";
	$result = mysql_query($queryAllLeads);
	if(!result) die("Error in sql script ".$queryAllLeads);
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

if($agent_no!=NULL){
	$created_by = $agent_no;
	$created_by_type = 'agent';
	//$queryAllLeads = "SELECT id, lname, fname , company_name,agent_id
	//FROM leads l
	//WHERE l.status != 'Inactive'
	//AND l.agent_id = $agent_no
	//ORDER BY l.fname ASC;";
	/*
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
		$queryAllLeads = "SELECT id, lname, fname , company_name,agent_id
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
	$queryAllLeads = "SELECT DISTINCT(id), lname, fname , company_name
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


}

if($mode=="")
{
	die("Mode is missing..!");
}

$leads_id = $_REQUEST['leads_id'];


//echo $queryAllLeads;


if ($mode=="manual")
{
?>
<div id="manual_entry" style="margin:10px; margin-right:20px; border:#CCCCCC solid 1px;">
<div class="hdr"><b>Manual Entry</b></div>
	<div style="padding:20px;">
	<div style="color:#999999; padding:5px;">Note : This Action will insert new leads to the system</div>
		<div style="float:left;">	
		<p><label>First Name :</label><input type="text" name="leads_fname" id="leads_fname" class="select"   /></p>
		<p><label>Last Name :</label><input type="text" name="leads_lname" id="leads_lname" class="select"   /></p>
		<p><label>Email</label><input type="text" name="leads_email" id="leads_email" class="select"   /></p>
		<p><label>Company</label><input type="text" name="leads_company" id="leads_company" class="select"   /></p>
		<p><label>Address</label><textarea name="leads_address" id="leads_address" class="select" rows="4"  ></textarea></p>
		</div>
		<div style="float:left; margin-left:10px;">	
			<input type="button" value="Generate" onClick="generateQuote('manual')">
			<input type="button" value="Cancel" onClick="hide('manual_entry');">
		</div>
		<div style="clear:both;"></div>
	</div>
</div>
<? }

if ($mode=="leads")
{
?>
<div id="leads" style="margin:10px; margin-right:20px; border:#CCCCCC solid 1px;">
<div class="hdr"><b>Select from Leads List</b></div>
	<div style="padding:20px;">
	<div style="color:#999999; padding:5px;">Choose Leads from the system</div>
		<div style="float:left;">	
			<p><label>Leads :</label><select id="leads_id" name="leads_id" class="select" >
									 <option value="0">--</option><?=$leads_Options;?>
									 </select>
			</p>
		</div>
		<div style="float:left; margin-left:10px;">	
			<input type="button" value="Generate" onClick="generateQuote('leads')">
			<input type="button" value="Cancel" onClick="hide('leads');">
		</div>
		<div style="clear:both;"></div>
	</div>
</div>

<? }?>