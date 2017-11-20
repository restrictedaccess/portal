<?
include '../config.php';
include '../conf.php';
include '../time.php';

$AusTime = date("H:i:s"); 
$AusDate = date("Y")."-".date("m")."-".date("d");
$ATZ = $AusDate." ".$AusTime;



$agent_no = $_SESSION['agent_no'];
$admin_id = $_SESSION['admin_id'];

if($_SESSION['agent_no']==NULL and $_SESSION['admin_id']==NULL){
	die("ID is Missing.");
}

if($admin_id!=NULL){
	$created_by = $admin_id;
	$created_by_type = 'admin';
}

if($agent_no!=NULL){
	$created_by = $agent_no;
	$created_by_type = 'agent';
}

$service_agreement_details_id = $_REQUEST['service_agreement_details_id'];
$sql = "SELECT  service_agreement_details FROM service_agreement_details s WHERE service_agreement_details_id = $service_agreement_details_id;";
$result = mysql_query($sql);	
list($service_agreement_details)=mysql_fetch_array($result)
?>

<div style="background:#D4D4D4; border:#D4D4D4 ridge 2px; padding:10px; position:absolute; width:500px;">
<textarea class="select" id="service_agreement_detail"  rows="3"  style="width:98%">
<?=$service_agreement_details;?>
</textarea>
<input type="button" value="Update" onclick="updateServiceAgreementDetails(<?=$service_agreement_details_id;?>);" /> 
<input type="button" value="Cancel" onClick="hide('service_agreement_details_edit_form');" />
</div>