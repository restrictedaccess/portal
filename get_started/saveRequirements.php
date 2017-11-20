<?php
include '../conf/zend_smarty_conf.php';
$gs_job_titles_details_id = $_REQUEST['gs_job_titles_details_id'];
$gs_job_role_selection_id = $_REQUEST['gs_job_role_selection_id'];
$requirement = $_REQUEST['requirement'];
$rating = $_REQUEST['rating'];
$box = $_REQUEST['box'];
$result_div = $_REQUEST['result_div'];

//TABLE : gs_job_titles_credentials
//gs_job_titles_credentials_id, gs_job_titles_details_id, description, rating, box
$data = array(
	'gs_job_titles_details_id' => $gs_job_titles_details_id, 
	'gs_job_role_selection_id' => $gs_job_role_selection_id,
	'description' => $requirement,
	'rating' => $rating,
	'box' => $box,
	'div' => $result_div
	);
//print_r($data);	
$db->insert('gs_job_titles_credentials', $data);
echo "Successfully Added";
?>