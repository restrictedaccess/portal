<?php
include('../conf/zend_smarty_conf.php');
include 'comments_function.php';
include '../time.php';
$smarty = new Smarty();


$AusTime = date("H:i:s"); 
$AusDate = date("Y")."-".date("m")."-".date("d");
$ATZ = $AusDate." ".$AusTime;



if($_SESSION['agent_no'] != "" || $_SESSION['agent_no'] !=NULL){
	$comment_by_id = $_SESSION['agent_no'];
	$comment_by_type = 'agent';
	
	$condition = " AND comment_by_id = $comment_by_id AND comment_by_type = '$comment_by_type'";
	
}else if($_SESSION['admin_id'] != "" || $_SESSION['admin_id']!=NULL){
	
	$condition = "";
	
}else if($_SESSION['client_id'] != "" || $_SESSION['client_id']!=NULL){
	$comment_by_id = $_SESSION['client_id'];
	$comment_by_type = 'leads';
	$condition = " AND comment_by_id = $comment_by_id AND comment_by_type = '$comment_by_type'";
	
}else{
	die("Session Expired. Please re-login");
}

$sql = "SELECT id, comment_by_id, comment_by_type, DATE_FORMAT(date_commented,'%d %b %Y')AS date_commented, comments, status, date_updated FROM system_comments WHERE  status != 'removed' $condition ";
	
		
	$comments = $db->fetchAll($sql);
	echo "<ol>";
	foreach($comments as $comment){
		//echo sprintf("<li><div class='com_box'><div>Date Created : %s</div><div style='margin-top:10px;'>%s</div></div></li>",$comment['date_commented'] , $comment['comments']);	
		$replies = GetReply($comment['id']);
	?>
	<li><div class='com_box'><div><?php echo getCreator($comment['comment_by_id'],$comment['comment_by_type']);?> #<?php echo $comment['comment_by_id'];?>
	<?php if($_SESSION['admin_id'] != "" || $_SESSION['admin_id']!=NULL){ ?>
	 <span class='com_con'><a href='javascript:ShowReplyForm(<?php echo $comment['id']?>)'>reply</a> | <a href='javascript:DeleteComment(<?php echo $comment['id']?>)'>delete</a></span>
	 <?php } ?>
	 </div>
		<div>Date Created : <?php echo $comment['date_commented'];?></div>
		<div class='comm'><img src='comments/media/images/quote-start.png'><?php echo $comment['comments'];?><img src='comments/media/images/quote-end.png'></div>
		<div class='reply_div' id='reply_div_<?php echo $comment['id'];?>'></div>
		<div id='replies_<?php echo $comment['id'];?>'>
		<?php if($replies !="" ) {?>
		<div class='rep_sec' >
		<div><b>REPLY</b></div>
		<div class='rep_list'>
		<table width='100%' cellpadding='3' cellspacing='0'><?php echo $replies;?></table>
		</div>
		</div>
		<?php } ?>
		</div>
		</div>
		</li>

	<?php	
		
	}
	
	echo "</ol>";

?>