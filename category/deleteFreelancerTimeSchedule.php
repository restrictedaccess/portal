<div style='border:#CCCCCC outset 1px; font: 12px Arial; background:#CCCCCC; padding-top:2px; padding-bottom:2px;'>
			<div style='float:left; width:90px; display:block;font: 12px Arial;'><b>Day</b></div>
			<div style='float:left; width:200px; display:block;font: 12px Arial;'><b>Schedule</b></div>
			<div style='float:left; width:60px; display:block;font: 12px Arial;'><b>Hour</b></div>
			<div class="refresh_btn"><b>Refresh</b></div>
			<div style='clear:both;'></div>
		</div>
<?
include '../config.php';
include '../conf.php';
include '../time.php';

$AusTime = date("H:i:s"); 
$AusDate = date("Y")."-".date("m")."-".date("d");
$ATZ = $AusDate." ".$AusTime;

if($_SESSION['admin_id']=="")
{
	die("Admin ID is Missing.");
}
$admin_id = $_SESSION['admin_id'];
$userid =$_REQUEST['userid'];
$id =$_REQUEST['id'];
if($id==""){
	die("evaluation_freelancer_time_schedule id is missing.");
}


$query = "DELETE FROM evaluation_freelancer_time_schedule WHERE id = $id;";
mysql_query($query);



$sql = "SELECT id, day_name, start_str, finsh_str, hour FROM evaluation_freelancer_time_schedule WHERE userid = $userid ORDER BY day_id ASC;";
	$result = mysql_query($sql);
	while(list($id, $days, $start_str, $finsh_str, $hour)=mysql_fetch_array($result))
	{
	?>
		<div style="border-bottom:#CCCCCC solid 1px;font: 12px Arial;">
		<div style="float:left; width:90px; display:block;font: 12px Arial;"><?=$days;?></div>
		<div style="float:left; width:200px; display:block;font: 12px Arial;"><?=$start_str;?> - <?=$finsh_str;?></div>
		<div style="float:left; width:60px; display:block;font: 12px Arial;"><?=$hour;?></div>
		<div onClick="deleteFreelancerTimeSchedule(<?=$id;?>);" style="float:left; width:20px; display:block;font: 12px Arial; color:#0000FF; cursor:pointer;">X</div>
		<div style="clear:both;"></div>
		</div>
	<?
	}
	//echo $sql;
?>
