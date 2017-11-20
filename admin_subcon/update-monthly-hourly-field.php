<?php
include('../conf/zend_smarty_conf.php');

$sql = "SELECT * FROM subcontractors";	
//echo $sql;exit;
$result = $db->fetchAll($sql);	

$counter = 0;
function isNaN( $var ) {
     return ereg ("^[-]?[0-9]+([\.][0-9]+)?$", $var);
}


foreach($result as $row){
	
	if(!isNaN($row['php_hourly'])){
		$data = array('php_hourly' => 0.00);
		$where = "id = ".$row['id'];
		$db->update('subcontractors' , $data, $where);
		$counter++;
	}
	
	if(!isNaN($row['client_price'])){
		$data = array('client_price' => 0.00);
		$where = "id = ".$row['id'];
		$db->update('subcontractors' , $data, $where);
		$counter++;
	}
	
	if(!isNaN($row['total_charge_out_rate'])){
		$data = array('total_charge_out_rate' => 0.00);
		$where = "id = ".$row['id'];
		$db->update('subcontractors' , $data, $where);
		$counter++;
	}
}
//echo $where;	
echo $counter." records updated";
?>
