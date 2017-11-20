<?php
include '../../config.php';
include '../../conf.php';
include '../../time.php';

$AusTime = date("H:i:s"); 
$AusDate = date("Y")."-".date("m")."-".date("d");
$ATZ = $AusDate." ".$AusTime;

if($_SESSION['admin_id']=="")
{
	die("Admin ID is Missing.");
}

$admin_id = $_SESSION['admin_id'];
$query = "SELECT DISTINCT(p.userid),CONCAT(p.fname,' ',p.lname),p.image FROM personal p";
echo $query;

echo "<div style='padding:3px; font:12px Arial;background:#E9E9E9; border:#CCCCCC outset 1px;'><b>All Registered Applicants</b></div>";
echo "<div style='padding:5px; border:#CCCCCC solid 1px;'>";


$query = "SELECT DISTINCT(p.userid),CONCAT(p.fname,' ',p.lname),p.image FROM personal p";
echo $query;
$result = mysql_query($query);
$counter=0;
while(list($userid,$applicant_name,$applicant_image)=mysql_fetch_array($result))
{
	$counter++;
	if($applicant_image==""){
		$applicant_image="images/Client.png";
	}
?>
	
	<div style="padding:3px; font:12px Arial; margin-bottom:5px; border:#CCCCCC solid 1px;">
		<div style="float:left; width:40px;"><?=$counter;?>)</div>
		<div style="float:left;"><img src="<?=$applicant_image;?>" height="110" width="109" /></div>
		<div style="float:left; margin-left:10px;"><?=$applicant_name;?></div>
		<div style=" clear:both;"></div>
	</div>
<?
}
echo "</div>";

?>