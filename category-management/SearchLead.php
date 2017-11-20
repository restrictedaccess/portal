<?php
include '../conf/zend_smarty_conf.php';
include '../time.php';

$search_str = $_REQUEST['search_str'];
$search_type = $_REQUEST['search_type'];

//echo $search_str." ".$search_type;
//exit;
$sql = "SELECT * FROM leads l WHERE $search_type = '$search_str' AND status!='Inactive' AND status!='REMOVED' AND status!='transferred' ORDER BY l.fname ASC;";
$result=$db->fetchAll($sql);
foreach($result as $result){
	$usernameOptions .="<option value= ".$result['id'].">".$result['fname']." ".$result['lname']." [".$result['email']."]</option>";
}
echo "<select id='lead_id' name='lead_id' style='width:300px;'>".$usernameOptions."</select>";
exit;
?>