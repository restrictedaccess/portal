<?php
$sql = $db->select()
	->from(array('b' => 'booking_lead_questions') , Array('id', 'userid', 'question', 'status', 'date_created'))
	->join(array('p' => 'personal') , 'p.userid = b.userid' , Array('fname' , 'lname'))
	->where('leads_id =?' , $leads_id);
//echo $sql;	
$questions = $db->fetchAll($sql);
//print_r($questions);
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
	
	if(!$id_check){
	    array_push($result_questions_reg,$data);
    }else{
	    array_push($result_questions_temp,$data);
	}   
}

//print_r($result_questions_temp);
//if($book_lead_method == 'regular'){
//    $smarty->assign('questions', $result_questions_reg);
//}else{
//    $smarty->assign('questions', $result_questions_temp);
//}
$smarty->assign('questions', $questions);
$body=$smarty->fetch('Questions.tpl');
$smarty->assign('question', $body);
?>