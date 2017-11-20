<?php

function GetReply($comment_id){
	global $db;
	if($comment_id != ""){
	$sql = "SELECT id , reply_by_id, reply_by_type, DATE_FORMAT(date_reply,'%d %b %Y %r')AS date_reply, reply FROM system_comments_reply WHERE comment_id = $comment_id AND reply_status != 'removed' ;";
		$replies = $db->fetchAll($sql);
		if(count($replies) > 0){
			foreach($replies as $reply){
			
				if($_SESSION['admin_id'] != "" || $_SESSION['admin_id']!=NULL){
					$control = "<div class=rep_con><a href=\"javascript:toggle('reply_edit_div_".$reply['id']."')\">edit</a> | <a href=\"javascript:DeleteReply(".$reply['id'].")\">delete</a></div>";
				}
				$reply_result .= "<tr>
								<td width='2%' valign='top'><img src='comments/media/images/quote-start.png'></td>
								<td width='98%' valign='top' style='border-left:#999999 solid 1px; padding-left:5px;'><div id='reply_edit_div_".$reply['id']."' class='edit_reply_div'><p><textarea class='reply_edit_text' name='reply_edit_text_".$reply['id']."' id='reply_edit_text_".$reply['id']."'>".$reply['reply']."</textarea></p><p><input type='button' value='update' onclick=UpdateReply(".$reply['id'].")><input type='button' value='close' onclick=toggle('reply_edit_div_".$reply['id']."')></p></div>".stripslashes($reply['reply'])."
							<div style='color:#666666; margin-top:10px;' >---".getCreator($reply['reply_by_id'],$reply['reply_by_type'])." ".$reply['date_reply']."</div>$control
								</td>
								</tr>
								<tr><td colspan='2'>&nbsp;</td></tr>
								";
			}	
			
			return $reply_result;
		}else{
			$reply_result = "";
			return $reply_result;
		}
	}
	
}

function getCreator($created_by , $created_by_type)
{
	global $db;
	if($created_by != ""){
			if($created_by_type == 'agent')
			{
				$query = $db->select()
					->from('agent' , 'fname')
					->where('agent_no = ?' ,$created_by);
				$name = $db->fetchOne($query);	
				return " Agent : ".$name;
				
			}else if($created_by_type == 'admin'){
				$query = $db->select()
					->from('admin' , 'admin_fname')
					->where('admin_id = ?' ,$created_by);
				$name = $db->fetchOne($query);	
				return " Admin : ".$name;
				
			}else if($created_by_type == 'leads'){
			
				$query = $db->select()
					->from('leads')
					->where('id = ?' ,$created_by);
				$name = $db->fetchRow($query);	
				return " Lead : ".$name['fname']." ".$name['lname'];
				
			}
			else{
				$name="";
				return $name;
			}
	}
}


function getEmail($created_by , $created_by_type)
{
	global $db;
	if($created_by != ""){
			if($created_by_type == 'agent')
			{
				$query = $db->select()
					->from('agent' , 'email')
					->where('agent_no = ?' ,$created_by);
				$email = $db->fetchOne($query);	
				return $email;
				
			}else if($created_by_type == 'admin'){
				$query = $db->select()
					->from('admin' , 'admin_email')
					->where('admin_id = ?' ,$created_by);
				$email = $db->fetchOne($query);	
				return $email;
				
			}else if($created_by_type == 'leads'){
			
				$query = $db->select()
					->from('leads' , 'email')
					->where('id = ?' ,$created_by);
				$email = $db->fetchOne($query);	
				return $email;
				
			}
			else{
				$email="devs@remotestaff.com.au";
				return $email;
			}
	}
}


