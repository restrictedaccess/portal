<?php
include('../conf/zend_smarty_conf.php');
include 'comments_function.php';
$smarty = new Smarty();

$comment_id = $_REQUEST['id'];
if($comment_id == ""){
	echo "Comment Id is missing.";
	exit;
}

$sql = $db->select()
	->from('system_comments')
	->where('id =?', $comment_id);
$comment = $db->fetchRow($sql);	



$smarty->assign('comment_id',$comment_id);
$smarty->assign('to',getCreator($comment['comment_by_id'],$comment['comment_by_type']));


header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); // Date in the past
header("Pragma: no-cache");
$smarty->display('ShowReplyForm.tpl');

?>