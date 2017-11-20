<?php

//CONFIG FILE
include('../conf/zend_smarty_conf.php');

//HEADERS
header("Expires: Mon, 26 Jul 1997 05:00:00GMT");
header("Cache-Control: no-cache");
header('Content-type: text/html; charset=utf-8');
header("Pragma: no-cache");

//NEW INSTANCE SMARTY
$smarty = new Smarty;

//this will check the admin/bp session and current user settings
include('AdminSessionChecker.php'); //place this after the zend_smarty_conf.php script and  $smarty = new Smarty;

//INCLUDE REQUIRED FILES
include '../leads_function.php';
include '../leads_information/ShowLeadsOrder.php';
include '../lib/addLeadsInfoHistoryChanges.php';


//DATE TIME FORMAT
$AusTime = date("H:i:s"); 
$AusDate = date("Y")."-".date("m")."-".date("d");
$ATZ = $AusDate." ".$AusTime;

//LEAD STATUS SEARCH
$lead_status = $_REQUEST['lead_status'];

//HIRING COORDINATOR SEARCH
$hiring_coordinator_id = $_REQUEST['hiring_coordinator_id'];

//KEYWORD SEARCH DEPEND ON FIELD TYPE
$field = $_REQUEST['field'];
$keyword = $_REQUEST['keyword'];

//BUSINESS DEVELOPER SEARCH
$business_developer_id = $_REQUEST['business_developer_id'];

//PIN SEARACH
$pin = $_REQUEST['pin'];

//CSRO SEARCH
$csro_id = $_REQUEST['csro_id'];

//DATE UPDATED
$date_updated_start = $_REQUEST['date_updated_start'];
$date_updated_end = $_REQUEST['date_updated_end'];

//REGISTER DATE
$register_date_start = $_REQUEST['register_date_start'];
$register_date_end = $_REQUEST['register_date_end'];

//echo "<pre>";
//print_r($_REQUEST);
//die;


//$order_by = $_REQUEST['order_by'];
//$ratings = $_REQUEST['ratings'];



$url = 'leads_list/'.basename($_SERVER['SCRIPT_FILENAME'])."?".$_SERVER['QUERY_STRING'];


$search_str = ""; 
$enable_disable_btn = False;
$show_notice = False;
$remark ="";
//// USE FOR PAGING ///
// how many rows to show per page
$rowsPerPage = $_REQUEST['rowsPerPage'];
//echo $rowsPerPage;

if($rowsPerPage == ""){
	$rowsPerPage = 20;
}
// by default we show first page
$pageNum = 1;
// if $_GET['page'] defined, use it as page number
if(isset($_REQUEST['page']))
{
	$pageNum = $_REQUEST['page'];
}
// counting the offset
//echo $pageNum ;

$offset = 0;
if($pageNum!=NULL){
	$offset = ($pageNum - 1) * $rowsPerPage;
	$offset2 = ($pageNum - 1) * $rowsPerPage;
}

//get all admin Hiring Coordinator
$sql = $db->select()
	->from('admin')
	->where('status !=?' , 'REMOVED')
	->where('hiring_coordinator =?' , 'Y');
$hiring_coordinators = $db->fetchAll($sql);

//get all admin CSRO
$sql = $db->select()
	->from('admin')
	->where('status !=?' , 'REMOVED')
	->where('csro =?' , 'Y');
$csro_officers = $db->fetchAll($sql);

//$limit = " LIMIT $offset, $rowsPerPage ";
//echo $limit;
$order_by = 'DESC';
/*
if(!$order_by){
    if($current_user['leads_order_by_setting'] == ""){
	    $order_by = 'DESC';
	}else{
	    $order_by = $current_user['leads_order_by_setting'];
	}	
}
*/
//echo $current_user['view_leads_setting']."<br>";
//echo $current_user['access_all_leads']."<br>";
if($business_developer_id==""){

    if($current_user['user_type'] == "BP"){
	//user is Business Developer
	    if($current_user['view_leads_setting']==""){
	        $business_developer_id = $current_user['id']; //assuming that the current user is BP
		}else{
		    $business_developer_id = $current_user['view_leads_setting'];
		}	
	}else{
	//user is Admin
	    $business_developer_id = $current_user['view_leads_setting'];
	}
	/*
    if($current_user['view_leads_setting']==""){
	    $business_developer_id = $current_user['id']; //assuming that the current user is BP
	}
    if($current_user['access_all_leads'] == 'NO'){
	    $business_developer_id = $current_user['id']; //assuming that the current user is BP
	}
	else{
	    $business_developer_id = $current_user['view_leads_setting'];
	}	
	*/
	//echo "business_developer_id => ".$business_developer_id;
}
//echo "<pre>";
//print_r($current_user);
//echo "</pre>";
$sql = "SELECT DISTINCT(status)as status FROM leads;";
$lead_statuses = $db->fetchAll($sql);
/*
$sql = $db->select()
    ->from('agent')
	->where('work_status =?' , 'BP')
	->where('status =?' ,'ACTIVE')
	->order('fname');
*/
$sql = "SELECT business_partner_id, a.agent_no, a.fname, a.lname FROM leads l JOIN agent a ON a.agent_no = l.business_partner_id  GROUP BY business_partner_id ORDER BY a.fname;";	
$business_partners = $db->fetchAll($sql);



$order_by_array = array('DESC' , 'ASC');
for($i=0; $i<count ($order_by_array); $i++){
	if($order_by == $order_by_array[$i]){
		$order_by_options .="<option selected value='".$order_by_array[$i]."'>".$order_by_array[$i]."ENDING</option>";
	}else{
		$order_by_options .="<option value='".$order_by_array[$i]."'>".$order_by_array[$i]."ENDING</option>";
	}
}

for($i=1; $i<6; $i++){
	if($ratings == $i){
		$rate_options .="<option selected value='".$i."'>".$i."</option>";
	}else{
		$rate_options .="<option value='".$i."'>".$i."</option>";
	}
}

//REMOVED
if(isset($_POST['remove'])){
	
	$users=explode(",",$_REQUEST['applicants']);
	for ($i=0; $i<count($users);$i++){
		if($users[$i] > 0 or $users[$i]!=""){
			$data = array('status' => 'REMOVED');
			addLeadsInfoHistoryChanges($data , $users[$i] , $current_user['id'] , $current_user['change_by_type']);
			$data['last_updated_date'] = $ATZ;
			$where = "id = ".$users[$i];	
			$db->update('leads' ,  $data , $where);
			
			$sql = $db->select()
				->from('leads' , Array('id','fname','lname'))
				->where('id =?',$users[$i]);
			$leads = $db->fetchRow($sql);	
			$tranferred_leads.= sprintf('<li>%s %s %s</li>', $leads['id'], $leads['fname'], $leads['lname']);
		}	
	}
	$show_notice_str = sprintf('<p><ol>Removed leads : %s</ol></p>', $tranferred_leads);
	$show_notice = True;
	$smarty->assign('body_attributes', "id='navselected' onLoad='placeIt()'");
	
}
//REMOVED ends here
//move
if(isset($_POST['move'])){
	//echo $_REQUEST['applicants']." ".$_POST['status'];
	$users=explode(",",$_REQUEST['applicants']);
	for ($i=0; $i<count($users);$i++)
	{
		if($users[$i] > 0 or $users[$i]!=""){
			$data = array('status' => $_POST['status']);
			addLeadsInfoHistoryChanges($data , $users[$i] , $current_user['id'] , $current_user['change_by_type']);
			$where = "id = ".$users[$i];
			$data['last_updated_date'] = $ATZ;	
			$db->update('leads' ,  $data , $where);
					
			$sql = $db->select()
				->from('leads' , Array('id','fname','lname'))
				->where('id =?',$users[$i]);
			$leads = $db->fetchRow($sql);	
			$tranferred_leads.= sprintf('<li>%s %s %s</li>', $leads['id'], $leads['fname'], $leads['lname']);
		}	
	}
	$show_notice_str = sprintf('<p><ol>List of leads moved to <span><strong>%s</strong></span> %s</ol></p>', $_POST['status'], $tranferred_leads);
	$show_notice = True;
	$smarty->assign('body_attributes', "id='navselected' onLoad='placeIt()'");
	
}	
//end move

//transfer
if(isset($_POST['transfer'])){

	$users=explode(",",$_REQUEST['applicants']);
	$agent_id=$_REQUEST['agent_id'];
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
					
					
					if($work_status!=""){
						if($work_status == "AFF"){
							$data = array(
										'business_partner_id' => $agent_id,
										'date_move' => $ATZ ,
										'agent_from' => $business_partner_id	
									);
							//addLeadsInfoHistoryChanges($data , $users[$i] , $admin_id , 'admin');
							$data['last_updated_date'] = $ATZ;
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
							$data['last_updated_date'] = $ATZ;
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
									 'change_by_id' => $current_user['id'], 
									 'change_by_type' => $current_user['change_by_type']
									 );
						$db->insert('leads_info_history', $changes);	
						
						$sql = $db->select()
							->from('leads' , Array('fname','lname'))
							->where('id =?',$users[$i]);
						$leads = $db->fetchRow($sql);	
						$tranferred_leads.= sprintf('<li>%s %s %s</li>', $leads['id'], $leads['fname'], $leads['lname']);
						
						
					}
					
				
				
			}
			$show_notice_str = sprintf('<p><ol>Successfully Transferred to <span><strong>%s</strong></span> %s</ol></p>', $to_name, $tranferred_leads);
	        $show_notice = True;
			$smarty->assign('body_attributes', "id='navselected' onLoad='placeIt()'");

}
//end transfer

if($lead_status){
    if($lead_status != 'All'){
        $search_str = " WHERE l.status = '".$lead_status."' ";
	    $search_str2 = " AND l.status = '".$lead_status."' ";
    }else{
        $search_str = "";
	    $search_str2 = "";    
    }
}else{
    $search_str = "";
	$search_str2 = ""; 
}

//echo $business_developer_id;
if($business_developer_id != 'all' ){

    $sql = $db->select()
	    ->from('agent')
		->where('agent_no =?', $business_developer_id);
	//echo $sql;//exit;
	$bd = $db->fetchRow($sql);
	
	$bd_name = "Business Developer : ".$bd['fname']." ".$bd['lname'];	
	
    // SEARCH PER BP
    if($search_str == "" ){
	    $search_str = " WHERE business_partner_id ='".$business_developer_id."' ";
		$search_str2 = " AND business_partner_id ='".$business_developer_id."' ";
	}else{
	    $search_str = $search_str." AND business_partner_id ='".$business_developer_id."' ";
		$search_str2 = $search_str2." AND business_partner_id ='".$business_developer_id."' ";
	}
}
/*
if($ratings!=NULL){
	if($search_str == "" ){
	    $search_str = " WHERE l.rating='$ratings' ";
		$search_str2 = " AND l.rating='$ratings' ";
	}else{
	    $search_str = $search_str." AND l.rating='$ratings' ";
		$search_str2 = $search_str2." AND l.rating='$ratings' ";
	}
}
*/
if($hiring_coordinator_id !=NULL){
    if($search_str == "" ){
	    $search_str = " WHERE l.hiring_coordinator_id=$hiring_coordinator_id ";
		$search_str2 = " AND l.hiring_coordinator_id=$hiring_coordinator_id ";
	}else{
	    $search_str = $search_str." AND l.hiring_coordinator_id=$hiring_coordinator_id ";
		$search_str2 = $search_str2." AND l.hiring_coordinator_id=$hiring_coordinator_id ";
	}
	
	$sql = $db->select()
	    ->from('admin')
		->where('admin_id =?', $hiring_coordinator_id);
	$hc = $db->fetchRow($sql);
	$hc_name = "Hiring Coordinator : ".$hc['admin_fname']." ".$hc['admin_lname'];	
}


if($csro_id !=NULL){
    if($search_str == "" ){
	    $search_str = " WHERE l.csro_id=$csro_id ";
		$search_str2 = " AND l.csro_id=$csro_id ";
	}else{
	    $search_str = $search_str." AND l.csro_id=$csro_id ";
		$search_str2 = $search_str2." AND l.csro_id=$csro_id ";
	}
	
	$sql = $db->select()
	    ->from('admin')
		->where('admin_id =?', $csro_id);
	$hc = $db->fetchRow($sql);
	$csro_name = "CSRO : ".$hc['admin_fname']." ".$hc['admin_lname'];	
}

if($pin != NULL){
    if($search_str == "" ){
	    $search_str = " WHERE l.mark_lead_for='$pin' ";
		$search_str2 = " AND l.mark_lead_for='$pin' ";
	}else{
	    $search_str = $search_str." AND l.mark_lead_for='$pin' ";
		$search_str2 = $search_str2." AND l.mark_lead_for='$pin' ";
	}
	
	//echo sprintf('%s <hr>%s', $search_str, $search_str2);
	//exit;
}

if($keyword){
    //echo $field." ".$keyword;
	if($field == "keyword"){
	    //KEYWORD SEARCH
	    //searching 2 words or more
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
	    $keyword_search =  " ( ".$queries." ) ";
	    
		if($search_str == "" ){
	        $search_str = " WHERE ".$keyword_search;
			$search_str2 = " AND ".$keyword_search;
	    }else{
	        $search_str = $search_str." AND ".$keyword_search;
			$search_str2 = $search_str2." AND ".$keyword_search;
	    }    
	}else{
	    if($search_str == "" ){
	        $search_str = " WHERE ".$field." LIKE '".$keyword."' ";
			$search_str2 = " AND ".$field." LIKE '".$keyword."' ";
	    }else{
	        $search_str = $search_str." AND ".$field." LIKE '".$keyword."' ";
			$search_str2 = $search_str2." AND ".$field." LIKE '".$keyword."' ";
	    }
	}
}

//DATE UPDATE CONCATINATED SEARCH QUERY
if($date_updated_start != NULL && $date_updated_end != NULL){
    if($search_str == "" ){
	    $search_str = " WHERE DATE(l.last_updated_date)>='$date_updated_start' AND DATE(l.last_updated_date)<='$date_updated_end' ";
		$search_str2 = " AND DATE(l.last_updated_date)>='$date_updated_start' AND DATE(l.last_updated_date)<='$date_updated_end' ";
	}else{
	    $search_str = $search_str." AND DATE(l.last_updated_date)>='$date_updated_start' AND DATE(l.last_updated_date)<='$date_updated_end' ";
		$search_str2 = $search_str2." AND DATE(l.last_updated_date)>='$date_updated_start' AND DATE(l.last_updated_date)<='$date_updated_end' ";
	}
}

//REGISTER DATE CONCATINATED SEARCH QUERY
if($register_date_start != NULL && $register_date_end != NULL){
    if($search_str == "" ){
	    $search_str = " WHERE DATE(l.timestamp)>='$register_date_start' AND DATE(l.timestamp)<='$register_date_end' ";
		$search_str2 = " AND DATE(l.timestamp)>='$register_date_start' AND DATE(l.timestamp)<='$register_date_end' ";
	}else{
	    $search_str = $search_str." AND DATE(l.timestamp)>='$register_date_start' AND DATE(l.timestamp)<='$register_date_end' ";
		$search_str2 = $search_str2." AND DATE(l.timestamp)>='$register_date_start' AND DATE(l.timestamp)<='$register_date_end' ";
	}
}


//echo $lead_status."<br>".$_GET['filter'];
//include 'leads_list.php';

//Today's date query only
$date_today = date('Y-m-d');
$sql = "SELECT COUNT(id)AS numrows FROM leads l WHERE DATE(timestamp) = '".$date_today."' ".$search_str2." ORDER BY timestamp $order_by;";
//echo $sql."<br>";
$today_numrows = $db->fetchOne($sql);
//echo $today_numrows;

if($lead_status != 'Client'){
     include 'leads_list.php';
}else{
    if($_GET['filter']=='ACTIVE'){
	    include 'active_clients.php';
	}else if($_GET['filter']=='INACTIVE'){
	    include 'inactive_clients.php';
	}else{
	    include 'leads_list.php';
	}
}

//echo "numrows => ".$numrows."<br>";
//echo "pageNum => ".$pageNum."<br>";
//paging setup

if($numrows > 0){ 
		        
   $maxPage = ceil($numrows/$rowsPerPage);
   //echo "maxPage => ".$maxPage."<br>";
   $smarty->assign('numrows',$numrows);
   $smarty->assign('maxPage', ($maxPage+1));
   $smarty->assign('pageNum',$pageNum);
		        
}

//end paging setup




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




$transfer_status = array('New Leads', 'Follow-Up', 'Keep In-Touch', 'pending', 'asl', 'custom recruitment' );
if (in_array($lead_status, array('New Leads', 'Follow-Up', 'Keep In-Touch' , 'Inactive')) == true) {
	$enable_disable_btn = True;
}

$pin_array = array('Replacement Requests', 'CSR Concerns', 'Sales Follow Up');
$smarty->assign('bd_name',$bd_name);
$smarty->assign('hc_name',$hc_name);
$smarty->assign('csro_name',$csro_name);
$smarty->assign('date_today',$date_today);
$smarty->assign('today_numrows',$today_numrows);
$smarty->assign('pageNum', $pageNum);
$smarty->assign('pin', $pin);
$smarty->assign('pin_array', $pin_array);
$smarty->assign('show_notice_str', $show_notice_str);
$smarty->assign('show_notice', $show_notice);
$smarty->assign('BPOptions', $BPOptions);
$smarty->assign('enable_disable_btn' , $enable_disable_btn);
$smarty->assign('transfer_status', $transfer_status);
if($lead_status == 'Client' ){
    if($_GET['filter']){
        $smarty->assign('path', sprintf('lead_status=%s&filter=%s', $lead_status, $_GET['filter']));
	}else{
	    $smarty->assign('path', sprintf('lead_status=%s', $lead_status));
	}	
}else{   
    $smarty->assign('path', sprintf('lead_status=%s', $lead_status));
}	
$smarty->assign('marked_leads_counter', count($marked_leads));
$smarty->assign('marked_leads_list',$marked_leads_list);
$smarty->assign('leads_list', $leads_list);
$smarty->assign('leads', $leads);
$smarty->assign('agent_no', $_REQUEST['agent_no']);
$smarty->assign('query',$query);

if( $current_user['menu_status'] == 'FULL-CONTROL'){
    $menus = array('New Leads', 'Follow-Up', 'asl', 'custom recruitment', 'Keep In-Touch', 'pending', 'Client');
}else if($current_user['menu_status'] == 'COMPLIANCE'){
    $menus = array('Client');
}else if($current_user['menu_status'] == 'FINANCE-ACCT'){
    $menus = array('Client');
}else{
    die('Unknown user');
}
//print_r($menus);exit;

$smarty->assign('csro_officers',$csro_officers);
$smarty->assign('hiring_coordinator_id',$hiring_coordinator_id);
$smarty->assign('csro_id',$csro_id);
$smarty->assign('hiring_coordinators',$hiring_coordinators);
$smarty->assign('order_by_options',$order_by_options);
$smarty->assign('business_developer_id', $business_developer_id);
$smarty->assign('business_partners', $business_partners);
$smarty->assign('field', $field);
$smarty->assign('lead_status', $lead_status);
$smarty->assign('keyword', $keyword);
$smarty->assign('rate_options',$rate_options);
$smarty->assign('statuses', $menus);
$smarty->assign('lead_statuses', $lead_statuses);
$smarty->assign('fields', Array('l.id' => 'id', 'email' => 'email', 'fname' => 'First Name', 'lname' => 'Last Name'));
$smarty->assign('jscripts', Array('../js/jquery.js','../js/MochiKit.js', '../js/calendar.js', '../js/calendar-setup.js', '../lang/calendar-en.js', '../js/functions.js', 'media/js/leads_list.js', 'media/js/overlay.js', 'media/js/dropdown.js'));
$smarty->assign('filter', $_GET['filter']);
$smarty->assign('body_attributes', "id='navselected'");
$smarty->assign('meta_title', 'Remote Staff Leads List');

include '../header_menu_asl_order_checker.php'; //flagging the menus


//$flag_menus = Array('New Leads' => $new_lead_marked_flag, 'Follow-Up' => $follow_up_marked_flag, 'asl' => $asl_up_marked_flag, 'custom recruitment' => $custom_recruitment_marked_flag, 'Keep In-Touch' => $keep_in_touch_marked_flag, 'pending' => $pending_marked_flag, 'Client' => $client_marked_flag);

$smarty->assign('flag_menus', $flagging_menus);

//echo "<pre>";
//print_r($flag_menus['custom recruitment']);
//echo "</pre>";
//exit;
$path =  explode('portal/', $_SERVER['REQUEST_URI']);
$smarty->assign('current_url', $path[count($path)-1]);

//DATE UPDATE
$smarty->assign('date_updated_start',$date_updated_start);
$smarty->assign('date_updated_end',$date_updated_end);

//REGISTER DATE
$smarty->assign('register_date_start',$register_date_start);
$smarty->assign('register_date_end',$register_date_end);

$smarty->display('index.tpl');
?>
