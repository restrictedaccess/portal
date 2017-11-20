<?php
include('conf/zend_smarty_conf.php');
include 'category-management/ads-function.php';


$AusTime = date("H:i:s"); 
$AusDate = date("Y")."-".date("m")."-".date("d");
$ATZ = $AusDate." ".$AusTime;


if($_SESSION['admin_id'] == "" or $_SESSION['admin_id'] == NULL){
	header("location:index.php");
}


$admin_id = $_SESSION['admin_id'];
$admin_status=$_SESSION['status'];

$id=$_REQUEST['id'];

if(isset($_POST['update'])){
	
	$lead_id = $_REQUEST['lead_id'];
	$category_id = $_REQUEST['category_id'];
	$outsourcing_model=$_REQUEST['outsourcing_model'];
	$companyname=$_REQUEST['companyname'];
	$jobposition=$_REQUEST['jobposition'];
	$jobvacancy_no=$_REQUEST['jobvacancy_no'];
	$heading = $_REQUEST['heading'];
	$status = $_REQUEST['status'];
	$show_status = $_REQUEST['show_status'];

	$date_created = $_REQUEST['date_created'];
	
	//check the date if NULL
	//$sql = $db->select()
	//	->from('posting' , 'date_created')
	//	->where('id =?' , $id);
	//$date_created = $db->fetchOne($sql);	
	//if(!$date_created){
	//	$date_created = $_REQUEST['date_created']." ".$AusTime;
	//}
	
	$posting = $db->fetchRow($db->select()->from(array("p"=>"posting"))->where("id = ?", $id));
	if ($status=="ACTIVE"&&$posting["status"]=="ARCHIVE"){
		$job_order_id = $posting["job_order_id"];
		$gs_jtd = $db->fetchRow($db->select()->from(array("gs_jtd"=>"gs_job_titles_details"))->where("gs_job_titles_details_id = ?", $job_order_id));
		if ($gs_jtd&&isset($gs_jtd["gs_job_role_selection_id"])&&$gs_jtd["gs_job_role_selection_id"]&&($gs_jtd["status"]=="finish"||$gs_jtd["status"]=="cancel")){
			$gs_jrs = $db->fetchRow($db->select()->from("gs_job_role_selection")->where("gs_job_role_selection_id = ?", $gs_jtd["gs_job_role_selection_id"]));
			if ($gs_jrs){
				include_once "function.php";
				unset($posting["id"]);
				$gs_jtd["date_filled_up"] = date("Y-m-d H:i:s");
				$gs_jtd["link_order_id"] = $gs_jtd["gs_job_titles_details_id"];
				$gs_jtd["service_type"] = "CUSTOM";
				$gs_jtd["date_closed"] = null;
				$gs_jtd["status"] = "new";
				unset($gs_jtd["gs_job_titles_details_id"]);
				$gs_jrs["date_created"] = date("Y-m-d H:i:s");
				$gs_jrs["status"] = "new";
				$gs_jrs["filled_up_by_id"] = $_SESSION["admin_id"];
				$gs_jrs["filled_up_by_type"] = "admin";
				$gs_jrs["filled_up_date"] = date("Y-m-d H:i:s");
				$gs_jrs["ran"] = get_rand_id();
				unset($gs_jrs["gs_job_role_selection_id"]);
				$db->insert("gs_job_role_selection", $gs_jrs);
				$gs_jtd["gs_job_role_selection_id"] = $db->lastInsertId("gs_job_role_selection");
				$db->insert("gs_job_titles_details", $gs_jtd);
				$posting["job_order_id"] = $db->lastInsertId("gs_job_titles_details");
				$db->insert	("posting", $posting);
				$id = $db->lastInsertId("posting");		
				
				
				
				
				
				
								
			}
		}else if ($gs_jtd["status"]=="onhold"||$gs_jtd["status"]=="cancel"||$gs_jtd["status"]=="finish"){
			$db->update("gs_job_titles_details", array("status"=>"new"), $db->quoteInto("gs_job_titles_details_id = ?", $gs_jtd["gs_job_titles_details_id"]));
		}
		
		
	}
	
	try{
		$retries = 0;
		while(true){
			try{
				if (TEST) {
					$mongo = new MongoClient(MONGODB_TEST);
					$database = $mongo -> selectDB('prod');
				} else {
					$mongo = new MongoClient(MONGODB_SERVER);
					$database = $mongo -> selectDB('prod');
				}	
				break;
			} catch(Exception $e){
				++$retries;
				
				if($retries >= 100){
					break;
				}
			}
		}
						
		
		$job_orders_collection = $database->selectCollection('job_orders');
		$db->delete("mongo_job_orders", $db->quoteInto("leads_id = ?", $lead_id));
		$job_orders_collection->remove(array("leads_id"=>$lead_id), array("justOne"=>false));	
	}catch(Exception $e){
		
	}
	if (TEST){
		file_get_contents("http://test.remotestaff.com.au/portal/cronjobs/sync_asl_no_job_category_to_mongo.php");
		file_get_contents("http://test.remotestaff.com.au/portal/cronjobs/sync_asl_via_job_category_to_mongo.php");
		file_get_contents("http://test.remotestaff.com.au/portal/cronjobs/sync_basic_custom_to_mongo.php");
		file_get_contents("http://test.remotestaff.com.au/portal/cronjobs/sync_merge_asl_no_job_category_to_mongo.php");
		file_get_contents("http://test.remotestaff.com.au/portal/cronjobs/sync_merge_asl_via_job_category_to_mongo.php");
		file_get_contents("http://test.remotestaff.com.au/portal/cronjobs/sync_merge_custom_to_mongo.php");
		
	}else{
		file_get_contents("http://sc.remotestaff.com.au/portal/cronjobs/sync_asl_no_job_category_to_mongo.php");
		file_get_contents("http://sc.remotestaff.com.au/portal/cronjobs/sync_asl_via_job_category_to_mongo.php");
		file_get_contents("http://sc.remotestaff.com.au/portal/cronjobs/sync_basic_custom_to_mongo.php");
		file_get_contents("http://sc.remotestaff.com.au/portal/cronjobs/sync_merge_asl_no_job_category_to_mongo.php");
		file_get_contents("http://sc.remotestaff.com.au/portal/cronjobs/sync_merge_asl_via_job_category_to_mongo.php");
		file_get_contents("http://sc.remotestaff.com.au/portal/cronjobs/sync_merge_custom_to_mongo.php");
		
	}

	
	

	$data = array(
			'lead_id' => $lead_id, 
			'category_id' => $category_id,
			'outsourcing_model' => $outsourcing_model, 
			'companyname' => $companyname, 
			'jobposition' => $jobposition, 
			'jobvacancy_no' => $jobvacancy_no, 
			'heading' => $heading,
			'status' => $status,
			'show_status' => $show_status,
			'date_created' => $date_created." ".$AusTime
			);
	//print_r($data);	die;
	
	AddPostingHistoryChanges($data , $id, $_SESSION['admin_id'] , 'admin');
	$where = "id = ".$id;	
	$db->update('posting' ,  $data , $where);	
	
	//update the lead marked
    check_unmarked_lead($id);
		
	//echo count($_POST['res_id']);exit;	
	if(count($_POST['res_id']) > 0){
		
		for($i=0 ; $i<count($_POST['res_id']); $i++ ){
			
			if($_POST['res_id'][$i]){
					//old record
					
					//Get the original content 
					$sql = $db->select()
							->from('posting_responsibility' , 'responsibility')
							->where('id =?' ,$_POST['res_id'][$i]);
					$responsibility = $db->fetchOne($sql); 
					
					//echo "- ".$_POST['res_id'][$i]." = [ORIG]".$responsibility."<br>";
					
					if($_POST['responsibility'][$i]){
							//check if it is NOT equal to the original content then update the record and Add history about this record
							if($_POST['responsibility'][$i] != $responsibility){
									$data = array('responsibility' => $_POST['responsibility'][$i]);
									$where = "id = ".$_POST['res_id'][$i];	
									$db->update('posting_responsibility' ,  $data , $where);
									
									//add history
									$history_changes = sprintf("UPDATED RESPONSIBILITY => FROM <i>%s</i> TO %s <br>", $responsibility , $_POST['responsibility'][$i] );
									$changes = array('posting_id' => $id,
												 'date_change' => $ATZ, 
												 'changes' => $history_changes, 
												 'change_by_id' => $_SESSION['admin_id'], 
												 'change_by_type' => 'admin');
									$db->insert('posting_history', $changes);	
							}
					
					}else{
						//if NULL delete this record. Means the user does not want to include this record in the Advertisement
						$where = "id = ".$_POST['res_id'][$i];	
						$db->delete('posting_responsibility' , $where);
						
						//add history
						$history_changes = sprintf("DELETED RESPONSIBILITY => <i>%s</i><br>", $responsibility);
						$changes = array('posting_id' => $id,
									 'date_change' => $ATZ, 
									 'changes' => $history_changes, 
									 'change_by_id' => $_SESSION['admin_id'], 
									 'change_by_type' => 'admin');
						$db->insert('posting_history', $changes);
						
					}
					
			}else{
					//new record has been added
					//check if NOT NULL
					if($_POST['responsibility'][$i]){
							$data =  array(
									'posting_id' => $id,
									'responsibility' => $_POST['responsibility'][$i]
									);
							$db->insert('posting_responsibility', $data);
							
							//add history
							$history_changes = sprintf("ADDED RESPONSIBILITY => %s<br>", $_POST['responsibility'][$i]);
							$changes = array('posting_id' => $id,
										 'date_change' => $ATZ, 
										 'changes' => $history_changes, 
										 'change_by_id' => $_SESSION['admin_id'], 
										 'change_by_type' => 'admin');
							$db->insert('posting_history', $changes);
					}
					
					
			}
			
		}
			
	
	}
	//exit;
	//REQUIREMENTS
		if(count($_POST['req_id']) > 0){
		
		for($i=0 ; $i<count($_POST['req_id']); $i++ ){
			
			if($_POST['req_id'][$i]){
					//old record
					
					//Get the original content 
					$sql = $db->select()
							->from('posting_requirement' , 'requirement')
							->where('id =?' ,$_POST['req_id'][$i]);
					$requirement = $db->fetchOne($sql); 
					
					//echo "- ".$_POST['req_id'][$i]." = [ORIG]".$requirement."<br>";
					
					if($_POST['requirement'][$i]){
							//check if it is NOT equal to the original content then update the record and Add history about this record
							if($_POST['requirement'][$i] != $requirement){
									$data = array('requirement' => $_POST['requirement'][$i]);
									$where = "id = ".$_POST['req_id'][$i];	
									$db->update('posting_requirement' ,  $data , $where);
									
									//add history
									$history_changes = sprintf("UPDATED REQUIREMENT => FROM <i>%s</i> TO %s <br>", $requirement , $_POST['requirement'][$i] );
									$changes = array('posting_id' => $id,
												 'date_change' => $ATZ, 
												 'changes' => $history_changes, 
												 'change_by_id' => $_SESSION['admin_id'], 
												 'change_by_type' => 'admin');
									$db->insert('posting_history', $changes);	
							}
					
					}else{
						//if NULL delete this record. Means the user does not want to include this record in the Advertisement
						$where = "id = ".$_POST['req_id'][$i];	
						$db->delete('posting_requirement' , $where);
						
						//add history
						$history_changes = sprintf("DELETED REQUIREMENT => <i>%s</i><br>", $requirement);
						$changes = array('posting_id' => $id,
									 'date_change' => $ATZ, 
									 'changes' => $history_changes, 
									 'change_by_id' => $_SESSION['admin_id'], 
									 'change_by_type' => 'admin');
						$db->insert('posting_history', $changes);
						
					}
					
			}else{
					//new record has been added
					//check if NOT NULL
					if($_POST['requirement'][$i]){
							$data =  array(
									'posting_id' => $id,
									'requirement' => $_POST['requirement'][$i]
									);
							$db->insert('posting_requirement', $data);
							
							//add history
							$history_changes = sprintf("ADDED REQUIREMENT => %s<br>", $_POST['requirement'][$i]);
							$changes = array('posting_id' => $id,
										 'date_change' => $ATZ, 
										 'changes' => $history_changes, 
										 'change_by_id' => $_SESSION['admin_id'], 
										 'change_by_type' => 'admin');
							$db->insert('posting_history', $changes);
					}
					
					
			}
			
		}
			
	
	}
	
	

	
	if(count($_POST['responsibility']) > 0){
		//delete the old responsibilities
		$where = "posting_id = ".$id;	
		$db->delete('posting_responsibility' ,$where);
	
		//insert new record	
		for ($i = 0; $i < count($_POST['responsibility']); ++$i)
		{
			if($_POST['responsibility'][$i]!="")
			{
				$data =  array(
						'posting_id' => $id,
						'responsibility' => $_POST['responsibility'][$i]
						);
				$db->insert('posting_responsibility', $data);
			}	
		}
		
		
		
	}
	
	if(count($_POST['requirement']) > 0){
		
		//delete the old requirements
		$where = "posting_id = ".$id;	
		$db->delete('posting_requirement' ,$where);
		
		for ($x = 0; $x < count($_POST['requirement']); ++$x)
		{
			if($_POST['requirement'][$x]!="")
			{
				$data =  array(
							'posting_id' => $id,
							'requirement' => $_POST['requirement'][$x]
							);
				$db->insert('posting_requirement', $data);
			}	
		}
	}
	
	
	
	$mess = "Updated successfully";
	echo '<script language="javascript">
				   alert("'.$mess.'");
				   location.href="admineditads.php?id='.$id.'";
				</script>';
}








if(!$id){
	die("Advertisement ID is missing!");
}





$sql = $db->select()
	->from('posting')
	->where('id =?' , $id);
$row = $db->fetchRow($sql);

$date_created = $row['date_created'];
//echo $date_created;
$outsourcing_model=$row['outsourcing_model'];
$companyname=$row['companyname'];
$jobposition=$row['jobposition'];
$jobvacancy_no=$row['jobvacancy_no'];
$lead_id =$row['lead_id'];
$status=$row['status'];
$show_status=$row['show_status'];
$heading=$row['heading'];
$category_id = $row['category_id'];

$sql = "SELECT DISTINCT l.id, l.lname, l.fname,l.email FROM leads l ORDER BY l.fname ASC;";
$result=$db->fetchAll($sql);
foreach($result as $result){
	 if ($lead_id==$result['id']){
	 	$usernameOptions .="<option selected value= ".$result['id'].">".$result['fname']." ".$result['lname']." [".$result['email']."]</option>";
	 }else{
	 	$usernameOptions .="<option value= ".$result['id'].">".$result['fname']." ".$result['lname']." [".$result['email']."]</option>";
	 }	
}


//SELECT * FROM job_role_category
//jr_cat_id, cat_name
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


$outsourcing_modelArray = array("Home Office","Office Location","Project Base");
//outsourcing_model
for($i=0; $i<count($outsourcing_modelArray);$i++){
	if($outsourcing_model == $outsourcing_modelArray[$i]){
		$outsourcing_modelOptions .="<option value='".$outsourcing_modelArray[$i]."' selected='selected'>".$outsourcing_modelArray[$i]."</option>";
	}else{
		$outsourcing_modelOptions .="<option value='".$outsourcing_modelArray[$i]."'>".$outsourcing_modelArray[$i]."</option>";
	}
}


$statuses = array('NEW' , 'ARCHIVE', 'ACTIVE');
for($i=0; $i<count($statuses); $i++){
	if($status == $statuses[$i]){
		$status_Options .="<option value='".$statuses[$i]."' selected='selected'>".$statuses[$i]."</option>";
	}else{
		$status_Options .="<option value='".$statuses[$i]."'>".$statuses[$i]."</option>";
	}
}

$statuses = array('YES','NO');
for($i=0; $i<count($statuses); $i++){
	if($show_status == $statuses[$i]){
		$show_status_Options .="<option value='".$statuses[$i]."' selected='selected'>".$statuses[$i]."</option>";
	}else{
		$show_status_Options .="<option value='".$statuses[$i]."'>".$statuses[$i]."</option>";
	}
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Remotestaff Advertisements</title>
<link rel=stylesheet type=text/css href="css/font.css">
<link rel=stylesheet type=text/css href="adminmenu.css">
<script type="text/javascript" src="./js/MochiKit.js"></script>
<script type="text/javascript" src="js/addrow-v2.js"></script>
<script language=javascript src="js/functions.js"></script>
<script src="./media/js/tinymce/jscripts/tiny_mce/tiny_mce.js"></script>
<link rel="stylesheet" href="./media/js/tinymce/jscripts/tiny_mce/themes/simple/skins/default/ui.css">
<script type="text/javascript" src="category-management/media/js/category-management.js"></script>
	
<script type="text/javascript" src="js/calendar.js"></script> 
<script type="text/javascript" src="lang/calendar-en.js"></script> 
<script type="text/javascript" src="js/calendar-setup.js"></script>
<link rel="stylesheet" type="text/css" media="all" href="css/calendar-blue.css" title="win2k-1" />
	
</head>


<body style="background:#ffffff" text="#000000" topmargin="0" leftmargin="0" marginheight="0" marginwidth="0">
<form name="form" method="post" action="admineditads.php?id=<?php echo $id;?>" onSubmit="return EditUpdatedAds()">
<input type="HIDDEN" name="id" value="<?php echo $id;?>">

<!-- HEADER -->

<table width=100% cellpadding=0 cellspacing=0 border=0 align=center><tr><td colspan=2 style='height: 1px;'>&nbsp;</td>
</tr>
<tr><td  align="left" style='border-right: #006699 2px solid; width: 170px; vertical-align:top; '>
<!-- <  ?php	include 'adminleftnav.php'; ? > -->
</td>
<td  valign=top >
<?php include 'admin-ads-tab.php'?>
<h2 align="center" style="text-decoration:underline;"><?php echo $jobposition;?></h2>
<?php if($mess){?>
<div style="background:#FFFF00; font-weight:bold; text-align:center; padding:5px;"><?php echo $mess;?></div>
<?php } ?>
<table width=100% border=0 cellspacing='1' cellpadding='3'>



<?php
if($date_created){
	$det = new DateTime($date_created);
	$date_created = $det->format("Y-m-d");
}
?>
 


  <tr>
    <td align="right">Date Created</td>
    <td style="color:#999999; font-weight:bold;">
	<input type="text" readonly name="date_created" id="date_created" value="<?php echo $date_created;?>"> <img align="absmiddle" src="images/calendar_ico.png"   id="bd" style="cursor: pointer; " title="Date selector" onMouseOver="this.style.background='red'" onMouseOut="this.style.background=''" />
<script type="text/javascript">
Calendar.setup({
   inputField     :    "date_created",     // id of the input field
	ifFormat       :    "%Y-%m-%d",      // format of the input field
	button         :    "bd",          // trigger for the calendar (button ID)
	align          :    "Tl",           // alignment (defaults to "Bl")
	showsTime	   :    false, 
	singleClick    :    true
});                     
 </script>
	<i>
	<?php  
		echo "Created by ".ShowCreatorName($row['agent_id'] , $row['created_by_type']);
	?></i>
	</td>
 </tr>


  <tr>
    <td align="right">Lead's Name </td>
    <td><select name="lead_id" class="select" id="lead_id" style="width:300px;" >
<option value="">-</option>
<?php echo $usernameOptions;?>
</select></td>
 </tr>
 
 
 
  <tr>
    <td align="right">Category</td>
    <td><select id="category_id" name="category_id" style="width:300px;">
      <option value="">Please Select</option>
      <?php echo $category_Options;?>
    </select> <span id="sub_cat"></span></td>
 </tr>
 <tr>
    <td align="right">Outsourcing Model</td>
    <td><select id="outsourcing_model" name="outsourcing_model" style="width:200px;">
	<option value="" selected="selected">Please Select</option>
	<?php echo $outsourcing_modelOptions;?>
	</select></td>
  </tr>
  <tr>
    <td align="right">Company :&nbsp;</td>
    <td><input type="text" name="companyname" value="<?php echo stripslashes($companyname);?>" size="50"></td>
  </tr>
	 
 <tr>
 <td colspan="3"> </td>
 </tr>
							   
  <tr>
    <td width="17%" align="right">Job Title Position :&nbsp;</td>
    <td width="83%" ><input type="text" name="jobposition" id="jobposition" value="<?php echo stripslashes($jobposition);?>" size="50">    </td>
  </tr>
   <td width="17%" align="right">Vancancy :&nbsp;</td>
    <td width="83%"><input type="text" name="jobvacancy_no" id="jobvacancy_no" value="<?php echo $jobvacancy_no;?>" size="3"></td>
  <tr>
    <td valign="top" align="right">Heading :</td>
    <td ><textarea name="heading" id="heading" wrap="physical" style="width:98%; height:200px;"><?php echo stripslashes($heading);?></textarea>
	<script type="text/javascript">
	<!--
	tinyMCE.execCommand("mceAddControl", true, 'heading')
	-->
	</script>
	</td>
  </tr>
  <tr>
    <td align="right">Status</td>
    <td><select id="status" name="status" style="width:100px;">
	<option value="" selected="selected">Please Select</option>
	<?php echo $status_Options;?>
	</select></td>
  </tr>
   <tr>
    <td align="right">Show Status</td>
    <td><select id="show_status" name="show_status" style="width:100px;">
	<option value="" selected="selected">Please Select</option>
	<?php echo $show_status_Options;?>
	</select></td>
  </tr>
   
  <tr bgcolor="#DEE5EB"><td><b>Responsibilities</b></td>
    <td>&nbsp;</td>
  </tr>
  <tr >
   <td align="right"></td>
   <td width="25%">
  		 <table width="100%" border="0" cellpadding="2" cellspacing="2">
<?php
$sql = $db->select()
	->from('posting_responsibility')
	->where('posting_id =?' ,$id);
$responsibilities = $db->fetchAll($sql);	

if(count($responsibilities)>0)
{
	$i=0;
	foreach($responsibilities as $responsibility){
		
		$responsibility_str = $responsibility['responsibility'];
	
?>
 <tr class="row_to_clone">
 <td width="2%" align="right"><img src="images/box.gif"></td>
 <td width="98%" align="left">
 <input type="hidden" size="2"  value="<?php echo $responsibility['id'];?>" name="res_id[<?php echo $i;?>]" />
 <input name="responsibility[<?php echo $i;?>]" type="text" class="text" style="width:98%;" value="<?php echo stripslashes($responsibility_str);?>"  /></td>
 </tr>
<?php
	$i++;
	}
}else{
?>
 <tr class="row_to_clone">
 <td width="2%" align="right"><img src="images/box.gif"></td>
 <td width="98%" align="left"><input name="responsibility[0]" type="text" class="text" style="width:98%;" /></td>
 </tr>

<?php
}
?>		 
    	</table>
   <div  ><input name="" type="button" value="Add More "  onclick="addRow(); return false;"/></div>
     </td>
   </tr>
 <!-- row 2 -->
  <tr bgcolor="#DEE5EB"><td><b>Requirements</b></td>
    <td>&nbsp;</td>
  </tr>
  <tr >
   <td align="right"></td>
   <td width="25%">
  		 <table width="100%" border="0" cellpadding="2" cellspacing="2">
<?php
$sql = $db->select()
	->from('posting_requirement')
	->where('posting_id =?' , $id);
$requirements = $db->fetchAll($sql);
if(count($requirements)>0)
{
	$i=0;
	foreach($requirements as $requirement){
		$requirement_str = $requirement['requirement'];
?>
  		 <tr class="row_to_clone2">
	     <td width="2%" align="right"><img src="images/box.gif"></td>
    	 <td width="98%" align="left">
		  <input type="hidden" size="2"  value="<?php echo $requirement['id'];?>" name="req_id[<?php echo $i;?>]" />
		 <input name="requirement[<?php echo $i;?>]" type="text" class="text" style="width:98%;" value="<?php echo stripslashes($requirement_str);?>"  /></td>
    	 </tr>
<?php
	$i++;
	}
}else{
?>
 <tr class="row_to_clone2">
 <td width="2%" align="right"><img src="images/box.gif"></td>
 <td width="98%" align="left"><input name="requirement[0]" type="text" class="text" style="width:98%;" /></td>
 </tr>

<?php
}
?>		
    	</table>
   <div  ><input name="" type="button" value="Add More "  onclick="addRow2(); return false;"/></div>
     </td>
   </tr>
<tr><td colspan="2"><input type="submit" name="update" value="Update"><input type="reset" value="Cancel"></td>
   
  </tr>
  <?php
  $history_changes = ShowAdsHistory($id);
  if($history_changes) {
  ?>
  <tr><td colspan="2" bgcolor="#FFFFCC" >
  <div style="font-size:12px; border:#333333 solid 1px;">
  <div style="padding:3px; background:#333333; color:#FFFFFF; font-weight:bold;">ADVERTISEMENT CHANGES</div>
  <?php echo $history_changes;?>
  </div>
  </td></tr>
  <?php }?>
</table>


		</td></tr>
</table>
<!-- < ?php include 'footer.php';?>-->
</form>
</body>
</html>
