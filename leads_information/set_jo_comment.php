<?php
include '../conf/zend_smarty_conf.php';
include '../lib/addLeadsInfoHistoryChanges.php';

//id, leads_id, date_change, changes, change_by_id, change_by_type
if($_SESSION['admin_id']!="") {
	
	$comment_by_id = $_SESSION['admin_id'] ;
	$comment_by_type = 'admin';
	$change_by_type = 'admin';
	
}else if($_SESSION['agent_no']!="") {

	$comment_by_id = $_SESSION['agent_no'] ;
	$comment_by_type = 'agent';
	$change_by_type = 'bp';
	
}else{
	die("Session Expired. Please re-login");
}


$AusTime = date("H:i:s"); 
$AusDate = date("Y")."-".date("m")."-".date("d");
$ATZ = $AusDate." ".$AusTime;

$leads_id = $_REQUEST['leads_id'];
$gs_job_titles_details_id=$_REQUEST['gs_job_titles_details_id'];
$comment=$_REQUEST['comment'];

$data = array(
    'comments' => $comment,
	'comment_by_id' => $comment_by_id,
	'comment_by_type' => $comment_by_type,
	'comment_date' => $ATZ
);

$db->update('gs_job_titles_details', $data, 'gs_job_titles_details_id='.$gs_job_titles_details_id);
//print_r($data);exit;

$no_of_order = ShowLeadsCustomOrder($leads_id);
//echo $no_of_order;exit;
if($no_of_order > 0){
	// leads has still an exsiting active or new ads
	$data = array('custom_recruitment_order' => 'yes');
	addLeadsInfoHistoryChanges($data ,$leads_id , $comment_by_id , $change_by_type);
	$where = "id = ".$leads_id;	
	$db->update('leads' ,  $data , $where);
		 
}else{
	// leads has no exsiting active or new ads
	$data = array('custom_recruitment_order' => 'no');
	addLeadsInfoHistoryChanges($data ,$leads_id , $comment_by_id , $change_by_type);
	$where = "id = ".$leads_id;	
	$db->update('leads' ,  $data , $where);
}

$data = array('last_updated_date' => $ATZ);
$db->update('leads', $data, 'id='.$leads_id);

function ShowLeadsCustomOrder($leads_id){
	global $db;
	$order_counter =0;
	$total_order_counter = 0;
	$order_details_counter = 0;
	$str = '';
	$sql = "SELECT * FROM gs_job_role_selection WHERE leads_id = ".$leads_id;
	//echo $sql."<br>";
	$orders = $db->fetchAll($sql);
	//echo "NO of rows gs_job_role_selection => ".count($orders)."<br>"; 
	//$order_details_counter = count($orders);
	if(count($orders) > 0){
	    $order_details_counter = 0;
		foreach($orders as $o){
			 $sql = "SELECT * FROM gs_job_titles_details g WHERE comments is NULL AND form_filled_up = 'yes' AND gs_job_role_selection_id =".$o['gs_job_role_selection_id'];
			 $order_details = $db->fetchAll($sql);
			 
			 //echo count($order_details_counter)."<br>";
			 
			 if(count($order_details) > 0){
			     //$order_details_counter = $order_details_counter + 1;
			     foreach($order_details as $d){
			         //CHECK IF ADS STATUS IS ARCHIVE
			         $sql = "SELECT * FROM posting WHERE status = 'ARCHIVE' AND job_order_source = 'rs' AND job_order_id = ".$d['gs_job_titles_details_id'];
					 //echo $sql."<br>";
			 	     $posting = $db->fetchRow($sql);
					 if($posting['id']){
					     $order_details_counter = $order_details_counter - 1;
					 }else{
					     $order_details_counter = $order_details_counter + 1;
					 } 
			     }
			 }
		}
		
	
	}
	//echo 'gs_job_titles_details => '.$order_details_counter;
	return $order_details_counter;
}	


echo 'ok';
exit;	
?>