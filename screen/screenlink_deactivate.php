<?php
/* screenlink_deactivate.php - 2013-04-25
  set the status of screenshare link to zero - to determine the deletion of file
*/
include '../conf/zend_smarty_conf.php';
if(empty($_SESSION['client_id'])) {
	header("location:index.php");
	exit;
}
$id = isset($_GET['id']) ? $_GET['id'] : $_POST['id'];
try {
    $db->update('client_screenlinks', array('status' => '0'), "id IN ($id)");
} catch (Exception $e){
	echo json_encode(array('result'=>$e->getMessage()));
}
exit();