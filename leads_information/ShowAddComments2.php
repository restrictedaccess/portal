<?php
include '../conf/zend_smarty_conf.php';
include ('./AdminBPActionHistoryToLeads.php');
$smarty = new Smarty();


if($_SESSION['agent_no'] != "" || $_SESSION['agent_no'] !=NULL){
	$comment_by_id = $_SESSION['agent_no'];
	$comment_by_type = 'agent';
}else if($_SESSION['admin_id'] != "" || $_SESSION['admin_id']!=NULL){
	$comment_by_id = $_SESSION['admin_id'];
	$comment_by_type = 'admin';
}else if($_SESSION['client_id'] != "" || $_SESSION['client_id']!=NULL){
	$comment_by_id = $_SESSION['client_id'];
	$comment_by_type = 'leads';
}else{
	die("Session Expired. Please re-login");
}


$id = $_REQUEST['id'];

if($id == "" or $id == NULL){
	echo "ID is Missing";
	exit;
}


$sql = $db->select()
	->from('staff_resume_email_sent_comments')
	->where('staff_resume_email_sent_id = ?' ,$id);
$comments = $db->fetchAll($sql);
if(count($comments) > 0){
			
	foreach($comments as $comment){
		$comments_result .= "
						<tr>
						<td width='2%' valign='top'><img src='leads_information/media/images/quote.png'></td>
						<td width='98%' class='mess' valign='top'>".stripslashes($comment['message'])."
						<div class='from'>---".getCreator($comment['comment_by_id'] , $comment['comment_by_type'])." ".$comment['comment_date']."</div>
						</td>
						</tr>
						<tr><td colspan='2'>&nbsp;</td></tr>
						";
		
					
	}
	
	
}else{
	$comments_result = "<tr><td colspan='2'>No comments or notes to be shown</td></tr>";	
}



$smarty->assign('id',$id);
$smarty->assign('comments_result',$comments_result);
	
header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); // Date in the past
header("Pragma: no-cache");
$smarty->display('ShowAddComments2.tpl');
?>

