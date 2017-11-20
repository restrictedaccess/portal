<?
include '../config.php';
include '../conf.php';

$query="SELECT agent_no,fname,lname FROM agent WHERE status='ACTIVE' AND work_status = 'BP' ORDER BY work_status DESC;";
$result=mysql_query($query);
while(list($agent_no,$fname,$lname)=mysql_fetch_array($result))
{
	$agentOptions.="<option value='$agent_no'>$fname&nbsp;$lname</option>";
}

$agent_no = $_SESSION['agent_no'];
$admin_id = $_SESSION['admin_id'];
if($admin_id!=NULL){
	$created_by = $admin_id;
	$created_by_type = 'admin';
	$queryAllLeads = "SELECT id, lname, fname , company_name,agent_id
	FROM leads l
	WHERE (l.status = 'New Leads' OR l.status = 'Follow-Up' OR l.status = 'Keep In-Touch' OR l.status = 'Client' )
	ORDER BY l.fname ASC;";
	$result = mysql_query($queryAllLeads);
	if(!result) die("Error in sql script ".$queryAllLeads);
	while(list($id, $lname, $fname , $company_name)=mysql_fetch_array($result))
	{
		$company_name ?  "( ".$company_name." )" : '&nbsp;';
		if($leads_id == $id ) {
			$leads_Options.="<option value=".$id." selected>".$fname." ".$lname."</option>";
		}else{
			$leads_Options.="<option value=".$id.">".$fname." ".$lname."</option>";
		}	
	}
	
}

if($agent_no!=NULL){
	$created_by = $agent_no;
	$created_by_type = 'agent';
	//$queryAllLeads = "SELECT id, lname, fname , company_name,agent_id
	//FROM leads l
	//WHERE (l.status = 'New Leads' OR l.status = 'Follow-Up' OR l.status = 'Keep In-Touch' OR l.status = 'Client' )
	//AND l.agent_id = $agent_no
	//ORDER BY l.fname ASC;";
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
	
	

}





$monthArray=array("","1","2","3","4","5","6","7","8","9","10","11","12");
$monthName=array("-","Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec");
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


?>
<div><b>SEARCH</b></div>
<div style="padding:20px; border-top:#666666 ridge 2px;border-bottom:#666666 ridge 2px;">
	<div style="color:#666666;"><b>Quote Created By</b></div>
	<div style="padding:5px;">
	<select name="agent" id="agent" class="select" onChange="searchByAgent(this.value)">
	<option value="ALL">-ALL-</option>
	<option value="0">Administrator</option>
	<?=$agentOptions;?>
	</select>
	</div>
	
	<div style="color:#666666;"><b>Leads</b></div>
	<div style="padding:5px;">
	<select name="client" id="client" class="select" onChange="searchByLeads();">
	 <option value="">-Select-</option>
	 <?=$leads_Options;?>
	</select>
	</div>
	<div style="color:#666666;"><b>Month | Year</b></div>
	<div style="padding:5px;">
	<select name="month" id="month" style="width:60px;" class="select" onChange="searchByMonth()">
	 	 <? echo $monthoptions;?>
	</select>
	<select name="year" id="year"  class="select" style="width:60px;"  onChange="searchByMonth();">
		<option value="2009">2009</option>
		<option value="2010">2010</option>
		<option value="2011">2011</option>
		<option value="2012">2012</option>
	</select>
	</div>
	<div style="color:#666666;"><b>Quote No</b></div>
	<div style="padding:5px;">
	<input type="text" id="quote_no" class="select" onKeyUp="searchByQuoteNo(this.value)">
	</div>
</div>