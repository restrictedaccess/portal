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



$userid=$_SESSION['userid'];
if($userid!="" or $userid!=NULL){
	
	$sql=$db->select()
		->from('language')
		->where('userid = ?' ,$userid);
	$rows = $db->fetchAll($sql);	
	
	$i=0;
	$languages = array();
	foreach ($rows as $row){
		$languages[$i]['language']=$row['language'];
		$languages[$i]['spoken']=$row['spoken'];
		$languages[$i]['written']=$row['written'];
		$i++;
	}
	
}


$language_options='<option value="" >-</option>'; 
$language_array=array("Arabic","Bahasa Indonesia","Bahasa Malaysia","Bengali","Chinese","Dutch","English","Filipino","French","German","Hebrew","Hindi","Italian","Japanese","Korean","Portuguese","Russian","Spanish","Tamil","Thai","Vietnamese");
for($i=0;$i<count($language_array);$i++){
	$language_options .= '<option value="'.$language_array[$i].'" >'.$language_array[$i].'</option>';
}

$spoken_options="";
for($i=0;$i<=10;$i++){
	$spoken_options .= '<option value="'.$i.'" >'.$i.'</option>';
}

$written_options="";
for($i=0;$i<=10;$i++){
	$written_options .= '<option value="'.$i.'" >'.$i.'</option>';
}


$language_HTML = "";
$languages = array();
if($languages != null){
	foreach($languages as $key=>$language){
		if($language['language'] == ''){
			unset($languages[$key]);
		}
	} 
}
array_push ($languages,array());

if($languages != NULL){
foreach($languages as $language){	
$language_HTML .= '	<table border="0" cellspacing="0" cellpadding="0" id="applyform">  
		<tr>
			<td width="200" align="right">Language:</td>
			<td width="300">
				<select name="language[]" id="language[]">';
$language_HTML .= str_replace('value="'.$language['language'].'"','value="'.$language['language'].'" selected ',$language_options);
$language_HTML .= '</select>
			</td>
		</tr>
		<tr>
			<td width="200" align="right">Spoken:</td>
			<td width="300">
				<select name="spoken[]" id="spoken[]">';
$language_HTML .= str_replace('value="'.$language['spoken'].'"','value="'.$language['spoken'].'" selected ',$spoken_options);
$language_HTML .= '</select>
			</td>
		</tr>
		<tr>
		  <td align="right">Written:</td>
		  <td>
			<select name="written[]" id="written[]">';
$language_HTML .= str_replace('value="'.$language['written'].'"','value="'.$language['written'].'" selected ',$written_options);
$language_HTML .= '</select>
		  </td>
		</tr>
	</table>
	<br>
	<br>';
}
}

//check if this form has already saved in the applicants_form
if($userid!=""){
	$sql = $db->select()
		->from('applicants_form')
		->where('userid = ?' ,$userid)
		->where('form = ?' , 6);
	$result = $db->fetchRow($sql);
	$form_id = $result['id'];
	$date_completed = $result['date_completed'];
	if($date_completed == "") {
		$status = "Not yet filled up";
	}else{
		$status = "Completed ".$date_completed;
	}	
	$smarty->assign('form_id',$form_id);
	
	$welcome = sprintf("Welcome ID%s %s %s<br>Step 6 Form status : %s " ,$userid ,$fname, $lname , $status);
	$smarty->assign('welcome',$welcome);
	
}

//right menus
$right_menus = RightMenus(6 , $userid);
$smarty->assign('right_menus' , $right_menus);

$smarty->assign('page' , basename($_SERVER['SCRIPT_FILENAME']));
$smarty->assign('userid' , $userid);
$smarty->assign('img_result',$img_result);
$smarty->assign('code',$code);
$smarty->assign('email',$email);

$smarty->assign('language_HTML',$language_HTML);
$smarty->assign("TEST", TEST);

header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); // Date in the past 
header("Pragma: no-cache");
$smarty->display('registernow-step6-languages-details.tpl');



?>
