<?php
include('conf/zend_smarty_conf.php');

$lead_status = $_REQUEST['lead_status'];
$leads_list = sprintf('leads_list/index.php?lead_status=%s&filter=ACTIVE', $lead_status);
header("location:$leads_list");
exit;


header("Expires: Mon, 26 Jul 1997 05:00:00GMT");
header("Cache-Control: no-cache");
header('Content-type: text/html; charset=utf-8');
header("Pragma: no-cache");
$smarty = new Smarty;

	
//check the user
$list_view = False;
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
	$access_all_leads = $agent['access_all_leads'];
	
	$view_leads_setting = $agent['view_leads_setting'];
	$leads_order_by_setting = $agent['leads_order_by_setting'];
	
	if($view_leads_setting){
		$save_setting_access_all_leads = "<input type='checkbox' checked name='save_setting_access_all_leads' value='business_developer_id' onclick=\"SaveSetting('save_setting_access_all_leads')\"  /> <small id='save_setting_access_all_leads_txt' style='vertical-align:super;' >remove setting</small>";
	}else{
		$save_setting_access_all_leads = "<input type='checkbox' name='save_setting_access_all_leads' value='business_developer_id' onclick=\"SaveSetting('save_setting_access_all_leads')\"  /> <small id='save_setting_access_all_leads_txt' style='vertical-align:super;' >save setting</small>";
	}
	//echo $leads_order_by_setting;
	if($leads_order_by_setting){
		$save_setting_leads_order_by = "<input type='checkbox' checked name='save_setting_leads_order_by' value='order_by' onclick=\"SaveSetting('save_setting_leads_order_by')\"  /> <small id='save_setting_leads_order_by_txt' style='vertical-align:super;' >remove setting</small>";
		//$list_view = True;
	}else{
		$save_setting_leads_order_by = "<input type='checkbox' name='save_setting_leads_order_by' value='order_by' onclick=\"SaveSetting('save_setting_leads_order_by')\"  /> <small id='save_setting_leads_order_by_txt' style='vertical-align:super;' >save setting</small>";
	}
	
	//configure the leads list view
	
	 
	
	$smarty->assign('save_setting_access_all_leads',$save_setting_access_all_leads);
	$smarty->assign('save_setting_leads_order_by',$save_setting_leads_order_by);
	$smarty->assign('agent_section',True);
	
	
	
}else if($_SESSION['admin_id'] !="" or $_SESSION['admin_id'] != NULL){
	
	$admin_id = $_SESSION['admin_id'];
	$admin_status=$_SESSION['status'];
	$sql=$db->select()
		->from('admin')
		->where('admin_id = ?' ,$admin_id);
	$admin = $db->fetchRow($sql);
	
	$session_name = $admin['admin_fname']." ".$admin['admin_lname'];
	$session_email = $admin['admin_email'];
	$created_by_id = $_SESSION['admin_id'];
	$created_by_type = 'admin';
	$access_all_leads = 'YES';
	
	$smarty->assign('admin_section',True);	
	$smarty->assign('admin_status',$admin_status);	
	
	if($admin_status != "FULL-CONTROL") {
		$lead_status = "Client";
	}
	
	//for exporting : Rica can only access this feature
	//admin id's : 6 = rica , 19 = tam , 5 = Norman , 17 = Lawrence , 16 = PJ , 30 = rhiza , 31 = Angel
	if (in_array($_SESSION['admin_id'], array(6)) == true) {
		$smarty->assign('show_export_button',True);
	}


}else{
	header("location:index.php");
}



include 'leads_function.php';
include 'lib/addLeadsInfoHistoryChanges.php';
include 'leads_information/ShowLeadsOrder.php';



$AusTime = date("H:i:s"); 
$AusDate = date("Y")."-".date("m")."-".date("d");
$ATZ = $AusDate." ".$AusTime;

$lead_status = $_REQUEST['lead_status'];
//echo $lead_status;
$lead_status_selection = False;
$agent_id = $_REQUEST['agent_id'];

$keyword = $_REQUEST['keyword'];
$event_date = $_REQUEST['event_date'];
$ratings = $_REQUEST['ratings'];
$month = $_REQUEST['month'];
$year = $_REQUEST['year'];
$location_id = $_REQUEST['location_id'];
$tme_flag = 0;
$registered_in = $_REQUEST['registered_in'];
$url = basename($_SERVER['SCRIPT_FILENAME'])."?".$_SERVER['QUERY_STRING'];
$order_by = $_REQUEST['order_by'];

$filter = $_REQUEST['filter'];
if(!$filter){
	header("location:leads-active.php?lead_status=Client&filter=ACTIVE");
}

if(!$order_by){
	$order_by = $leads_order_by_setting;
}

$business_developer_id = $_REQUEST['business_developer_id'];
if(!$business_developer_id){
	//if(!$view_leads_setting){
	//	$view_leads_setting = 'all';
	//}
	$business_developer_id = $view_leads_setting;
}

//echo $business_developer_id;
$rowsPerPage = $_REQUEST['rowsPerPage'];
if(!$rowsPerPage){
	// how many rows to show per page
	$rowsPerPage = 10;
}

$search_flag = False;


//// USE FOR PAGING ///
// by default we show first page
$pageNum = 1;
// if $_GET['page'] defined, use it as page number
if(isset($_GET['page']))
{
	$pageNum = $_GET['page'];
}
// counting the offset

if($pageNum!=NULL and $agent_id!=NULL){
	$offset2 = ($pageNum - 1) * $rowsPerPage;
}
$offset = 0;


if (array_key_exists('_submit_check', $_POST)) {
	$lead_status = $_POST['folder'];
	$folder = $_POST['folder'];
}

//REMOVED
if(isset($_POST['REMOVED'])){
	$transfer_ok = 0;
	$applicants =$_REQUEST['applicants'];
	if($created_by_type == 'agent') {
		$change_by_type = 'bp';
	}else{
		$change_by_type = 'admin';
	}	
	
	if($applicants == ""){
		$smarty->assign('leads_transfer_error_msg','Please choose leads to be remove');
		$transfer_ok = 1;
	}
	
	if($transfer_ok ==0){
		if($applicants != ""){
			$users=explode(",",$applicants);
			for ($i=0; $i<count($users);$i++)
			{
				if($users[$i] > 0 or $users[$i]!=""){
					$data = array('status' => 'REMOVED' , 'marked' => 'no');
					addLeadsInfoHistoryChanges($data , $users[$i] , $created_by_id , $change_by_type);
					$where = "id = ".$users[$i];	
					$db->update('leads' ,  $data , $where);
				}	
			}
			$smarty->assign('leads_transfer_error_msg','Successfully removed from the list');
		}
	}
}
//REMOVED ends here

//move
if(isset($_POST['move'])){
	
	$transfer_ok = 0;
	$applicants =$_REQUEST['applicants'];
	if($created_by_type == 'agent') {
		$change_by_type = 'bp';
	}else{
		$change_by_type = 'admin';
	}	
	
	if($_POST['status'] == ""){
		$smarty->assign('leads_transfer_error_msg','Lead Status is missing');
		$transfer_ok = 1;
	}
	
	
	if($applicants == ""){
		$smarty->assign('leads_transfer_error_msg','Please choose leads to move');
		$transfer_ok = 1;
	}
	
	if($transfer_ok ==0){
		if($applicants != ""){
			$users=explode(",",$applicants);
			for ($i=0; $i<count($users);$i++)
			{
				if($users[$i] > 0 or $users[$i]!=""){
					$data = array('status' => $_POST['status']);
					addLeadsInfoHistoryChanges($data , $users[$i] , $created_by_id , $change_by_type);
					$where = "id = ".$users[$i];	
					$db->update('leads' ,  $data , $where);
					
					$sql = $db->select()
						->from('leads' , Array('fname','lname'))
						->where('id =?',$users[$i]);
					$leads = $db->fetchRow($sql);	
					$tranferred_leads.="<li>".$leads['fname']." ".$leads['lname']."</li>";
				}	
			}
			$str="<ol>";
			$str.=$tranferred_leads;
			$str.="</ol>Transferred to ".$_POST['status'];
			$smarty->assign('leads_transfer_error_msg',$str);
			$tme_flag = 1;
		}
	}
}
//move end here



//transferring
$transfer_message = "";
if(isset($_POST['transfer']))
{
	//echo "Transfer Click";
	$transfer_ok = 0;
	$applicants =$_REQUEST['applicants'];
	$agent_id=$_REQUEST['agent_id'];
	$users=explode(",",$applicants);
	if($applicants == ""){
		$smarty->assign('leads_transfer_error_msg','Please choose any leads to begin transfer');
		$transfer_ok = 1;
	}
	
	if($transfer_ok == 0){
			for ($i=0; $i<count($users);$i++)
			{
					$sql = $db->select()
						->from('leads' , Array('agent_id' , 'business_partner_id'))
						->where('id =?' ,$users[$i]);
					
					//echo $sql;
					$agents = $db->fetchRow($sql);	
					$agent = $agents['agent_id'];
					$business_partner_id = $agents['business_partner_id'];
					//echo $agent." ".$business_partner_id."<br>";
					
					
					$sql = $db->select()
						->from('agent' , 'work_status')
						->where('agent_no =?' ,$agent);
					$work_status = $db->fetchOne($sql);	
					
					if($created_by_type == 'agent') {
						$change_by_type = 'bp';
					}else{
						$change_by_type = 'admin';
					}
					
					if($work_status!=""){
						if($work_status == "AFF"){
							$data = array(
										'business_partner_id' => $agent_id,
										'date_move' => $ATZ ,
										'agent_from' => $business_partner_id	
									);
							//addLeadsInfoHistoryChanges($data , $users[$i] , $admin_id , 'admin');
							$where = "id = ".$users[$i];	
							$db->update('leads' ,  $data , $where);	
							
							
							
								
						}
						if($work_status == "BP"){
							$data = array(
										'agent_id' => $agent_id ,
										'business_partner_id' => $agent_id,
										'date_move' => $ATZ ,
										'agent_from' => $business_partner_id	
									);
							//addLeadsInfoHistoryChanges($data , $users[$i] , $admin_id , 'admin');
							$where = "id = ".$users[$i];	
							$db->update('leads' ,  $data , $where);						
						}
						//$transfer_message = " <b>Successfully Transferred!</b>";
						
						//create a history
						$sql = $db->select()
							->from('agent' , 'fname')
							->where('agent_no =?' ,$business_partner_id);
						$from_name = $db->fetchOne($sql);
						
						
						$sql = $db->select()
							->from('agent' , 'fname')
							->where('agent_no =?' ,$agent_id);
						$to_name = $db->fetchOne($sql);	
						
						$history_changes = sprintf('Leads transfered from BP %s to BP %s' , $from_name , $to_name);
						$changes = array('leads_id' => $users[$i] ,
									 'date_change' => $ATZ, 
									 'changes' => $history_changes, 
									 'change_by_id' => $created_by_id, 
									 'change_by_type' => $change_by_type
									 );
						$db->insert('leads_info_history', $changes);	
						
						$sql = $db->select()
							->from('leads' , Array('fname','lname'))
							->where('id =?',$users[$i]);
						$leads = $db->fetchRow($sql);	
						$tranferred_leads.="<li>".$leads['fname']." ".$leads['lname']."</li>";
						
						
					}
					
				
				
			}
			$str="<ol>";
			$str.=$tranferred_leads;
			$str.="</ol>Successfully Transferred to ".$to_name;
			//$smarty->assign('leads_transfer_error_msg','Successfully Transferred to '.$to_name.$str);
			$message = $str;
			$smarty->assign('leads_transfer_error_msg',$str);
			$tme_flag = 1;
	
	}
	
	
}
//transferring ends here

if($keyword!=NULL){
	
	$search_text = $keyword;
	$search_text=ltrim($search_text);
	$search_text=rtrim($search_text);
	
	$kt=explode(" ",$search_text);//Breaking the string to array of words
	// Now let us generate the sql 
	while(list($key,$val)=each($kt)){
		if($val<>" " and strlen($val) > 0){
			
			$queries .= " l.id like '%$val%' or l.fname like '%$val%' or l.lname like '%$val%' or l.email like '%$val%' or l.company_position like '%$val%' or l.company_name like '%$val%' or l.company_address like '%$val%' or l.officenumber like '%$val%' or l.mobile like '%$val%' or l.sec_fname like '%$val%' or l.sec_lname like '%$val%' or l.sec_email like '%$val%' or l.sec_phone like '%$val%' or l.sec_position like '%$val%' or l.acct_dept_name1 like '%$val%' or l.acct_dept_email1 like '%$val%' or l.acct_dept_name2 like '%$val%' or l.acct_dept_email2 like '%$val%' or l.supervisor_staff_name like '%$val%' or l.supervisor_email like '%$val%' or";
		}
	}// end of while
	
	$queries=substr($queries,0,(strlen($queries)-3));
	// this will remove the last or from the string. 
	$keyword_search =  " AND ( ".$queries." ) ";
	//echo $keyword_search;exit;
	$search_flag = True;
	
	
}else{
	$keyword_search = " ";
}


if ($event_date!=NULL){
	$event_date_search = " AND DATE(l.timestamp) = '$event_date' ";
	$search_flag = True;
	
}else{
	$event_date_search =" ";
}


if($ratings!=NULL){
	$ratings_search = "AND l.rating='$ratings' ";
	$search_flag = True;
	
}else{
	$ratings_search = " ";
}


if($month!=NULL){
	$month_search = " AND MONTH(l.timestamp) = '$month' ";
	$search_flag = True;
	
}else{
	$month_search = " ";
}

if($year!=NULL){
	$year_search = " AND YEAR(l.timestamp) = '$year' ";
	$search_flag = True;
	
}else{
	$year_search = " ";
}

if($registered_in != NULL){
	$registered_in_search = " AND l.registered_in = '$registered_in' ";
	$search_flag = True;
	
}else{
	$registered_in_search = " ";
}


if($location_id != NULL){
	$location_id_search = " AND l.location_id = '$location_id' ";
	$search_flag = True;
}else{
	$location_id_search = " ";
}






//echo $access_all_leads."<br>".$lead_status."<br>";
if($access_all_leads == 'YES'){
	
	if(!$business_developer_id){
		$business_developer_id = 'all';
	}
	if($business_developer_id == 'all'){
		if($lead_status == "All"){
			$status_Search = " l.status != 'Inactive' AND  l.status != 'REMOVED' ";
		}else{
			$status_Search = " l.status = '$lead_status' ";
		}
		
		$status_Search2 = $status_Search;
	}else{
			
			if($lead_status == "All"){
				$status_Search = " l.status != 'Inactive' AND  l.status != 'REMOVED' AND l.business_partner_id = ".$business_developer_id;
				$status_Search2 = " l.status != 'Inactive' AND  l.status != 'REMOVED' ";
			}else{
				if($lead_status == "Keep In-Touch"){
					$status_Search = " l.status = '$lead_status' ";
				}else{
					$status_Search = " l.status = '$lead_status' AND l.business_partner_id = ".$business_developer_id;
				}
				$status_Search2 = " l.status = '$lead_status' ";
			}
		
			
	}
	//echo $status_Search;	
	//$sql = "SELECT l.business_partner_id , a.fname , a.lname FROM leads l JOIN agent a ON a.agent_no = l.business_partner_id WHERE $status_Search2 $search_options GROUP BY business_partner_id ORDER BY business_partner_id;";	
	//echo $business_developer_id;
	$sql = $db->select()
			->from('agent')
			->where('work_status =?' , 'BP')
			->where('status =?' ,'ACTIVE')
			->order('fname');
	//echo $sql;//exit;
	$business_partners = $db->fetchAll($sql);
	//print_r($business_partners);				
	foreach($business_partners as $business_partner){
		if($business_developer_id == $business_partner['agent_no']){
			$business_partners_id_options .=	"<option selected value='".$business_partner['agent_no']."'>".$business_partner['fname']." ".$business_partner['lname']."</option>";	
		}else{
			$business_partners_id_options .=	"<option value='".$business_partner['agent_no']."'>".$business_partner['fname']." ".$business_partner['lname']."</option>";
		}
	}


}else{
		//echo $created_by_type."<br>";
		if($created_by_type == 'agent'){
			if(!$business_developer_id){
				$business_developer_id = $_SESSION['agent_no'];
			}
		}
		if($lead_status == "All"){
			$status_Search = " l.status != 'Inactive' AND  l.status != 'REMOVED' AND l.business_partner_id = ".$business_developer_id;
		}else{
		
			if($lead_status == "Keep In-Touch"){
				$status_Search = " l.status = '$lead_status' ";
			}else{
				$status_Search = " l.status = '$lead_status' AND l.business_partner_id = ".$business_developer_id;
			}
			
		}
	
}


$search_options = $keyword_search . $event_date_search . $ratings_search . $month_search . $year_search . $registered_in_search . $location_id_search;

//echo $order_by." <br> ".$leads_order_by_setting;

$order_by_array = array('DESC' , 'ASC');
$order_by_array2 = array('DESCENDING [current to old]' , 'ASCENDING [old to new]');
for($i=0; $i<count ($order_by_array); $i++){
	if($order_by == $order_by_array[$i]){
		$order_by_options .="<option selected value='".$order_by_array[$i]."'>".$order_by_array2[$i]."</option>";
	}else{
		$order_by_options .="<option value='".$order_by_array[$i]."'>".$order_by_array2[$i]."</option>";
	}
}



if($order_by){
	$search_flag = True;
	if($filter == 'ACTIVE'){
		include 'leads_active_list_order_by_view.php';
	}else if($filter == 'INACTIVE'){
		include 'leads_inactive_list_order_by_view.php';
	}else{
		include 'leads_client_list_order_by_view.php';
	}
}else{
	//default view of the list
	if($filter == 'ACTIVE'){
		include 'leads_active_list_default_view.php';
	}else if($filter == 'INACTIVE'){
		include 'leads_inactive_list_default_view.php';
	}else{
		include 'leads_client_list_default_view.php';
	}	
	
}
//leads display script ends here

$active_h2 = '';
$inactive_h2 = '';
$all_h2 = '';
 
if($filter == 'ACTIVE'){
	$active_h2 = 'class="inf_select"';
}

if($filter == 'INACTIVE'){
	$inactive_h2 = 'class="inf_select"';
}

if($filter == 'ALL'){
	$all_h2 = 'class="inf_select"';
}
//echo $filter.$all_h2;






$registered_in_lookup = array(
		'home page' => 'Registered in Home page',
	'available staff' => 'Registered thru Available Staff', 
	'recruitment service' => 'Registered thru Recruitment Service' ,
	'contact us' => 'Registered in Contact Us page',
	'send resume' => 'Registered thru Send Resume',
	'added manually' => 'Added Manually',
	'ask a question' => 'Ask A Question',
	' ' => 'Unknown location'
);

if(!$folder){
	if($lead_status != 'All'){
		$folder = $lead_status;
	}
}
$sql = $db->select()
	->from('leads' , 'status')
	->group('status');
//echo $sql;	
$status_array = $db->fetchAll($sql);	
foreach($status_array as $stats){
	if($stats['status']!=""){
		
		//Admin user
		if($created_by_type == 'admin') {
			if ($admin_status=="FULL-CONTROL") {	
				if($folder == $stats['status']){
					$searchoptions .= "<option selected value='".$stats['status']."'>".$stats['status']."</option>\n";
				}else{
					$searchoptions .= "<option value='".$stats['status']."'>".$stats['status']."</option>\n";
				}
			}else{
				$searchoptions = "<option selected value='Client'>Client</option>\n";
			}
		}
		
		//Agent
		if($created_by_type == 'agent') {
			if($folder == $stats['status']){
				$searchoptions .= "<option selected value='".$stats['status']."'>".$stats['status']."</option>\n";
			}else{
				$searchoptions .= "<option value='".$stats['status']."'>".$stats['status']."</option>\n";
			}
		}
	}
}

if($folder == "") {
	$folder = $_GET['lead_status'];
}else{
	$folder = $_REQUEST['folder'];
}	

if (in_array($folder, array('New Leads', 'Follow-Up', 'Keep In-Touch' , 'Inactive')) == true) {
	$smarty->assign('enable_disable_btn' , True);
}


/*
$transfer_status = array('New Leads', 'Follow-Up', 'Keep In-Touch', 'pending' , 'asl', 'custom recruitment');
for($i=0; $i<count($transfer_status);$i++){
	if($lead_status != $transfer_status[$i]){
		$transfer_buttons .="<input type='submit' class='move_btns' name='move' value='".$transfer_status[$i]."' onclick=\"Move('".$transfer_status[$i]."')\" />&nbsp;";
	}
}
*/





//detect the status of the leads wants to view
if($lead_status == ""){
	
	
	$lead_status_selection_status = array('New Leads', 'Follow-Up', 'Keep In-Touch', 'Interview Bookings', 'pending' , 'custom recruitment' , 'Client' , 'All');
	for($i=0; $i<count ($lead_status_selection_status); $i++){
		$lead_status_selection_Options .="<input type='radio' onclick=\"javascript:location.href='leads.php?lead_status=".$lead_status_selection_status[$i]."'\" /> ".strtoupper($lead_status_selection_status[$i]);

	}
	
	$smarty->assign('lead_status_selection',True);
	$smarty->assign('lead_status_selection_Options',$lead_status_selection_Options);	
}
//





$rows = array(5,10,20,30,40,50,100);
for($i=0; $i<count($rows); $i++){
	if($rowsPerPage == $rows[$i]){
		$rowsPerPageOptions .="<option selected value='".$rows[$i]."'>".$rows[$i]."</option>";
	}else{
		$rowsPerPageOptions .="<option value='".$rows[$i]."'>".$rows[$i]."</option>";
	}
}

$monthArray=array("","01","02","03","04","05","06","07","08","09","10","11","12");
$monthName=array("-","January","February","March","April","May","June","July","August","September","October","November","December");
for ($i = 0; $i < count($monthArray); $i++)
{
	if($month == $monthArray[$i]){
		$monthoptions .= "<option selected value=\"$monthArray[$i]\">$monthName[$i]</option>\n";
	}else{
		$monthoptions .= "<option value=\"$monthArray[$i]\">$monthName[$i]</option>\n";
	}
}


$currentYear = date("Y");
for($i=2008; $i<=$currentYear;$i++){
	if($year == $i){
		$yearoptions .="<option selected value='".$i."'>".$i."</option>";
	}else{
		$yearoptions .="<option value='".$i."'>".$i."</option>";
	}
}

$sqlBBTransferLeads = "SELECT t.agent_no,CONCAT(a.fname,' ',a.lname)AS agent_name FROM agent_transfer_leads t LEFT JOIN agent a ON a.agent_no = t.agent_no;";
$result = $db->fetchAll($sqlBBTransferLeads);
foreach($result as $agent){
	if($created_by_type == 'agent'){
		if($_SESSION['agent_no'] != $agent['agent_no']){
			$BPOptions.="<option value='".$agent['agent_no']."'>".$agent['agent_name']."</option>";
		}
	}else{
		$BPOptions.="<option value='".$agent['agent_no']."'>".$agent['agent_name']."</option>";
	}
}


for($i=1; $i<6; $i++){
	if($ratings == $i){
		$rate_options .="<option selected value='".$i."'>".$i."</option>";
	}else{
		$rate_options .="<option value='".$i."'>".$i."</option>";
	}
}


$registered_in_array =array('home page' ,'available staff', 'recruitment service', 'contact us', 'send resume', 'added manually');
for($i=0; $i<count($registered_in_array); $i++){
	if($registered_in == $registered_in_array[$i]){
		$registered_in_options .= "<option selected value='".$registered_in_array[$i]."'>".$registered_in_array[$i]."</option>";
	}else{
		$registered_in_options .= "<option value='".$registered_in_array[$i]."'>".$registered_in_array[$i]."</option>";
	}
}



$sql = $db->select()
	->from('leads_location_lookup');
$leads_location_lookup = $db->fetchAll($sql);	
foreach($leads_location_lookup as $location){
	if($location_id == $location['id']){
		$location_id_options .=	"<option selected value='".$location['id']."'>".$location['location']."</option>";	
	}else{
		$location_id_options .=	"<option value='".$location['id']."'>".$location['location']."</option>";	
	}
}				











	

///////////////////////////////////////
$smarty->assign('active_h2',$active_h2);
$smarty->assign('inactive_h2',$inactive_h2);
$smarty->assign('all_h2' ,$all_h2);
$smarty->assign('filter',$filter);
$smarty->assign('order_by_options',$order_by_options);
$smarty->assign('business_partners_id_options' , $business_partners_id_options);
$smarty->assign('access_all_leads' , $access_all_leads);
$smarty->assign('view',$view);
$smarty->assign('tme_flag',$tme_flag);
$smarty->assign('location_id_options',$location_id_options);
$smarty->assign('yearoptions',$yearoptions);
$smarty->assign('search',$search_flag);
$smarty->assign('registered_in_options',$registered_in_options);
$smarty->assign('transfer_buttons',$transfer_buttons);
$smarty->assign('BPOptions',$BPOptions);
$smarty->assign('monthoptions',$monthoptions);
$smarty->assign('keyword',$keyword);
$smarty->assign('event_date',$event_date);
$smarty->assign('rate_options',$rate_options);

$smarty->assign('rowsPerPageOptions',$rowsPerPageOptions);
$smarty->assign('searchoptions',$searchoptions);
$smarty->assign('leads_list', $leads_list);
$smarty->assign('lead_status', $lead_status);
$smarty->assign('session_name', $session_name);
$smarty->display('leads-active.tpl');