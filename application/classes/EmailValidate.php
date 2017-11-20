<?php
require_once dirname(__FILE__) . "/AbstractProcess.php";
require_once dirname(__FILE__)."/../../tools/CouchDBMailbox.php";

class EmailValidate extends AbstractProcess {
	public function render() {
		$smarty = $this -> smarty;
		if (TEST) {
			$smarty -> assign("site", "test.remotestaff.com.ph");
		} else {
			$smarty -> assign("site", "remotestaff.com.ph");
		}
		$smarty -> display("email_validate.tpl");
	}

	public function createFromFBAccount() {
		$db = $this -> db;
		if (!empty($_POST)) {
			if (isset($_REQUEST["from"])){
				$_SESSION["from"] = $_REQUEST["from"];
				$_SESSION["job_id"] = $_REQUEST["job_id"];
			}else{
				$_SESSION["from"] = "Registration";
			}
			
			$personal = $db -> fetchRow($db -> select() -> from(array("p" => "personal")) -> where("email = ?", $_POST["email"]));
			if ($personal) {
				$db->update("personal", array("facebook_id"=>$_POST["id"]), $db->quoteInto("userid = ?", $personal["userid"]));
				
				if ($personal["pass"]) {
					$_SESSION["userid"] = $personal["userid"];
					if (isset($_SESSION["from"])){
						if ($_SESSION["from"]=="PH"){
							echo json_encode(array("success" => true, "redirect" => null, "from"=>$_SESSION["from"]));										
						}else{
							echo json_encode(array("success" => true, "redirect" => "/portal/jobseeker/", "from"=>$_SESSION["from"]));
						}

					}else{
						echo json_encode(array("success" => true, "redirect" => "/portal/jobseeker/"));	
					}
					
				} else {
					$_SESSION["userid"] = $personal["userid"];
					echo json_encode(array("success" => true, "redirect" => "/portal/application/setpassword.php"));

				}
				if (isset($_SESSION["promo_code"])){
					$db->update("personal", array("promotional_code"=>$_SESSION["promo_code"]), $db->quoteInto("userid = ?", $personal["userid"]));
				}
				
			} else {
				//register information on jobseeker portal
				
				
				$data = array();
				$data["fname"] = $_POST["first_name"];
				$data["lname"] = $_POST["last_name"];
				$data["middle_name"] = $_POST["middle_name"];
				if ($_POST["gender"] == "male") {
					$data["gender"] = "Male";
				} else if ($_POST["gender"] == "female") {
					$data["gender"] = "Female";
				}
				$bdate = explode("/", $_POST["birthday"]);
				$data["byear"] = $bdate[2];
				$data["bmonth"] = intval($bdate[0]);
				$data["bday"] = intval($bdate[1]);
				$data["email"] = $_POST["email"];
				if (isset($_SESSION["mobile_number"])){
					$data["handphone_no"] = $_SESSION["mobile_number"];
					$data["handphone_country_code"] = "+63";
				}
				
				$data["marital_status"] = $this->getStatus($_POST["relationship_status"]);
				if (isset($_SESSION["promo_code"])){
					$data["promotional_code"] = $_SESSION["promo_code"];
				}
				
	
				
				$country = $db -> fetchRow($db -> select() -> from(array("c" => "country"), array("iso3")) -> where("printable_name = ?", $_POST["current_location"]["country"]));
				if ($country) {
					$data["nationality"] = $_POST["current_location"]["country"];
					$data["permanent_residence"] = $country["iso3"];
					$data["country_id"] = $country["iso3"];
					$data["state"] = $_POST["current_location"]["state"];
					$data["city"] = $_POST["current_location"]["city"];
				}else{
					$data["country_id"] = "PH";
					$data["nationality"] = "Philippines";
				}
				$data["datecreated"] = date("Y-m-d H:i:s");
				$data["dateupdated"] = date("Y-m-d H:i:s");
				$data["facebook_id"] = $_POST["id"];
				$data["status"] = "New";
				$db -> insert("personal", $data);
				$userid = $db -> lastInsertId("personal");
				
				//get promo code owner
				if (isset($_SESSION["promo_code"])){
					$promocode = $db->fetchRow($db->select()->from("personal_promo_codes")->where("promocode = ?", $_SESSION["promo_code"]));
					if ($promocode){
						//register as a referral with type promocode
						$personal = $db->fetchRow($db->select()->from("personal")->where("userid = ?", $userid));
						
						if ($personal){
							$referral = array(
								"user_id"=>$promocode["userid"],
								"firstname"=>$personal["fname"],
								"lastname"=>$personal["lname"],
								"email"=>$personal["email"],
								"contactnumber"=>$personal["handphone_country_code"]."+".$personal["handphone_no"],
								"date_created"=>date("Y-m-d H:i:s"),
								"contacted"=>0,
								"jobseeker_id"=>$userid,
								"type"=>"promo_code"
							);
							$refer = $db->fetchRow($db->select()->from("referrals")->where("user_id = ?", $promocode["userid"])->where("jobseeker_id = ?", $userid));
							if (!$refer){
								$db->insert("referrals", $referral);
							}
						}
						
							
					}					
				}

				file_put_contents(dirname(__FILE__) . "/../../uploads/pics/" . $userid . ".jpg", fopen($_POST["picture"], 'r'));
				$db -> update("personal", array("image" => "uploads/pics/" . $userid . ".jpg"), $db -> quoteInto("userid = ?", $userid));
				$db -> insert("unprocessed_staff", array("userid" => $userid, "admin_id" => 0, "date" => date("Y-m-d H:i:s")));
				if (!empty($_POST["languages"])) {
					foreach ($_POST["languages"] as $language) {
						$db -> insert("language", array("userid" => $userid, "language" => $language["name"]));
					}
				}
				
				if (!empty($_POST["education"])){
					//loop all education then select highest qualification
					
					$levels = array("High School Diploma","Vocational Diploma / Short Course Certificate","Bachelor/College Degree","Post Graduate Diploma / Master Degree","Professional License (Passed Board/Bar/Professional License Exam)","Doctorate Degree");
					$highestPoints = 0;
					$currentEducation = array();
					foreach($_POST["education"] as $education){
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
				
				if (!empty($_POST["work"])){
					$i = 1;
					$currentjob = array();
					foreach($_POST["work"] as $work){
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
							$currentjob["monthfrom".$suffix] = $this->getMonth($startdate[1]);
							$currentjob["yearfrom".$suffix] = $startdate[0];
						}else{
							$currentjob["monthfrom".$suffix] = "Present";
							$currentjob["yearfrom".$suffix] = "Present";
							
						}
						if (isset($work["end_date"])){
							$enddate = $work["end_date"];
							$enddate = explode("-", $enddate);
							if ($enddate[0]!="0000"&&$enddate[1]=="00"){
								$currentjob["monthto".$suffix] = $this->getMonth($enddate[1]);
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
				$_SESSION["userid"] = $userid;
				echo json_encode(array("success" => true, "redirect" => "/portal/application/setpassword.php"));

			}
		}

	}

	private function getStatus($status){
		if ($status=="Single"){
			return "Single";
		}else if ($status=="In a relationship"){
			return "Single";
		}else if ($status=="Engaged"){
			return "Engaged";
		}else if ($status=="It's Complicated"){
			return "Its Complicated";
		}else if ($status=="In an open relationship"){
			return "DeFacto";
		}else if ($status=="Married"){
			return "Married";
		}else if ($status=="Divorced"){
			return "Divorced";
		}else if ($status=="Separated"){
			return "Divorced";
		}else if ($status=="In a civil union"){
			return "DeFacto";
		}else if ($status=="In a domestic partnership"){
			return "DeFacto";
		}else if ($status=="Married"){
			return "Married";
		}else{
			return "Single";
		}
	}
	
	private function getMonth($month){
		if ($month=="01"){
			return "JAN";
		}else if ($month=="02"){
			return "FEB";
		}else if ($month=="03"){
			return "MAR";
		}else if ($month=="04"){
			return "APR";
		}else if ($month=="05"){
			return "MAY";
		}else if ($month=="06"){
			return "JUN";
		}else if ($month=="07"){
			return "JUL";
		}else if ($month=="08"){
			return "AUG";
		}else if ($month=="09"){
			return "SEP";
		}else if ($month=="10"){
			return "OCT";
		}else if ($month=="11"){
			return "NOV";
		}else if ($month=="12"){
			return "DEC";
		}else{
			return "Present";
		}
	}
	
	
	

}
