<?php


//include('conf/zend_smarty_conf_root.php');
include('conf/zend_smarty_conf.php');
include 'comments/comments_function.php';
include 'function.php';
include 'time.php';
$AusTime = date("H:i:s"); 
$AusDate = date("Y")."-".date("m")."-".date("d");
$ATZ = $AusDate." ".$AusTime;

if($_SESSION['client_id'] == "" or $_SESSION['client_id'] == NULL){

	header("location:index.php");
}

$client_id = $_SESSION['client_id'];
$sent = False;


if (array_key_exists('_submit_check', $_POST)) {

	$comment = $_POST['comment'];
	$data = array(
		'comment_by_id' => $_SESSION['client_id'], 
		'comment_by_type' => 'leads', 
		'date_commented' => $ATZ, 
		'comments' => $comment, 
		'status' => 'new'
	);
	$db->insert('system_comments', $data);		
	$comment_id = $db->lastInsertId();
	//echo $comment_id;
	
	
	$sql = $db->select()
		->from('leads')
		->where('id = ?', $_SESSION['client_id']);
	$result = $db->fetchRow($sql);	
	
	$body = "<p>Dear Admin, </p>
					<p>A Remotestaff Client sent a comment from ".$_SERVER['HTTP_HOST']."</p>
					<p>Please see comments / suggestions below.</p>
					<hr>
			<table width='100%' cellpadding='3' cellspacing='0'>
					<tr>
					<td width='2%' valign='top'><img src='http://test.remotestaff.com.au/portal/leads_information/media/images/quote.png'></td>
					<td width='98%' valign='top' style='border-left:#999999 solid 1px; padding-left:5px;'>".stripslashes($comment)."
					<div style='color:#666666; margin-top:10px;' >---".$result['fname']." ".$result['lname']." ".$result['email']." ".$ATZ."</div>
					</td>
					</tr>
			</table>";
				
	$mail = new Zend_Mail();
	$mail->setBodyHtml($body);
	$mail->setFrom('noreply@remotestaff.com.au', 'No Reply');
	if(! TEST){
	
		$mail->addTo('staffclientrelations@remotestaff.com.au' , 'Client-Staff Relations Officer');
		$mail->addCc('admin@remotestaff.com.au', 'Admin');
		$mail->addBcc('normanm@remotestaff.com.au');// Adds a recipient to the mail not visible in the header.
		
	}else{
		$mail->addTo('devs@remotestaff.com.au', 'Remotestaff Developers');
	}
	
	$subject = sprintf("Remotestaff Client %s %s sent a comment",$result['fname'],$result['lname']);
	$mail->setSubject($subject);
	$mail->send($transport);
	$sent = True;
	
	
	
}

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Client RemoteStaff</title>
<link rel=stylesheet type=text/css href="css/font.css">
<link rel=stylesheet type=text/css href="css/style.css">
<link rel=stylesheet type=text/css href="menu.css">
<link rel=stylesheet type=text/css href="leads_information/media/css/leads_information.css">
<link rel=stylesheet type=text/css href="comments/media/css/comment.css">
<script type="text/javascript" src="js/MochiKit.js"></script>
<link rel=stylesheet type=text/css href="comments/media/css/comment.css">
<script type="text/javascript" src="comments/media/js/selectComments.js"></script>	

	
</head>


<body style="background:#ffffff" text="#000000" topmargin="0" leftmargin="0" marginheight="0" marginwidth="0">
<form name="form" method="post" action="comments_suggestion.php" onSubmit="return CheckComment();">
<?php include 'header.php';?>
<?php include 'client_top_menu.php';?>
<table cellpadding="0" cellspacing="0" border="0" width="100%">
<tr>
<td width="15%" height="176" bgcolor="#ffffff" valign="top"  style="border-right: #006699 2px solid; width: 170px; vertical-align:top;">
<?php include 'clientleftnav.php';?>
</td>
<td width="85%" valign="top" >
<div style="padding:10px; border:#CCCCCC solid 1px; margin:5px;">
Please post your comments. We welcome any feedback, comments, and suggestions you may have.<br>
We would like to inform you that your comments made will be treated as a high priority by all our team members.<br>
We look forward to your feedback.
<p>Message : <br>
<textarea name="comment" id="comment" style="height:100px; width:500px;"></textarea>
</p>
<?php if($sent==True) { echo "<p><span style='background:yellow;'><b>Your message has been sent</b></span></p>"; } ?>
<p><input type="submit" value="Post your Comment"> </p>
</div>

<h2>Comments & Suggestions</h2>
<div class="hiresteps">
<div id="comments" class="com_div" ><img src="images/loading.gif"></div>
</div></td>
</table>
<?php include 'footer.php';?>
<input type="hidden" name="_submit_check" value="1"/>
</form>
</body>
</html>
