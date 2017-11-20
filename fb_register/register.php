<?php
include ('../conf/zend_smarty_conf.php');
require_once dirname(__FILE__)."/../tools/CouchDBMailbox.php";
require_once dirname(__FILE__)."/../application/classes/SkillTestEmail.php";

include "util.php";
$data = $_POST;
$query = array();
$skip = array("password", "confirm_password");
foreach($data as $key=>$val){
	$data[$key] = trim($val);
	if (!in_array($key, $skip)){
		$query[] = $key."=".urlencode($val);	
	}
}
$querystring = implode("&", $query);


if ($data["fname"]==""){
	header("Location:/portal/fb_register/?error=".urlencode("First Name is Required")."&".$querystring);
	die;
}
if ($data["lname"]==""){
	header("Location:/portal/fb_register/?error=".urlencode("Last Name is Required")."&".$querystring );
	die;
}
if (strlen($data["lname"])<2){
	header("Location:/portal/fb_register/?error=".urlencode("Minimum Character for Last Name is 2 characters")."&".$querystring);
	die;
}
if (strlen($data["fname"])<2){
	header("Location:/portal/fb_register/?error=".urlencode("Minimum Character for First Name is 2 characters")."&".$querystring);
	die;
}
if ($data["number"]==""){
	header("Location:/portal/fb_register/?error=".urlencode("Mobile Number is Required")."&".$querystring);
	die;
}
$number = $data["number"];

if ($number{0}=="0"&&strlen($number)!=11){
	header("Location:/portal/fb_register/?error=".urlencode("Mobile Number Format should be in 09xxxxxxxxx")."&".$querystring);
	die;
}else if ($number{0}=="9"&&strlen($number)!=10){
	header("Location:/portal/fb_register/?error=".urlencode("Mobile Number Format should be in 09xxxxxxxxx")."&".$querystring);
	die;
}else if (strlen($number)!=11){
	header("Location:/portal/fb_register/?error=".urlencode("Mobile Number Format should be in 09xxxxxxxxx")."&".$querystring);
	die;
}

if ($data["password"]==""){
	header("Location:/portal/fb_register/?error=".urlencode("Password is Required")."&".$querystring);
	die;
}

if (strlen($data["password"])<6){
	header("Location:/portal/fb_register/?error=".urlencode("Minimum Character for Password is 6 characters")."&".$querystring);
	die;
}

if ($data["password"]!=$data["confirm_password"]){
	header("Location:/portal/fb_register/?error=".urlencode("Password should be the same")."&".$querystring);
	die;
}

if ($data["skype_id"]==""){
	header("Location:/portal/fb_register/?error=".urlencode("Skype ID is required")."&".$querystring);
	die;
}

if (!isset($data["work_from_home_before"])){
	header("Location:/portal/fb_register/?error=".urlencode("Worked from home before is required")."&".$querystring);
	die;
}


if ($data["isp"]==""){
	header("Location:/portal/fb_register/?error=".urlencode("Please select your Internet Connection")."&".$querystring);
	die;
}

if ($data["internet_plan"]==""){
	header("Location:/portal/fb_register/?error=".urlencode("Your internet plan and package is required")."&".$querystring);
	die;
}
if ($data["speed_test"]==""){
	header("Location:/portal/fb_register/?error=".urlencode("Speed Test is required")."&".$querystring);
	die;
}

$validator = new Zend_Validate_EmailAddress();

if (!$validator->isValid($data["email"])){
	header("Location:/portal/fb_register/?error=".urlencode("A valid email is required")."&".$querystring);
	die;
} 

$row = $db->fetchRow($db->select()->from("personal", "email")
								->where("email = ?", $data["email"])
								->where("fname <> ''")->where("lname <> ''")
								->where("fname IS NOT NULL")->where("lname IS NOT NULL"));	
								
if ($row){
	header("Location:/portal/fb_register/?error=".urlencode("Your email is already registered. Please login to your jobseeker account by clicking the following <a href='http://remotestaff.com.au/portal/' target='_blank'>link</a>.")."&".$querystring);
	die;
}





//process registration
require_once "fb/facebook.php";
$fbconfig['appUrl'] = "http://test.remotestaff.com.au/portal/fb_register/"; 
$smarty =  new Smarty();
$facebook = new Facebook(array(
  'appId'  => '141234452753604',
  'secret' => '4e473f2c006ae4adea347deb85f845c0',
));
// Get User ID
$user = $facebook->getUser();
if ($user) {
  try {
    // Proceed knowing you have a logged in user who's authenticated.
    $user_profile = $facebook->api('/me');
	//$email = $facebook->api("/me/email");
  } catch (FacebookApiException $e) {
    error_log($e);
    $user = null;
  }
}

// If the user is authenticated then generate the variable for the logout URL
if ($user) {
  $logoutUrl = $facebook->getLogoutUrl();  
} else {
  $loginUrl = $facebook->getLoginUrl(array('redirect_uri' => $fbconfig['appUrl'],"scope"=>array("email", "user_birthday","user_about_me")
  ));
 print "<script type='text/javascript'>top.location.href = '$loginUrl';</script>";
}

//process saving of record
$personal = array();
$personal["fname"] = $data["fname"];
$personal["lname"] = $data["lname"];

if ($data["work_from_home_before"]=="yes"){
	$personal["work_from_home_before"] = 1;	
}else{
	$personal["work_from_home_before"] = 0;	
}
$personal["speed_test"] = $data["speed_test"];
$personal["external_source"] = "Facebook";
$personal["isp"] = $data["isp"];
$personal["internet_connection"] = $data["internet_plan"];
$personal["skype_id"] = $data["skype_id"];
$personal["pass"] = sha1($data["password"]);
$personal["handphone_no"] = $number;
$personal["handphone_country_code"] = "+63";
$personal["email"] = $data["email"];


if ($user_profile["gender"]=="male"){
	$personal["gender"] = "Male";
}else{
	$personal["gender"] = "Female";
}

$bdate = explode("/", $user_profile["birthday"]);
$personal["byear"] = $bdate[2];
$personal["bmonth"] = intval($bdate[0]);
$personal["bday"] = intval($bdate[1]);
$personal["marital_status"] = getStatus($user_profile["relationship_status"]);
$personal["promotional_code"] = "facebook";
try{
	$country = $db -> fetchRow($db -> select() -> from(array("c" => "country"), array("iso3")) -> where("printable_name = ?", $user_profile["current_location"]["country"]));
	if ($country) {
		$personal["nationality"] = $user_profile["current_location"]["country"];
		$personal["permanent_residence"] = $country["iso3"];
		$personal["country_id"] = $country["iso3"];
		$personal["state"] = $user_profile["current_location"]["state"];
		$personal["city"] = $user_profile["current_location"]["city"];
	}else{
		$personal["country_id"] = "PH";
		$personal["nationality"] = "Philippines";
	}	
}catch(Exception $e){
	$personal["country_id"] = "PH";
	$personal["nationality"] = "Philippines";
	
}

$personal["datecreated"] = date("Y-m-d H:i:s");
$personal["dateupdated"] = date("Y-m-d H:i:s");
$personal["facebook_id"] = $data["facebook_id"]; 
$personal["status"] = "New";
$db -> insert("personal", $personal);
$userid = $db->lastInsertId("personal");
file_put_contents(dirname(__FILE__) . "/../uploads/pics/" . $userid . ".jpg", fopen("https://graph.facebook.com/{$data["facebook_id"]}/picture?type=large", 'r'));
$db -> update("personal", array("image" => "uploads/pics/" . $userid . ".jpg"), $db -> quoteInto("userid = ?", $userid));
$db -> insert("unprocessed_staff", array("userid" => $userid, "admin_id" => 0, "date" => date("Y-m-d H:i:s")));
if (!empty($user_profile["languages"])) {
	foreach ($user_profile["languages"] as $language) {
		$db -> insert("language", array("userid" => $userid, "language" => $language["name"]));
	}
}
if (!empty($user_profile["education"])){
	//loop all education then select highest qualification
	
	$levels = array("High School Diploma","Vocational Diploma / Short Course Certificate","Bachelor/College Degree","Post Graduate Diploma / Master Degree","Professional License (Passed Board/Bar/Professional License Exam)","Doctorate Degree");
	$highestPoints = 0;
	$currentEducation = array();
	foreach($user_profile["education"] as $education){
		$currentPoint = 0;
		if ($education["type"]=="High School"){
			$currentPoint = 0;
		}else if ($education["type"]=="College"){
			if (isset($education["concentration"])){
				$concentration = $education["concentration"];
				if (!(strpos($concentration["name"], "Bachelor")===false)){
					$currentPoint = 2;
				}else if ((!(strpos($concentration["name"], "Master")===false))||(!(strpos($concentration["name"], "Graduate")===false))){
					$currentPoint = 3;
				}else if ((!(strpos($concentration["name"], "Doctor")===false))){
					$currentPoint = 4;
				}else{
					$currentPoint = 2;
				}
			}else{
				$currentPoint = 1;
			}							
		}
		if ($highestPoints<=$currentPoint){
			$highestPoints = $currentPoint;
			$currentEducation = $education;
		}

	}
	
	
	$educationData = array();
	$education = $currentEducation;
	if ($education["type"]=="High School"){
		$educationData["educationallevel"] = "High School Diploma";
	}else if ($education["type"]=="College"){
		if (isset($education["concentration"])){
			$concentration = $education["concentration"];
			if (!(strpos($concentration["name"], "Bachelor")===false)){
				$educationData["educationallevel"] = "Bachelor/College Degree";
			}else if ((!(strpos($concentration["name"], "Master")===false))||(!(strpos($concentration["name"], "Graduate")===false))){
				$educationData["educationallevel"] = "Post Graduate Diploma / Master Degree";
			}else if ((!(strpos($concentration["name"], "Doctor")===false))){
				$educationData["educationallevel"] = "Doctorate Degree";
			}else{
				$educationData["educationallevel"] = "Bachelor/College Degree";
			}
		}else{
			$educationData["educationallevel"] = "Bachelor/College Degree";
		}							
	}
	$major = explode("in", $education["concentration"]["name"]); 
	if (count($major)==2){
		$educationData["major"] = trim($major[1]);
	}else{
		$educationData["major"] = $education["concentration"]["name"];
	}
	if (isset($currentEducation["year"])){
		$educationData["graduate_year"] = $currentEducation["year"]["name"];
	}
	if (isset($currentEducation["school"])){
		$educationData["college_name"] = $currentEducation["school"]["name"];
	}
	
	$edu = $db->fetchRow($db->select()->from(array("e"=>"education"))->where("userid = ?", $userid));
	if ($edu){
		$db->update("education", $educationData, $db->quoteInto("userid = ?", $userid));
	}else{
		$educationData["userid"] = $userid;
		$db->insert("education", $educationData);
	}
	
	
}
if (!empty($user_profile["work"])){
	$i = 1;
	$currentjob = array();
	foreach($user_profile["work"] as $work){
		if ($i == 1){
			$suffix = "";
		}else{
			$suffix = $i;
		}
		$currentjob["companyname".$suffix] = $work["employer"]["name"];
		$currentjob["position".$suffix] = $work["position"]["name"];
		$startdate = $work["start_date"];
		$startdate = explode("-", $startdate);
		if ($startdate[0]!="0000"&&$startdate[1]!="00"){
			$currentjob["monthfrom".$suffix] = getMonth($startdate[1]);
			$currentjob["yearfrom".$suffix] = $startdate[0];
		}else{
			$currentjob["monthfrom".$suffix] = "Present";
			$currentjob["yearfrom".$suffix] = "Present";
			
		}
		if (isset($work["end_date"])){
			$enddate = $work["end_date"];
			$enddate = explode("-", $enddate);
			if ($enddate[0]!="0000"&&$enddate[1]=="00"){
				$currentjob["monthto".$suffix] = getMonth($enddate[1]);
				$currentjob["yearto".$suffix] =  $enddate[0];								
			}else{
				$currentjob["monthto".$suffix] = "Present";
				$currentjob["yearto".$suffix] = "Present";
			}
		}else{
			$currentjob["monthto".$suffix] = "Present";
			$currentjob["yearto".$suffix] = "Present";
		}
		$i++;
	}
	$job = $db->fetchRow($db->select()->from(array("c"=>"currentjob"))->where("userid = ?", $userid));
	if ($job){
		$db->update("currentjob", $currentjob, $db->quoteInto("userid = ?", $userid));						
	}else{
		$currentjob["userid"] = $userid;
		$db->insert("currentjob", $currentjob);
	}

}
if (!empty($_FILES)){
	if(basename($_FILES['resume']['name']) != NULL || basename($_FILES['resume']['name']) != ""){
        $AusTime = date("h:i:s"); 
		$AusDate = date("Y")."-".date("m")."-".date("d");
		$ATZ = $AusDate." ".$AusTime;
		$date = $ATZ;
        
        $date_created = $AusDate;
        $name = $userid."_".basename($_FILES['resume']['name']);
        
        $name = str_replace(" ", "_", $name);
        $name = str_replace("'", "", $name);
        $name = str_replace("-", "_", $name);
        $name = str_replace("php", "php.txt", $name);
		 if (preg_match("/^.*\.(pdf|doc|docx|odt|)$/i", $name)){
        	$filesize = filesize($_FILES['resume']['tmp_name']);
        	$file_mb = round(($filesize / 1048576), 2);
        	if ($file_mb<=10){
        		
				$file = dirname(__FILE__) . "/../applicants_files/$name";
				if (move_uploaded_file($_FILES['resume']['tmp_name'],$file)){
					$db->insert("tb_applicant_files", 
						array("userid"=>$userid,
							  "file_description"=>"RESUME",
							  "name"=>$name,
							  "permission"=>"ALL",
							  "date_created"=>$date_created)
					);
					chmod($file, 0777);
				}
			}
		 }
		
	}	
	
		
}
$_SESSION["userid"] = $userid;


#finally send an email that the registration is complete
$personal = $db->fetchRow($db->select()->from(array("p"=>"personal"))->where("userid = ?", $_SESSION["userid"]));
$emailSmarty = new Smarty();
$emailSmarty->assign("fname", $personal["fname"]);
$emailSmarty->assign("email", $personal["email"]);

$template = $emailSmarty->fetch("complete_resume.tpl");
$subject = "Remote Staff Application - Complete Your Resume";			
SaveToCouchDBMailbox(null, null, null, 'Remote Staff HR<recruitment@remotestaff.com.au>', $template, $subject, '',array($personal["email"]));
$emailSmarty = new Smarty();
$emailSmarty->assign("fname", $personal["fname"]);
$emailSmarty->assign("lname", $personal["lname"]);

$template = $emailSmarty->fetch("welcome.tpl");
$subject = "WELCOME TO REMOTE STAFF";			
SaveToCouchDBMailbox(null, null, null, 'Remote Staff HR<recruitment@remotestaff.com.au>', $template, $subject,'', array($personal["email"]));

$test = new SkillTestEmail($db);
$test->sendEmail("recruitment@remotestaff.com.au", $personal["email"]);
header("Location:/portal/fb_register/take_a_test.php");
