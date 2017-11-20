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

//check the $category_name if existing
$sql = $db->select()
	->from('job_category' , 'category_id')
	->where('category_name = ?' ,$category_name)
	->where('status != ?' ,'removed');
$category_id = $db->fetchOne($sql);	
if($category_id){
	echo $category_name. " already exist. Please try to enter a different sub category name!";
	exit;
}

$data = array(
		'job_role_category_id' => $jr_cat_id, 
		'category_name' => $category_name, 
		'created_by' => $_SESSION['admin_id'], 
		'category_date_created' => $ATZ,
		'status' => 'posted'
		);
		
//print_r($data);		
$db->insert('job_category',$data);
echo $category_name." successfully saved.";

?>