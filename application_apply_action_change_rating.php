<?php
include('conf/zend_smarty_conf_root.php');

$rating = $_REQUEST["rating"];
$userid = $_REQUEST["userid"];

//START - star rating
$sql = $db->select()
	->from('tb_additional_information')
	->where('userid =?' , $userid);
$result = $db->fetchRow($sql);
$is_exist	= $result['userid'];
if($is_exist)
{
	$data = array('rating' => $rating);
	$where = "userid = ".$userid;	
	$db->update('tb_additional_information' , $data , $where);	
}
else
{
	$data = array(
		'job_category' => '',
		'sub_job_category' => '',
		'availability' => '',
		'expected_salary' => '',
		'salary_from_previous_job' => '',
		'lowest_non_negostiable_salary' => '',
		'notes' => '',
		'userid' => $userid,
		'rating' => $rating
	);
	$db->insert('tb_additional_information', $data);
}

echo "<strong>New rating has been saved</strong>";
//ENDED - star rating

?>