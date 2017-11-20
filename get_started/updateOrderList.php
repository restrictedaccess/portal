<?php
include '../conf/zend_smarty_conf.php';
include 'lib/get_started_function.php';
$smarty = new Smarty();

$gs_job_role_selection_id = $_REQUEST['gs_job_role_selection_id'];
$gs_job_titles_details_id = $_REQUEST['gs_job_titles_details_id'];
$jr_list_id = $_REQUEST['jr_list_id'];
$jr_cat_id = $_REQUEST['jr_cat_id'];
$level = $_REQUEST['level'];
$work_status = $_REQUEST['work_status'];

$working_timezone = $_REQUEST['working_timezone'];
$start_work = $_REQUEST['start_work'];
$finish_work = $_REQUEST['finish_work'];
$no_of_staff_needed = $_REQUEST['no_of_staff_needed'];

$history_changes ="";
if($_SESSION['admin_id']!="" or $_SESSION['admin_id']!=NULL){
	//die('Invalid ID for Admin');
	$change_by_id = $_SESSION['admin_id'];
	$change_by_type = "admin";
}else if($_SESSION['agent_no'] != "" || $_SESSION['agent_no']!=NULL){
	$change_by_id = $_SESSION['agent_no'];
	$change_by_type = "bp";
}else{
    die("Session Expires. Updates cannot be saved. Please re-login");
}

//echo $gs_job_role_selection_id."<br>".$gs_job_titles_details_id."<br>".$jr_list_id."<br>". $jr_cat_id."<br>". $level."<br>". $work_status. "<br>" .$working_timezone . "<br>" .$start_work. "<br>" . $finish_work."<hr>";

//get the jr_name first
$sql = $db->select()
	->from('job_role_cat_list' , 'jr_name')
	->where('jr_list_id = ?' ,$jr_list_id);
//echo $sql;
$jr_name = $db->fetchOne($sql);
//echo $jr_name;

//parse data in gs_job_titles_details table
$sql = $db->select()
	->from('gs_job_titles_details')
	->where('gs_job_titles_details_id = ?' , $gs_job_titles_details_id);
	
$result = $db->fetchRow($sql);
//print_r($result);
//must check the difference of the jr_list_id and level

if($jr_list_id != $result['jr_list_id']){
	//check if there's thesame jr_list_id in the order by using the gs_job_role_selection_id
	
	//check the level if exist update if not add new one
	
	//echo "Job Positions selected are not the same in the database<br>";
	$sql2 = $db->select()
		->from('gs_job_titles_details')
		->where('gs_job_role_selection_id = ?' , $gs_job_role_selection_id)
		->where('jr_list_id = ?' , $jr_list_id)
		->where('level = ?' , $level);
	$result2 =  $db->fetchRow($sql2);	
	//print_r($result2);
	
	//echo $result2['gs_job_titles_details_id']."<br>";
	if($result2['gs_job_titles_details_id'] != ""){
		if($result2['gs_job_titles_details_id'] != $gs_job_titles_details_id){
			//echo "not the thesame delete id " .$gs_job_titles_details_id."<br>";
			//delete
			$where = "gs_job_titles_details_id = ".$gs_job_titles_details_id;	
			$db->delete('gs_job_titles_details' , $where);
			
			$gs_job_titles_details_id = $result2['gs_job_titles_details_id'];
			$level = $result2['level'];
			$no_of_staff_needed = $no_of_staff_needed + $result2['no_of_staff_needed'];
			//echo $no_of_staff_needed."<br>";
			
		}
	}
	
	//update 
	$data = array(
				'jr_list_id' => $jr_list_id, 
				'jr_cat_id' => $jr_cat_id, 
				'selected_job_title' => $jr_name,
				'level' => $level, 
				'no_of_staff_needed' => $no_of_staff_needed, 
				'work_status' => $work_status, 
				'working_timezone' => $working_timezone, 
				'start_work' => $start_work, 
				'finish_work' => $finish_work 
				);
	$history_changes = compareData($data , $gs_job_titles_details_id);
	//echo $history_changes;exit;
	$where = "gs_job_titles_details_id = ".$gs_job_titles_details_id;	
	$db->update('gs_job_titles_details' ,  $data , $where);
	if($history_changes !=""){
	    $data = array(
		    'gs_job_role_selection_id' => $gs_job_role_selection_id,
			'gs_job_titles_details_id' => $gs_job_titles_details_id,
			'history' => sprintf('<ul>%s</ul>' , $history_changes),
			'date_history' => date('Y-m-d H:i:s'),
			'change_by_id' => $change_by_id,
			'change_by_type' => $change_by_type
		);
		$db->insert('gs_job_history' , $data);
	}
	
	
}else{

	//check the level if exist update if not add new one
	$sql2 = $db->select()
		->from('gs_job_titles_details')
		->where('gs_job_role_selection_id = ?' , $gs_job_role_selection_id)
		->where('jr_list_id = ?' , $result['jr_list_id'])
		->where('level = ?' , $level);
	$result2 =  $db->fetchRow($sql2);		
	//print_r($result2);
	//echo $result2['gs_job_titles_details_id']."<br>";
	
	if($result2['gs_job_titles_details_id'] != ""){
		if($result2['gs_job_titles_details_id'] != $gs_job_titles_details_id){
			//echo "not the thesame delete id " .$gs_job_titles_details_id."<br>";
			//delete
			$where = "gs_job_titles_details_id = ".$gs_job_titles_details_id;	
			$db->delete('gs_job_titles_details' , $where);
			
			$gs_job_titles_details_id = $result2['gs_job_titles_details_id'];
			$level = $result2['level'];
			$no_of_staff_needed = $no_of_staff_needed + $result2['no_of_staff_needed'];
			//echo $no_of_staff_needed."<br>";
			
		}
	}
	//update 
	$data = array(
				'level' => $level, 
				'no_of_staff_needed' => $no_of_staff_needed, 
				'work_status' => $work_status, 
				'working_timezone' => $working_timezone, 
				'start_work' => $start_work, 
				'finish_work' => $finish_work 
				);
	$history_changes = compareData($data , $gs_job_titles_details_id);
	//echo $history_changes;exit;
	
	$where = "gs_job_titles_details_id = ".$gs_job_titles_details_id;	
	$db->update('gs_job_titles_details' ,  $data , $where);
	if($history_changes !=""){
	    $data = array(
		    'gs_job_role_selection_id' => $gs_job_role_selection_id,
			'gs_job_titles_details_id' => $gs_job_titles_details_id,
			'history' => sprintf('<ul>%s</ul>' , $history_changes),
			'date_history' => date('Y-m-d H:i:s'),
			'change_by_id' => $change_by_id,
			'change_by_type' => $change_by_type
		);
		$db->insert('gs_job_history' , $data);
	}
	
}


$query = $db->select()
	->from('gs_job_titles_details')
	->where('gs_job_role_selection_id = ?' , $gs_job_role_selection_id)
	->group('jr_list_id');
$jr_list_ids = $db->fetchAll($query);	

//echo count($jr_list_ids);

$data = array('no_of_job_role' => count($jr_list_ids));
$where = "gs_job_role_selection_id = ".$gs_job_role_selection_id;	
$db->update('gs_job_role_selection' ,  $data , $where);
echo "Updated Successfully";

?>

