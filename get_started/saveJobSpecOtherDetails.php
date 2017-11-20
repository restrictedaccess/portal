<?php
include '../conf/zend_smarty_conf.php';
include('../time.php');
$smarty = new Smarty();
header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); // Date in the past
header('Content-Type: text/html; charset=ISO-8859-1');

$AusTime = date("H:i:s"); 
$AusDate = date("Y")."-".date("m")."-".date("d");
$ATZ = $AusDate." ".$AusTime;

$gs_job_titles_details_id = $_REQUEST['gs_job_titles_details_id'];
$gs_job_role_selection_id = $_REQUEST['gs_job_role_selection_id'];


$campaign_type = $_REQUEST['campaign_type']; // campaign_type
$duties_responsibilities = $_REQUEST['duties_responsibilities']; //duties_responsibilites
$others = $_REQUEST['others']; // other_skills
//$additional_essentials = $_REQUEST['additional_essentials']; // additional_essential
$notes = $_REQUEST['notes']; // comments
$call_type = $_REQUEST['call_type'];

$responsibilty = $_REQUEST['requirement'];
$responsibilty = substr($responsibilty,0,(strlen($responsibilty)-1)); // delete the last | "|" 
$responsibilty = explode("|",$responsibilty);
//print_r($responsibilty);

// Telemarketer Additional Information
$q1 = $_REQUEST['q1'];
$q2 = $_REQUEST['q2'];
$q3 = $_REQUEST['q3'];
$q4 = $_REQUEST['q4'];
$lead_generation = $_REQUEST['lead_generation']; 
$telemarketer_hrs = $_REQUEST['telemarketer_hrs'];
$onshore = $_REQUEST['onshore'];

$writer_type = $_REQUEST['writer_type'];
$writer_type = substr($writer_type,0,(strlen($writer_type)-1)); // delete the last | "|" 

$staff_phone = $_REQUEST['staff_phone'];
$require_graphic = $_REQUEST['require_graphic'];

if($writer_type!=""){
	//this means the form is Writer Form
	//echo $writer_type;
	$writer_type_array = explode("|",$writer_type);
	
	$where = "gs_job_titles_details_id = ".$gs_job_titles_details_id . " AND box = 'writer_type' AND gs_job_role_selection_id = ".$gs_job_role_selection_id;		
	$db->delete('gs_job_titles_credentials', $where);
	
	if(count($writer_type_array)>0) {
		for($i=0 ; $i<count($writer_type_array); $i++){
			$data = array(
				'gs_job_titles_details_id' => $gs_job_titles_details_id, 
				'gs_job_role_selection_id' => $gs_job_role_selection_id,
				'description' => $writer_type_array[$i],
				'box' => 'writer_type'
			);
			$db->insert('gs_job_titles_credentials', $data);
		}
	}

	
}


//check if the ff: box is exsiting then update only if not add

if($others=="") $others = " ";
if($notes=="") $notes = " ";

$box_array = array('campaign_type','other_skills','comments','call_type','q1','q2','q3','q4','lead_generation','telemarketer_hrs','onshore','staff_phone','require_graphic');
$requirement_array = array($campaign_type,$others,$notes,$call_type,$q1,$q2,$q3,$q4,$lead_generation,$telemarketer_hrs,$onshore,$staff_phone,$require_graphic);

for($i=0; $i<count($box_array);$i++){
	$query = "SELECT * FROM gs_job_titles_credentials WHERE gs_job_titles_details_id = $gs_job_titles_details_id  AND  gs_job_role_selection_id = $gs_job_role_selection_id  AND box ='".$box_array[$i]."';";
	$result = $db->fetchRow($query);
	$gs_job_titles_credentials_id = $result['gs_job_titles_credentials_id'];

	if($gs_job_titles_credentials_id !="" ){
		//echo "Just update";
		if($requirement_array[$i] != "" or $requirement_array[$i] != NULL){
			$data = array(
				'gs_job_titles_details_id' => $gs_job_titles_details_id, 
				'gs_job_role_selection_id' => $gs_job_role_selection_id,
				'description' => $requirement_array[$i],
				'box' => $box_array[$i]
				);
			$where = "gs_job_titles_credentials_id = ".$gs_job_titles_credentials_id;		
			$db->update('gs_job_titles_credentials', $data, $where);
		}
		//$str_message = "Successfully Updated";
	}
	
	if($gs_job_titles_credentials_id =="" ){
		if($requirement_array[$i] != "" or $requirement_array[$i] != NULL){
			$data = array(
				'gs_job_titles_details_id' => $gs_job_titles_details_id, 
				'gs_job_role_selection_id' => $gs_job_role_selection_id,
				'description' => $requirement_array[$i],
				'box' => $box_array[$i]
				);
			$db->insert('gs_job_titles_credentials', $data);
		}
		//$str_message = "Successfully Saved";
		//echo "Add";
	}

}	

//delete first the existing duties and responsibilites
$where = "gs_job_titles_details_id = ".$gs_job_titles_details_id . " AND box = 'responsibility' AND gs_job_role_selection_id = ".$gs_job_role_selection_id;		
$db->delete('gs_job_titles_credentials', $where);

for($i=0; $i<count($responsibilty);$i++){
	if($responsibilty[$i] != "" or $responsibilty[$i] != NULL){
		$data = array(
			'gs_job_titles_details_id' => $gs_job_titles_details_id, 
			'gs_job_role_selection_id' => $gs_job_role_selection_id,
			'description' => $responsibilty[$i],
			'box' => 'responsibility'
			);
		$db->insert('gs_job_titles_credentials', $data);
	}
}

	
$str_message = "Successfully Updated";

$data = array(
	'form_filled_up' => 'yes',
	'date_filled_up' => $ATZ
	);
$where = "gs_job_titles_details_id = ".$gs_job_titles_details_id;		
$db->update('gs_job_titles_details', $data, $where);


$sql = $db->select()
	 ->from('gs_job_titles_details')
	 ->where('gs_job_role_selection_id = ?', $gs_job_role_selection_id);
$result = $db->fetchAll($sql);

$need_attention = 0;
$filled_up = 0;
foreach($result as $line){
	$form_filled_up = $line['form_filled_up'];
	if($form_filled_up=="no"){
		$need_attention = $need_attention + 1;
	}else{
		$filled_up = $filled_up + 1;
	}
}		
echo $str_message;
exit;
//$smarty->assign('need_attention', $need_attention);
//$smarty->assign('filled_up', $filled_up);
//$smarty->display('saveJobSpecOtherDetails.tpl');
?>