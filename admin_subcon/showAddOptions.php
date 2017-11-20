<?php
include '../conf/zend_smarty_conf.php';
$smarty = new Smarty();

if($_SESSION['admin_id']=="")
{
	die("Admin id is missing");
}
$admin_id = $_SESSION['admin_id'];

$mode = $_REQUEST['mode'];
$keyword = $_REQUEST['keyword'];


//mode : 1 create new , 2 select from applicants list , 3 select from marked applicant list, 4 keyword search
//echo $mode." ".$keyword;
if($mode == 2){
	$sql = "SELECT DISTINCT(userid), fname, lname , email  FROM personal ORDER BY fname ASC;";
	$result = $db->fetchAll($sql);
	foreach($result as $row){
		$usernameOptions .="<option value=".$row['userid'].">".$row['fname']." ".$row['lname']." [".$row['email']."]</option>";
	}
	$smarty->assign('usernameOptions',$usernameOptions);
}
if($mode == 3){
	$sql = "SELECT DISTINCT(userid), fname, lname , email FROM personal WHERE status='MARK' ORDER BY fname ASC;";
	$result = $db->fetchAll($sql);
	foreach($result as $row){
		$usernameOptions .="<option value=".$row['userid'].">".$row['fname']." ".$row['lname']." [".$row['email']."]</option>";
	}
	$smarty->assign('usernameOptions',$usernameOptions);
}

if($mode == 4){
	$sql = "SELECT DISTINCT(s.userid), fname, lname , email FROM personal u JOIN subcontractors s ON s.userid = u.userid WHERE s.status='ACTIVE' ORDER BY fname ASC;";
	$result = $db->fetchAll($sql);
	foreach($result as $row){
		$usernameOptions .="<option value=".$row['userid'].">".$row['fname']." ".$row['lname']." [".$row['email']."]</option>";
	}
	$smarty->assign('usernameOptions',$usernameOptions);
}



if($mode == 'keyword'){
	$keyword_search = " ";
	if($keyword!=NULL){
		# convert to upper case, trim it, and replace spaces with "|": 
		$search = strtoupper(preg_replace('/\s+/', '|', trim($keyword))); 
		# create a MySQL REGEXP for the search: 
		$regexp = "REGEXP '^.*($search).*\$'"; 
		$keyword_search = " WHERE (
					UPPER(lname) $regexp 
					OR UPPER(fname) $regexp 
					OR UPPER(email) $regexp 
					) ";
	}
	$sql = "SELECT DISTINCT(userid), fname, lname , email , image FROM personal $keyword_search ORDER BY fname ASC;";
	$result = $db->fetchAll($sql);
	$smarty->assign('result',$result);
	$smarty->assign('sql',$sql);
}

$smarty->assign('mode',$mode);
header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); // Date in the past
header('Content-Type: text/html; charset=ISO-8859-1');
$smarty->display('showAddOptions.tpl');



?>
