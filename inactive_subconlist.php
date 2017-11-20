<?php
include './conf/zend_smarty_conf.php';
include './admin_subcon/subcon_function.php';


header("Expires: Mon, 26 Jul 1997 05:00:00GMT");
header("Cache-Control: no-cache");
header('Content-type: text/html; charset=utf-8');
header("Pragma: no-cache");
$smarty = new Smarty;

$page_status = 'INACTIVE';

if($_SESSION['admin_id']=="")
{
	header("location:index.php");
	exit;
}
header("location:/portal/django/subcontractors/subcons/inactive");
exit;
//day of the week and determines the staff working hours based on the day of the week per column field of subcontractors table.
$weekday_str = strtolower(date('D'))."_start";
$weekday_str_finish = strtolower(date('D'))."_finish";

$admin_id = $_SESSION['admin_id'];
$admin_status=$_SESSION['status'];

if($admin_status == 'HR'){
	$resume_page = "recruiter/staff_information.php";
}else{
	$resume_page = "application_apply_action.php";
}
$site = $_SERVER['HTTP_HOST'];


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
if(isset($_GET['page']))
{
	$pageNum = $_GET['page'];
}
// counting the offset
//echo $pageNum ;

$offset = 0;
if($pageNum!=NULL){
	$offset = ($pageNum - 1) * $rowsPerPage;
	//echo "offset2 ( ".$offset2." )<br>";
}


$limit = " LIMIT $offset, $rowsPerPage ";

// get all subcon
$sql = "SELECT DISTINCT(s.userid), fname, lname , email FROM personal u JOIN subcontractors s ON s.userid = u.userid WHERE (s.status ='terminated' OR s.status ='resigned') ORDER BY fname ASC;";
$result = $db->fetchAll($sql);
foreach($result as $row){
	$usernameOptions .="<option value=".$row['userid'].">".$row['fname']." ".$row['lname']." [".$row['email']."]</option>";
}


//use in paging
//get all active subcon
$sql = "SELECT COUNT(id)AS numrows FROM subcontractors s  WHERE (s.status ='terminated' OR s.status ='resigned');";
$numrows = $db->fetchOne($sql);
$maxPage = ceil($numrows/$rowsPerPage);
// print the link to access each page
$self = "./".basename($_SERVER['SCRIPT_FILENAME']);
$nav = '';
for($page = 1; $page <= $maxPage; $page++)
{
	if ($page == $pageNum)
	{
		if($agent_id == $agents_id) {
			$nav .= " <li><a class='currentpage' href=\"$self?page=$page\">$page</a></li> ";
		}else{
			$nav .= " <li><a class='' href=\"$self?page=$page\">$page</a></li> ";
		}
	}
	else
	{
		$nav .= " <li><a href=\"$self?page=$page\">$page</a></li> ";
	}
}

if ($pageNum > 1){

	$page = $pageNum - 1;
	$prev = " <li><a href=\"$self?page=$page\">Prev</a></li> ";
	$first = "<li><a href=\"$self?page=1\">First Page</a></li>";
	
}
else{

	$prev  = '&nbsp;'; // we're on page one, don't print previous link
	$first = '&nbsp;'; // nor the first page link
}

if ($pageNum < $maxPage){

	$page = $pageNum + 1;
	$next = " <li><a href=\"$self?page=$page\">Next</a></li>";
	$last = " <li><a href=\"$self?page=$maxPage\">Last Page</a></li> ";
}else{

	$next = '&nbsp;'; // we're on the last page, don't print next link
	$last = '&nbsp;'; // nor the last page link
}
//echo $first . $prev . $nav. $next . $last;
$paging =  $first . $prev . $next . $last;

$search_flag = False;
$keyword_search ="";
$contract_age_option = "";
$order_by = " ORDER BY s.id DESC ";
if (array_key_exists('_submit_check', $_POST)) {
	
	$userid = $_POST['userid'];
	$keyword = $_POST['keyword'];
	
	
	if($userid != ""){
		$conditions .= " AND s.userid = $userid ";
	}
	
	if($_POST['work_status']){
	    //echo $_POST['work_status'];
		$conditions .= " AND s.work_status = '".$_POST['work_status']. "'";
	}
	
	if($_POST['leads_id']){
	    $conditions .= " AND s.leads_id = '".$_POST['leads_id']. "'";
	}
	
	if($_POST['login_status']){
	    $conditions .= " AND a.status = '".$_POST['login_status']. "'";
	}
	
	if($_POST['client_timezone']){
	    $conditions .= " AND s.client_timezone = '".$_POST['client_timezone']. "'";
	}
	
	if($_POST['csro']){
	    $conditions .= " AND l.csro_id = '".$_POST['csro']. "'";
	}
	
	if($_POST['business_partner_id']){
	    $conditions .= " AND l.business_partner_id = '".$_POST['business_partner_id']. "'";
	}
    
	if($_POST['recruiter']){
		$conditions .= " AND rs.admin_id = '".$_POST['recruiter']. "'";
	}
	
	if($_POST['hm']){
	    $conditions .= " AND l.hiring_coordinator_id = '".$_POST['hm']. "'";
	}
	
	if($_POST['flexi']){
	    $conditions .= " AND s.flexi = '".$_POST['flexi']. "'";
	}
	
	if($_POST['contract_age_option'] !=""){
	    //$conditions .= create_date_difference($_POST['contract_age_option'], date('Y-m-d'));
		$contract_age_option = $_POST['contract_age_option'];
	}
	//echo $conditions;
	if($keyword!=NULL){
	
			$search_text = $keyword;
			$search_text=ltrim($search_text);
			$search_text=rtrim($search_text);
			
			$kt=explode(" ",$search_text);//Breaking the string to array of words
			// Now let us generate the sql 
			while(list($key,$val)=each($kt)){
				if($val<>" " and strlen($val) > 0){
					
					$queries .= " s.userid like '%$val%' or p.fname like '%$val%' or p.lname like '%$val%' or p.email like '%$val%' or p.skype_id like '%$val%' or s.job_designation like '%$val%' or";
				}
			}// end of while
			
			$queries=substr($queries,0,(strlen($queries)-3));
			// this will remove the last or from the string. 
			$keyword_search =  " AND ( ".$queries." ) ";
			//echo $keyword_search;exit;
			$search_flag = True;
	}
	
	if($_POST['month'] > 0 and $_POST['year'] != ""){
        $conditions .= " AND ( MONTH(s.date_terminated) = '".$_POST['month']."' AND YEAR(s.date_terminated) = '".$_POST['year']."' ";
		$conditions .= " OR MONTH(s.resignation_date) = '".$_POST['month']."' AND YEAR(s.resignation_date) = '".$_POST['year']."' )";
	}else if($_POST['month'] > 0 and $_POST['year'] == ""){
	    $conditions .= " AND ( MONTH(s.date_terminated) = '".$_POST['month']."' ";
		$conditions .= " OR MONTH(s.resignation_date) = '".$_POST['month']."' )";
	}else if($_POST['month'] == 0 and $_POST['year'] != ""){
	    $conditions .= " AND ( YEAR(s.date_terminated) = '".$_POST['year']."' ";
		$conditions .= " OR YEAR(s.resignation_date) = '".$_POST['year']."' )";
	}
	
	$limit = "";
	$search_flag = True;
	$order_by = " ORDER BY p.fname ASC ";
	//exit;
}



$query = "SELECT s.id,s.starting_date, s.userid , p.fname, p.lname , p.email ,s.leads_id, CONCAT(l.fname,' ',l.lname)AS client_name, (l.email)AS leads_email, p.handphone_country_code,  p.handphone_no, p.skype_id ,p.tel_area_code, p.tel_no , p.registered_email ,a.status, s.client_timezone, s.client_start_work_hour,
s.work_status, s.job_designation, flexi, s.prepaid, s.staff_working_timezone, p.image , ($weekday_str)AS work_hour, ($weekday_str_finish)AS work_hour_finish, currency, staff_currency_id, client_price, php_monthly, p.address1, p.city, p.postcode, p.state, p.country_id, l.company_name, l.company_address, l.csro_id, ad.admin_fname, ad.admin_lname,
date_terminated, resignation_date, reason , (s.status)AS contract_status, s.client_finish_work_hour, s.reason_type, s.replacement_request,s.service_type, l.business_partner_id, rs.admin_id, l.hiring_coordinator_id
FROM subcontractors s
LEFT JOIN personal p ON p.userid = s.userid
LEFT JOIN leads l ON l.id = s.leads_id
LEFT JOIN activity_tracker a ON s.userid = a.userid
LEFT JOIN admin ad ON ad.admin_id = l.csro_id
LEFT JOIN recruiter_staff rs ON rs.userid = s.userid
WHERE (s.status IN('terminated','resigned'))
$conditions  $keyword_search
$order_by $limit;";
//echo $query;
$filter_staffs = $db->fetchAll($query);
$ctr = $offset;
$counters = array();
$staffs = array();


//let's filter first
include 'filter-subconlist.php';


//now display it
foreach($staffs as $staff){
	$ctr++;
	
	if($bgcolor=="#FFFFFF"){
		$bgcolor="#CCFFCC";
	}else{
		$bgcolor="#FFFFFF";
	}
	
	
	
	$image = "<img src='http://www.remotestaff.com.au/portal/tools/staff_image.php?w=48&id=".$staff['userid']."' border='0' align='texttop'  />";
	
	$work_schedule ="";
	$starting_date = date('F j, Y', strtotime($staff['starting_date']));
	$starting_date_str = date('Y-m-d', strtotime($staff['starting_date']));
	
	//echo $starting_date;
	$contract_updated = $staff['contract_updated'];
	if($contract_updated == 'n'){ //this contract need to be updated
		$warning_str = "staff contract needs update";
	}else{
		$warning_str ="";
	}
		     
	if($staff['work_hour']){
		$staff_start_work_hour_str = date('h:i a', strtotime($staff['work_hour']));
	}
			
	if($staff['work_hour_finish']){
		$staff_finish_work_hour_str = date('h:i a', strtotime($staff['work_hour_finish']));
	}
	
	if($staff['client_start_work_hour']){
		$client_start_work_hour_str = date('h:i a', strtotime($staff['client_start_work_hour']));
	}
	
	if($staff['client_finish_work_hour']){
		$client_finish_work_hour_str = date('h:i a', strtotime($staff['client_finish_work_hour']));
	}
			
	if($staff['contract_status'] == 'resigned'){
		$staff_contract_finish_date = date('F j, Y', strtotime($staff['resignation_date']));
	    $staff_contract_finish_date_str = date('Y-m-d', strtotime($staff['resignation_date']));
	} 
			
	if($staff['contract_status'] == 'terminated'){
		$staff_contract_finish_date = date('F j, Y', strtotime($staff['date_terminated']));
	    $staff_contract_finish_date_str = date('Y-m-d', strtotime($staff['date_terminated']));
	}
			 
	if($staff['flexi'] == 'no'){
	    $work_schedule = sprintf('%s to %s %s', $staff_start_work_hour_str, $staff_finish_work_hour_str, $staff['staff_working_timezone']);
	}else{
	    $work_schedule = 'Flexi Schedule';
	} 
	
	if($starting_date_str <= $staff_contract_finish_date_str){
	    $duration = sprintf("<small style='color:green;font-weight:bold;'>%s</small>", $staff['duration']);
	}else{
	    $duration = sprintf("<small style='color:green;font-weight:bold;'>%s</small>", 'Not yet started');
	}
	
	//csro
	if($staff['csro_id']){
		$sql = $db->select()
		    ->from('admin', array('admin_fname', 'admin_lname'))
			->where('admin_id=?', $staff['csro_id']);
		$staff['csro'] = $db->fetchRow($sql);	
	}
	//hiring manager	
	if($staff['hiring_coordinator_id']){
		$sql = $db->select()
		    ->from('admin', array('admin_fname', 'admin_lname'))
			->where('admin_id=?', $staff['hiring_coordinator_id']);
		$staff['hm'] = $db->fetchRow($sql);	
	}
	
	$csro_name="";
	if($staff['csro']){
		$csro_name = sprintf('CSRO : %s %s<br>', $staff['csro']['admin_fname'], $staff['csro']['admin_lname']);
	}
	
	$hm_name="";
	if($staff['csro']){
		$hm_name = sprintf('Hiring Manager : %s %s<br>', $staff['hm']['admin_fname'], $staff['hm']['admin_lname']);
	}
	
	$resultOptions .="<tr bgcolor='$bgcolor' class='staff_name'>";	
	$resultOptions .="<td valign='top'>".$ctr."</td>";
	$resultOptions .="<td valign='top'><a href=".$resume_page."?userid=".$staff['userid']." target='_blank'>".$image."</a><div style='float:left; display:block;'><small>SUBCON ID : ".$staff['id']."</small><br> <a href=".$resume_page."?userid=".$staff['userid']." target='_blank'><b>".$staff['fname']." ".$staff['lname']."</b></a><br>".$staff['email']."<br>".$staff['job_designation']."<br>".$work_schedule."</div></td>";
	$resultOptions .="<td valign='top'>";	
			        
			
			$contract_link = sprintf('./contractForm.php?sid=%s',$staff['id']);
			//$contract_link = "./staff/subcon.php?id=".$staff['id'];
			$resultOptions.= "<div><div style='float:left; display:block; width:350px; margin-right:2px;'><span style='float:right;'>".$working_status."</span><div><input type='radio' align='absmiddle' name='userid' onclick=javascript:window.open('$contract_link') /> <a href='leads_information.php?id=".$staff['leads_id']."&lead_status=".$staff['leads_status']."' target='_blank'><b>".$staff['client_name']."</b></a></div><div style='margin-left:25px;'>Contract Status : <span style='color:red;font-weight:bold;'>".$staff['contract_status']."</span><br>Work Status : ".$staff['work_status']."<br>Starting Date : ".$starting_date." to ".$staff_contract_finish_date."<br>Contract Length : ".$duration."<br>".$staff['client_timezone']."<br>".$csro_name.$hm_name."</div></div><div style='float:right; border:#333 dashed 1px; padding:3px;  width:300px; display:block; background:yellow; '><strong>Service Type</strong> : ".$staff['service_type']."<br><strong>Reason Type</strong> : ".$staff['reason_type']."<br><strong>Replacement Request</strong> : ".$staff['replacement_request']."<br><strong>Reason</strong> : <br><em style='padding-left:10px;'>".$staff['reason']."</em></div><br clear='all'></div>";	
	
		
		
	$resultOptions .="</td>";	
	$resultOptions .="</tr>";	
	array_push($counters,$ctr);
	
}




if(isset($_POST['export'])){
    include 'subconlist-export.php';
}


//print_r($counters);exit;
//echo $pageNum ." | ". $maxPage;
if($offset == 0){
	$staff_num = 1;
	$offset = $rowsPerPage;
}else{
	
	
	
	if($pageNum < $maxPage){
		//$staff_num = (($ctr + 1) - $rowsPerPage);
		//$offset = $offset + $rowsPerPage;
		$staff_num = (($ctr + 1) - $rowsPerPage);
		$offset = $ctr;
	}else{
		$staff_num = min($counters);
		$offset = max($counters);
	
	}
	
}

$row_results = $staff_num." - ".$offset." of ".$numrows;
$work_status_array = array('Full-Time','Part-Time');
for($i=0; $i<count($work_status_array); $i++){
    if($_POST['work_status'] == $work_status_array[$i]){
        $work_status_Options .="<option selected value='".$work_status_array[$i]."'>".$work_status_array[$i]."</option>";
	}else{
	    $work_status_Options .="<option value='".$work_status_array[$i]."'>".$work_status_array[$i]."</option>";
	}
}


//get all clients with active staff
$sql = "SELECT COUNT(s.id)AS no_staff, s.leads_id , l.fname, l.lname FROM subcontractors s JOIN leads l ON l.id = s.leads_id WHERE (s.status ='terminated' OR s.status ='resigned') GROUP BY s.leads_id ORDER BY l.fname;";
$active_clients = $db->fetchAll($sql);
foreach($active_clients as $client){
    if($_POST['leads_id'] == $client['leads_id']){
	    $active_client_Options .="<option selected value='".$client['leads_id']."'>".$client['fname']." ".$client['lname']." - ". $client['leads_id']."</option>";
	}else{
	    $active_client_Options .="<option value='".$client['leads_id']."'>".$client['fname']." ".$client['lname']." - #". $client['leads_id']."</option>";
	}
}

//get all active bp
$sql = "SELECT * FROM agent a WHERE status='ACTIVE' AND work_status='BP' ORDER BY fname;";
$bps = $db->fetchAll($sql);
foreach($bps as $bp){
    if($_POST['business_partner_id'] == $bp['agent_no']){
	    $bp_Options .="<option selected value='".$bp['agent_no']."'>".$bp['fname']." ".$bp['lname']."</option>";
	}else{
	    $bp_Options .="<option value='".$bp['agent_no']."'>".$bp['fname']." ".$bp['lname']."</option>";
	}
}


$login_status_array = array('working', 'not working', 'lunch break', 'quick break');
for($i=0; $i<count($login_status_array); $i++){
    if($_POST['login_status'] == $login_status_array[$i]){
        $login_status_Options .="<option selected value='".$login_status_array[$i]."'>".$login_status_array[$i]."</option>";
	}else{
	    $login_status_Options .="<option value='".$login_status_array[$i]."'>".$login_status_array[$i]."</option>";
	}
}

//csro
$sql = "SELECT * FROM recruitment_team r WHERE team_status='active';";
$teams = $db->fetchAll($sql);
foreach($teams as $team){
    $sql = "SELECT r.admin_id, a.admin_fname, a.admin_lname FROM recruitment_team_member r JOIN admin a ON a.admin_id = r.admin_id WHERE member_position='csro' AND team_id =".$team['id'];
	//echo $sql;
	$team_members = $db->fetchAll($sql);
	foreach($team_members as $member){
		if($_POST['csro'] == $member['admin_id']){
			$team_Options .="<option value='".$member['admin_id']."' selected='selected'>".sprintf('%s %s =>%s', $member['admin_fname'], $member['admin_lname'], $team['team'])."</option>";
		}else{
			$team_Options .="<option value='".$member['admin_id']."' >".sprintf('%s %s =>%s', $member['admin_fname'], $member['admin_lname'], $team['team'])."</option>";
		}
	}
	
}

//recruiter
$sql = "SELECT * FROM admin a WHERE status='HR' ORDER BY admin_fname;";
$recruiters = $db->fetchAll($sql);
foreach($recruiters as $recruiter){
   	if($_POST['recruiter'] == $recruiter['admin_id']){
		$recruiter_Options .="<option value='".$recruiter['admin_id']."' selected='selected'>".sprintf('%s %s', $recruiter['admin_fname'], $recruiter['admin_lname'])."</option>";
	}else{
		$recruiter_Options .="<option value='".$recruiter['admin_id']."' >".sprintf('%s %s', $recruiter['admin_fname'], $recruiter['admin_lname'])."</option>";
	}
}



//echo "=>".$contract_age_option;
for($i=0; $i<count($AGE_CONTRACTS); $i++){
    if($contract_age_option !=""){
        if($contract_age_option == $i){
            $AGE_CONTRACTS_OPTIONS .="<option selected value='".$i."'>".$AGE_CONTRACTS[$i]."</option>";
	    }else{
	        $AGE_CONTRACTS_OPTIONS .="<option value='".$i."'>".$AGE_CONTRACTS[$i]."</option>";
	    }
	}else{
	    $AGE_CONTRACTS_OPTIONS .="<option value='".$i."'>".$AGE_CONTRACTS[$i]."</option>";
	}
}

$years = array();
for($i=2008; $i<=date("Y"); $i++ ){
    array_push($years, $i);
}

$months = array("-", "January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");


//HIRING MANAGER
$sql = "SELECT * FROM recruitment_team r WHERE team_status='active';";
$teams = $db->fetchAll($sql);
foreach($teams as $team){
    $sql = "SELECT r.admin_id, a.admin_fname, a.admin_lname FROM recruitment_team_member r JOIN admin a ON a.admin_id = r.admin_id WHERE member_position='hiring coordinator' AND team_id =".$team['id'];
	//echo $sql;
	$team_members = $db->fetchAll($sql);
	foreach($team_members as $member){
		if($_POST['hm'] == $member['admin_id']){
			$hm_Options .="<option value='".$member['admin_id']."' selected='selected'>".sprintf('%s %s', $member['admin_fname'], $member['admin_lname'], $team['team'])."</option>";
		}else{
			$hm_Options .="<option value='".$member['admin_id']."' >".sprintf('%s %s', $member['admin_fname'], $member['admin_lname'], $team['team'])."</option>";
		}
	}	
}

$sql="SELECT client_timezone FROM subcontractors s GROUP BY client_timezone;";
$client_timezones = $db->fetchAll($sql);


$smarty->assign('client_timezones', $client_timezones);
$smarty->assign('hm_Options', $hm_Options);
$smarty->assign('recruiter_Options',$recruiter_Options);
$smarty->assign('bp_Options',$bp_Options);
$smarty->assign('year', $_POST['year']);
$smarty->assign('month', $_POST['month']);
$smarty->assign('years', $years);
$smarty->assign('months', $months);
$smarty->assign('AGE_CONTRACTS_OPTIONS', $AGE_CONTRACTS_OPTIONS);
$smarty->assign('team_Options', $team_Options);
$smarty->assign('client_timezone', $_POST['client_timezone']);
$smarty->assign('flexi', $_POST['flexi']);
$smarty->assign('prepaid_Options',Array('no', 'yes'));
$smarty->assign('login_status_Options',$login_status_Options);
$smarty->assign('active_clients_num',count($active_clients));
$smarty->assign('active_client_Options',$active_client_Options);
$smarty->assign('work_status_Options', $work_status_Options);
$smarty->assign('admin_status',$_SESSION['status']);
$smarty->assign('script_filename',basename($_SERVER['SCRIPT_FILENAME']));
$smarty->assign('page_status',$page_status);
$smarty->assign('row_results',$row_results);
$smarty->assign('ctr',$ctr);
$smarty->assign('numrows',$numrows);
$smarty->assign('offset',$offset);

$smarty->assign('resultOptions',$resultOptions);
$smarty->assign('staff',$staff);
$smarty->assign('search_flag',$search_flag);
$smarty->assign('paging',$paging);
$smarty->assign('filter_count_results',count($staffs));
$smarty->assign('keyword',$keyword);
$smarty->assign('usernameOptions',$usernameOptions);
$smarty->display('subconlist.tpl');
?>