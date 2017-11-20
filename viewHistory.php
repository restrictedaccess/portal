<?php
include './conf/zend_smarty_conf_root.php';
header("Expires: Mon, 26 Jul 1997 05:00:00GMT");
header("Cache-Control: no-cache");
header("Pragma: no-cache");
$smarty = new Smarty;


if($_SESSION['agent_no'] !="" or $_SESSION['agent_no'] != NULL){
	
	$agent_no = $_SESSION['agent_no'];
	$sql=$db->select()
		->from('agent')
		->where('agent_no = ?' ,$agent_no);
	$agent = $db->fetchRow($sql);
	$session_name = $agent['fname']." ".$agent['lname'];
	$session_email = $agent['email'];
	$created_by_id = $_SESSION['agent_no'];
	$created_by_type = 'agent';
	$smarty->assign('agent_section',True);
	
	
}else if($_SESSION['admin_id'] !="" or $_SESSION['admin_id'] != NULL){

	$admin_id = $_SESSION['admin_id'];
	$sql=$db->select()
		->from('admin')
		->where('admin_id = ?' ,$admin_id);
	$admin = $db->fetchRow($sql);
	
	$session_name = $admin['admin_fname']." ".$admin['admin_lname'];
	$session_email = $admin['admin_email'];
	$created_by_id = $_SESSION['admin_id'];
	$created_by_type = 'admin';
	$smarty->assign('admin_section',True);	

}else{

	die("Session Expires . Please re-login");
}



$id=$_REQUEST['id'];
if(!$id){
	die("History ID is missing");
}



if(isset($_POST['save_csr'])){
	
	$history_id = $id;
	//DELETE RECORD
	$where = "history_id = ".$id;	
	$db->delete('history_csr' , $where);

	for ($i = 0; $i < count($_POST['question']); ++$i){
		//echo $_POST['question'][$i]." ".$_POST['answer'][$i]."<br>";
		$data = array(
			'history_id' => $history_id, 
			'question' => $_POST['question'][$i], 
			'answer' => $_POST['answer'][$i]
		);
		$db->insert('history_csr', $data);
	}
	$msg ="Messages updated.";
	echo '<script language="javascript">
	   alert("'.$msg.'");
	</script>';
}

if(isset($_POST['delete'])){
	
	$sql = $db->select()
		->from('history')
		->where('id =?' , $id);
	//echo $sql;	
	$result = $db->fetchRow($sql);
	$leads_id = $result['leads_id'];
	
	//echo $leads_id;exit;
	$sql = $db->select()
		->from('leads','status')
		->where('id =?' , $leads_id);
	$leads_status = $db->fetchOne($sql);

	$history_id = $id;
	//DELETE RECORD
	$where = "history_id = ".$id;	
	$db->delete('history_csr' , $where);

	$where = "id = ".$id;	
	$db->delete('history' , $where);
	
	$msg ="Messages deleted.";
	echo '<script language="javascript">
	   alert("'.$msg.'");
	   opener.updatemyarray("leads_information.php?id='.$leads_id.'&lead_status='.$leads_status.'&page_type=TRUE")
	   window.close();
	</script>';
	exit;
}




$sql = $db->select()
	->from('history')
	->where('id =?' , $id);
$result = $db->fetchRow($sql);


$leads_id = $result['leads_id'];
$history = $result['history'];


if($result['actions'] == 'CSR'){
	$history="";
	$q=0;
	$sql = $db->select()
		->from('history_csr')
		->where('history_id =?' , $id);
	$csrs = $db->fetchAll($sql);
	//id, history_id, question, answer
	foreach($csrs as $csr){
		$q++;
		$history.=sprintf('<div style="margin-bottom:10px;"><div><b>%s) %s</b></div><div style="margin-left:20px;margin-right:20px;">- <em>%s</em></div></div>',$q ,$csr['question'] , $csr['answer']);
	}
	$smarty->assign('csrs' , $csrs);				
}


function getCreator($created_by , $created_by_type)
{
	global $db;
	if($created_by_type == 'agent')
	{
		$query = "SELECT * FROM agent a WHERE agent_no = $created_by;";
		$result = $db->fetchRow($query);
		$name = "Agent ".$result['fname'];
	}
	else if($created_by_type == 'admin')
	{
		//return "Admin Norman";
		$query = "SELECT * FROM admin a WHERE admin_id = $created_by;";
		$result = $db->fetchRow($query);
		$name = "Admin ".$result['admin_fname'];
	}
	else{
		$name="";
	}
	return $name;
}


$sql ="SELECT * FROM leads WHERE id = $leads_id;";
$lead = $db->fetchRow($sql);
$leads_name = $lead['fname']." ".$lead['lname'];

//$smarty->assign('created_by_id' , $result['agent_no']);
//$smarty->assign('created_by_type' , $result['created_by_type']);

//$smarty->assign('session_id' , $created_by_id);
//$smarty->assign('session_type' , $created_by_type);

if(($result['agent_no'] == $created_by_id) and ($result['created_by_type'] == $created_by_type) ){
	$smarty->assign('enabled_button' , True);
}


$history = strip_tags($history);
$history = str_replace("@import url(http://fonts.googleapis.com/css?family=Orienta);", "", $history);
$history = "<pre>".trim($history)."</pre>";
$smarty->assign('actions' , $result['actions']);
$smarty->assign('leads_id', $leads_id);
$smarty->assign('creator' , getCreator($result['agent_no'] , $result['created_by_type']));
$smarty->assign('result',$result);
$smarty->assign('message',$history);
$smarty->assign('leads_name',$leads_name);
$smarty->display('viewHistory.tpl');
?>


