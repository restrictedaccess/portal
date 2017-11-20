<?php
include('../conf/zend_smarty_conf.php');

$sql = $db->select()
	->from('subcontractors');
$result = $db->fetchAll($sql);	

foreach($result as $row){
	$det = new DateTime($row['starting_date']);
	$starting_date = $det->format("Y-m-d");
	
	$data = array('starting_date' => $starting_date);
	$where = "id = ".$row['id'];	
	$db->update('subcontractors' , $data, $where);
	
	echo $starting_date."<br>";
}
	

?>
