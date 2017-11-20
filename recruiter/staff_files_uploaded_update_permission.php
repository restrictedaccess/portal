<?php
include('../conf/zend_smarty_conf.php') ;
$action = $_REQUEST["action"];
$id = $_REQUEST["id"];
$data= array('permission' => $action);
$where = "id = ".$id;
$db->update('tb_applicant_files' , $data , $where);	
echo "File permission updates has been applied.";
?>