<?php
include '../conf/zend_smarty_conf.php';
include '../time.php';

$AusTime = date("H:i:s"); 
$AusDate = date("Y")."-".date("m")."-".date("d");
$ATZ = $AusDate." ".$AusTime;

if($_SESSION['admin_id']=="" or $_SESSION['admin_id']==NULL){
	die('Invalid ID for Admin. Session Expires');
}


$jr_cat_id = $_REQUEST['jr_cat_id'];
$category_id = $_REQUEST['category_id'];

$sql = $db->select()
	->from('job_category' , 'category_name')
	->where('category_id = ?' , $category_id);
$current_category_name = $db->fetchOne($sql);	

//TODO
//check if this category_id is existing in posting table
$sql = $db->select()
	->from('posting')
	->where('category_id =?' ,$category_id);
$result = $db->fetchAll($sql);	
if(count($result)>0){
	echo "Cannot be remove. This Sub Category is currently in used in Advertisement Section.";
	exit;
}
//
$data = array(
		'created_by' => $_SESSION['admin_id'], 
		'category_date_created' => $ATZ,
		'status' => 'removed'
		);
		
//print_r($data);		
$where = "category_id = ".$category_id;	
//echo $where;
$db->update('job_category',$data , $where);
echo $current_category_name." successfully removed.";

?>