<?
include "../config.php";
include "../conf.php";


$admin_id = $_SESSION['admin_id'];
$admin_status=$_SESSION['status'];
if($_SESSION['admin_id']==NULL)
{
	die("Session Expired. Please Logout then try to re-login again.");
}


$userid = $_REQUEST['userid'];
$recruitment_candidates_id = $_REQUEST['recruitment_candidates_id'];


$query = "SELECT CONCAT(p.fname,' ',p.lname), p.email FROM personal p WHERE userid = $userid;";
//echo $query;
$result = mysql_query($query);
list($candidate_name,$email)=mysql_fetch_array($result);

?>


<div style="padding:5px; border:#333333 ridge 2px; ">
	<p><b>Notes / Comments for <?=$candidate_name;?></b></p>
	<p>
	<textarea name="notes2" id="notes2" style="width:500px; height:80px;"></textarea></p>
	<p><input type="button" value="Add" class="bttn" onClick="javascript:addNotes(<?=$recruitment_candidates_id;?>,<?=$userid;?>);"><input type="button" value="Close" class="bttn" onClick="hide('notes_add_form');"></p>
</div>