<?php
include '../conf/zend_smarty_conf.php';
include ('./AdminBPActionHistoryToLeads.php');
include ('./GetAdminBPNotes.php');
$smarty = new Smarty();


$id = $_REQUEST['id'];
if($id == "" or $id == NULL){
	echo "ID is Missing";
	exit;
}

//echo "Here";
$notes = GetAdminBPNotes2($id);
echo $notes;
?>

