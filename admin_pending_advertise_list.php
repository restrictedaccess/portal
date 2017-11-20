<?php
include './conf/zend_smarty_conf_root.php';
include 'category-management/ads-function.php';


$AusTime = date("H:i:s"); 
$AusDate = date("Y")."-".date("m")."-".date("d");
$ATZ = $AusDate." ".$AusTime;

if($_SESSION['admin_id'] == "" or $_SESSION['admin_id'] == NULL){
	header("location:index.php");
}

$available_status = 'NEW';

if(isset($_POST['allocate'])){
	
	for ($i = 0; $i < count($_POST['counter2']); ++$i){
		if($_POST['counter2'][$i]!=""){
			if($_POST['category_id2'][$i]!=""){
				//echo $_POST['category_id2'][$i]."<br>";
				if($_POST['category_id2'][$i]!="ARCHIVE"){
					$data = array('category_id' => $_POST['category_id2'][$i]);
					
					AddPostingHistoryChanges($data , $_POST['counter2'][$i], $_SESSION['admin_id'] , 'admin');
					
					$where = "id = ".$_POST['counter2'][$i];	
					$db->update('posting' ,  $data , $where);
				}else{
					$data = array('status' => 'ARCHIVE');
					
					AddPostingHistoryChanges($data , $_POST['counter2'][$i], $_SESSION['admin_id'] , 'admin');
					
					$where = "id = ".$_POST['counter2'][$i];	
					$db->update('posting' ,  $data , $where);
				}	
			}
		}
		
	
	}
	
	
}


if(isset($_POST['update'])){
     //echo 'here';exit;
	for ($i = 0; $i < count($_POST['counter']); ++$i){
		if($_POST['counter'][$i]!=""){
			
			if($_POST['status'][$i]!="" and $_POST['status'][$i] != $available_status){
				//status : update	
				$data = array('status' => $_POST['status'][$i]);
				
				//add history
				AddPostingHistoryChanges($data , $_POST['counter'][$i], $_SESSION['admin_id'] , 'admin');
				
				$where = "id = ".$_POST['counter'][$i];	
				$db->update('posting' ,  $data , $where);
				
				
				//update the lead marked
				check_unmarked_lead($_POST['counter'][$i]);		
				
				
			}
			if($_POST['show'][$i]!=""){
				//show_status : update	
				$data = array('show_status' => $_POST['show'][$i]);
				
				//add history
				AddPostingHistoryChanges($data , $_POST['counter'][$i], $_SESSION['admin_id'] , 'admin');
				
				$where = "id = ".$_POST['counter'][$i];	
				$db->update('posting' ,  $data , $where);
			}
			
			/*if($_POST['category_id'][$i]!=""){
				$data = array('category_id' => $_POST['category_id'][$i]);
				$where = "id = ".$_POST['counter'][$i];	
				$db->update('posting' ,  $data , $where);
			}
			*/
		}
	}	
}



function SetUpSelectElement($category_id){
	global $db;
	$sql = $db->select()
	->from('job_role_category');
	$categories = $db->fetchAll($sql);	
	foreach($categories as $category){
		$query = $db->select()
			->from('job_category')
			->where('job_role_category_id =?' , $category['jr_cat_id'])
			->where('status != ?','removed');
		$sub_cats = $db->fetchAll($query);
		
		$category_Options.="<OPTGROUP LABEL='".strtoupper($category['cat_name'])."'>";
		foreach($sub_cats as $sub_cat){
			if($category_id == $sub_cat['category_id']){
				$category_Options .="<option value='".$sub_cat['category_id']."' selected='selected'>".$sub_cat['category_name']."</option>";
			}else{
				$category_Options .="<option value='".$sub_cat['category_id']."' >".$sub_cat['category_name']."</option>";
			}
		
		}
		$category_Options.="</OPTGROUP><OPTGROUP>&nbsp;</OPTGROUP>";
		
	}
	return $category_Options;
}

function AdsStatus($status){
	global $db;
	$statuses = array('NEW' , 'ARCHIVE', 'ACTIVE');
	
	for($i=0; $i<count($statuses); $i++){
		if($status == $statuses[$i]){
			$status_Options .="<option value='".$statuses[$i]."' selected='selected'>".$statuses[$i]."</option>";
		}else{
			$status_Options .="<option value='".$statuses[$i]."'>".$statuses[$i]."</option>";
		}
	}
	return $status_Options;
}

function AdsShowStatus($status){
	global $db;
	$statuses = array('YES','NO');
	
	for($i=0; $i<count($statuses); $i++){
		if($status == $statuses[$i]){
			$show_status_Options .="<option value='".$statuses[$i]."' selected='selected'>".$statuses[$i]."</option>";
		}else{
			$show_status_Options .="<option value='".$statuses[$i]."'>".$statuses[$i]."</option>";
		}
	}
	return $show_status_Options;
	
}


//check the posting if there's no category_id detected
$sql = $db->select()
	->from(array('p' => 'posting') , Array('p.id' , 'companyname' , 'jobposition' , 'outsourcing_model' , 'date_created' , 'lead_id' , 'category_id' , 'status' ))
	->join(array('l' => 'leads'), 'l.id = p.lead_id' , Array('fname' ,'lname'))
	->where('p.status =?' ,$available_status);	
	
$result = $db->fetchAll($sql);	
$need_attention = 0;
foreach($result as $resulta){
	if($resulta['category_id'] == ""){
		$need_attention++;
	}
}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

<link rel=stylesheet type=text/css href="css/font.css">
<link rel=stylesheet type=text/css href="adminmenu.css">
<link rel=stylesheet type=text/css href="./leads_information/media/css/leads_information.css">
<link rel=stylesheet type=text/css href="category-management/media/css/category-management.css">
<script type="text/javascript" src="./js/MochiKit.js"></script>

<title>Remotestaff Advertisements</title></head>


<body style="background:#ffffff" text="#000000" topmargin="0" leftmargin="0" marginheight="0" marginwidth="0">
<form name="form" method="post" action="admin_pending_advertise_list.php">
<!-- HEADER -->
<!--
< ?php include 'header.php';? >
< ?php include 'admin_header_menu.php';? >
< ?php include 'admin-sub-tab.php';? >

-->

<table width="100%" cellpadding="0" cellspacing="0" border="0" >
<tr>
<!--
<td  align="left" style='border-right: #006699 2px solid; width: 170px; vertical-align:top; '>
 < ?  php include 'adminleftnav.php'; ?  >
</td>
-->
<td  valign='top' style="padding-top:10px;" >
<?php include 'admin-ads-tab.php'?>


<?php include 'advertisement-list.php';?>

</td>
</tr>
</table>
<!--< ?php include 'footer.php';?>-->
</form>
</body>
</html>
