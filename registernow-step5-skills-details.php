<?php 
include('conf/zend_smarty_conf.php');
include('inc/home_pages_link_for_template.php');
include ("inc/register-right-menu.php");
include './portal/lib/validEmail.php';
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



$userid=$_SESSION['userid'];
if($userid!="" or $userid!=NULL){
	
	$sql=$db->select()
		->from('skills')
		->where('userid = ?' ,$userid);
	$rows = $db->fetchAll($sql);	
	
	$i=0;
	$skills = array();
	foreach ($rows as $row){
		$skills[$i]['skill']=$row['skill'];
		$skills[$i]['experience']=$row['experience'];
		$skills[$i]['proficiency']=$row['proficiency'];
		$i++;
	}

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

$experience_options='<option value="" >-</option>';
for($i=1;$i<12;$i++){
	if($i==1){$years="Year";}
	else{$years="Years";}
	if($i==11){$i ="more than 10";}
	$experience_options .= '<option value="'.$i.'" > '.$i.' '.$years.'</option>';
	if($i=="more than 10"){$i = 11;} 
}

$proficiency_array = array('Advanced','Intermediate','Beginner');
$proficiency_options ='<option value="" >-</option>';
for($i=1;$i<=count($proficiency_array);$i++){
	$proficiency_options .= '<option value="'.$i.'" > '.$proficiency_array[$i-1].'</option>';
}


array_push ($skills,array());
$skill_HTML = "";		

foreach($skills as $skill){	

$skill_HTML .= '<table border="0" cellspacing="0" cellpadding="0" id="applyform">
		<tr>
			<td width="200" align="right" valign="top">Skill:</td>
			<td width="300"><textarea name="skill[]" cols="35" rows="3" id="skill[]">'.$skill['skill'].'</textarea></td>
		</tr>
	<tr>
		<td width="200" align="right">Years of Experience:</td>
		<td width="300">
			<select name="skill_exp[]" id="skill_exp[]">';
$skill_HTML .= str_replace('value="'.$skill['experience'].'"','value="'.$skill['experience'].'" selected ',$experience_options);
$skill_HTML .= '</select>
		</td>
	</tr>
	<tr>
		<td align="right">Proficiency:</td>
		<td>
			<select name="skill_proficiency[]" id="skill_proficiency[]">';
$skill_HTML .= str_replace('value="'.$skill['proficiency'].'"','value="'.$skill['proficiency'].'" selected ',$proficiency_options);
$skill_HTML .= '</select>  
		</td>
	</tr>
</table>
<br>
<br>'; 

}



//right menus
$right_menus = RightMenus(5 , $userid);
$smarty->assign('right_menus' , $right_menus);

$smarty->assign('page' , basename($_SERVER['SCRIPT_FILENAME']));
$smarty->assign('userid' , $userid);
$smarty->assign('img_result',$img_result);
$smarty->assign('code',$code);
$smarty->assign('email',$email);

$smarty->assign('skill_HTML',$skill_HTML); 

header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); // Date in the past
header("Pragma: no-cache");
$smarty->display('registernow-step5-skills-details.tpl');



?>
<?php 
include('conf/zend_smarty_conf.php');
include('inc/home_pages_link_for_template.php');
include ("inc/register-right-menu.php");
include './portal/lib/validEmail.php';
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



$userid=$_SESSION['userid'];
if($userid!="" or $userid!=NULL){
	
	$sql=$db->select()
		->from('personal')
		->where('userid = ?' ,$userid);
	$result = $db->fetchRow($sql);	
	$fname = $result['fname'];
	$lname=$result['lname'];
	$email = $result['email'];
	$bmonth= $result['bmonth'];
	$bday= $result['bday'];
	$byear= $result['byear'];
	$gender =$result['gender'];
	$identification = $result['auth_no_type_id'];
	$identification_number = $result['msia_new_ic_no'];
	$permanent_residence = $result['permanent_residence'];
	
		
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

//right menus
$right_menus = RightMenus(5 , $userid);
$smarty->assign('right_menus' , $right_menus);

$smarty->assign('page' , basename($_SERVER['SCRIPT_FILENAME']));
$smarty->assign('userid' , $userid);
$smarty->assign('img_result',$img_result);
$smarty->assign('code',$code);
$smarty->assign('email',$email);

header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); // Date in the past
header("Pragma: no-cache");
$smarty->display('registernow-step5-skills-details.tpl');



?>
