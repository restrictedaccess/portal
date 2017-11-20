<?
include './config.php';
$query = "SELECT id ,agent_id  FROM leads l;";
$result = mysql_query($query);
$ctr =0;
while(list($id, $agent_id)=mysql_fetch_array($result)){
	$ctr++;
	$sql = "SELECT work_status FROM agent a WHERE agent_no =$agent_id;";
	$result1 = mysql_query($sql);
	list($work_status)=mysql_fetch_array($result1);
	if($work_status == "BP"){
		$business_partner_id = $agent_id;
		
	}else{
		$sqlBP="SELECT business_partner_id FROM agent_affiliates f WHERE f.affiliate_id = $agent_id;";
		$result2 = mysql_query($sqlBP);
		list($business_partner_id)=mysql_fetch_array($result2);
		$business_partner_id = $business_partner_id;
	}
	
	$QUERY = "UPDATE leads SET business_partner_id = $business_partner_id WHERE id = $id;";
	mysql_query($QUERY);
}
//echo count($result)."<br>";
echo $ctr;
?>