<?php
putenv("TZ=Philippines/Manila") ;
include('../conf/zend_smarty_conf.php') ;
if (!isset($_GET["hr"])){
	$select = "SELECT admin_id,admin_fname,admin_lname 	 
			FROM `admin`
			where (status='HR' 
		OR admin_id='41'
		OR admin_id='67'
		OR admin_id='71'
		OR admin_id='78'
		OR admin_id='81')  
		AND status <> 'REMOVED'  AND status <> 'REMOVED'  AND admin_id <> 161   ORDER by admin_fname";
}else{
	$select = "SELECT admin_id,admin_fname,admin_lname FROM `admin` WHERE hiring_coordinator='Y' AND status <> 'REMOVED' ORDER BY admin_fname";
}
echo json_encode($db->fetchAll($select)); 