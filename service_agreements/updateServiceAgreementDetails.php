<?
include '../config.php';
include '../conf.php';
include '../time.php';
include '../function.php';

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

$service_agreement_id = $_REQUEST['service_agreement_id'];
$service_agreement_details_id = $_REQUEST['service_agreement_details_id'];
$service_agreement_details = filterfield($_REQUEST['service_agreement_detail']);


$sql = "UPDATE service_agreement_details SET service_agreement_details = '$service_agreement_details' 
		WHERE service_agreement_details_id = $service_agreement_details_id;";
$result = mysqli_query($link2, $sql);	
if(!$result) die ("Error in SQL Script ." .$sql);

$sql = "SELECT service_agreement_details_id, service_agreement_details FROM service_agreement_details s WHERE service_agreement_id = $service_agreement_id;";
	//echo $sql;	
  $result = mysqli_query($link2, $sql);	
  $counter=0;
  /*
  1. 1 part time Debt Collector (telemarketer), working 4 hours a day, 5 days a week
	Monthly Fees: $AUD 600 - 700 + GST + Temporary Currency Fluctuation Fee
  */
  while(list($service_agreement_details_id, $service_agreement_details)=mysqli_fetch_array($result))
  {
  		$counter++;
				
	?>
		<div style="padding:10px;">
			<div style="text-align:right;"><a href="javascript:editServiceAgreementDetails(<?=$service_agreement_details_id;?>)">Edit</a> | <a href="javascript:deleteServiceAgreementDetails(<?=$service_agreement_details_id;?>)">Delete</a></div>
			<div>
			<?
			$str =  $service_agreement_details;
			//echo $str;
			$chars = preg_split('/Monthly/', $str, -1, PREG_SPLIT_NO_EMPTY);
			echo $counter.") ". $chars[0];
			echo "<br>Monthly ". $chars[1];
			
			?>
			</div>
		</div>
	<?	
  }
	  
?>



