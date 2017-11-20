<?php 
include('conf/zend_smarty_conf.php');
include('inc/home_pages_link_for_template.php');
include ("inc/register-right-menu.php");
include './portal/lib/validEmail.php';
$smarty = new Smarty();
$img_result = ShowActiveInactiveImages(LOCATION_ID);

function generatePositionExperienceOptions($position_exp,$name){
	if($position_exp=="Yes"){
		$is_yes_checked="checked='checked'"; 
		$is_no_checked="";	
	}
	else{
		$is_yes_checked="";
		$is_no_checked="checked='checked'";
	}
	return '<input type="radio" name="'.$name.'"  id="'.$name.'" value="Yes" '.$is_yes_checked.' /> yes  
	<input type="radio" name="'.$name.'"  id="'.$name.'" value="No" '.$is_no_checked.' /> no ';
}

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
		->from('currentjob')
		->where('userid = ?' ,$userid);
	$result = $db->fetchRow($sql);	
	
	$freshgrad = $result['freshgrad'];
	$intern_status = $result['intern_status'];
	$years_worked = $result['years_worked'];
	$months_worked = $result['months_worked'];
	$expected_salary_neg = $result['expected_salary_neg'];
	$expected_salary = $result['expected_salary'];
	$salary_currency = $result['$salary_currency'];
	$latest_job_title = $result['latest_job_title'];
	$position_first_choice = $result['position_first_choice'];
	$position_first_choice_exp = $result['position_first_choice_exp'];
	$position_second_choice = $result['position_second_choice'];
	$position_second_choice_exp = $result['position_second_choice_exp'];
	$position_third_choice = $result['position_third_choice'];
	$position_third_choice_exp = $result['position_third_choice_exp'];
	
}

	$still_studying_selected="";
	$fresh_graduate_selected="";
	$experienced_selected="";
	$selected="checked='checked'";
	
	
	if($freshgrad=="1"){
		$fresh_graduate_selected=$selected;
		$years_worked="";
		$months_worked="";
	}
	else{
		if($intern_status=="1"){
			$still_studying_selected=$selected;
			$years_worked="";
			$months_worked="";
		}
		else $experienced_selected=$selected;
	}
	
	$years_worked_options="";
	for($i=0;$i<=16;$i++){
		if($years_worked==$i)$years_worked_options.="<option value='".$i."' selected >".$i."</option>";
		else $years_worked_options.="<option value='".$i."' >".$i."</option>";
	}
	
	$months_worked_options="";
	for($i=0;$i<=11;$i++){
		if($months_worked==$i)$months_worked_options.="<option value='".$i."' selected >".$i."</option>";
		else $months_worked_options.="<option value='".$i."' >".$i."</option>";
	}
	
	if($expected_salary_neg=="Yes")$is_negotiable=$selected;
	
	$salary_currency_array=array("Australian Dollar","Bangladeshi Taka","British Pound","Chinese RenMinBi","Euro","HongKong Dollar","Indian Rupees","Indonesian Rupiah","Japanese Yen","Malaysian Ringgit","New Zealand Dollar","Philippine Peso","Singapore Dollar","Thai Baht","US Dollars","Vietnam Dong");
	$salary_currency_options="";
	for($i=0;$i<count($salary_currency_array);$i++){
		if($salary_currency_array[$i]==$salary_currency)$salary_currency_options.="<option value='".$salary_currency_array[$i]."' selected >".$salary_currency_array[$i]."</option>";
		else $salary_currency_options.="<option value='".$salary_currency_array[$i]."' >".$salary_currency_array[$i]."</option>";
	}
	
	$position_first_choice_options="";
	$position_second_choice_options="";
	$position_third_choice_options="";
	$position_array=array("Graphic Designer","Internet Marketer","Telemarketer","Writers","Accountant/Bookkeeper","Virtual Assistant","General Support /Service","Developer/Coder /Server","Networking Technicians / Engineers","Technical Support","Architecture","Engineering");
	for($i=0;$i<count($position_array);$i++){
		if($position_array[$i]==$position_first_choice)
			$position_first_choice_options.="<option value='".$position_array[$i]."' selected >".$position_array[$i]."</option>";
		else $position_first_choice_options.="<option value='".$position_array[$i]."' >".$position_array[$i]."</option>";
		
		if($position_array[$i]==$position_second_choice)
			$position_second_choice_options.="<option value='".$position_array[$i]."' selected >".$position_array[$i]."</option>";
		else $position_second_choice_options.="<option value='".$position_array[$i]."' >".$position_array[$i]."</option>";
		
		if($position_array[$i]==$position_third_choice)
			$position_third_choice_options.="<option value='".$position_array[$i]."' selected >".$position_array[$i]."</option>";
		else $position_third_choice_options.="<option value='".$position_array[$i]."' >".$position_array[$i]."</option>";
	}
	
	
	
	$position_first_choice_exp_options = generatePositionExperienceOptions($position_first_choice_exp,"position_first_choice_exp");
	$position_second_choice_exp_options = generatePositionExperienceOptions($position_second_choice_exp,"position_second_choice_exp");
	$position_third_choice_exp_options = generatePositionExperienceOptions($position_third_choice_exp,"position_third_choice_exp");
	
	
	$month_options = '<option value="JAN">JAN </option>
		<option value="FEB">FEB </option> 
		<option selected="selected" value="MAR">MAR </option>
		<option value="APR">APR </option>
		<option value="MAY">MAY </option>
		<option value="JUN">JUN </option>
		<option value="JUL">JUL </option> 
		<option value="AUG">AUG </option>
		<option value="SEP">SEP </option>
		<option value="OCT">OCT </option>
		<option value="NOV">NOV </option>
		<option value="DEC">DEC </option>';
	
	$year_options = "";
	for($i=$current_year;$i>=1950;$i--){
		$year_options .= '<option value="'.$i.'">'.$i.'</option>';
	}
	
	$history=array(); 
	for($i=0;$i<=10;$i++){
		if($i==0)$suffix="";
		else $suffix=$i+1;		
		if($result['companyname'.$suffix]!=""){ 
			$history[$i]['companyname']=$result['companyname'.$suffix];
			$history[$i]['position']=$result['position'.$suffix];
			$history[$i]['monthfrom']=$result['monthfrom'.$suffix];
			$history[$i]['yearfrom']=$result['yearfrom'.$suffix];
			$history[$i]['monthto']=$result['monthto'.$suffix];
			$history[$i]['yearto']=$result['yearto'.$suffix];
			$history[$i]['duties']=$result['duties'.$suffix];  
		}
		else break;
	}
	
	$current_year = date('Y');

$month_options = '<option value="JAN">JAN </option>
    <option value="FEB">FEB </option> 
    <option value="MAR">MAR </option>
    <option value="APR">APR </option>
    <option value="MAY">MAY </option>
    <option value="JUN">JUN </option>
    <option value="JUL">JUL </option> 
    <option value="AUG">AUG </option>
    <option value="SEP">SEP </option>
    <option value="OCT">OCT </option>
    <option value="NOV">NOV </option>
    <option value="DEC">DEC </option>';
	
$year_options = "";
for($i=$current_year;$i>=1950;$i--){
	$year_options .= '<option value="'.$i.'">'.$i.'</option>';
}
	
$histories=$history;
array_push ($histories,array());
$history_HTML="";		
$i=0;
foreach($histories as $history){	
	$history_HTML .= '<table width="500" border="0" cellspacing="0" cellpadding="0" id="applyform">
	<tr>
	<td width="200" align="right">Company Name:</td>
	<td width="300"><input name="history_company_name[]" type="text" id="history_company_name" value="'.$history['companyname'].'" size="35" /></td>
	</tr>
	<tr>
	  <td align="right">Position Title:</td>
	  <td><input name="history_position[]" type="text" id="history_position" value="'.$history['position'].'" size="35" /></td>
	</tr>
	<tr>
	  <td align="right">Employment Period</td>
	  <td>
		<select name="history_monthfrom[]"> ';
	$history_HTML .= str_replace('value="'.$history['monthfrom'].'"','value="'.$history['monthfrom'].'" selected ',$month_options);
	$history_HTML .= '</select>
		<select name="history_yearfrom[]" >';
	$history_HTML .= str_replace('value="'.$history['yearfrom'].'"','value="'.$history['yearfrom'].'" selected ',$year_options);  
	$history_HTML .= '</select> to 
		<select name="history_monthto[]" >';
	if($i==0){
		if($history['monthto']=='Present') $history_HTML .= '<option value="Present" selected > Present </option>';
		else $history_HTML .= '<option value="Present"> Present </option>';
	}
	$history_HTML .= str_replace('value="'.$history['monthto'].'"','value="'.$history['monthto'].'" selected ',$month_options);
	$history_HTML .= '    </select>
		<select name="history_yearto[]" >';
	if($i==0){
		if($history['yearto']=='Present') $history_HTML .= '<option value="Present" selected > Present </option>';
		else $history_HTML .= '<option value="Present"> Present </option>';
	}
	$history_HTML .= str_replace('value="'.$history['yearto'].'"','value="'.$history['yearto'].'" selected ',$year_options);
	$history_HTML .= '</select>
	</td>
	</tr>
	<tr>
	  <td align="right" valign="top">Responsibilities Achievement</td>
	  <td><textarea name="history_responsibilities[]" cols="35" rows="7" id="textfield4">'.$history['duties'].'</textarea></td>
	</tr>
	</table>';
	$i++;
}

	
//check if this form has already saved in the applicants_form
if($userid!=""){
	$sql = $db->select()
		->from('applicants_form')
		->where('userid = ?' ,$userid)
		->where('form = ?' , 4);
	$result = $db->fetchRow($sql);
	$form_id = $result['id'];
	$date_completed = $result['date_completed'];
	if($date_completed == "") {
		$status = "Not yet filled up";
	}else{
		$status = "Completed ".$date_completed;
	}	
	$smarty->assign('form_id',$form_id);
	
	$welcome = sprintf("Welcome ID%s %s %s<br>Step 4 Form status : %s " ,$userid ,$fname, $lname , $status);
	$smarty->assign('welcome',$welcome); 
	
}


//right menus
$right_menus = RightMenus(4 , $userid);
$smarty->assign('right_menus' , $right_menus);

$smarty->assign('page' , basename($_SERVER['SCRIPT_FILENAME']));
$smarty->assign('userid' , $userid);
$smarty->assign('img_result',$img_result);
$smarty->assign('code',$code);
$smarty->assign('email',$email);

$smarty->assign('still_studying_selected' , $still_studying_selected);
$smarty->assign('fresh_graduate_selected',$fresh_graduate_selected);
$smarty->assign('experienced_selected',$experienced_selected);
$smarty->assign('years_worked_options',$years_worked_options);
$smarty->assign('months_worked_options',$months_worked_options);
$smarty->assign('is_negotiable',$is_negotiable);
$smarty->assign('expected_salary',$expected_salary);
$smarty->assign('salary_currency_options',$salary_currency_options);
$smarty->assign('latest_job_title',$latest_job_title);

$smarty->assign('position_first_choice_options',$position_first_choice_options);
$smarty->assign('position_second_choice_options',$position_second_choice_options);
$smarty->assign('position_third_choice_options',$position_third_choice_options);  

$smarty->assign('position_first_choice_exp_options',$position_first_choice_exp_options);
$smarty->assign('position_second_choice_exp_options',$position_second_choice_exp_options);
$smarty->assign('position_third_choice_exp_options',$position_third_choice_exp_options);  

$smarty->assign('history_HTML',$history_HTML);

header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); // Date in the past
header("Pragma: no-cache");
$smarty->display('registernow-step4-work-history-details.tpl');



?>
