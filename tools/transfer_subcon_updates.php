<?php
/*
Clone table subcon_updates to table bulletin_board  
*/

include '../conf/zend_smarty_conf.php';

if(!$_SESSION['admin_id']){
    die("Plase Login.");
}

$sql = "SELECT * FROM subcon_updates;";
$subcon_updates = $db->fetchAll($sql);	
echo "<pre>";
echo sprintf('%s recrods found', count($subcon_updates));
echo "<ol>";
foreach($subcon_updates as $subcon_update){
	$data=array(
		'admin_id' => $subcon_update['admin_id'], 
		'message' => $subcon_update['contents'], 
		'date_created' => $subcon_update['date_created'],  
		'status' => 'active', 				
	);
	$db->insert('bulletin_board', $data);
	echo sprintf('<li>subcon_updates.id =>[%s] transffered to bulletin_board table.</li>', $subcon_update['id']);
}
echo "</ol>";
echo "</pre>";
?>