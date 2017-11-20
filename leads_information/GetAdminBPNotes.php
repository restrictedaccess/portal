<?php
function GetAdminBPNotes($invoice_id){
		global $db;
		
		if($invoice_id == "" or $invoice_id == NULL){
			return "Invoice ID is Missing";
			exit();
		}
		
		
		$sql = "SELECT DATE_FORMAT(comment_date, '%d %b %Y %r')AS comment_date FROM leads_invoice_comments WHERE leads_invoice_id = $invoice_id ORDER BY comment_date DESC LIMIT 1;";	
			
		$comments = $db->fetchAll($sql);
		if(count($comments) > 0){
			
			foreach($comments as $comment){
				/*$comments_result .= "<table class='mess_box' width='100%'>
								<tr>
								<td width='2%' valign='top'><img src='leads_information/media/images/quote.png'></td>
								<td width='98%' class='mess' valign='top'>".$comment['comment_date']."
								<div class='from'>---".getCreator($comment['comment_by_id'] , $comment['comment_by_type'])."</div>
								</td>
								</tr>
								</table>";
				*/
				//$comments_result .=	stripslashes(substr($comment['message'],0,100));			
				//$comments_result = $comment['comment_date'];		
				$det = new DateTime($comment['comment_date']);
				$timestamp = $det->format("M j, Y");
				$comments_result = $timestamp;	
			}
			
			return $comments_result;
		}else{
			return "click to add comment / note";	
		}
		
}


function GetAdminBPNotes2($id){
		global $db;
		
		if($id == "" or $id == NULL){
			return "ID is Missing";
			exit();
		}
		
		$sql = "SELECT comment_by_id, comment_by_type, DATE_FORMAT(comment_date, '%d %b %Y %r')AS comment_date, message FROM staff_resume_email_sent_comments WHERE staff_resume_email_sent_id = $id ORDER BY comment_date DESC LIMIT 1;";	
			
		$comments = $db->fetchAll($sql);
		if(count($comments) > 0){
			
			foreach($comments as $comment){
				/*$comments_result .= "<table class='mess_box' width='100%'>
								<tr>
								<td width='2%' valign='top'><img src='leads_information/media/images/quote.png'></td>
								<td width='98%' class='mess' valign='top'>".stripslashes($comment['message'])."
								<div class='from'>---".getCreator($comment['comment_by_id'] , $comment['comment_by_type'])." ".$comment['comment_date']."</div>
								</td>
								</tr>
								</table>";
				*/
				$det = new DateTime($comment['comment_date']);
				$timestamp = $det->format("M j, Y");
				$comments_result = $timestamp;	
			}
			
			return $comments_result;
		}else{
			return "click to add comment / note";	
		}	
		
		
}



?>

