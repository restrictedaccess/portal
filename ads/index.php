<?php 
// CREATE & VIEW
include('../conf/zend_smarty_conf.php');
include('../function.php');
header("Expires: Mon, 26 Jul 1997 05:00:00GMT");
header("Cache-Control: no-cache");
header("Pragma: no-cache");
$smarty = new Smarty;



if($_SESSION['agent_no'] !="" or $_SESSION['agent_no'] != NULL){
	
	$created_by_id = $_SESSION['agent_no'];
	$created_by_type = 'agent';
	

}else if($_SESSION['admin_id'] !="" or $_SESSION['admin_id'] != NULL){

	$created_by_id = $_SESSION['admin_id'];
	$created_by_type = 'admin';

}else{
	die("Session expires. Please re-login");
}

$id = $_GET["id"];
if ($id){
    $job_order_id = $db->fetchOne($db->select()->from("posting", array("job_order_id"))->where("id = ?", $id));
    if ($job_order_id){
        header("Location:/portal/ads/?gs_job_titles_details_id=".$job_order_id."&mode=edit&source=rs");
        die;   
    }    
}

$mode = $_REQUEST['mode'];
if(!$mode){
	$mode = 'view';
}
$source = $_REQUEST['source'];
//update via job order 
$gs_job_titles_details_id = $_REQUEST['gs_job_titles_details_id']; // reference gs_job_titles_details.gs_job_titles_details_id		
	
if ($mode=="edit"&&$source=="rs"&&$gs_job_titles_details_id){
	
	$sql = $db->select()
			->from('gs_job_titles_details')
			->where('gs_job_titles_details_id =?' , $gs_job_titles_details_id);
		$job_title = $db->fetchRow($sql);	
		
	//gs_job_titles_credentials_id, gs_job_titles_details_id, gs_job_role_selection_id, description, rating, box, div
	$sql= $db->select()
		->from('gs_job_titles_credentials')
		->where('gs_job_titles_details_id =?' , $gs_job_titles_details_id);
	$job_title_details = $db->fetchAll($sql);	
	
	$sql = $db->select()
		->from('gs_job_role_selection' , 'leads_id')
		->where('gs_job_role_selection_id=?' ,$job_title['gs_job_role_selection_id']);
	$leads_id = $db->fetchOne($sql);
	
	
	$sql = $db->select()
		->from('leads')
		->where('id =?' , $leads_id);
	$lead = $db->fetchRow($sql);
	
	//get the existing posting_id
	$ad = $db->fetchRow($db->select()->from("posting")->where("job_order_id = ?", $gs_job_titles_details_id));
	$posting_id = $ad["id"];
	$category_id = $ad["category_id"];
	$outsourcing_model = $ad["outsourcing_model"];
	$status = $ad["status"];
	$show_status = $ad["show_status"];
	$heading = $ad["heading"];
	
	$jr_cat_id = $job_title['jr_cat_id'];
	$working_timezone = $job_title['working_timezone'];
	
	if($working_timezone == "localtime"){
		$working_timezone = "Australia/Sydney";
	}	
		
	
	$heading = $job_title['level']." level. ".$job_title['work_status']." ".$working_timezone." timezone  ".setConvertTimezones($working_timezone, $working_timezone , $job_title['start_work'], $job_title['finish_work']);
	
	
	
	//,system  ,database  , pc_products , app_programming , multimedia , open_source
	$requirements = array();
	$responsibilities = array();
	
	foreach($job_title_details as $detail){
		if (trim($detail["description"])==""){
			continue;
		}
		
		if ($detail["box"]=="responsibility"||$detail["box"]=="tasks"){
			if ($detail["box"]=="tasks"){
				try{
					
					$item = $db->fetchOne($db->select()->from("job_position_skills_tasks", array("value"))->where("id = ?", $detail["description"]));	
					
					if (!in_array($item, $responsibilities)){
						$responsibilities[] = $item;
					}
				}catch(Exception $e){
					
				}
			}else{
				
				if (!in_array( trim($detail["description"]), $responsibilities)){
					$responsibilities[] = trim($detail["description"]);
				}
				
			}
		}else{
			if ($detail["box"]=="skills"){
				try{
					$item = $db->fetchOne($db->select()->from("job_position_skills_tasks", array("value"))->where("id = ?", $detail["description"]));					
					if (!in_array($item, $requirements)){
						$requirements[] = $item;
					}
				}catch(Exception $e){
					
				}
			}else{
				$not_to_display = array("onshore", "staff_phone", "comments", "campaign_type", "call_type", "q1", "q2", "q3", "q4", "telemarketer_hrs", "lead_generation", "writer_type", "require_graphic", "staff_provide_training", "staff_make_calls", "staff_first_time", "staff_report_directly", "increase_demand", "replacement_post", "support_current", "experiment_role", "meet_new","special_instruction");
			
				if (!in_array($detail["box"], $not_to_display)){
					if (!in_array( trim($detail["description"]), $requirements)){
						$requirements[] = trim($detail["description"]);
					}
					
				}
				
			}
		}
		
	}
	
	$smarty->assign('requirements' , $requirements);
	$smarty->assign('responsibilities' , $responsibilities);
	
	$smarty->assign("edit_by_js", true);
	$smarty->assign("id", $posting_id);
	
	
	$smarty->assign('body_attributes', 'bgcolor="#FFFFFF" style="font-size:14px; font-family:Arial, Helvetica, sans-serif; margin:0px;"');
	
}


if($mode == 'create'){
	$source = $_REQUEST['source']; // reference where we can get the data . Value can be 'rs' [Recruitment Service] or 'asl' [Available Staff List]
	
	$gs_job_titles_details_id = $_REQUEST['gs_job_titles_details_id']; // reference gs_job_titles_details.gs_job_titles_details_id		
	
	
	
	
	//rs
	if($source == 'rs'){
	
		
		
		//get the data from table gs_job_titles_details
		if(!$gs_job_titles_details_id){
			die("Reference ID of Job Order details is missing");
		}
		
		//check if $gs_job_titles_details_id is already existing in the posting table proceed if not
		//id, agent_id, created_by_type, lead_id, category_id, date_created, outsourcing_model, companyname, jobposition, jobvacancy_no, skill, responsibility, status, heading, show_status, job_order_id, job_order_source
		$sql = $db->select()
			->from('posting' , 'id')
			->where('job_order_id =?' , $gs_job_titles_details_id )
			->where('job_order_source =?' , 'rs');
		$id = $db->fetchOne($sql);	
		
		//existing no need to create one
		if($id){
			header("location:./?id=$id&mode=view&mess=2");	
			exit;
		}
		
		
		$sql = $db->select()
			->from('gs_job_titles_details')
			->where('gs_job_titles_details_id =?' , $_REQUEST["gs_job_titles_details_id"]);
			
		$job_title = $db->fetchRow($sql);	
		
		//gs_job_titles_credentials_id, gs_job_titles_details_id, gs_job_role_selection_id, description, rating, box, div
		$sql= $db->select()
			->from('gs_job_titles_credentials')
			->where('gs_job_titles_details_id =?' , $gs_job_titles_details_id);
		$job_title_details = $db->fetchAll($sql);	
		$sql = $db->select()
			->from('gs_job_role_selection' , 'leads_id')
			->where('gs_job_role_selection_id=?' ,$job_title['gs_job_role_selection_id']);
		$leads_id = $db->fetchOne($sql);
		
		
		$sql = $db->select()
			->from('leads')
			->where('id =?' , $leads_id);
		$lead = $db->fetchRow($sql);
		
		
		
		$jr_cat_id = $job_title['jr_cat_id'];
		$working_timezone = $job_title['working_timezone'];
		
		if($working_timezone == "localtime"){
			$working_timezone = "Australia/Sydney";
		}	
			
		
		$heading = $job_title['level']." level. ".$job_title['work_status']." ".$working_timezone." timezone  ".setConvertTimezones($working_timezone, $working_timezone , $job_title['start_work'], $job_title['finish_work']);
		
		
		
		//,system  ,database  , pc_products , app_programming , multimedia , open_source
		$requirements = array();
		$responsibilities = array();
		
		foreach($job_title_details as $detail){
			if (trim($detail["description"])==""){
				continue;
			}
			
			if ($detail["box"]=="responsibility"||$detail["box"]=="tasks"){
				if ($detail["box"]=="tasks"){
					try{
						
						$item = $db->fetchOne($db->select()->from("job_position_skills_tasks", array("value"))->where("id = ?", $detail["description"]));	
						
						if (!in_array($item, $responsibilities)){
							$responsibilities[] = $item;
						}
					}catch(Exception $e){
						
					}
				}else{
					
					if (!in_array( trim($detail["description"]), $responsibilities)){
						$responsibilities[] = trim($detail["description"]);
					}
					
				}
			}else{
				if ($detail["box"]=="skills"){
					try{
						$item = $db->fetchOne($db->select()->from("job_position_skills_tasks", array("value"))->where("id = ?", $detail["description"]));					
						if (!in_array($item, $requirements)){
							$requirements[] = $item;
						}
					}catch(Exception $e){
						
					}
				}else{
					$not_to_display = array("onshore", "staff_phone", "comments", "campaign_type", "call_type", "q1", "q2", "q3", "q4", "telemarketer_hrs", "lead_generation", "writer_type", "require_graphic", "staff_provide_training", "staff_make_calls", "staff_first_time", "staff_report_directly", "increase_demand", "replacement_post", "support_current", "experiment_role", "meet_new","special_instruction");
			
					if (!in_array($detail["box"], $not_to_display)){
						if (!in_array( trim($detail["description"]), $requirements)){
							$requirements[] = trim($detail["description"]);
						}
						
					}
					
				}
			}
			
		}
		
		$smarty->assign('requirements' , $requirements);
		$smarty->assign('responsibilities' , $responsibilities);
		
		
	}
	//end rs 
	
		$smarty->assign('body_attributes', 'bgcolor="#FFFFFF" style="font-size:14px; font-family:Arial, Helvetica, sans-serif; margin:0px;"');

}





$id = $_REQUEST['id'];
$mess = $_REQUEST['mess'];

if(($mode == 'view' or $mode == 'edit' )&&$id){

		//view and edit mode of advertisement
		if(!$id){
			die("Advertisement ID is missing.");
		}
		$sql = $db->select()
			->from('posting')
			->where('id =?' ,$id);
		$ad = $db->fetchRow($sql);	
		
		
		if($ad['category_id']){
			$sql = $db->select()
				->from(array('s' => 'job_category') , Array('category_name'))
				->join(array('c' => 'job_role_category') , 's.job_role_category_id = c.jr_cat_id' , Array('cat_name'))
				->where('category_id =?' , $ad['category_id']);
			$category_results = $db->fetchRow($sql);
			$smarty->assign('category_results' , $category_results);
		}	
		
		$det = new DateTime($ad['date_created']);
		$date_created = $det->format("F j, Y");
		
		
		if($ad['lead_id']){
			$sql = $db->select()
				->from('leads' , Array('fname','lname'))
				->where('id =?' , $ad['lead_id']);
			$lead = $db->fetchRow($sql);
			$smarty->assign('lead' , $lead);	
		}	
		
		$sql = $db->select()
			->from('posting_requirement' , 'requirement')
			->where('posting_id = ?' , $id);
		$requirements = $db->fetchAll($sql);		
		
		
		$sql = $db->select()
			->from('posting_responsibility' , 'responsibility')
			->where('posting_id = ?' , $id);
		$responsibilities = $db->fetchAll($sql);	
		
		if (!empty($responsibilities)){
			foreach($responsibilities as $key=>$responsibility){
				$responsibilities[$key]["on_ad"] = true;
			}
		}
		
		if ($ad){
			$sql= $db->select()
				->from('gs_job_titles_credentials')
				->where('gs_job_titles_details_id =?' , $ad["job_order_id"]);
			$job_title_details = $db->fetchAll($sql);	
		}else{
			$job_title_details = array();
		}

		
		if (!empty($job_title_details)){
			$to_add = array();	
			
			
			foreach($job_title_details as $job_title_detail){
				$responsibility = array();
				$responsibility["responsibility"] = $job_title_detail["description"];
				$responsibility["on_ad"] = false;
				
				foreach($responsibilities as $key=>$item){
					$resp1 = $item["responsibility"];
					$resp2 = $responsibility["responsibility"];
					similar_text($resp1,$resp2,$percent);
					if ($percent<70){
					//	$to_add[] = $responsibility;	
					}
				}
			}
			
			if (!empty($to_add)){
				foreach($to_add as $key=>$responsibility){
					$responsibilities[] = $responsibility;
				}
			}
		}
		
		
		$category_id = $ad['category_id'];
		$outsourcing_model = $ad['outsourcing_model'];
		
		$status = $ad['status'];
		$show_status = $ad['show_status'];
		
		$smarty->assign('requirements_count' , count($requirements));
		$smarty->assign('requirements' , $requirements);				
		
		
		$smarty->assign('responsibility_count' , count($responsibilities));
		$smarty->assign('responsibilities' , $responsibilities);				
		
		$smarty->assign('id' , $id);			
		$smarty->assign('date_created' , $date_created);
		$smarty->assign('ad' , $ad);
	
		
}

if($mode == 'view'){

$smarty->assign('body_attributes', 'bgcolor="#FFFFFF" background="../images/sample4abg.jpg" style="font-size:14px; font-family:Arial, Helvetica, sans-serif; margin:0px;"');

}

if($mode == 'edit'){
$smarty->assign('body_attributes', 'bgcolor="#FFFFFF" style="font-size:14px; font-family:Arial, Helvetica, sans-serif; margin:0px;"');
}

if($mess == 1){
	$smarty->assign('added_flag' , True);
}

if($mess == 2){
	$smarty->assign('existing_flag' , True);
}

if($mess == 3){
	$smarty->assign('updated_flag' , True);
}




//echo $category_id;

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

if ($gs_job_titles_details_id){
	$_SESSION["gs_job_titles_details_id"] = $_REQUEST["gs_job_titles_details_id"];
}

//echo $leads_id;
$smarty->assign('heading' , $heading);

$smarty->assign('jr_cat_id' , $jr_cat_id);
$smarty->assign('leads_id',$leads_id);
$smarty->assign('lead' , $lead);			
$smarty->assign('category_Options',$category_Options);		
$smarty->assign('outsourcing_modelOptions',$outsourcing_modelOptions);		
$smarty->assign('status_Options',$status_Options);		
$smarty->assign('show_status_Options',$show_status_Options);		

$smarty->assign('gs_job_titles_details_id',$gs_job_titles_details_id);	
$smarty->assign('job_title',$job_title);
$smarty->assign('job_title_details',$job_title_details);

$smarty->assign('mode', $mode);
$smarty->assign('stylesheets', Array('media/css/ad.css'));
$smarty->assign('javascripts', Array('../js/MochiKit.js', '../js/jquery.js' , '../js/addrow-v2.js' , '../js/functions.js' , 'media/js/ads.js' ));
$smarty->display('index.tpl');
?>
