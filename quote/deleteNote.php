<?
include '../config.php';
include '../conf.php';
include '../time.php';

$AusTime = date("H:i:s"); 
$AusDate = date("Y")."-".date("m")."-".date("d");
$ATZ = $AusDate." ".$AusTime;

if($_SESSION['agent_no']==NULL and $_SESSION['admin_id']==NULL){
	die("ID is Missing.");
}

$agent_no = $_SESSION['agent_no'];
$admin_id = $_SESSION['admin_id'];
if($admin_id!=NULL){
	$created_by = $admin_id;
	$created_by_type = 'admin';
	
}

if($agent_no!=NULL){
	$created_by = $agent_no;
	$created_by_type = 'agent';
}




$quote_id = $_REQUEST['quote_id'];
$id = $_REQUEST['id'];


//echo $id."<br>".$message;

/*
SELECT * FROM quote_notes q;
id, quote_id, agent_no, notes, date_note
*/
$query ="DELETE FROM quote_notes WHERE id = $id;";
$result = mysql_query($query);
if(!$result) die ("Error in sql script");
echo $quote_id;


?>