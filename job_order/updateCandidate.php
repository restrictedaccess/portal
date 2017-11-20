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
if($_SESSION['admin_id']==NULL)
{
	die("Session Expired. Please Logout then try to re-login again.");
}


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

function showStar($count){
	for($i=0;$i<$count;$i++){
		$str.="<img src=\"images/star.png\">";
	}
	return $str;
}


$userid = $_REQUEST['userid'];
$candidate_status = $_REQUEST['candidate_status'];
$expected_salary = filterfield($_REQUEST['expected_salary']);
$recruitment_candidates_id = $_REQUEST['recruitment_candidates_id'];
$job_order_list_id = $_REQUEST['job_order_list_id'];


//echo $recruitment_candidates_id;
//recruitment_candidates_id

$query = "UPDATE recruitment_candidates SET  
			userid = $userid, 
			expected_salary = '$expected_salary', 
			candidate_status = '$candidate_status' 
			WHERE recruitment_candidates_id = $recruitment_candidates_id;";
mysql_query($query);
$query = "UPDATE recruitment_candidates_notes SET userid = $userid WHERE recruitment_candidates_id = $recruitment_candidates_id;";
mysql_query($query);

$query = "SELECT recruitment_candidates_id, r.userid,CONCAT(p.fname,' ',p.lname), p.email, p.image, expected_salary, candidate_status, 
		  added_by_id, added_by_type, DATE_FORMAT(date_added,'%D %b %Y'),r.ratings
		  FROM recruitment_candidates r LEFT JOIN personal p ON p.userid = r.userid WHERE job_order_list_id = $job_order_list_id AND recruitment_candidates_id = $recruitment_candidates_id;";
//echo $query; 		  
$result = mysql_query($query);

list($recruitment_candidates_id, $userid,$candidate_name,$email, $image, $expected_salary, $candidate_status, $added_by_id, $added_by_type, $date_added ,$ratings)=mysql_fetch_array($result);


?>

<div>
	<div style="float:left; border:#999999 solid 1px; width:90px; display:block; padding:5px; "><img src="<? echo "lib/thumbnail_staff_pic.php?file_name=$image";?>"  /></div>
	<div style="float:left; margin-left:10px; border-left:#CCCCCC solid 1px; border-right:#CCCCCC solid 1px; padding:5px; height:150px; display:block; width:300px;">
		<div style="padding:2px;">
			<div style="float:left;"><b><?=$candidate_name;?></b></div>
			<div id="<?=$recruitment_candidates_id;?>_ratings" style="float:right;"><?=showStar($ratings);?></div>
			<div style="clear:both;"></div>
		</div>
		<div style="padding:2px;"><?=$email;?></div>
		<div style="padding:2px;">Exp. Salary : <?=$expected_salary;?></div>
		<div style="padding:2px; color:#666666;">Added By : <?=getCreator($added_by_id, $added_by_type);?></div>
		<div style="padding:2px; color:#666666;">Added Date : <?=$date_added;?></div>
		<div style="padding:2px; color:#666666;">Status : <?=$candidate_status;?></div>
	</div>
	<div id="<?=$recruitment_candidates_id;?>_notes_list" style="float:left; margin-left:1px; display:block; width:580px; height:150px; overflow:auto;">
	<?
		$sql = "SELECT recruitment_candidates_notes_id,  added_by_id, added_by_type, DATE_FORMAT(date_added,'%D %b %y'), notes 
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
	
	</div>
	
	<div style="clear:both;"></div>
</div>
