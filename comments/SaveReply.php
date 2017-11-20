<?php
include('../conf/zend_smarty_conf.php');
include 'comments_function.php';
include '../time.php';
$smarty = new Smarty();


$AusTime = date("H:i:s"); 
$AusDate = date("Y")."-".date("m")."-".date("d");
$ATZ = $AusDate." ".$AusTime;



if($_SESSION['agent_no'] != "" || $_SESSION['agent_no'] !=NULL){
	$reply_by_id = $_SESSION['agent_no'];
	$reply_by_type = 'agent';
}else if($_SESSION['admin_id'] != "" || $_SESSION['admin_id']!=NULL){
	$reply_by_id = $_SESSION['admin_id'];
	$reply_by_type = 'admin';
}else if($_SESSION['client_id'] != "" || $_SESSION['client_id']!=NULL){
	$reply_by_id = $_SESSION['client_id'];
	$reply_by_type = 'leads';
}else{
	die("Session Expired. Please re-login");
}

$comment_id = $_REQUEST['comment_id'];
$message = $_REQUEST['message'];
$send = $_REQUEST['send'];



if($comment_id == ""){
	echo "Comment Id is missing.";
	exit;
}


//id, comment_id, reply_by_id, reply_by_type, date_reply, reply, reply_status
$data = array(
				'comment_id' => $comment_id, 
				'reply_by_id' => $reply_by_id, 
				'reply_by_type' => $reply_by_type, 
				'date_reply' => $ATZ, 
				'reply' => $message, 
				'reply_status' => 'posted' 
			);
//print_r($data)."<br>";

$db->insert('system_comments_reply',$data);
$reply_id = $db->lastInsertId();


if($send == "yes"){
	//send an email to the onw who commented with reply
	
	//id, comment_by_id, comment_by_type, date_commented, comments, status, date_updated
	$sql = $db->select()
		->from('system_comments')
		->where('id =?', $comment_id);
	$comment = $db->fetchRow($sql);	
	
	//recipient
	$email = getEmail($comment['comment_by_id'],$comment['comment_by_type']);
	$name = getCreator($comment['comment_by_id'],$comment['comment_by_type']);
	
	
	//sender
	$sender = getCreator($reply_by_id,$reply_by_type); 
	$site = $_SERVER['HTTP_HOST'];
	if($site == "localhost"){
		$site ="test.remotestaff.com.au";
	}
	
	$body = "<p>".$name.", </p>
					<p>".$sender." replies to your comment</p>
					<p><b>Your posted comment/suggestion </b><br> <em>".$comment['comments']."</em></p>
					<hr>
			<table width='100%' cellpadding='3' cellspacing='0'>
					<tr>
					<td width='2%' valign='top'><img src='http://".$site."/portal/leads_information/media/images/quote.png'></td>
					<td width='98%' valign='top' style='border-left:#999999 solid 1px; padding-left:5px;'>".stripslashes($message)."
					<div style='color:#666666; margin-top:10px;' >---".$sender." ".$ATZ."</div>
					</td>
					</tr>
			</table><br>
			<a href='http://".$site."/'>
				<img src='http://".$site."/portal/images/remote_staff_logo.png' width='171' height='49' border='0'>
			</a>";
	
	//SEND MAIL
	$subject = "Message from Remotestaff";
	$mail = new Zend_Mail();
	$mail->setBodyHtml($body);
	$mail->setFrom('noreply@remotestaff.com.au', 'No Reply');
	if(! TEST){
		$mail->addTo($email,$name);
	}else{
		$mail->addTo('devs@remotestaff.com.au','Remotestaff Developers');
	}
	$mail->setSubject($subject);
	$mail->send($transport);

	
}


//parse all replies

$reply_result = GetReply($comment_id);




$smarty->assign('reply_result',$reply_result);
header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); // Date in the past
header("Pragma: no-cache");
$smarty->display('SaveReply.tpl');


?>