<?
include "../config.php";
include "../conf.php";
include "../time.php";
include "../function.php";

$AusTime = date("H:i:s"); 
$AusDate = date("Y")."-".date("m")."-".date("d");
$ATZ = $AusDate." ".$AusTime;


if($_SESSION['admin_id']!="")
{
	$user = $_SESSION['admin_id'];
	$type = 'admin';
}
else{
	die("Session Expired. Please re-login again.");
}

//echo $type;
$testimony_id = $_REQUEST['id'];
$reply = filterfield($_REQUEST['reply']);
$mode = $_REQUEST['mode'];
$status = $_REQUEST['status'];

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


$query = "INSERT INTO testimonials_reply SET 
				testimony_id = $testimony_id, 
				created_by_id = $user, 
				created_by_type = '$type', 
				date_created = '$ATZ', 
				testimony_reply_status = '$status',
				testimony_reply = '$reply';";
$result = mysql_query($query);		
//echo $query;
		
if(!$result) die ("Ther was a problem in saving your reply");



$sql = "SELECT testimony_reply_id, created_by_id, created_by_type, DATE_FORMAT(date_created,'%D %b %Y'), testimony_reply  , testimony_reply_status , DATE_FORMAT(date_updated,'%D %b %Y')
			FROM testimonials_reply 
			WHERE testimony_id = $testimony_id 
			ORDER BY date_created ASC;";
	$data = mysql_query($sql);
	while(list($testimony_reply_id, $reply_by_id, $reply_by_type, $reply_date_created, $testimony_reply , $testimony_reply_status , $reply_date_updated)=mysql_fetch_array($data))
	{
		$testimony_reply = str_replace("\n","<br>",$testimony_reply) ;
		echo "<div id ='testimony_reply_id_$testimony_reply_id' style='border-top:#CCCCCC dashed 1px; margin-bottom:10px; margin-top:10px; font:11px tahoma; padding:5px;'>
				<div style='font:bold 7.8pt verdana; color:#666666; margin-bottom:20px; background:#E8E8E8;padding:4px;'>
					<div style='float:left'>Reply ID : ".$testimony_reply_id."</div>
					<div style='float:left; display:block; margin-left:10px;'>Status : ".strtoupper($testimony_reply_status)."</div>
					<div style='float:right; display:block;margin-right:10px;'><a href=javascript:showAdminReplyForm(".$testimony_reply_id.",'update')>Edit</a></div>
					<div style='float:right; display:block;margin-right:10px;'>Date Updated : ".$reply_date_updated."</div>
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