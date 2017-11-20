<?php
include('../conf/zend_smarty_conf.php');
/*
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

//Get the recorded years saved in monngodb
$doc = $collection->findOne(array('summary_type' => 'recorded years'));

$leave_request_per_year=array();
foreach($doc['recorded_years'] as $recorded_year){	
	$doc = $collection->findOne(array("summary_type"=> 'total per year', "year" => ((int)$recorded_year['year'])));
	$leave_request_per_year[]=array('total' => $doc['total'], "year" => $doc["year"]);
}



//On leave today
$doc = $collection->findOne(array('summary_type' => 'on leave today'));
$on_leave_today = $doc['total'];


//get leave request filed today
$sql = "SELECT COUNT(l.id)AS numrows FROM leave_request l WHERE l.leave_type NOT IN('Absent') AND DATE(l.date_requested)='".date('Y-m-d')."';";
$numrows = $db->fetchOne($sql);



echo json_encode(array("success"=>true, "data" => $leave_request_per_year, "current_day_total" => $numrows, "on_leave_today_total" => $on_leave_today ));
exit;
*/


/*
Approve Leave for Today excluding Inhouse
Approve Leave for Today Inhouse
Marked absent today
*/

//Approve Leave for Today excluding Inhouse
$sql = "SELECT r.id, d.id AS leave_request_date_id FROM leave_request r INNER JOIN leave_request_dates AS d ON d.leave_request_id = r.id WHERE DATE(d.date_of_leave) ='".date('Y-m-d')."' AND d.status ='approved' AND r.leads_id NOT IN(11);";
$results = $db->fetchAll($sql);
$total_no_approved_leave_excluding_inhouse_staff = count($results);


//Approve Leave for Today Inhouse
$sql = "SELECT r.id, d.id AS leave_request_date_id FROM leave_request r INNER JOIN leave_request_dates AS d ON d.leave_request_id = r.id WHERE DATE(d.date_of_leave) ='".date('Y-m-d')."' AND d.status ='approved' AND r.leads_id IN(11);";
$results = $db->fetchAll($sql);
$total_no_approved_leave_inhouse_staff = count($results);


//Marked absent today
$sql = "SELECT r.id, d.id AS leave_request_date_id FROM leave_request r INNER JOIN leave_request_dates AS d ON d.leave_request_id = r.id WHERE DATE(d.date_of_leave) ='".date('Y-m-d')."' AND d.status ='absent';";
$results = $db->fetchAll($sql);
$total_no_approved_marked_absent = count($results);


echo json_encode(array("success"=>true, "total_no_approved_leave_excluding_inhouse_staff" => $total_no_approved_leave_excluding_inhouse_staff, "total_no_approved_leave_inhouse_staff" => $total_no_approved_leave_inhouse_staff, "total_no_approved_marked_absent" => $total_no_approved_marked_absent ));
exit;
?>