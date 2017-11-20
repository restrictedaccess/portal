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
$days = $_REQUEST['days'];
$start = $_REQUEST['start'];
$out = $_REQUEST['out'];
$hour = $_REQUEST['hour'];


$timeNum = array("0","1","2","3","4","5","6","7","8","9","10","11","12","13","14","15","16","17","18","19","20","21","22","23","24");
$timeArray = array("-","1:00 am","2:00 am","3:00 am","4:00 am","5:00 am","6:00 am","7:00 am","8:00 am","9:00 am","10:00 am","11:00 am","12:00 noon","1:00 pm","2:00 pm","3:00 pm","4:00 pm","5:00 pm","6:00 pm","7:00 pm","8:00 pm","9:00 pm","10:00 pm","11:00 pm","12:00 am");
for($i=0; $i<count($timeNum); $i++)
{
	if($start == $timeNum[$i])
	{
		$start_str =$timeArray[$i];
	}
	
	if($out == $timeNum[$i])
	{
		$finish_str =$timeArray[$i];
	}
}

/*
SELECT * FROM evaluation_fulltime_schedule e;
id, userid, days, start_str, finsh_str, hour, date_created, created_by
*/
// check the days if the days is existing do not insert...
$query = "SELECT * FROM evaluation_freelancer_time_schedule WHERE day_name = '$days' AND userid = $userid;";
$result = mysql_query($query);
$check = mysql_num_rows($result);

if($check > 0 ){
	
	//echo "Selected Day Exist!";
	echo  "<div style='border-bottom:#CCCCCC solid 1px;font: 12px Arial;text-align:center; color:#FF0000'><b>[ ".$days." ] Selected Day already exist !</b></div>";
	
}else{
	
	$day_name = array("Monday","Tuesday","Wednesday","Thursday","Friday","Saturday","Sunday");
	for($i=0;$i<count($day_name);$i++)
	{
		if($day_name[$i] == $days){
			$day_id = $i+1;
		}
	}
	
	
	
	
	$query = "INSERT INTO evaluation_freelancer_time_schedule SET 
				userid = $userid, 
				day_id = $day_id,
				day_name = '$days', 
				start_str = '$start_str', 
				finsh_str = '$finish_str',
				hour = '$hour', 
				date_created = '$ATZ', 
				created_by = $admin_id;";
	$result = mysql_query($query);
	if(!$result){
		die($query."<br>Mysql Error ".mysql_error());
	}

}
$sql = "SELECT id, day_name, start_str, finsh_str, hour FROM evaluation_freelancer_time_schedule WHERE userid = $userid ORDER BY day_id ASC;";
//echo $sql;
	$result = mysql_query($sql);
	while(list($id,$days, $start_str, $finsh_str, $hour)=mysql_fetch_array($result))
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
?>

