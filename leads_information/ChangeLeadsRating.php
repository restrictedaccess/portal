<?php
include '../conf/zend_smarty_conf.php';
include '../lib/addLeadsInfoHistoryChanges.php';
include '../time.php';

//id, leads_id, date_change, changes, change_by_id, change_by_type
if($_SESSION['admin_id']!="") {
	
	$change_by_id = $_SESSION['admin_id'] ;
	$change_by_type = 'admin';
	
}else if($_SESSION['agent_no']!="") {

	$change_by_id = $_SESSION['agent_no'] ;
	$change_by_type = 'bp';
	
}else{
	die("Session Expired. Please re-login");
}


$AusTime = date("H:i:s"); 
$AusDate = date("Y")."-".date("m")."-".date("d");
$ATZ = $AusDate." ".$AusTime;

$leads_id=$_REQUEST['leads_id'];
$rating = $_REQUEST['rating'];

//echo $leads_id ."<br>".$lead_status;



$data = array('rating' => $rating );
//add history
addLeadsInfoHistoryChanges($data ,$leads_id , $change_by_id , $change_by_type);

$where = "id = ".$leads_id;	
$db->update('leads' ,  $data , $where);

$data = array('last_updated_date' => $ATZ);
$db->update('leads', $data, 'id='.$leads_id);

//stars to be displayed
for($i=1; $i<=$rating;$i++){
	$starOptions.='<img src="images/star.png" align="top">';
}
echo $starOptions;
?>

