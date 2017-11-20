<?

include "../config.php";
include "../conf.php";
include "../time.php";
include "../function.php";

$AusTime = date("H:i:s"); 
$AusDate = date("Y")."-".date("m")."-".date("d");
$ATZ = $AusDate." ".$AusTime;


$admin_id = $_SESSION['admin_id'];
$admin_status=$_SESSION['status'];
$userid = $_REQUEST['userid'];
$recruitment_candidates_id = $_REQUEST['recruitment_candidates_id'];
$notes = filterfield($_REQUEST['notes']);

if($_SESSION['admin_id']==NULL)
{
	die("Session Expired. Please Logout then try to re-login again.");
}




$query = "INSERT INTO recruitment_candidates_notes SET  
			recruitment_candidates_id = $recruitment_candidates_id, 
			added_by_id = $admin_id, 
			added_by_type = 'admin', 
			date_added = '$ATZ', 
			notes = '$notes',
			userid = $userid;";
$result =  mysql_query($query);	



function getCreator($id,$type){
	if($type == 'agent')
	{
		$query = "SELECT fname,work_status FROM agent a WHERE agent_no = $id;";
		$data = mysql_query($query);
		$row = mysql_fetch_array($data);
		$name = "-- ".$row[1]." :".$row[0];
	}
	else if($type == 'admin')
	{
		$query = "SELECT admin_fname , admin_lname FROM admin a WHERE admin_id = $id;";
		$data = mysql_query($query);
		$row = mysql_fetch_array($data);
		$name = "-- Admin ".$row[0]." ".$row[1];
	}
	else{
		$name="";
	}
	return $name;
}
		
//echo $query;	
$sql = "SELECT recruitment_candidates_notes_id,  added_by_id, added_by_type, DATE_FORMAT(date_added,'%a %b %e %Y %r'), notes 
				FROM recruitment_candidates_notes r WHERE recruitment_candidates_id = $recruitment_candidates_id ORDER BY date_added DESC;";
		$data = mysql_query($sql);		
		while(list($recruitment_candidates_notes_id,  $added_by_id, $added_by_type, $date_added, $notes)=mysql_fetch_array($data))
		{
			?>
			<div style="border-bottom:#CCCCCC solid 1px; padding:2px;">
				<div style="text-align:right; color:#666666;font:11px tahoma;"><?=$date_added;?></div>
				<div><?=$notes;?></div>
				<div style="color:#999999; font:11px tahoma;"><?=getCreator($added_by_id, $added_by_type);?></div>
			</div>	
			<?
		}
?>