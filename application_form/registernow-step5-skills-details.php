<?php 
include '../conf/zend_smarty_conf.php';
include './inc/home_pages_link_for_template.php';
include './inc/register-right-menu.php';
include '../lib/validEmail.php';

$smarty = new Smarty();
$img_result = ShowActiveInactiveImages(LOCATION_ID);


$error = $_REQUEST['error'];
$error_msg = $_REQUEST['error_msg'];
if($error == "") $error = False;
if($error == "True"){ 
	$email = trim($_POST['email']);
	$code = $_POST['code'];
	$smarty->assign('error',True);
	$smarty->assign('error_msg',$error_msg);
}else{
	$smarty->assign('error',False);
	$smarty->assign('error_msg',$error_msg);
}



$userid = $_SESSION['userid'];
if($userid != '' or $userid != NULL){ 
	 
	$sql = $db->select()
		->from('skills')
		->where('userid = ?' ,$userid)
		->where('skill_type = ?' ,'technical');
	$rows = $db->fetchAll($sql);	
 
	$i=0;
	$skills = array();
	foreach ($rows as $row){
		$skills[$i]['skill'] = $row['skill'];
		$skills[$i]['experience'] = $row['experience'];
		$skills[$i]['proficiency'] = $row['proficiency'];
		$i++;
	}
	
	$sql = $db->select()
		->from('skills')
		->where('userid = ?' ,$userid) 
		->where('skill_type = ?' ,'admin');
	$rows = $db->fetchAll($sql);	 

	$i=0;
	$admin_skills = array();
	foreach ($rows as $row){
		$admin_skills[$i]['skill'] = $row['skill'];
		$admin_skills[$i]['experience'] = $row['experience'];
		$admin_skills[$i]['proficiency'] = $row['proficiency'];
		$i++;
	}

}
else{
	$skills = array();
	$admin_skills = array();
}

//check if this form has already saved in the applicants_form
if($userid!=""){
	$sql = $db->select()
		->from('applicants_form')
		->where('userid = ?' ,$userid)
		->where('form = ?' , 5);
	$result = $db->fetchRow($sql); 
	$form_id = $result['id'];
	$date_completed = $result['date_completed'];
	if($date_completed == "") {
		$status = "Not yet filled up";
	}else{
		$status = "Completed ".$date_completed;
	}	
	$smarty->assign('form_id',$form_id);
	
	$welcome = sprintf("Welcome ID%s %s %s<br>Step 5 Form status : %s " ,$userid ,$fname, $lname , $status);
	$smarty->assign('welcome',$welcome);
}

$skills_array = array('Actionscript','Adobe Dreamweaver','Adobe Fireworks','Adobe Illustrator','Adobe Indesign','Adobe Photoshop', 'AJAX','ASP','C#','C++','CAD','CISCO','Classic ASP','Coldfusion','Corel Draw','CSS','Drupal','HTML','JavaScript','Joomla','Link Building','Magento','Maya','Microsoft Access','Microsoft Office','MS SQL','MySQL','OOP','PHP','SEO','SOLIDWORKS','Swishmax','Vector Works','Video Editing','Wordpress','XHTML','XML','.NET','3D MAX');
$skills_options = '<option value="" >Select Skill</option>';
for($i=0;$i<count($skills_array);$i++){
	$skills_options .= '<option value="'.$skills_array[$i].'" > '.$skills_array[$i].'</option>';
}

$admin_skills_array = array('Appointment Setting','Customer Service','Data Entry','Debt Collection','Internet Research','Lead Generation','Legal','Microsoft Applications','Microsoft Excel','Microsoft PowerPoint','Microsoft Word','MYOB','ORACLE','Peachtree','Photo Editing','Quickbooks','SAP','Tele Sales','Tele Survey','Telemarketing','Video Editing','Writing'); 
$admin_skills_options = '<option value="" >Select Skill</option>';
for($i=0;$i<count($admin_skills_array);$i++){
	$admin_skills_options .= '<option value="'.$admin_skills_array[$i].'" > '.$admin_skills_array[$i].'</option>'; 
}




$proficiency_array = array('Beginner','Intermediate','Advanced');
$proficiency_options ='<option value="" >-</option>';
for($i=1;$i<=count($proficiency_array);$i++){
	$proficiency_options .= '<option value="'.$i.'" > '.$proficiency_array[$i-1].'</option>';
}

//if ($skills != NULL){
	
	while(count($skills) < 5){
		array_push ($skills,array());
	}

	$skill_HTML = "";		
	$i = 1;
	foreach($skills as $skill){	
		
		$experience_options="<option value='' >-</option>";
		
		if ($skill["experience"]==0.5){
			$experience_options.="<option value='0.5' selected>Less than 6 months</option>";
		}else{
			$experience_options.="<option value='0.5'>Less than 6 months</option>";
		}
		if ($skill["experience"]==0.75){
			$experience_options.="<option value='0.75' selected>Over 6 months</option>";
		}else{
			$experience_options.="<option value='0.75'>Over 6 months</option>";
		}
		for($j=1;$j<12;$j++){
			if($j==1){
				$years="Year";
			}else{
				$years="Years";
			}
			if ($j!=11){
				$label = $j." ".$years;
			}else{
				$label = "More than 10 years";
			}
			if ($skill["experience"]==$j){
				$experience_options .= '<option value="'.$j.'" selected> '.$label.'</option>';
			}else{
				$experience_options .= '<option value="'.$j.'"> '.$label.'</option>';
			}
		}
			
		$skill_HTML .= '<tr>
			  <td align="left"><select class="skill-dropdown" name="tskill[]" id="tskill'.$i.'">'.
				str_replace('<option value="'.$skill['skill'].'" > '.$skill['skill'].'</option>',
				'<option value="'.$skill['skill'].'" selected > '.$skill['skill'].'</option>',
				$skills_options).
			  '</select></td>
			  <td align="left"><select class="prof-dropdown" name="tprof[]" id="tprof'.$i.'">'.
				str_replace('<option value="'.$skill['proficiency'].'" >',
				'<option value="'.$skill['proficiency'].'" selected >',
				$proficiency_options).
			  '</select></td>
			  <td align="left"><select class="exp-dropdown" name="texp[]" id="texp'.$i.'">'.
				str_replace('<option value="'.$skill['experience'].'" > ',
				'<option value="'.$skill['experience'].'" selected> ',
				$experience_options).
			  '</select></td>
			</tr>';
		$i++;
	}
//}


//if ($skills != NULL){
	
	while(count($admin_skills) < 5){
		array_push ($admin_skills,array());
	}

	$admin_skill_HTML = "";		
	$i = 1;
	foreach($admin_skills as $skill){	
		
		
		$experience_options="<option value='' >-</option>";
		
		if ($skill["experience"]==0.5){
			$experience_options.="<option value='0.5' selected>Less than 6 months</option>";
		}else{
			$experience_options.="<option value='0.5'>Less than 6 months</option>";
		}
		if ($skill["experience"]==0.75){
			$experience_options.="<option value='0.75' selected>Over 6 months</option>";
		}else{
			$experience_options.="<option value='0.75'>Over 6 months</option>";
		}
		for($j=1;$j<12;$j++){
			if($j==1){
				$years="Year";
			}else{
				$years="Years";
			}
			if ($j!=11){
				$label = $j." ".$years;
			}else{
				$label = "More than 10 years";
			}
			if ($skill["experience"]==$j){
				$experience_options .= '<option value="'.$j.'" selected> '.$label.'</option>';
			}else{
				$experience_options .= '<option value="'.$j.'"> '.$label.'</option>';
			}
		}
				
		
		
		$admin_skill_HTML .= '<tr>
			  <td align="left"><select class="skill-dropdown" name="askill[]" id="askill'.$i.'">'.
				str_replace('<option value="'.$skill['skill'].'" > '.$skill['skill'].'</option>',
				'<option value="'.$skill['skill'].'" selected > '.$skill['skill'].'</option>',
				$admin_skills_options).
			  '</select></td>
			  <td align="left"><select class="prof-dropdown" name="aprof[]" id="aprof'.$i.'">'.
				str_replace('<option value="'.$skill['proficiency'].'" > ',
				'<option value="'.$skill['proficiency'].'" selected > ',
				$proficiency_options).
			  '</select></td> 
			  <td align="left"><select class="exp-dropdown" name="aexp[]" id="aexp'.$i.'">'.
				$experience_options.
			  '</select></td>
			</tr>';
		$i++;
	}
//}



//right menus
$right_menus = RightMenus(5 , $userid);
$smarty->assign('right_menus' , $right_menus);
 
$smarty->assign('page' , basename($_SERVER['SCRIPT_FILENAME']));
$smarty->assign('userid' , $userid);
$smarty->assign('img_result',$img_result);
$smarty->assign('code',$code);
$smarty->assign('email',$email);

$smarty->assign('email',$email);

$smarty->assign('skills_options',$skills_options); 
$smarty->assign('admin_skills_options',$admin_skills_options); 
$smarty->assign('experience_options',$experience_options); 
$smarty->assign('proficiency_options',$proficiency_options); 
$smarty->assign('skill_HTML',$skill_HTML); 
$smarty->assign('admin_skill_HTML',$admin_skill_HTML); 
$smarty->assign("TEST", TEST);
header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); // Date in the past
header("Pragma: no-cache");
$smarty->display('registernow-step5-skills-details.tpl'); 



?>
