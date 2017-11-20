<?php
class UpdatePersonalProcess extends AbstractProcess{
	
	
	public function process(){
		$db = $this->db;
		$AusTime = date("H:i:s");
		$AusDate = date("Y")."-".date("m")."-".date("d");
		$ATZ = $AusDate." ".$AusTime;
		
		if (isset($_POST["process"])){
			$userid = $_SESSION['userid'];
			
			//before
			$old = $db->fetchRow($db->select()->from(array("p"=>"personal"))->where("userid = ?", $_SESSION["userid"]));
			unset($old["dateupdated"]);
			
			if ($_POST["others"]=="referral"){
				$_POST["external_source_others"] = "";
				$_POST["external_source"] = "";
			}else{
				$_POST["referred_by"] = "";
			}
			
			$this->skipFields = array("have_you_spoken", "others", "recruiter", "process");
			
			$data = $this->getPostData();
			
			if ($data["external_source"]=="Others"){
				$data["external_source"] = $data["external_source_others"];
			}
			
			unset($data["external_source_others"]);
			
			$data["dateupdated"] = date("Y-m-d H:i:s");
			$db->update("personal", $data, "userid = {$userid}");
			$recruiterYesNo = $_POST["have_you_spoken"];
			$db->delete("recruiter_staff", "userid = {$userid}");
			
			if ($recruiterYesNo=="Yes"){
				$data = array("admin_id"=>$_POST["recruiter"], "userid"=>$userid, "date"=>date("Y-m-d h:i:s"));
				$db->insert("recruiter_staff", $data);			
			}
			
			$new = $db->fetchRow($db->select()->from(array("p"=>"personal"))->where("userid = ?", $_SESSION["userid"]));
			unset($new["dateupdated"]);
			
			$difference = array_diff_assoc($old,$new);

			$history_changes = "";
			if( count($difference) > 0){
				foreach(array_keys($difference) as $array_key){
					$history_changes .= sprintf("[%s] from %s to %s,\n", $array_key, $old[$array_key] , $new[$array_key]);
				}
				include_once "../time.php";
				$db->insert("staff_history", array("changes"=>$history_changes, "userid"=>$userid, "date_change"=>date("Y-m-d h:i:s")));
			
			
			}
			
			
			echo "<script>alert('Profile has been updated');window.location.href='/portal/personal/myresume.php';</script>";
			
			header("location:/portal/personal/myresume.php");
		}

	}

	
	public function render(){
		$db = $this->db;
		$userid = $_SESSION['userid'];
		
		//load user from db
		$user = $db->fetchRow("SELECT * FROM personal WHERE userid = ".$userid);
		
		$smarty = $this->smarty;
		$month_array = array("Month","Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec");
		$monthOptions = $this->renderMonthOptions($user, "bmonth");
		$dmonthOptions = $this->renderMonthOptions($user, "dmonth");
		
		$dayOptions = $this->renderDayOptions($user, "bday");
		$ddayOptions = $this->renderDayOptions($user, "dday");

		$identificationOptions = $this->renderOptions(array("SSS ID","TIN","Passport","Postal ID","Drivers License","PRC ID"), $user, "auth_no_type_id", true);
		$home_working_environment = array("Private Room", "Shared Room", "Living Room");
		$home_working_environment_options = "";
		foreach($home_working_environment as $environment){
			if (strtolower($environment)==strtolower($user["home_working_environment"])){
				$home_working_environment_options.="<input name='home_working_environment' value='{$environment}' type='radio' checked='checked'>{$environment}&nbsp;";
			}else{
				$home_working_environment_options.="<input name='home_working_environment' value='{$environment}' type='radio'/>{$environment}&nbsp;";
			}
		}
		$internet_connection = array("WI-FI", "Dial-Up", "DSL");
		$internet_connection_options = "";
		foreach($internet_connection as $ic){
			if (strtolower($ic)==strtolower($user["internet_connection"])){
				$internet_connection_options.="<input name='internet_connection' value='{$ic}' type='radio' checked='checked' class='internet_connection'>{$ic}&nbsp;";
			}else{
				$internet_connection_options.="<input name='internet_connection' value='{$ic}' type='radio' class='internet_connection'/>{$ic}&nbsp;";
			}
		}
		
		
		$gender_array = array("Male" , "Female");
		for($i=0; $i<count($gender_array);$i++){
			if($user["gender"] == $gender_array[$i]){
				$genderOptions.="<input name='gender' type='radio' value='".$gender_array[$i]."' style='width:15px;' checked='checked'  class='gender'/> ".$gender_array[$i];
			}else{
				if ($i==0){
					$genderOptions.="<input name='gender' type='radio' value='".$gender_array[$i]."' style='width:15px;'  class='gender' checked='checked'/> ".$gender_array[$i];
				}else{
					$genderOptions.="<input name='gender' type='radio' value='".$gender_array[$i]."' style='width:15px;'  class='gender'/> ".$gender_array[$i];
				}
			}
		}
		
		$marital_statuses = array("Single","Married","DeFacto","Its Complicated","Engaged");
		for($i=0; $i<count($marital_statuses);$i++){
			if($user["marital_status"] == $marital_statuses[$i]){
				$marital_status_Options .="<option value=\"".$marital_statuses[$i]."\" selected>".$marital_statuses[$i]."</option>";
			}else{
				$marital_status_Options .="<option value=\"".$marital_statuses[$i]."\">".$marital_statuses[$i]."</option>";
			}
		}
		
		$pregnant_array= array("Yes","No","No! I'm a Male Applicant","No, but I wish I was");
		
		for($i=0; $i<count($pregnant_array);$i++){
			if($user["pregnant"] == addslashes($pregnant_array[$i])){
				$pregnant_Options .="<option value=\"".$pregnant_array[$i]."\" selected>".$pregnant_array[$i]."</option>";
			}else{
				$pregnant_Options .="<option value=\"".$pregnant_array[$i]."\">".$pregnant_array[$i]."</option>";
			}
		}
		
		
		$headset_quality_options = $this->renderOptions(array("No Headset","1","2","3", "4", "5"), $user, "headset_quality", true);
		//echo $permanent_residence;
		
		$sql = $db->select()
			->from('country'); 
		$countries = $db->fetchAll($sql) or die (mysql_error());	
		
		$countryOptions2 = "<option value=\"\">Select country</option>";
		$countryOptions = "<option value=\"\">Select country</option>";
		foreach($countries as $country){
			
			if($user["country_id"]== $country['iso']){
				$countryOptions2 .= "<option value=\"".$country['iso']."\" selected>".$country['printable_name']."</option>";
			}else{
				$countryOptions2 .= "<option value=\"".$country['iso']."\">".$country['printable_name']."</option>";
			}
			
			if($user["permanent_residence"] == $country['iso']){
				$countryOptions .= "<option value=\"".$country['iso']."\" selected>".$country['printable_name']."</option>";
			}else{
				$countryOptions .= "<option value=\"".$country['iso']."\">".$country['printable_name']."</option>";
			}
			
		}
		
		
		$sql = $db->select()
			->from('country')
		
			->order('printable_name');
		
		$nationalities = $db->fetchAll($sql);	
		
		
		//$nationalities = explode("," ,$nationalities);
		$nationalityOptions .= "<option value=\"\" selected>Select nationality</option>";
		foreach($nationalities as $nationality_option){
			if($user["nationality"] == $nationality_option['printable_name']){
				$nationalityOptions .= "<option value=\"".$nationality_option['printable_name']."\" selected>".$nationality_option['printable_name']."</option>";
			}else{
				$nationalityOptions .= "<option value=\"".$nationality_option['printable_name']."\">".$nationality_option['printable_name']."</option>";
			}
		}
		
		if($country=='Philippines'){
			//Philippines States
			$ph_states_array=array('Armm','Bicol Region','C.A.R.','Cagayan Valley','Central Luzon','Central Mindanao','Caraga','Central Visayas','Eastern Visayas','Ilocos Region','National Capital Reg','Northern Mindanao','Southern Mindanao','Southern Tagalog','Western Mindanao','Western Visayas');
			$ph_states_code = array("AR", "BR", "CA", "CG", "CL", "CM", "CR", "CV", "EV", "IL", "NC", "NM", "SM", "ST", "WM", "WV");
			
			for($i=0; $i<count($ph_states_array); $i++){
				if($state == $ph_states_code[$i]){
					$ph_state_options .= "<option value=\"".$ph_states_code[$i]."\" selected>".$ph_states_array[$i]."</option>";
				}else{
					$ph_state_options .= "<option value=\"".$ph_states_code[$i]."\">".$ph_states_array[$i]."</option>";
				}
			}
			
			//$ph_state_options = $this->renderOptions(array('Armm','Bicol Region','C.A.R.','Cagayan Valley','Central Luzon','Central Mindanao','Caraga','Central Visayas','Eastern Visayas','Ilocos Region','National Capital Reg','Northern Mindanao','Southern Mindanao','Southern Tagalog','Western Mindanao','Western Visayas'), $user, "state");
		}
		
		$yes_no =  array("Yes", "No");
		for($i=0; $i<count($yes_no); $i++){
			//Do you have pending Visa application ?
			if (!is_null($user["pending_visa_application"])){
				if($user["pending_visa_application"] == $yes_no[$i]){
					$pending_visa_application_Options.="<input name='pending_visa_application' type='radio' value='".$yes_no[$i]."' style='width:15px;' checked='checked' /> ".$yes_no[$i];
				}else{
					$pending_visa_application_Options.="<input name='pending_visa_application' type='radio' value='".$yes_no[$i]."' style='width:15px;'/> ".$yes_no[$i];
				}
			}else{
				$pending_visa_application_Options.="<input name='pending_visa_application' type='radio' value='".$yes_no[$i]."' style='width:15px;'/> ".$yes_no[$i];
			}
			
			//Do you have active Visa�s for US, Australia, UK, Dubai ?
			if (!is_null($user["active_visa"])){
				if($user["active_visa"]== $yes_no[$i]){
					$active_visa_Options.="<input name='active_visa' type='radio' value='".$yes_no[$i]."' style='width:15px;clear:both' checked='checked' /> ".$yes_no[$i];
				}else{
					$active_visa_Options.="<input name='active_visa' type='radio' value='".$yes_no[$i]."' style='width:15px;clear:both'/> ".$yes_no[$i];
				}
			}else{
				$active_visa_Options.="<input name='active_visa' type='radio' value='".$yes_no[$i]."' style='width:15px;'/> ".$yes_no[$i];
			}
			
			 
		}
		
		$referred_by_array = array('Contacted by Remotestaff','Facebook','Twitter','Google','JobStreet','JobsDB', 'Friend','Linkedin','Bestjobs.ph','Others');
		$referredByOptions = "<option>Please Select </option>"; 
		for($i=0; $i<count($referred_by_array);$i++){
			
			
			if($user["external_source"] == $referred_by_array[$i]){
				$referredByOptions .= "<option value='".$referred_by_array[$i]."' selected>".$referred_by_array[$i]."</option>";
			
			}else{
				
				
				if(($user["external_source"] != '')&&(!in_array($user["external_source"],$referred_by_array))&&($referred_by_array[$i] == 'Others')){
					$referredByOptions .= "<option value='".$referred_by_array[$i]."' selected >".$referred_by_array[$i]."</option>";
				}else{
					$referredByOptions .= "<option value='".$referred_by_array[$i]."'>".$referred_by_array[$i]."</option>";
				}
			}
			
		}
		
		//check if the applicant is tied up with a recruiter
		$answers = array("Yes", "No");
		$sql = $db->select()->from("recruiter_staff", array("recruiter_staff.admin_id AS admin_id"))
				->joinInner("admin", "admin.admin_id = recruiter_staff.admin_id", array("CONCAT(admin.admin_fname, ' ', admin.admin_lname) AS client"))
				->where("recruiter_staff.userid = ?",$userid);
		$data = $db->fetchRow($sql);
		
		
		$select = "SELECT admin_id,admin_fname,admin_lname 	 
		FROM `admin`
		where (status='HR' 
		OR admin_id='41' 
		OR admin_id='71'
		OR admin_id='78'
		OR admin_id='81')  
		AND status <> 'REMOVED' 
		order by admin_fname";
		
		$recruiters = $db->fetchAll($select);
		$recruiterYesNo = "";
		$recruiterOption = "";
		if ($data){
			$recruiterYesNo .= "<option value='Yes' selected>Yes</option>";
			$recruiterYesNo .= "<option value='No'>No</option>";
			foreach($recruiters as $recruiter){
				if ($recruiter["admin_id"]==$data["admin_id"]){
					$recruiterOption.="<option value='{$recruiter["admin_id"]}' selected>{$recruiter["admin_fname"]} {$recruiter["admin_lname"]}</option>";	
				}else{
					$recruiterOption.="<option value='{$recruiter["admin_id"]}'>{$recruiter["admin_fname"]} {$recruiter["admin_lname"]}</option>";
				}	
			}
		}else{
			$recruiterYesNo .= "<option value='Yes'>Yes</option>";
			$recruiterYesNo .= "<option value='No' selected >No</option>";
			foreach($recruiters as $recruiter){
				$recruiterOption.="<option value='{$recruiter["admin_id"]}'>{$recruiter["admin_fname"]} {$recruiter["admin_lname"]}</option>";
			}
		}
		
		
		
		$smarty = $this->smarty;
		
		//check if this form has already saved in the applicants_form
		if($userid!=""){
			$sql = $db->select()
				->from('applicants_form')
				->where('userid = ?' ,$userid)
				->where('form = ?' , 1);
			$result = $db->fetchRow($sql);
			$form_id = $result['id'];
			$date_completed = $result['date_completed'];
			if($date_completed == "") {
				$status = "Not yet filled up";
			}else{
				$status = "Completed ".$date_completed;
			}	
			$smarty->assign('form_id',$form_id);
			
			$welcome = sprintf("Welcome ID%s %s %s<br>Step 1 Form status : %s " ,$userid ,$fname, $lname , $status);
			$smarty->assign('welcome',$welcome);
			
		}
		
		
		//email address enabling and disabling
		$subcontractorsCount = $db->fetchRow($db->select()->from(array("s"=>"subcontractors"), array("COUNT(s.id) AS count"))
											->where("userid = ?", $_SESSION["userid"])
											->where("status IN ('ACTIVE', 'suspended')"));
				
		if ($subcontractorsCount&&$subcontractorsCount["count"]>=1){
			$smarty->assign("disableEmail", "disabled='disabled'");
		}else{
			$smarty->assign("disableEmail", "");
		}
		
		
		$smarty->assign("userid", $_SESSION["userid"]);
		$smarty->assign("recruiterYesNo", $recruiterYesNo);
		$smarty->assign("recruiterOption", $recruiterOption);
		$smarty->assign('page' , basename($_SERVER['SCRIPT_FILENAME']));
		$smarty->assign('userid' , $userid);
		$smarty->assign('img_result',$img_result);
		$smarty->assign('right_menus' , $right_menus);
		//echo $user["external_source"];
		if (!in_array($user["external_source"], $referred_by_array)){
			$smarty->assign('external_source_others' , $user["external_source"]);
		}else{
			$smarty->assign('external_source_others' , "");
		}
		$smarty->assign('code',$code);
		$smarty->assign('email',$user["email"]);
		$smarty->assign('fname',$user["fname"]);
		$smarty->assign('lname',$user["lname"]);
		$smarty->assign('middle_name',$user["middle_name"]);
		$smarty->assign('nick_name',$user["nick_name"]);
		$smarty->assign("process", true);
		
		$smarty->assign('monthOptions',$monthOptions);
		$smarty->assign('dmonthOptions',$dmonthOptions);
		$smarty->assign('dayOptions',$dayOptions);
		$smarty->assign('ddayOptions',$ddayOptions);
		$smarty->assign('byear',$user["byear"]);
		$smarty->assign("dyear", $user["dyear"]);
		$smarty->assign("home_working_environment_options", $home_working_environment_options);
		$smarty->assign("internet_connection_options", $internet_connection_options);
		$smarty->assign("isp", $user["isp"]);
		$smarty->assign("computer_hardware", $user["computer_hardware"]);
		$smarty->assign("headset_quality_options", $headset_quality_options);
		$smarty->assign("linked_in", $user["linked_in"]);
		$smarty->assign("password", $user["pass"]);
		$smarty->assign('identificationOptions',$identificationOptions);
		$smarty->assign('identification_number',$user["msia_new_ic_no"]);
		$smarty->assign('genderOptions',$genderOptions);
		$smarty->assign('marital_status_Options',$marital_status_Options);
		$smarty->assign('no_of_kids',$user["no_of_kids"]);
		$smarty->assign('pregnant_Options',$pregnant_Options);
		$smarty->assign('nationalityOptions',$nationalityOptions);
		$smarty->assign('countryOptions',$countryOptions);
		$smarty->assign('countryOptions2',$countryOptions2);
		
		$smarty->assign('pending_visa_application_Options',$pending_visa_application_Options);
		$smarty->assign('active_visa_Options',$active_visa_Options);
		$smarty->assign('referredByOptions',$referredByOptions);
		
		
		$smarty->assign('alt_email',$user["alt_email"]);
		$smarty->assign('handphone_country_code',$user["handphone_country_code"]);
		$smarty->assign('handphone_no',$user["handphone_no"]);
		$smarty->assign('tel_area_code',$user["tel_area_code"]);
		$smarty->assign('tel_no',$user["tel_no"]);
		$smarty->assign('address1' , $user["address1"]);
		
		$smarty->assign('postcode' , $user["postcode"]);
		$smarty->assign('state' , $user["state"]);
		$smarty->assign('city' , $user["city"]);
		
		$smarty->assign('msn_id' , $user["msn_id"]);
		$smarty->assign('yahoo_id' , $user["yahoo_id"]);
		$smarty->assign('icq_id' , $user["icq_id"]);
		$smarty->assign('skype_id' , $user["skype_id"]);
		
		if ($user["external_source"]!=""){
			$user["referred_by"] = "";
		}else{
			$user["external_source"] = "";
		}
		
		$smarty->assign('referred_by' , $user["referred_by"]); 
		$smarty->assign('external_source' , $user["external_source"]);
		
		$external_source = $user["external_source"];
		if(($external_source != '')&&(!in_array($external_source,$referred_by_array))){
			$display_others = "block";
		}
		else{
			$display_others = "none";
		}
		$smarty->assign('display_others' , $display_others);
		$smarty->display('updatepersonal.tpl');
		
		
	}

}