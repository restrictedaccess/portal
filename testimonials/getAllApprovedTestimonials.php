<?
include "../config.php";
include "../conf.php";
include "../time.php";
include "../function.php";

$AusTime = date("H:i:s"); 
$AusDate = date("Y")."-".date("m")."-".date("d");
$ATZ = $AusDate." ".$AusTime;


if($_SESSION['client_id']!="")
{
	$user = $_SESSION['client_id'];
	$type = 'leads';
	$create_page = "client_create_testimonials.php";
	//WHERE  $status  ((created_by_id = $user AND created_by_type ='$type') OR (recipient_id =$user AND recipient_type = '$type'))
	
	$status = " WHERE testimony_status = 'posted' AND ((created_by_id = $user AND created_by_type ='$type') OR (recipient_id =$user AND recipient_type = '$type'))";
	$testimony_reply_status =" AND testimony_reply_status = 'posted' " ;
}
else if($_SESSION['userid']!="")
{
	$user = $_SESSION['userid'];
	$type = 'subcon';
	$create_page = "subcon_create_testimonials.php";
	$status = " WHERE testimony_status = 'posted' AND ((created_by_id = $user AND created_by_type ='$type') OR (recipient_id =$user AND recipient_type = '$type'))";
	$testimony_reply_status =" AND testimony_reply_status = 'posted' " ;
}
else if($_SESSION['admin_id']!="")
{
	$user = $_SESSION['admin_id'];
	$type = 'admin';
	$status = "  ";
	$testimony_reply_status ="  " ;
}
else if($_SESSION['agent_no']!="")
{
	$user = $_SESSION['agent_no'];
	$type = 'agent';
	$status = " WHERE testimony_status = 'posted' AND ((created_by_id = $user AND created_by_type ='$type') OR (recipient_id =$user AND recipient_type = '$type'))";
	$testimony_reply_status =" AND testimony_reply_status = 'posted' " ;
}
else{
	die("Session Expired. Please re-login again.");
}
//echo $user."<br>".$type;

function getName($id,$type)
{
	if($type == 'agent')
	{
		$query = "SELECT work_status , fname , lname FROM agent a WHERE agent_no = $id;";
		$data = mysql_query($query);
		$row = mysql_fetch_array($data);
		$name = $row[0]." ".$row[1]." ".$row[2];
	}
	else if($type == 'admin')
	{
		$query = "SELECT admin_fname , admin_lname FROM admin a WHERE admin_id = $id;";
		$data = mysql_query($query);
		$row = mysql_fetch_array($data);
		$name = "Administrator ".$row[0]." ".$row[1];
	}
	else if($type == 'leads')
	{
		$query = "SELECT fname , lname, company_name FROM leads WHERE id = $id;";
		$data = mysql_query($query);
		$row = mysql_fetch_array($data);
		$name = "Client ".$row[0]." ".$row[1]."<br>".$row[2];
	}
	else if($type == 'subcon')
	{
		$query = "SELECT p.fname , p.lname, c.latest_job_title FROM personal p LEFT OUTER JOIN currentjob c ON c.userid = p.userid  WHERE p.userid = $id;";
		$data = mysql_query($query);
		$row = mysql_fetch_array($data);
		$title = $row[2];
		if($row[2]=="") $title = "Staff"; 

		$name = "Staff ".$row[0]." ".$row[1]."<br>".$title;
	}
	else{
		$name="";
	}
	return $name;
}


$query = "SELECT testimony_id, recipient_id, recipient_type, DATE_FORMAT(date_created,'%D %b %Y'),testimony_status, DATE_FORMAT(date_posted,'%D %b %Y'), title, testimony , created_by_id , created_by_type FROM testimonials t  $status  ;";
//echo $query;

$result = mysql_query($query);
while(list($testimony_id, $recipient_id, $recipient_type, $date_created,$testimony_status, $date_posted, $title, $testimony, $created_by_id , $created_by_type)=mysql_fetch_array($result))
{
	//echo $testimony_id."<br>";
	$testimony = str_replace("\n","<br>",$testimony);
	?>
	<div style="margin-bottom:10px; margin-top:10px; border-bottom:#000000 solid 1px; padding-bottom:20px;">
	<div style="font:bold 7.8pt verdana; color:#666666; margin-bottom:20px; background:#E8E8E8; padding:5px;">
		<div style="float:right; display:block; margin-left:10px;">
		<? if($created_by_id == $user and $created_by_type == $type) {?>
			<a href="<?=$create_page;?>?testimony_id=<?=$testimony_id;?>">Edit</a>
		<? } else { echo "&nbsp;";} ?>
		</div>
		<div style="float:right; display:block; margin-left:10px;">Status : <?=strtoupper($testimony_status);?></div>
		<div style="float:right; display:block; ">Date Created : <?=$date_created;?></div>
		<div style="clear:both;"></div>
	</div>
	<div style="padding:5px;">
		<div style="padding:5px;"><b><?=$title;?></b></div>	
		<div>
			<div style="float:left;padding:10px; color:#666666;">To <?=getName($recipient_id, $recipient_type);?></div>
			<div style=" float:right; padding:10px; color:#666666; text-align:right;">Created By <?=getName($created_by_id , $created_by_type);?></div>
			<div style="clear:both;"></div>
		</div>
		<div style="padding:10px;"><?=$testimony;?></div>
		<div style=" margin-top:30px;">
			<div style="padding:5px;"><b>Reply Section</b></div>
		<?
			// Reply section
			if($recipient_id == $user and  $recipient_type == $type){
				//echo "reply";
				?>
					<div><a href="javascript:showReplyForm(<?=$testimony_id;?>,'save')">Create Reply</a></div>
					<div id="save_reply_form_<?=$testimony_id;?>" class="reply_form"></div>
				<?
			}
			
			//parse all approved testimonials reply
			//testimony_reply_id, testimony_id, created_by_id, created_by_type, testimony_reply_status, date_created, testimony_reply
			$sql = "SELECT testimony_reply_id, created_by_id, created_by_type, DATE_FORMAT(date_created,'%D %b %Y'), testimony_reply 
					FROM testimonials_reply 
					WHERE testimony_id = $testimony_id 
					$testimony_reply_status 
					ORDER BY date_created ASC;";
			$data = mysql_query($sql);
			while(list($testimony_reply_id, $reply_by_id, $reply_by_type, $reply_date_created, $testimony_reply)=mysql_fetch_array($data))
			{
				//echo $testimony_reply."<br>";
				
				echo "<div id ='testimony_reply_id_$testimony_reply_id' style='border-top:#CCCCCC dashed 1px; margin-bottom:10px; margin-top:10px; font:11px tahoma; '>
				<div style='font:bold 7.8pt verdana; color:#666666; margin-bottom:20px; background:#E8E8E8;padding:4px;'>
					<div style='float:left'>Reply ID : ".$testimony_reply_id."</div>";
				if($reply_by_id == $user and  $reply_by_type == $type){	
					echo"<div style='float:right; display:block;margin-right:10px;'><a href=javascript:showReplyForm(".$testimony_reply_id.",'update')>Edit</a></div>";
				}	
				echo"<div style='float:right; display:block;margin-right:10px;'>Date Updated : ".$reply_date_updated."</div>
					<div style='float:right; display:block;margin-right:10px;'>Date Created : ".$reply_date_created."</div>
					
					
					<div style='clear:both;'></div>	
				</div>
				<div id='update_reply_form_$testimony_reply_id' class='reply_form'></div>
				<i>
				<div id='testimony_reply_$testimony_reply_id'>".$testimony_reply."</div>
				<div>
					<div style='float:right; padding:10px; color:#666666; text-align:right;'>~ Replied By ".getName($reply_by_id, $reply_by_type)."</div>
					<div style='clear:both;'></div>
				</div>
				</i>
			</div>";
				
				
			}
		?>
		</div>
		
		
	</div>

</div>

	<?
}	
?>	
