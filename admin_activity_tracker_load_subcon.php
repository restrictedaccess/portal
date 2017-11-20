<?php
include 'config.php';
include 'conf.php';
$client_id = @$_REQUEST["client_id"];
$method = @$_REQUEST["method"];

if($method=="ALL")
{
	$d = '<select size="1" disabled name="subcon_id" id="s_id" style=\'color:#000000; font:arial; font-weight:normal; font-size:11px; padding:0px 1px 2px 2px; border:1px #666666 solid;\'>';
}
else
{
	$d = '<select size="1" name="subcon_id" id="s_id" style=\'color:#000000; font:arial; font-weight:normal; font-size:11px; padding:0px 1px 2px 2px; border:1px #666666 solid;\'>';
}

	$query = "SELECT DISTINCT(p.userid), p.fname,p.lname FROM personal p, subcontractors s WHERE s.userid=p.userid AND s.leads_id='$client_id' AND s.status='ACTIVE'";
	$r_e = mysql_query($query);
	$d = $d."<option value=''></option>";
	while ($row = mysql_fetch_assoc($r_e)) 
	{
		$d = $d."<option value='".$row["userid"]."'>".$row["fname"]." ".$row["lname"]."</option>";
	}
$d = $d."</select>";

echo $d;
?>