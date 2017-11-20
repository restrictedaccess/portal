<?php
include '../conf/zend_smarty_conf.php';
include '../time.php';
header("Expires: Mon, 26 Jul 1997 05:00:00GMT");
header("Cache-Control: no-cache");
header("Pragma: no-cache");
$smarty = new Smarty;

$leads_id = $_REQUEST['leads_id'];
$book_lead_method = $_REQUEST['booking_method'];

$sql = $db->select()
	->from(array('b' => 'booking_lead_questions') , Array('id', 'userid', 'question', 'status', 'date_created'))
	->join(array('p' => 'personal') , 'p.userid = b.userid' , Array('fname' , 'lname'))
	->where('leads_id =?' , $leads_id);
$questions = $db->fetchAll($sql);
$result_questions_reg = array();
$result_questions_temp = array();
foreach($questions as $question){
    
	$query = $db->select()
		->from('leads_transactions', 'id')
		->where('reference_table =?' , 'booking_lead_questions')
		->where('reference_no =?' , $question['id']);
	$id_check = $db->fetchOne($query);
	
	$data = array(
	    'id' => $question['id'],
		'userid' => $question['userid'],
		'question' => $question['question'],
		'status' => $question['status'],
		'date_created' => $question['date_created'],
		'fname' => $question['fname'],
		'lname' => $question['lname'],
	);
	
	if($book_lead_method == 'regular'){
	    array_push($result_questions_reg,$data);
    }else{
	    array_push($result_questions_temp,$data);
	}   
}

$home_dir = dirname(__FILE__);
//echo $home_dir;exit;
$smarty->template_dir = '../templates';
$smarty->compile_dir = "../templates_c";

if($book_lead_method == 'regular'){
    $smarty->assign('questions', $result_questions_reg);
}else{
    $smarty->assign('questions', $result_questions_temp);
}
$smarty->display('Questions.tpl');
?>