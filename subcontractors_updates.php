<?php
include('./conf/zend_smarty_conf.php');

header("Expires: Mon, 26 Jul 1997 05:00:00GMT");
header("Cache-Control: no-cache");
header('Content-type: text/html; charset=utf-8');
header("Pragma: no-cache");
$smarty = new Smarty;

if($_SESSION['admin_id']=="") {
    die("Admin ID is missing.");
}

$sql= $db->select()
    ->from('admin')
	->where('admin_id =?', $_SESSION['admin_id']);
$admin = $db->fetchRow($sql);

if($admin['view_subcon_latest_updates'] == 'N'){
	die("PERMISSION DENIED. Staff Contract Access Denied.");
}

if($_REQUEST['sid']){
	$conditions .=" AND s.id=".$_REQUEST['sid']." ";
}


$year = $_REQUEST['year'];
$month = $_REQUEST['month'];
$status = $_REQUEST['status'];

if($year == ""){
	$year = date('Y');
}
if($month == ""){
	$month = date('m');
}

//// USE FOR PAGING ///
// how many rows to show per page
$rowsPerPage = $_REQUEST['rowsPerPage'];
//echo $rowsPerPage;

if($rowsPerPage == ""){
	$rowsPerPage = 100;
}
// by default we show first page
$pageNum = 1;
// if $_GET['page'] defined, use it as page number
if(isset($_POST['page']))
{
	$pageNum = $_POST['page'];
}
// counting the offset
//echo $pageNum ;

$offset = 0;
if($pageNum!=NULL){
	$offset = ($pageNum - 1) * $rowsPerPage;
	//echo "offset2 ( ".$offset2." )<br>";
}


//$limit = " LIMIT $offset, $rowsPerPage ";


if(isset($_POST['submit_check'])){
	
	//if($_POST['status']){
	//	$conditions .= " AND s.status = '".$_POST['status']. "'";
	//}else{
	//	$conditions .= " AND s.status IN('ACTIVE', 'suspended')";
	//}
	$params="";
	if($_REQUEST['csro']){
		$conditions .= " AND l.csro_id =".$_REQUEST['csro'];
		$params .=sprintf('&csro=%s', $_REQUEST['csro']); 
	}
	
	
	if($_REQUEST['year']){
		$conditions .= " AND YEAR(h.date_change) = '".$_REQUEST['year']."'";
		$params .=sprintf('&year=%s', $_REQUEST['year']); 
	}
	
	
	if($_REQUEST['month']){
		$conditions .= " AND MONTH(h.date_change) = '".$_REQUEST['month']."'";
		$params .=sprintf('&month=%s', $_REQUEST['month']); 
	}
	
	if($_REQUEST['contract_status']){
		$conditions .= " AND s.status IN(".$_REQUEST['contract_status'].")";
		$params .=sprintf('&contract_status=%s', $_REQUEST['contract_status']); 
	}
	
	$history_search="";
	if($_REQUEST['str']){
		$params .=sprintf('&str=%s', $_REQUEST['str']); 
		foreach($_REQUEST['str'] as $str){
			$history_search .=" OR h.changes LIKE '%".$str."%' ";	
		}	
	}
	
	if($history_search != ""){
		//remove the first 'OR'
		$history_search = substr($history_search, 3); 
		$history_search = sprintf('AND (%s)', $history_search);
	}
	
	$year = $_REQUEST['year'];
    $month = $_REQUEST['month'];

}else{
	$conditions .= " AND YEAR(h.date_change) = '".date('Y')."'";
	$conditions .= " AND MONTH(h.date_change) = '".date('m')."'";
	//$conditions .= " AND ( h.changes LIKE '%Client Quoted Price%' OR h.changes LIKE '%Staff Monthly Salary%' OR h.changes LIKE '%Staff Hourly Salary%' )";

}

$scheduled_subcon=array();
$sql = "SELECT subcontractors_id FROM subcontractors_scheduled_subcon_rate WHERE status = 'waiting'";
$schedules = $db->fetchAll($sql);
foreach($schedules as $schedule){
	$scheduled_subcon[] = $schedule['subcontractors_id'];
}


$sql = "SELECT subcontractors_id FROM subcontractors_scheduled_client_rate WHERE status = 'waiting'";
$schedules = $db->fetchAll($sql);
foreach($schedules as $schedule){
	$scheduled_subcon[] = $schedule['subcontractors_id'];
}



//echo "<pre>";
//print_r($scheduled_subcon);
//echo "</pre>";
//echo "<hr>";


$sql = "SELECT (h.id)AS history_id, s.id, s.userid, s.leads_id, l.csro_id, h.changes, h.date_change, h.change_by_id, h.changes_status, s.job_designation, s.status, s.client_price, s.php_monthly, s.starting_date, s.work_status FROM subcontractors_history h JOIN subcontractors s ON s.id = h.subcontractors_id JOIN leads l ON l.id=s.leads_id WHERE h.changes_status IN('approved','updated')  $conditions  $history_search ORDER BY h.date_change DESC $limit;";
$subcons = $db->fetchAll($sql);
//echo $sql;

//$sql = "SELECT COUNT(s.id) AS numrows FROM subcontractors_history h JOIN subcontractors s ON s.id = h.subcontractors_id JOIN leads l ON l.id=s.leads_id WHERE  h.changes_status IN('approved','updated')  $conditions  $history_search ;";
//$numrows = $db->fetchOne($sql);
//echo count($subcons);


$retries = 0;
while(true){
	try{
		if (TEST) {
			$mongo = new MongoClient(MONGODB_TEST);
			//$database = $mongo -> selectDB('prod');
	    } else {
	        $mongo = new MongoClient(MONGODB_SERVER);
	        //$database = $mongo -> selectDB('prod');
	    }
	    
		//Fetch comments in mongodb
		$database = $mongo->selectDB('subcontractors');
		break;
	} catch(Exception $e){
		++$retries;
		
		if($retries >= 100){
			break;
		}
	}
}

$collection = $database->selectCollection('update_rates_comments');
			
$SUBCONS=array();
$existing_subcon = array();
//echo "<ol>";
foreach($subcons as $subcon){
	$INCLUDE = false;
	if($subcon['changes_status'] == 'updated'){
		if(in_array($subcon['id'], $scheduled_subcon)){
			$INCLUDE = true;
			$subcon['status'] = 'scheduled';
		}
	}else{
		$INCLUDE = true;
	}
	if($INCLUDE){
		//echo sprintf('<li>%s %s %s</li>', $subcon['id'], $subcon['changes_status'], $INCLUDE);
		if(!in_array($subcon['id'], $existing_subcon)){
			$existing_subcon[] = $subcon['id'];
			$sql = $db->select()
				->from('personal', Array('fname', 'lname'))
				->where('userid =?', $subcon['userid']);
			$personal = $db->fetchRow($sql);
			
			$sql = $db->select()
				->from('leads', Array('fname', 'lname'))
				->where('id =?', $subcon['leads_id']);
			$lead = $db->fetchRow($sql);
			
			$sql = $db->select()
				->from('admin', Array('admin_fname', 'admin_lname'))
				->where('admin_id =?', $subcon['change_by_id']);
			$admin = $db->fetchRow($sql);
			
			$csro=array();
			if($subcon['csro_id']){
				$sql = $db->select()
					->from('admin', Array('admin_fname', 'admin_lname'))
					->where('admin_id=?', $subcon['csro_id']);
				$csro = $db->fetchRow($sql);	
			}
			
			
			
			$cursor = $collection->find(array(
				"subcontractors_id"=>((int)$subcon['id']),
				"history_id" => ((int)$subcon['history_id']) 
			));
			$update_rates_comments = array();
			while($cursor->hasNext()){
				$update_rates_comments[] = $cursor->getNext();
			}
			$mongo_comments=array();
			foreach($update_rates_comments as $update_rates_comment){
				$mongo_comments[] = array(
					'admin' => $update_rates_comment['admin_name'],
					'comment' => $update_rates_comment['comment_note'],
					'date_time' => date('Y-m-d H:i:s', $update_rates_comment['date_search']->sec)
				);
			}
			
			if($subcon['status'] != 'scheduled'){
				//Get all client rates
				$sql = "SELECT * FROM subcontractors_client_rate s WHERE work_status IS NOT NULL AND subcontractors_id=".$subcon['id'];
				$client_rates = $db->fetchAll($sql);
				$temp_rate =0;
				$temp_work_status="";
				$CLIENT_RATES=array();
				foreach($client_rates as $client_rate){
					$client_rate['client_hourly']="";
					if($client_rate['work_status']){
						if($client_rate['work_status'] == 'Part-Time'){
							$client_rate['client_hourly'] = (((($client_rate['rate'] * 12) /52) /5) /4);
						}else{
							$client_rate['client_hourly'] = (((($client_rate['rate'] * 12) /52) /5) /8);
						}
					}
					
					if($client_rate['end_date']== NULL){
						if($client_rate['rate'] != $temp_rate){
							$CLIENT_RATES[] =$client_rate;
						}
					}else{
						if($client_rate['rate'] != $temp_rate){
							$CLIENT_RATES[] =$client_rate;
							$temp_rate = $client_rate['rate'];
							$temp_work_status = $client_rate['work_status'];
						}
					}
				}
				/*
				if(!$CLIENT_RATES){
					if($subcon['client_price_effective_date']){
						$starting_date = $subcon['client_price_effective_date'];
					}else{
						$starting_date = $subcon['starting_date'];
					}
					
					$data=array(
						'start_date' => $starting_date, 
						'end_date' =>'', 
						'rate' => $subcon['client_price'], 
						'work_status' => $subcon['work_status'] 			
					);
					$CLIENT_RATES[] = $data;
				}
				*/
				$sql = "SELECT * FROM subcontractors_staff_rate s WHERE subcontractors_id=".$subcon['id'];
				$staff_rates = $db->fetchAll($sql);
				$STAFF_RATES=array();
				foreach($staff_rates as $staff_rate){
					$staff_rate['staff_hourly']="";
					if($staff_rate['work_status']){
						if($staff_rate['work_status'] == 'Part-Time'){
							$staff_rate['staff_hourly'] = (((($staff_rate['rate'] * 12) /52) /5) /4);
						}else{
							$staff_rate['staff_hourly'] = (((($staff_rate['rate'] * 12) /52) /5) /8);
						}
					}
					
					$STAFF_RATES[]=$staff_rate;
				}
			}else{
				//scheduled client rate update
				$sql = "SELECT * FROM subcontractors_scheduled_client_rate s WHERE work_status IS NOT NULL AND status='waiting' AND subcontractors_id=".$subcon['id'];
				$client_rates = $db->fetchAll($sql);
				$CLIENT_RATES=array();
				$rate=array();
				foreach($client_rates as $client_rate){
					$client_rate['client_hourly']="";
					if($client_rate['work_status']){
						if($client_rate['work_status'] == 'Part-Time'){
							$rate['client_hourly'] = (((($client_rate['rate'] * 12) /52) /5) /4);
						}else{
							$rate['client_hourly'] = (((($client_rate['rate'] * 12) /52) /5) /8);
						}
					}
					
					$rate['start_date'] = $client_rate['scheduled_date'];
					$rate['rate'] = $client_rate['rate'];
					$rate['work_status']= $client_rate['work_status'];
					$CLIENT_RATES[] = $rate;
				}
				//scheduled staff rate updates
				$sql = "SELECT * FROM subcontractors_scheduled_subcon_rate s WHERE status='waiting' AND subcontractors_id=".$subcon['id'];
				$staff_rates = $db->fetchAll($sql);
				$STAFF_RATES=array();
				$rate=array();
				foreach($staff_rates as $staff_rate){
					$staff_rate['staff_hourly']="";
					if($staff_rate['work_status']){
						if($staff_rate['work_status'] == 'Part-Time'){
							$rate['staff_hourly'] = (((($staff_rate['rate'] * 12) /52) /5) /4);
						}else{
							$rate['staff_hourly'] = (((($staff_rate['rate'] * 12) /52) /5) /8);
						}
					}
					$rate['start_date'] = $staff_rate['scheduled_date'];
					$rate['rate'] = $staff_rate['rate'];
					$rate['work_status']= $staff_rate['work_status'];
					$STAFF_RATES[]=$rate;
				}
				
			}
			
			$days_before_suspension ="0 days";
			$CLIENT_ID = ((int)$subcon['leads_id']);  //must be an integer
			$CLIENT = new couchClient($couch_dsn, 'client_docs');
			//client currency settings
			$CLIENT->startkey(Array($CLIENT_ID, Array(date('Y'),date('m'),date('d'),date('H'),date('i'),0,0)));
			$CLIENT->endkey(Array($CLIENT_ID, Array(2011,0,0,0,0,0,0)));
			$CLIENT->descending(True);
			$CLIENT->limit(1);
			$CLIENT->include_docs(True);
			$response = $CLIENT->getView('client', 'settings');
				
			$doc = $response->rows[0]->doc;
			$doc->days_before_suspension;
			
			if($doc->days_before_suspension){
				$days_before_suspension = sprintf('%s days', $doc->days_before_suspension);	
			}	

			
			
			$data=array(
			    'history_id' => $subcon['history_id'],
				'subcon_id' => $subcon['id'],
				'staff' => $personal,
				'lead' => $lead,
				'admin' => $admin,
				'date_change' => $subcon['date_change'],
				'job_designation' => $subcon['job_designation'],
				'csro' => $csro,
				'status' => $subcon['status'],
				'client_rates' => $CLIENT_RATES,
				'staff_rates' => $STAFF_RATES,
				'days_before_suspension' => $days_before_suspension,
				'comment_note' => $mongo_comments
			);
			
			$days_before_suspension = sprintf('%s', $days_before_suspension);
			
				
			
			if($_REQUEST['days_before_suspension']){
				if($_REQUEST['days_before_suspension'] == $days_before_suspension){
					$SUBCONS[]= $data;
				}
			}else{	
				$SUBCONS[]= $data;
			}
		}		
	}
}
//echo "<pre>";
//print_r($SUBCONS);
//echo "</pre>";
//exit;
/*
$maxPage = ceil($numrows/$rowsPerPage);
// print the link to access each page
$self = "./".basename($_SERVER['SCRIPT_FILENAME']);
$nav = '';
$page_numbers=array();
for($page = 1; $page <= $maxPage; $page++){
	$page_numbers[] = $page;
}
*/



$STRING_SEARCH= array(
    'Client Quoted Price', 
	'Effect Date of New Client Price',
	'Staff Working Status',
	'Staff Monthly Salary',
	'Staff Hourly Salary'
);

$SEARCH = array();
if($_REQUEST['str']){
	$SEARCH = $_REQUEST['str'];
}
for($i=0; $i<count($STRING_SEARCH); $i++){
	if (in_array($STRING_SEARCH[$i],$SEARCH)){
		$checkboxes .= sprintf('<input type="checkbox" checked name="str[]" value="%s" /><span class="str_search">%s</span>', $STRING_SEARCH[$i], $STRING_SEARCH[$i]);
	}else{
		$checkboxes .= sprintf('<input type="checkbox" name="str[]" value="%s" /><span class="str_search">%s</span>', $STRING_SEARCH[$i], $STRING_SEARCH[$i]);
	}
}

$YEARS=array();
for($i=2008; $i<=date('Y'); $i++){
	$YEARS[]=$i;
}

//csro
$sql = "SELECT * FROM admin a WHERE csro='Y' AND status NOT IN('PENDING','REMOVED') ORDER BY admin_fname ASC;";
$csros = $db->fetchAll($sql); 
foreach($csros as $csro){
    if($_REQUEST['csro'] == $csro['admin_id']){
	    $team_Options .="<option value='".$csro['admin_id']."' selected='selected'>".sprintf('%s %s', $csro['admin_fname'], $csro['admin_lname'])."</option>";
	}else{
		$team_Options .="<option value='".$csro['admin_id']."'>".sprintf('%s %s', $csro['admin_fname'], $csro['admin_lname'])."</option>";
	}
}

$DBS =array();
for($i=0; $i>=-30; $i--){
    //echo $i;
	$DBS[] = sprintf('%s days', $i);
}

$MONTHS=array('January' => '01', 'February' => '02', 'March' => '03', 'April' => '04', 'May' => '05', 'June' => '06', 'July' => '07', 'August' => '08', 'September' => '09', 'October' => '10', 'November' => '11', 'December' => '12');

//$smarty->assign('maxPage', $maxPage);
//$smarty->assign('pageNum', $pageNum);
//$smarty->assign('page_numbers',$page_numbers);
$smarty->Assign('contract_status', $_REQUEST['contract_status']);
$smarty->assign('CONTRACT_STATUS_ARRAY',  array("'ACTIVE', 'suspended'", "'terminated', 'resigned', 'deleted'"));
$smarty->assign('DBS', $DBS);
$smarty->assign('days_before_suspension', $_REQUEST['days_before_suspension']);
$smarty->assign('team_Options', $team_Options);
$smarty->assign('checkboxes',$checkboxes);
$smarty->assign('numrows',count($SUBCONS));
$smarty->assign('SUBCONS',$SUBCONS);
$smarty->assign('month',$month);
$smarty->assign('year',$year);
$smarty->assign('YEARS',$YEARS);
$smarty->assign('MONTHS', $MONTHS);
$smarty->assign('script_filename',basename($_SERVER['SCRIPT_FILENAME']));
$smarty->display('subcontractors_updates.tpl');
?>