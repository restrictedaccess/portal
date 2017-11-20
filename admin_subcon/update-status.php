<?php
include('../conf/zend_smarty_conf.php');

$sql = $db->select()
	->from('subcontractors');
$result = $db->fetchAll($sql);	

foreach($result as $row){
	if($row['status'] == "ACTIVE"){
		$status = "ACTIVE";
	}else{
		$status = "resigned";
	}
	
	$data = array('temp_status' => $status);
	$where = "id = ".$row['id'];	
	$db->update('subcontractors' , $data, $where);
}
	

?>
