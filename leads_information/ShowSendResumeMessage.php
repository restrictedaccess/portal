<?php
include '../conf/zend_smarty_conf.php';
include ('./AdminBPActionHistoryToLeads.php');
$smarty = new Smarty();


$id = $_REQUEST['id'];
if($id == "" or $id == NULL){
	echo "ID is Missing";
	exit;
}


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




$sql = $db->select()
	->from('staff_resume_email_sent')
	->where('id = ?' ,$id);
$comments = $db->fetchRow($sql);
$comments_result .= "
						<tr>
						<td width='2%' valign='top'><img src='./media/images/quote.png'></td>
						<td width='98%' class='mess' valign='top'>".stripslashes($comments['message'])."
						<div class='from'>---".getCreator($comments['leads_id'] , 'leads')." ".$comments['date']."</div>
						</td>
						</tr>
						<tr><td colspan='2'>&nbsp;</td></tr>
						";
		
					

	
	



$smarty->assign('id',$id);
$smarty->assign('comments',$comments);	
$smarty->assign('comments_result',$comments_result);

header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); // Date in the past
header("Pragma: no-cache");
$smarty->display('ShowSendResumeMessage.tpl');

?>

