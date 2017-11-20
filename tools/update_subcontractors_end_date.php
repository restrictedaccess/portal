<?php
include '../conf/zend_smarty_conf.php';

if($_SESSION['admin_id']==""){
	echo "Page cannot be viewed.";
	exit;
}

$sql = "SELECT id, status, resignation_date, date_terminated, end_date FROM subcontractors s ;";
$subcontractors = $db->fetchAll($sql);

echo "<pre>";

foreach($subcontractors as $subcon){
    if($subcon['status'] == 'resigned'){
		$data = array('end_date' => $subcon['resignation_date']);	    
	}
	if($subcon['status'] == 'terminated'){
		$data = array('end_date' => $subcon['date_terminated']);
	}
	
	if($subcon['status'] == 'suspended'){
		$data = array('end_date' => NULL);
	}
	
	if($subcon['status'] == 'ACTIVE'){
		if($subcon['end_date'] != ""){
			echo sprintf('[id]=>%s [end_date]=>%s <em>updated end_date set to NULL</em><br>', $subcon['id'], $subcon['end_date']);
		}
		$data = array('end_date' => NULL);
	}
	if($data){
	    $db->update('subcontractors', $data, 'id='.$subcon['id'] );
	}
}
echo "</pre>";
?>