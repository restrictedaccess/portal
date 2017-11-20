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
$userid = $_REQUEST['userid'];
$recruitment_candidates_id = $_REQUEST['recruitment_candidates_id'];


$query = "SELECT CONCAT(p.fname,' ',p.lname), p.email FROM personal p WHERE userid = $userid;";
//echo $query;
$result = mysql_query($query);
list($candidate_name,$email)=mysql_fetch_array($result);

?>
<div style="padding:5px; border:#333333 ridge 2px; ">
	<p><b>Rate <?=$candidate_name;?></b></p>
	<p><label>Ratings : </label><select id="ratings" name="ratings" class="select" style="width:50px;" onchange="showStar(this.value);">
	<option value="0">--</option>
	<option value="1">1</option>
	<option value="2">2</option>
	<option value="3">3</option>
	<option value="4">4</option>
	<option value="5">5</option>
	</select>
	<span id="star" style="margin-left:5px;"></span>
	</p>
	
	<p><input type="button" value="Add" class="bttn" onClick="javascript:addRatings(<?=$recruitment_candidates_id;?>);"><input type="button" value="Close" class="bttn" onClick="hide('rating_form');"></p>
</div>