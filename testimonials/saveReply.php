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
	
}
else if($_SESSION['userid']!="")
{
	$user = $_SESSION['userid'];
	$type = 'subcon';
	
}
else if($_SESSION['admin_id']!="")
{
	$user = $_SESSION['admin_id'];
	$type = 'admin';
}
else if($_SESSION['agent_no']!="")
{
	$user = $_SESSION['agent_no'];
	$type = 'agent';
}
else{
	die("Session Expired. Please re-login again.");
}

//echo $type;
$id = $_REQUEST['id'];
$reply = filterfield($_REQUEST['reply']);
$mode = $_REQUEST['mode'];

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
//echo $reply;

/*
SELECT * FROM testimonials_reply t;
testimony_reply_id, testimony_id, created_by_id, created_by_type, updated_by_id, updated_by_type, testimony_reply_status, date_created, date_updated, testimony_reply
*/

if($mode == "save"){
	$query = "INSERT INTO testimonials_reply SET 
					testimony_id = $id, 
					created_by_id = $user, 
					created_by_type = '$type', 
					date_created = '$ATZ', 
					testimony_reply = '$reply';";
	$result = mysql_query($query);				
	if(!$result) die ("Ther was a problem in saving your reply");
	echo "Your reply has successfully saved and subject for approval before it get posted...";

}	
if($mode == "update"){

	$query = "UPDATE testimonials_reply SET 
					updated_by_id = $user, 
					updated_by_type = '$type',
					date_updated = '$ATZ',
					testimony_reply_status = 'updated',
					testimony_reply = '$reply' 
					
					WHERE testimony_reply_id = $id;";
	$result = mysql_query($query);				
	if(!$result) die ("Ther was a problem in saving your reply");
	echo "Your reply has successfully saved and subject for approval before it get posted...";

}
?>