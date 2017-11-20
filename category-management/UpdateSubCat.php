<?php
include '../conf/zend_smarty_conf.php';
include '../time.php';

$AusTime = date("H:i:s"); 
$AusDate = date("Y")."-".date("m")."-".date("d");
$ATZ = $AusDate." ".$AusTime;

if($_SESSION['admin_id']=="" or $_SESSION['admin_id']==NULL){
	die('Invalid ID for Admin. Session Expires');
}


$category_name = $_REQUEST['category_name'];
$jr_cat_id = $_REQUEST['jr_cat_id'];
$category_id = $_REQUEST['category_id'];
$job_role_category_id = $_REQUEST['job_role_category_id'];


$sql = $db->select()
	->from('job_category' , 'category_name')
	->where('category_id = ?' , $category_id);
$current_category_name = $db->fetchOne($sql);	

if($current_category_name != $category_name){

	//check the $category_name if existing
	$sql = $db->select()
		->from('job_category' , 'category_id')
		->where('category_name = ?' ,$category_name)
		->where('status != ?' ,'removed');
	$current_category_id = $db->fetchOne($sql);	
	if($current_category_id){
		echo $category_name. " already exist. Please try to enter a different sub category name!";
		exit;
	}
}


$data = array(
		'category_name' => $category_name,
		'job_role_category_id' => $job_role_category_id, 
		'created_by' => $_SESSION['admin_id'], 
		'category_date_created' => $ATZ,
		'status' => 'posted'
		);
		
//print_r($data);		
$where = "category_id = ".$category_id;	
//echo $where;
$db->update('job_category',$data , $where);
echo $category_name." successfully updated.";

?>