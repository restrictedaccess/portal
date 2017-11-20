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
$sub_category_id=$_REQUEST['sub_category_id'];




// sub_category_id, category_id, sub_category_name, sub_category_date_created
$sql = "SELECT * FROM job_sub_category j WHERE sub_category_id = $sub_category_id;";
$data = mysql_query($sql);
$row = mysql_fetch_array($data);
echo "<div style='padding:3px; font:12px Arial;background:#E9E9E9; border:#CCCCCC outset 1px;'><b>".$row['sub_category_name']." Applicants</b></div>";
echo "<div style='padding:5px; border:#CCCCCC solid 1px;'>";


$query = "SELECT DISTINCT(j.userid),CONCAT(p.fname,' ',p.lname),p.image 
FROM job_sub_category_applicants j 
LEFT JOIN personal p ON p.userid = j.userid 
WHERE j.sub_category_id =".$sub_category_id;
//echo $query;
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
		<div style="float:left; margin-left:10px;">
		<div style="cursor:pointer; color:#0033FF;" onClick= "javascript:popup_win('./resume3.php?userid=<? echo $userid;?>',800,500);" ><?="<b>".$applicant_name."</b>";?></div>
		<div id="applicant_top_ten_status" style="padding:5px; font:12px Arial; margin-bottom:10px; color:#333333;">
<?
$sql = "SELECT DISTINCT(j.category_id),c.category_name
		FROM job_sub_category_applicants j
		LEFT JOIN job_category c ON c.category_id = j.category_id
		WHERE j.userid = $userid;";
//echo $sql;
$resulta = mysql_query($sql);
$ctr = mysql_num_rows($resulta);

if($ctr > 0) {
echo "Applicant ".$name. " is currently included in the following Category <br>";
while(list($category_id,$category_name)=mysql_fetch_array($resulta))
{
	echo "<li>".$category_name."</li>";
	$query = "SELECT DISTINCT(j.sub_category_id) ,s.sub_category_name FROM  job_sub_category_applicants j LEFT JOIN job_sub_category s ON s.sub_category_id = j.sub_category_id WHERE j.category_id = $category_id AND userid = $userid;";
	$RESULT =mysql_query($query);
	while(list($sub_category_id,$sub_category_name)=mysql_fetch_array($RESULT))
	{
		echo "<div style='margin-left:20px;'>--- ".$sub_category_name."</div>";
	}
	//echo "<li>";	
	
}

}

?>

</div>
		</div>
		<div style=" clear:both;"></div>
	</div>
<?
}
echo "</div>";
?>