<?php
include '../conf/zend_smarty_conf.php';
include '../time.php';
$smarty = new Smarty();


$AusTime = date("H:i:s"); 
$AusDate = date("Y")."-".date("m")."-".date("d");
$ATZ = $AusDate." ".$AusTime;



if($_SESSION['agent_no'] != "" || $_SESSION['agent_no'] !=NULL){
	$created_by_id = $_SESSION['agent_no'];
	$created_by_type = 'bp';
	$added_by_type = 'agent';
}else if($_SESSION['admin_id'] != "" || $_SESSION['admin_id']!=NULL){
	$created_by_id = $_SESSION['admin_id'];
	$created_by_type = 'admin';
	$added_by_type = 'admin';
}else{
	die("Session Expired. Please re-login");
}


$leads_id = $_REQUEST['leads_id'];
$category_ids = $_REQUEST['category_ids'];

$category_ids = explode(',',$category_ids);
//print_r($category_ids);
//echo count($category_ids);

//get the MAX(counter)
$sql = "SELECT MAX(counter)AS counter FROM leads_inquiry;";
$counter = $db->fetchOne($sql);
if(!$counter){
	$counter = 1;
}else{
	$counter = $counter + 1;
}	
//echo $counter;exit;


for($i=0; $i<count($category_ids); $i++){

	
	$sql = $db->select()
		->from('job_category' , 'category_name')
		->where('category_id =?' ,$category_ids[$i]);
	$category_name = $db->fetchOne($sql);
	//echo $category_ids[$i]." ".$category_name."<br>";
	
	//id, category_id, leads_id, date_added, added_by_id, added_by_type, counter
	$data = array('category_id' => $category_ids[$i] , 'leads_id' => $leads_id, 'date_added' => $ATZ , 'added_by_id' => $created_by_id, 'added_by_type' => $added_by_type, 'counter' => $counter);
	$db->insert('leads_inquiry' , $data);
	
	$category_names .= $category_name.",";
	
}


$category_names=substr($category_names,0,(strlen($category_names)-1));
$history_changes = 'Added Leads Inquiring about : '.$category_names ;
$changes = array(
			 'leads_id' => $leads_id ,
			 'date_change' => $ATZ, 
			 'changes' => $history_changes, 
			 'change_by_id' => $created_by_id, 
			 'change_by_type' => $created_by_type
			 );
$db->insert('leads_info_history', $changes);

$data = array('last_updated_date' => $ATZ);
$db->update('leads', $data, 'id='.$leads_id);
	
?>