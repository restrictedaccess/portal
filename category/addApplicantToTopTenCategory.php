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

$userid = $_REQUEST['userid'];
$jobCategory = $_REQUEST['jobCategory'];
$subcategories = $_REQUEST['subcategories'];

$queryApplicant="SELECT * FROM personal p  WHERE p.userid=$userid";
$data=mysql_query($queryApplicant);
$row = mysql_fetch_array ($data); 
$name =$row['fname']."  ".$row['lname'];

//echo $name;


$subcategories = explode(",",$subcategories);
//echo (count($subcategories));
/*
SELECT * FROM job_sub_category_applicants j;
id, sub_category_id, category_id, userid, ratings, sub_category_applicants_date_created
*/

for($i=0; $i<count($subcategories);$i++)
{
	//echo $subcategories[$i]."<br>";
	$sqlCheck = "SELECT * FROM job_sub_category_applicants WHERE category_id = $jobCategory AND userid = $userid  AND sub_category_id = ".$subcategories[$i];
	//echo $sqlCheck;
	$data = mysql_query($sqlCheck);
	$check = mysql_num_rows($data);
	if($check > 0){
		// If exist dont insert just take a note...
		$querySub = "SELECT s.sub_category_name FROM  job_sub_category s WHERE s.sub_category_id = ".$subcategories[$i];
		$res = mysql_query($querySub);
		echo "<p style='color:red;'>". $name ." is already exist in the Sub Category ";
		list($sub_category_name)=mysql_fetch_array($res);
		$mess=$sub_category_name."</p>";
		echo $mess;
		
	}else{
	
		// Check if the subcategoryis full
		$queryCount = "SELECT COUNT(userid) FROM job_sub_category_applicants WHERE sub_category_id = ".$subcategories[$i];
		$res =mysql_query($queryCount);
		list($count)=mysql_fetch_array($res);	
		//if($count<10){
			$query = "INSERT INTO job_sub_category_applicants SET 
						sub_category_id = ".$subcategories[$i].", 
						category_id = $jobCategory, 
						ratings = '0', 
						userid = $userid, 
						sub_category_applicants_date_created = '$ATZ';";
			//echo $query."<br>";			
			mysql_query($query);			
		//}else{
			//$querySub = "SELECT s.sub_category_name FROM  job_sub_category s WHERE s.sub_category_id = ".$subcategories[$i];
			//$res = mysql_query($querySub);
			//list($sub_category_name)=mysql_fetch_array($res);
			//echo "Sub-Category ".$sub_category_name ." is full.<br> Maximum of 10 applicants only!<br>";
		//}	
	}
	
}




$sql = "SELECT DISTINCT(j.category_id),c.category_name
		FROM job_sub_category_applicants j
		LEFT JOIN job_category c ON c.category_id = j.category_id
		WHERE j.userid = $userid;";
//echo $sql;
$result = mysql_query($sql);
$ctr = mysql_num_rows($result);

if($ctr > 0) {
echo "Applicant ".$name. " is included in the following Category <br>";
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
