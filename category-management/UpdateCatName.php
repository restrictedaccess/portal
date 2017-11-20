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
$cat_name = $_REQUEST['cat_name'];


//check the cat_name
$sql = $db->select()
	->from('job_role_category' , 'cat_name')
	->where('jr_cat_id = ?' , $jr_cat_id);
$current_cat_name = $db->fetchOne($sql);	

if($current_cat_name != $cat_name){
	$sql = $db->select()
		->from('job_role_category' , 'jr_cat_id')
		->where('cat_name = ?' , $cat_name);
	$current_jr_cat_id = $db->fetchOne($sql);
	
	if($current_jr_cat_id){
		echo $cat_name." already exist. Please try another name!";
		exit;
	}
}



//update
$data = array('cat_name' => $cat_name);
$where = "jr_cat_id = ".$jr_cat_id;	
$db->update('job_role_category',$data , $where);


echo $cat_name;



?>