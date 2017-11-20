<?php
include '../conf/zend_smarty_conf.php';
$queryString = trim($_REQUEST['queryString']);
if(strlen($queryString) >0) {
	$sql = "SELECT category_name FROM job_category WHERE status !='removed' AND category_name LIKE '$queryString%' ";
	//echo $sql;exit;
	$results = $db->fetchAll($sql);
	//print_r($results);exit;
	
	if(count($results)) {
		echo '<ul>';
			foreach($results as $result) {
				echo '<li onClick="fill(\''.addslashes($result['category_name']).'\');">'.$result['category_name'].'</li>';
			}
		echo '</ul>';
	}
}
?>
