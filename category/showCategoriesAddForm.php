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
$userid=$_REQUEST['userid'];

$queryApplicant="SELECT * FROM personal p  WHERE p.userid=$userid";
$data=mysql_query($queryApplicant);
$row = mysql_fetch_array ($data); 
$name =$row['fname']."  ".$row['lname'];


?>
<div style="padding:5px; background:#CCCCCC; border:#CCCCCC outset 1px; font:bold 12px Arial; color:#0000FF;">Add <?=$name;?> in Top 10 Categories</div>
<div style="padding:5px; background:#FFFFFF; border:#CCCCCC solid 1px; font:12px Arial;">

<div id="applicant_top_ten_status" style="padding:5px; font:12px Arial; margin-bottom:10px; color:#333333;">
<?
$sql = "SELECT DISTINCT(j.category_id),c.category_name
		FROM job_sub_category_applicants j
		LEFT JOIN job_category c ON c.category_id = j.category_id
		WHERE j.userid = $userid;";
//echo $sql;
$result = mysql_query($sql);
$ctr = mysql_num_rows($result);

if($ctr > 0) {
echo "Applicant ".$name. " is currently included in the following Category <br>";
while(list($category_id,$category_name)=mysql_fetch_array($result))
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
	<div style="float:left; width:320px; border:#CCCCCC solid 1px;">
	<div style="background:#E9E9E9; border:#CCCCCC outset 1px; padding:5px; font:bold 12px Arial;">Available Job Categories</div>
	<?
	$queryAllJobCategories = "SELECT category_id, category_name FROM job_category j;";
	$result = mysql_query($queryAllJobCategories);
	$counter = 0;
	while(list($category_id, $category_name)=mysql_fetch_array($result))
	{
		$counter++;
	?>
		<div style="padding:5px;font:12px Arial;">
			<?=$counter;?> ) 
			<input type="radio" name="jobCategory" value="<?=$category_id;?>" onClick="getSubCategories(<?=$category_id;?>);"> 
			<?=$category_name;?> 
		</div>
	<?
	}
	?>	
	</div>
	<div style="float:left; margin-left:10px; width:400px;">
		<div id="sub_category_listings" style="font:12px Arial;">
			Select a Job Categories from left
		</div>
	</div>
	<div style=" clear:both;"></div>
</div>
<div id="category_control" style="padding:5px;font:12px Arial; margin-top:10px; border:#CCCCCC solid 1px; display:none;">
	<input type="button" value="Save" onClick="saveConfiguration();"> &nbsp; <input type="button" value="Delete">
</div>