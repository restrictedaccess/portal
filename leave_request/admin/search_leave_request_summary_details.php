<?php
include '../../conf/zend_smarty_conf.php';
$retries = 0;
while(true){
	try{
		if (TEST){
			try {
				$mongo = new MongoClient();
			} catch (Exception $e) {
				$mongo = new MongoClient(MONGODB_TEST);
			}
		}else{
			$mongo = new MongoClient(MONGODB_SERVER);
		}
		
		$database = $mongo->selectDB('reports');
		break;
	} catch(Exception $e){
		++$retries;
		
		if($retries >= 100){
			break;
		}
	}
}

$collection = $database->selectCollection('leave_request_summary');

//echo "<pre>";
//print_r($_POST);
//echo "</pre>";


if(!isset($_POST['summary_type'])){
	die("summary_type is missing");
}

if(!$_POST['summary_type']){
	die("summary_type cannot be null");	
}

$summary_type = $_POST['summary_type'];

if($summary_type == 'on leave today'){
	$doc = $collection->findOne(array('summary_type' => 'on leave today'));
	$on_leave_today = $doc['total'];
	$records = $doc['records'];
	$data=array();
	foreach($records as $record){
		$data[]= $record['leave_request_id'];	
	}
}


if($summary_type == 'current'){
	$sql = "SELECT l.id FROM leave_request l WHERE l.leave_type NOT IN('Absent') AND DATE(l.date_requested)='".date('Y-m-d')."';";
	$leave_requests = $db->fetchAll($sql);
	$data=array();
	foreach($leave_requests as $leave_request){
		$data[] = $leave_request['id'];
	}
}


if($summary_type == 'total per year'){
	if(!isset($_POST['year'])){
		die("Year is missing");
	}
	
	if(!$_POST['year']){
		die("Year cannot be null");
	}
	
	$doc = $collection->findOne(array("summary_type"=> 'total per year', "year" => ((int)$_POST['year'])));
	$records = $doc['records'];
	$data=array();
	foreach($records as $record){
		$data[]= $record['leave_request_id'];	
	}
}


if($summary_type == 'today'){
	if(!isset($_POST['status'])){
		die("leave status is missing");
	}
	
	if(!$_POST['status']){
		die("leave status cannot be null");
	}
	
	if($_POST['status'] == 'approved'){
		//AND r.leads_id IN(11)
		$search_str="";
		if($_POST['inhouse'] == 'yes'){
			$search_str = " AND r.leads_id IN(11) ";
		}else{
			$search_str = " AND r.leads_id NOT IN(11) ";
		}
		
		$sql = "SELECT r.id FROM leave_request r INNER JOIN leave_request_dates AS d ON d.leave_request_id = r.id WHERE DATE(d.date_of_leave) ='".date('Y-m-d')."' AND d.status ='approved' ".$search_str." ;";		
	}
		
	if($_POST['status'] == 'absent'){
		$sql = "SELECT r.id FROM leave_request r INNER JOIN leave_request_dates AS d ON d.leave_request_id = r.id WHERE DATE(d.date_of_leave) ='".date('Y-m-d')."' AND d.status ='absent';";
	}
	
	
	$leave_requests = $db->fetchAll($sql);
	$data=array();
	foreach($leave_requests as $leave_request){
		$data[] = $leave_request['id'];
	}
	//echo "<pre>";
	//print_r($data);
	//echo "</pre>";
	//exit;
		
}



if(count($data) == 0){
	echo json_encode(array('success' => false ));
	exit;
}

$records=array();
$rowsPerPage = 100;
$pageNum = $_POST['page'];
//$pageNum = 2;
$offset = 0;

if($pageNum!=NULL){
	$offset = ($pageNum - 1) * $rowsPerPage;
}

$counter =$offset;
//echo $counter;
//echo "<br>";
$limit = " LIMIT $offset, $rowsPerPage ";

$numrows = count($data);
$data = implode(",", $data);


$sql="SELECT r.id, r.leads_id, r.userid, r.leave_type, r.reason_for_leave, (l.fname)AS client_fname, (l.lname)AS client_lname , (p.fname)AS staff_fname, (p.lname)AS staff_lname
FROM leave_request r
LEFT JOIN leads l ON l.id = r.leads_id
LEFT JOIN personal p ON p.userid = r.userid WHERE r.id IN(".$data.") ".$limit.";";
//echo $sql;
$leave_requests = $db->fetchAll($sql);
foreach($leave_requests as $leave_request){
	$counter++;
	
	$sql = "SELECT date_of_leave, status FROM leave_request_dates l WHERE leave_request_id=".$leave_request['id'].";";
	$dates = $db->fetchAll($sql);
	
	
	$records[] = array(
		'counter' => $counter,			   
		'leave_request_id' => $leave_request['id'],
		'leave_type' => $leave_request['leave_type'],
		'client' => $leave_request['client_fname']." ".$leave_request['client_lname'],
		'staff' => $leave_request['staff_fname']." ".$leave_request['staff_lname'],
		'userid' => $leave_request['userid'],
		'leads_id' => $leave_request['leads_id'],
		'reason_for_leave' => $leave_request['reason_for_leave'],
		'dates' => $dates
	);
}


$maxPage = ceil($numrows/$rowsPerPage);
//echo "maxPage => ".$maxPage."<br>";
//echo "pagenum => ".$pageNum."<br>";
//exit;

//echo "<pre>";
//print_r($records);
//echo "</pre>";
//exit;


echo json_encode(array('records' => $records, 'pagenum' => $pageNum, 'maxpage' => $maxPage, 'count' => $numrows, 'success' => true ));
exit;
?>