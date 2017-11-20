<?php
include '../../config.php';
include '../../conf.php';
include '../../time.php';
include('../../conf/zend_smarty_conf.php');

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
$row=$db->fetchRow($queryApplicant);
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
	$data = mysqli_query($link2,$sqlCheck);
	$check = mysqli_num_rows($data);
	if($check > 0){
		// If exist dont insert just take a note...
		$querySub = "SELECT s.sub_category_name FROM  job_sub_category s WHERE s.sub_category_id = ".$subcategories[$i];
		$res = mysqli_query($link2,$querySub);
		echo "<p style='color:red;'>". $name ." is already exist in the Sub Category ";
		list($sub_category_name)=mysqli_fetch_array($res);
		$mess=$sub_category_name."</p>";
		echo $mess;
		
	}else{
	
		// Check if the subcategoryis full
		$queryCount = "SELECT COUNT(userid) FROM job_sub_category_applicants WHERE sub_category_id = ".$subcategories[$i];
		$res =mysqli_query($link2,$queryCount);
		list($count)=mysqli_fetch_array($res);	
		//if($count<10){
			
			$data = array("sub_category_id"=>$subcategories[$i], 
						"category_id"=>$jobCategory,
						"ratings"=>"1",
						"userid"=>$userid,
						"sub_category_applicants_date_created"=>$ATZ);
		
			$db->insert("job_sub_category_applicants", $data);
			$lastInsertId = $db->lastInsertId();
			/*
			$query = "INSERT INTO job_sub_category_applicants SET 
						sub_category_id = ".$subcategories[$i].", 
						category_id = $jobCategory, 
						ratings = '1', 
						userid = $userid, 
						sub_category_applicants_date_created = '$ATZ';";
			//echo $query."<br>";			
			mysqli_query($link2,$query);	
			*/
			
			
			$jsca = $db->fetchRow($db->select()->from(array("jsca"=>"job_sub_category_applicants"), array("jsca.userid"))->joinLeft(array("jsc"=>"job_sub_category"), "jsc.sub_category_id = jsca.sub_category_id", array("sub_category_name"))->where("id = ?",$lastInsertId));
			$history_changes = "<span style='color:#ff0000'>Added</span> in the ASL List under <span style='color:#ff0000'>".$jsca["sub_category_name"]."</span> with display status initially set to <span style='color:#ff0000'>NO</span>";
			$changeByType = $_SESSION["status"];
			if ($changeByType=="FULL-CONTROL"){
				$changeByType = "ADMIN";
			}
			
			
			$db->insert("staff_history", array("changes"=>$history_changes, "userid"=>$jsca["userid"], "date_change"=>date("Y-m-d H:i:s"), "change_by_type"=>$changeByType, "change_by_id"=>$_SESSION["admin_id"]));
					
			//START: add status lookup or history
			$admin_id = $_SESSION['admin_id'];
			$status_to_use = "ASL";
			$data2 = array(
			'personal_id' => $userid,
			'admin_id' => $admin_id,
			'status' => $status_to_use,
			'date' => date("Y-m-d")." ".date("H:i:s"),
			"link_id"=>$lastInsertId
			);
			$db->insert('applicant_status', $data2);
			//ENDED: add status lookup or history
				
				
		//}else{
			//$querySub = "SELECT s.sub_category_name FROM  job_sub_category s WHERE s.sub_category_id = ".$subcategories[$i];
			//$res = mysqli_query($link2,$querySub);
			//list($sub_category_name)=mysqli_fetch_array($res);
			//echo "Sub-Category ".$sub_category_name ." is full.<br> Maximum of 10 applicants only!<br>";
		//}	
		
		
	
	}
	
}

$date = $ATZ;
$dateupdated = date("M d, Y H:i:s A", strtotime($date));
mysqli_query($link2,"UPDATE personal SET dateupdated = '".$date."' WHERE userid = ".$userid);


$sql = "SELECT DISTINCT(j.category_id),c.category_name
		FROM job_sub_category_applicants j
		LEFT JOIN job_category c ON c.category_id = j.category_id
		WHERE j.userid = $userid;";
//echo $sql;
$result = mysqli_query($link2,$sql);
$ctr = mysqli_num_rows($result);

if($ctr > 0) 
{

	//START: add status lookup or history
	$admin_id = $_SESSION['admin_id'];
	/*
	$status_to_use = "ASL";
	$data2 = array(
	'personal_id' => $userid,
	'admin_id' => $admin_id,
	'status' => $status_to_use,
	'date' => date("Y-m-d")." ".date("H:i:s")
	);
	$db->insert('applicant_status', $data2);
	*/
	//ENDED: add status lookup or history
		
		
	echo "Applicant ".$name. " is included in the following Category <br>";
	while(list($category_id,$category_name)=mysqli_fetch_array($result))
	{
		echo "<li>".$category_name."</li>";
		$query = "SELECT DISTINCT(j.sub_category_id) ,s.sub_category_name FROM  job_sub_category_applicants j LEFT JOIN job_sub_category s ON s.sub_category_id = j.sub_category_id WHERE j.category_id = $category_id AND userid = $userid;";
		$RESULT =mysqli_query($link2,$query);
		while(list($sub_category_id,$sub_category_name)=mysqli_fetch_array($RESULT))
		{
			echo "<div style='margin-left:20px;'>--- ".$sub_category_name."</div>";
		}
		//echo "<li>";	
	}

	//START: staff status
	include_once('../../lib/staff_status.php') ;
	staff_status($db, $_SESSION['admin_id'], $userid, 'ASL');

	try{
		global $base_api_url;
		global $curl;

		$curl->get($base_api_url . "/solr-index/sync-asl/", array("userid" => $userid));


		if (TEST){
			$curl->get("http://test.remotestaff.com.au/portal/cronjobs/sync_recruiter_home_to_mongo.php?userid=".$userid);
		} else{
			$curl->get("http://sc.remotestaff.com.au/portal/cronjobs/sync_recruiter_home_to_mongo.php?userid=".$userid);
		}

	} catch(Exception $e){


		if (TEST){

			file_get_contents("http://test.api.remotestaff.com.au/solr-index/sync-asl/?userid=".$userid);
			file_get_contents("http://test.remotestaff.com.au/portal/cronjobs/sync_recruiter_home_to_mongo.php?userid=".$userid);
		} else if(STAGING){
			file_get_contents("http://sc.remotestaff.com.au/portal/cronjobs/sync_recruiter_home_to_mongo.php?userid=".$userid);
			file_get_contents("http://staging.api.remotestaff.com.au/solr-index/sync-asl/?userid=".$userid);
		} else{
			file_get_contents("http://sc.remotestaff.com.au/portal/cronjobs/sync_recruiter_home_to_mongo.php?userid=".$userid);
			file_get_contents("https://api.remotestaff.com.au/solr-index/sync-asl/?userid=".$userid);
		}
	}

	
//	if (TEST){
//
//	   file_get_contents("http://test.api.remotestaff.com.au/solr-index/sync-asl/?userid=".$userid);
//	   file_get_contents("http://test.remotestaff.com.au/portal/cronjobs/sync_recruiter_home_to_mongo.php?userid=".$userid);
//	}else{
//	   file_get_contents("http://sc.remotestaff.com.au/portal/cronjobs/sync_recruiter_home_to_mongo.php?userid=".$userid);
//	   file_get_contents("https://api.remotestaff.com.au/solr-index/sync-asl/?userid=".$userid);
//    }
//
//
		
	//ENDED: staff status

	//NOTE: this section here is 100% working, it's temporary removed on the staff history because it has it's own history on the staff status reporting
	//START: insert staff history
	//include('../../lib/staff_history.php');
	//staff_history($db, $userid, $_SESSION['admin_id'], 'ADMIN', 'STAFF STATUS', 'INSERT', 'ASL');
	//ENDED: insert staff history	
	
	
}
?>
