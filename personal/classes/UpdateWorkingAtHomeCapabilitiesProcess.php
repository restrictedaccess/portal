<?php
class UpdateWorkingAtHomeCapabilities extends AbstractProcess{
	public function process(){
		$db = $this->db;
		$AusTime = date("H:i:s");
		$AusDate = date("Y")."-".date("m")."-".date("d");
		$ATZ = $AusDate." ".$AusTime;
		
		if (isset($_POST["process"])){
			$userid = $_SESSION['userid'];
			if (isset($_POST['work_from_home_before'])){
				$work_from_home_before=$_POST['work_from_home_before'];
			}else{
				$work_from_home_before = null;
			}
			$start_worked_from_home_month=$_POST['start_worked_from_home_month'];
			if($start_worked_from_home_month == ''){
				$start_worked_from_home_month = 0;
			}

			$start_worked_from_home_year=$_POST['start_worked_from_home_year'];
			if($start_worked_from_home_year == ''){
				$start_worked_from_home_year = 0;
			}

			$have_a_baby_in_the_house=$_POST['have_a_baby_in_the_house'];
			$who_is_the_main_caregiver=$_POST['who_is_the_main_caregiver'];
			$why_do_you_want_to_work_from_home=$_POST['why_do_you_want_to_work_from_home'];
			$how_long_do_you_see_yourself_working_for_rs=$_POST['how_long_do_you_see_yourself_working_for_rs'];
			$home_working_environment=$_POST['home_working_environment'];
			$internet_connection=$_POST['internet_connection'];
			$internet_connection_others=$_POST['internet_connection_others'];
			$internet_plan=$_POST['internet_plan'];
			$speed_test_result_link=$_POST['speed_test_result_link'];
			$internet_consequences=$_POST['internet_consequences'];
			$desktop_computer=$_POST['desktop_computer'];
			$desktop_os=$_POST['desktop_os'];
			$desktop_processor=$_POST['desktop_processor'];
			$desktop_ram=$_POST['desktop_ram'];
			$loptop_computer=$_POST['loptop_computer'];
			$loptop_os=$_POST['loptop_os'];
			$loptop_processor=$_POST['loptop_processor'];
			$loptop_ram=$_POST['loptop_ram'];
			$headset=$_POST['headset'];
			$headphone=$_POST['headphone'];
			$printer=$_POST['printer'];
			$scanner=$_POST['scanner'];
			$tablet=$_POST['tablet'];
			$pen_tablet=$_POST['pen_tablet'];
			$noise_level=$_POST['noise_level'];

			//$noises = '';
			if($noise_level != ''){
				$noises = implode(',',$noise_level);
			}


			if($_POST['form_id'] == "") {
				$password = trim($_POST['password']);
				if($password == "") {
					//make a random string password for client
					$characters = '0123456789abcdefghijklmnopqrstuvwxyz';
					$rand_pw = '';
					for ($p = 0; $p < 10; $p++) {
						$rand_pw .= $characters[mt_rand(0, strlen($characters))];
					}
					$password = $rand_pw;
				}
				$pass= sha1($password);
			}else{
				$sql = $db->select()
				->from('personal' ,'pass')
				->where('userid = ?' , $userid);
				$pass = $db->fetchOne($sql);
			}

			$start_worked_from_home=$start_worked_from_home_year."years and ".$start_worked_from_home_month."months";
			$desktop_specs = "";
			$laptop_specs = "";
			if($desktop_computer=="yes")$desktop_specs = "desktop,".$desktop_os.",".$desktop_processor.",".$desktop_ram."\n";
			if($loptop_computer=="yes")$laptop_specs = "laptop,".$loptop_os.",".$loptop_processor.",".$loptop_ram."\n";
			$others_specs = "";
			$others_specs .= $headset."\n";
			$others_specs .= $headphone."\n";
			$others_specs .= $printer."\n";
			$others_specs .= $scanner."\n";
			$others_specs .= $tablet."\n";
			$others_specs .= $pen_tablet."\n";
			$computer_hardware=$desktop_specs.$laptop_specs.$others_specs;
			
			
			if (isset($_POST['work_from_home_before'])){
				$work_from_home_before=$_POST['work_from_home_before'];
				if($work_from_home_before == 'No'){
					$work_from_home_before = 0;
				}
				else{
					$work_from_home_before = 1;
				}
			}else{
				$work_from_home_before = null;
			}
				
			$data = array(
					'work_from_home_before' => $work_from_home_before,
					'start_worked_from_home' => $start_worked_from_home,
					'has_baby' => $have_a_baby_in_the_house,
					'main_caregiver' => $who_is_the_main_caregiver,
					'reason_to_wfh' => $why_do_you_want_to_work_from_home,
					'timespan' => $how_long_do_you_see_yourself_working_for_rs,
					'home_working_environment' => $home_working_environment,
					'isp' => $internet_connection,
					'internet_connection_others' => $internet_connection_others,
					'internet_connection' => $internet_plan,
					'speed_test' => $speed_test_result_link,
					'internet_consequences' => $internet_consequences,
					'computer_hardware' => $computer_hardware,  
					'noise_level' => $noises
					);
				
			$db->update("personal", $data, "userid = {$userid}");
			echo "<script>alert('Profile has been updated');window.location.href='/portal/personal/myresume.php';</script>";
			//header("Location:/portal/personal/myresume.php");
		}
	}

	public function render(){
		$smarty = $this->smarty;
		$db = $this->db;
		$userid = $_SESSION['userid'];

		//load user from db
		$user = $this->getUser();


		if ($user&&!empty($user)){
			$work_from_home_before = $user['work_from_home_before'];
			$start_worked_from_home=$user['start_worked_from_home'];
			$date=explode("and",$start_worked_from_home);
			$start_worked_from_home_year = trim(str_replace('years','',$date[0]));
			$start_worked_from_home_month = trim(str_replace('months','',$date[1]));
	
	
			$have_a_baby_in_the_house = $user['has_baby'];
			$who_is_the_main_caregiver = $user['main_caregiver'];
			$why_do_you_want_to_work_from_home = $user['reason_to_wfh'];
			$how_long_do_you_see_yourself_working_for_rs = $user['timespan'];
			$internet_connection_others = $user['internet_connection_others'];
			$internet_plan = $user['internet_connection'];
			$speed_test_result_link = $user['speed_test'];
			$internet_consequences = $user['internet_consequences'];
			$internet_connection=$user['isp'];
			$home_working_environment=$user['home_working_environment'];
			$computer_hardware=$user['computer_hardware'];
	
			$tools=explode("\n",$computer_hardware);
			$desktop=str_replace("desktop ","",$tools[0]);
			if($desktop!=""){
				$desktop_computer="yes";
				$desktop_specs=explode(",",$desktop);
				$desktop_os=$desktop_specs[1];
				$desktop_processor=$desktop_specs[2];
				$desktop_ram=$desktop_specs[3];
			}
	
			$laptop=str_replace("laptop ","",$tools[1]);
			if($laptop!=""){
				$laptop_computer="yes";
				$laptop_specs=explode(",",$laptop);
				$laptop_os=$laptop_specs[1];
				$laptop_processor=$laptop_specs[2];
				$laptop_ram=$laptop_specs[3];
			}
	
			$headset = $tools[2];
			$headphone = $tools[3];
			$printer = $tools[4];
			$scanner = $tools[5];
			$tablet = $tools[6];
			$pen_tablet = $tools[7];
			$noise_levels = array();
			$noise_levels=explode(',',$user['noise_level']);
	
			$noise_levels_array = array('quiet/no noise','tricycles','general car traffic','dog/rooster/chicken','children' ,'family members in-house','street vendors','planes','surrounding construction/home renovations');
	
			if($noise_levels != null){
				for($i=0; $i<count($noise_levels_array); $i++){
					$checked = '';
					if(in_array($noise_levels_array[$i],$noise_levels)){
						$checked = 'checked';
					}
					$noise_level_Options .="<input type=\"checkbox\" ".$checked." name=\"noise_level[]\" value=\"".$noise_levels_array[$i]."\"/>".$noise_levels_array[$i]."<br />";
				}
			}
	
			//$loptop_checked
			if($laptop_computer != ''){
				if($laptop_computer == 'yes'){
					$laptop_checked = 'checked';
				}
			}
	
			//desktop_checked
			if($desktop_computer != ''){
				if($desktop_computer == 'yes'){
					$desktop_checked = 'checked';
				}
			}
	
			$operating_systems = array("Windows XP" , "Windows Vista" ,"Windows 7" , "Linux");
			for($i=0; $i<count($operating_systems); $i++){
				//desktop
				if($desktop_os == $operating_systems[$i]){
					$desktop_os_Options .= "<option value=\"".$operating_systems[$i]."\" selected>".$operating_systems[$i]."</option>";
				}else{
					$desktop_os_Options .= "<option value=\"".$operating_systems[$i]."\">".$operating_systems[$i]."</option>";
				}
				//loptop
				if($laptop_os == $operating_systems[$i]){
					$laptop_os_Options .= "<option value=\"".$operating_systems[$i]."\" selected>".$operating_systems[$i]."</option>";
				}else{
					$laptop_os_Options .= "<option value=\"".$operating_systems[$i]."\" >".$operating_systems[$i]."</option>";
				}
			}
	
	
	
	
	
	
			//
			if($work_from_home_before!=""){
				if($work_from_home_before == 1){
					$smarty->assign('work_from_home_before_yes' , 'checked');
				}else{
					$smarty->assign('work_from_home_before_no' , 'checked');
				}
			}
	
			$monthOptions="<option >Months</option>";
			for($i=0; $i<12;$i++){
				if($start_worked_from_home_month == $i){
					$monthOptions.="<option value=\"".$i."\" selected=\"true\" >".$i."</option>";
				}else{
					$monthOptions.="<option value=\"".$i."\">".$i."</option>";
				}
			}
	
			$yearOptions="<option >Year</option>";
			for($i=0; $i<=15;$i++){
				if($start_worked_from_home_year == $i){
					$yearOptions.="<option value=\"".$i."\" selected=\"true\" >".$i."</option>";
				}else{
					$yearOptions.="<option value=\"".$i."\">".$i."</option>";
				}
			}
	
	
	
	
			$yes_no =  array(array('1' , 'Yes'), array('0' , 'No'));
			for($i=0; $i<count($yes_no); $i++){
				//Do  you have a baby in the house ?
				if($have_a_baby_in_the_house == $yes_no[$i][0]){
					$have_a_baby_in_the_house_Options.="<input name='have_a_baby_in_the_house'  type='radio' value='".$yes_no[$i][0]."' style='width:15px;' checked='checked' /> ".$yes_no[$i][1];
				}else{
					$have_a_baby_in_the_house_Options.="<input name='have_a_baby_in_the_house' type='radio' value='".$yes_no[$i][0]."' style='width:15px;'/> ".$yes_no[$i][1];
				}
			}
	
			$timespan = array("1 month" , "3 months" , "6 months" , "9 months" , "1 year" , "2 years" , "as long as possible");
			for($i=0; $i<count($timespan); $i++){
				if($how_long_do_you_see_yourself_working_for_rs == $timespan[$i]){
					$timespan_Options .= "<option value=\"".$timespan[$i]."\" selected>".$timespan[$i]."</option>";
				}else{
					$timespan_Options .= "<option value=\"".$timespan[$i]."\">".$timespan[$i]."</option>";
				}
			}
	
	
			//home_working_environment
			$home_working_environments = array("private room", "shared room" ,"living room");
			$home_working_environments2 = array("Private Room", "Shared Room" ,"Living Room");
			for($i=0; $i<count($home_working_environments); $i++){
				//Do  you have a baby in the house ?
				if($home_working_environment == $home_working_environments[$i]){
					$home_working_environment_Options.="<input name='home_working_environment' id='home_working_environment' type='radio' value='".$home_working_environments[$i]."' style='width:15px;' checked='checked' /> ".$home_working_environments2[$i];
				}else{
					$home_working_environment_Options.="<input name='home_working_environment' id='home_working_environment' type='radio' value='".$home_working_environments[$i]."' style='width:15px;'/> ".$home_working_environments2[$i];
				}
			}
	
			//internet_connection
			$internet_connections = array("PLDT MyDSL" , "PLDT WeRoam Wireless" , "BayanTel DSL" , "Globelines Broadband" , "Globelines Wireless/WiMax/Tattoo" , "Smart Bro Wireless" , "Sun Broadband Wireless" ,"Others");
			for($i=0; $i<count($internet_connections); $i++){
				if($internet_connection == $internet_connections[$i]){
					$internet_connections_Options .= "<option value=\"".$internet_connections[$i]."\" selected>".$internet_connections[$i]."</option>";
				}else{
					$internet_connections_Options .= "<option value=\"".$internet_connections[$i]."\">".$internet_connections[$i]."</option>";
				}
			}
	
	
	
	
	
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
			$headset_quality_options = $this->renderOptions(array("No Headset","1","2","3", "4", "5"), $user, "headset_quality", true);
	
			$smarty->assign('fname',$user["fname"]);
	
	
			$smarty->assign('monthOptions',$monthOptions);
			$smarty->assign('yearOptions',$yearOptions);
			$smarty->assign('dayOptions',$dayOptions);
			$smarty->assign('byear',$byear);
	
			$smarty->assign('start_worked_from_home_year',$start_worked_from_home_year);
			$smarty->assign('have_a_baby_in_the_house_Options',$have_a_baby_in_the_house_Options);
			$smarty->assign('who_is_the_main_caregiver',$who_is_the_main_caregiver);
			$smarty->assign('why_do_you_want_to_work_from_home',$why_do_you_want_to_work_from_home);
			$smarty->assign('timespan_Options' ,$timespan_Options);
			$smarty->assign('home_working_environment_Options',$home_working_environment_Options);
			$smarty->assign('internet_connections_Options',$internet_connections_Options);
			$smarty->assign('internet_connection_others',$internet_connection_others);
			$smarty->assign('internet_plan',$internet_plan);
			$smarty->assign('speed_test_result_link',$speed_test_result_link);
			$smarty->assign('internet_consequences' ,$internet_consequences);
			$smarty->assign('desktop_checked',$desktop_checked);
			$smarty->assign('laptop_checked',$laptop_checked);
			$smarty->assign('desktop_os_Options' , $desktop_os_Options);
			$smarty->assign('desktop_processor',$desktop_processor);
			$smarty->assign('desktop_ram',$desktop_ram);
	
			$smarty->assign('laptop_os_Options' ,$laptop_os_Options);
			$smarty->assign('laptop_processor',$laptop_processor);
			$smarty->assign('laptop_ram' , $laptop_ram);
			$smarty->assign("process", true);
			$smarty->assign('headset' , $headset);
			$smarty->assign('headphone' , $headphone);
			$smarty->assign('printer' , $printer);
			$smarty->assign('scanner' , $scanner);
			$smarty->assign('tablet' , $tablet);
			$smarty->assign('pen_tablet' , $pen_tablet);
	
			$smarty->assign('noise_level_Options',$noise_level_Options);
			$smarty->assign("home_working_environment_options", $home_working_environment_options);
			$smarty->assign("internet_connection_options", $internet_connection_options);
			$smarty->assign("isp", $user["isp"]);
			$smarty->assign("computer_hardware", $user["computer_hardware"]);
			$smarty->assign("headset_quality_options", $headset_quality_options);
			$smarty->display("updateworkingathomecapabilities.tpl");
		}else{
			$this->authCheck();
		}
		
	}
}